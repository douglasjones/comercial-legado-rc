#!/bin/sh
set -eu

ROOT_DIR=$(CDPATH= cd -- "$(dirname "$0")/.." && pwd)
TIMESTAMP=$(date +"%Y-%m-%d_%H%M%S")
BACKUP_DIR="${BACKUP_DIR:-$ROOT_DIR/backups/$TIMESTAMP}"
DB_CONTAINER="${DB_CONTAINER:-crm_db}"
WEB_CONTAINER="${WEB_CONTAINER:-crm_web}"
PROJECT_NAME="${PROJECT_NAME:-crm-comercial-antigo}"

mkdir -p "$BACKUP_DIR"

if [ -f "$ROOT_DIR/.env" ]; then
  set -a
  # shellcheck disable=SC1091
  . "$ROOT_DIR/.env"
  set +a
fi

DB_NAME="${DB_NAME:-wwgepr_crm_antigo}"
UPLOAD_BASE_DIR="${UPLOAD_BASE_DIR:-/var/appdata/uploads}"

PROJECT_ARCHIVE="$BACKUP_DIR/${PROJECT_NAME}_files_${TIMESTAMP}.tar.gz"
DB_ARCHIVE="$BACKUP_DIR/${DB_NAME}_${TIMESTAMP}.sql.gz"
UPLOADS_ARCHIVE="$BACKUP_DIR/${PROJECT_NAME}_uploads_${TIMESTAMP}.tar.gz"
ENV_COPY="$BACKUP_DIR/dotenv_${TIMESTAMP}.env"
METADATA_FILE="$BACKUP_DIR/metadata_${TIMESTAMP}.txt"

echo "Backup directory: $BACKUP_DIR"

if [ -f "$ROOT_DIR/.env" ]; then
  cp "$ROOT_DIR/.env" "$ENV_COPY"
fi

COPYFILE_DISABLE=1 tar \
  --exclude='./.git' \
  --exclude='./backups' \
  --exclude='./deploy_pkg' \
  --exclude='./*.tar.gz' \
  --exclude='./*.sql' \
  --exclude='./*.sql.gz' \
  --exclude='./.DS_Store' \
  -czf "$PROJECT_ARCHIVE" \
  -C "$ROOT_DIR" .

docker exec "$DB_CONTAINER" sh -lc \
  "mysqldump --single-transaction --routines --triggers --default-character-set=latin1 -uroot -p\"\$MYSQL_ROOT_PASSWORD\" \"$DB_NAME\"" \
  | gzip > "$DB_ARCHIVE"

docker exec "$WEB_CONTAINER" sh -lc \
  "tar -C \"$(dirname "$UPLOAD_BASE_DIR")\" -czf - \"$(basename "$UPLOAD_BASE_DIR")\"" \
  > "$UPLOADS_ARCHIVE"

{
  echo "Backup generated at: $(date '+%Y-%m-%d %H:%M:%S %z')"
  echo "Project root: $ROOT_DIR"
  echo "Project archive: $(basename "$PROJECT_ARCHIVE")"
  echo "Database archive: $(basename "$DB_ARCHIVE")"
  echo "Uploads archive: $(basename "$UPLOADS_ARCHIVE")"
  if [ -f "$ENV_COPY" ]; then
    echo "Environment copy: $(basename "$ENV_COPY")"
  fi
  echo
  echo "Stack versions:"
  docker exec "$WEB_CONTAINER" php -v | sed -n '1,2p'
  docker exec "$DB_CONTAINER" mysql --version
  docker exec "$WEB_CONTAINER" sh -lc 'apache2 -v | sed -n "1,2p"'
  echo
  echo "PHP settings:"
  docker exec "$WEB_CONTAINER" sh -lc \
    'php -i | grep -E "Loaded Configuration File|memory_limit|max_execution_time|upload_max_filesize|post_max_size|default_charset|date.timezone"'
  echo
  echo "PHP modules:"
  docker exec "$WEB_CONTAINER" sh -lc 'php -m | grep -E "^(mysql|mysqli|pdo_mysql)$"'
  echo
  echo "MySQL settings:"
  docker exec "$DB_CONTAINER" sh -lc \
    'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" -Nse "SELECT VERSION(), @@sql_mode, @@character_set_server, @@collation_server, @@time_zone;"'
  echo
  echo "Application env:"
  echo "APP_ENV=${APP_ENV:-production}"
  echo "APP_URL=${APP_URL:-}"
  echo "DB_HOST=${DB_HOST:-db}"
  echo "DB_NAME=$DB_NAME"
  echo "DB_USER=${DB_USER:-crm_user}"
  echo "UPLOAD_BASE_DIR=$UPLOAD_BASE_DIR"
  echo "UPLOAD_MAX_SIZE=${UPLOAD_MAX_SIZE:-5242880}"
  echo "SESSION_COOKIE_SECURE=${SESSION_COOKIE_SECURE:-0}"
  echo "SESSION_COOKIE_SAMESITE=${SESSION_COOKIE_SAMESITE:-Lax}"
} > "$METADATA_FILE"

echo "Created:"
echo "  - $PROJECT_ARCHIVE"
echo "  - $DB_ARCHIVE"
echo "  - $UPLOADS_ARCHIVE"
if [ -f "$ENV_COPY" ]; then
  echo "  - $ENV_COPY"
fi
echo "  - $METADATA_FILE"

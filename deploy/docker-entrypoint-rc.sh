#!/bin/sh
set -eu

MAIL_FLAG="${MAIL_ENABLED:-false}"
MAIL_FLAG_LOWER=$(printf '%s' "$MAIL_FLAG" | tr '[:upper:]' '[:lower:]')

if [ "$MAIL_FLAG_LOWER" = "false" ] || [ "$MAIL_FLAG_LOWER" = "0" ] || [ "$MAIL_FLAG_LOWER" = "no" ]; then
    cat > /usr/local/etc/php/conf.d/98-mail-disabled.ini <<'EOF'
sendmail_path = /bin/true
EOF
else
    rm -f /usr/local/etc/php/conf.d/98-mail-disabled.ini
fi

mkdir -p "${UPLOAD_BASE_DIR:-/var/appdata/uploads}"
chown -R www-data:www-data "${UPLOAD_BASE_DIR:-/var/appdata/uploads}"

exec docker-php-entrypoint "$@"

#!/bin/sh
set -eu

if [ "$#" -lt 1 ] || [ "$#" -gt 2 ]; then
  echo "Usage: $0 <dump.sql.gz|dump.sql> [db_container]" >&2
  exit 1
fi

DUMP_FILE=$1
DB_CONTAINER=${2:-crm_db}

if [ ! -f "$DUMP_FILE" ]; then
  echo "Dump not found: $DUMP_FILE" >&2
  exit 1
fi

if [ "${DUMP_FILE##*.}" = "gz" ]; then
  gzip -dc "$DUMP_FILE" | docker exec -i "$DB_CONTAINER" sh -lc 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"'
else
  cat "$DUMP_FILE" | docker exec -i "$DB_CONTAINER" sh -lc 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE"'
fi

echo "Database restored into container $DB_CONTAINER using file $DUMP_FILE"

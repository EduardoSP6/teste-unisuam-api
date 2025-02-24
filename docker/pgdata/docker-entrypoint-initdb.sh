#!/bin/bash
set -e

DB_HOST="db"
DB_PORT=5432

until PGPASSWORD="$POSTGRES_PASSWORD" psql -h "$DB_HOST" -U "$POSTGRES_USER" -p "$DB_PORT" -c '\q' > /dev/null 2>&1; do
  sleep 2
  echo "Waiting PostgreSQL initialization..."
done

echo "PostgreSQL is ready"

DB_EXISTS=$(PGPASSWORD="$POSTGRES_PASSWORD" psql -h "$DB_HOST" -U "$POSTGRES_USER" -tAc "SELECT 1 FROM pg_database WHERE datname='$POSTGRES_DB'")

if [ "$DB_EXISTS" = "1" ]; then
  echo "Database '$POSTGRES_DB' already exists."
else
    psql -h "$DB_HOST" -U "$POSTGRES_USER" --dbname=postgres -c "CREATE DATABASE $POSTGRES_DB;"
    echo "Database created successfully"
fi

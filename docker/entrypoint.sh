#!/bin/sh
set -e

PORT="${PORT:-10000}"
sed "s/PORT_PLACEHOLDER/$PORT/" /etc/nginx/sites-available/default.template > /etc/nginx/sites-available/default

mkdir -p /run/mysqld /run/php
chown mysql:mysql /run/mysqld

exec "$@"
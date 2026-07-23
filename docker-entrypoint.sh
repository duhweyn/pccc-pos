#!/bin/bash
set -e

echo "Clearing cached config..."
php artisan config:clear || true

echo "Running database migrations..."
php artisan migrate --force

echo "Caching config for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Linking module public assets..."
php artisan modules:symlink || true

echo "Starting Apache..."
exec "$@"

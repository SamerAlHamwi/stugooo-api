#!/bin/sh
set -e

php artisan storage:link --force 2>/dev/null || true

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php-fpm

#!/bin/sh
set -e

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

php artisan storage:link --force 2>/dev/null || true

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec php-fpm

#!/bin/bash

set -e

echo "Starting API Service..."

envsubst < ./infra/nginx/challenge-api.conf > /etc/nginx/sites-available/default

composer install --no-interaction --prefer-dist --optimize-autoloader

echo "API up and running!"

# start PHP-FPM in the background
php-fpm -D

# start NGINX in foreground
exec nginx -g 'daemon off;'

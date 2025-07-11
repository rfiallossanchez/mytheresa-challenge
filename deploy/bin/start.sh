#!/bin/bash

set -e

echo "Starting API Service..."

# Adding Nginx configuration
envsubst < ./deploy/nginx/challenge-api.conf > /etc/nginx/sites-available/default

# Installing dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Setting up database
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create --no-interaction
php bin/console doctrine:schema:create --no-interaction
php bin/console doctrine:migrations:migrate --no-interaction

echo "API up and running!"

# start PHP-FPM in the background
php-fpm -D

# start NGINX in foreground
exec nginx -g 'daemon off;'

#!/bin/bash

echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h"balances-mysql" --silent; do
    sleep 1
done

echo "MySQL is ready!"

cd /var/www

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --class=BalanceSeeder --force

echo "Starting Kafka consumer..."
php artisan kafka:consume 

echo "Starting PHP-FPM..."
exec php-fpm
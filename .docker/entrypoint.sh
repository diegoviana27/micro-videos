#!/bin/bash

cp .env.example .env
cp .env.testing.example .env.testing
chmod -R 777 storage
composer install
php artisan key:generate
php artisan migrate
php-fpm

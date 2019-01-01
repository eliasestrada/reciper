#! /bin/bash

if [ ! -f /var/www/.env ] && [ -f /var/www/vendor/autoload.php ]; then
    cd /var/www
    cp .env.example .env
    php artisan key:generate
    php artisan storage:link
    php artisan wipe
else
    echo 'Try again, because composer is still installing dependencies'
fi
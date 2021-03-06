#! /bin/bash
# This script will run untill composer done with creating autoload.php file
# in laravel vendor folder

printf 'Waiting for composer and npm to finish... \n'
cd /var/www

while [ true ]; do
    if [ -f vendor/autoload.php ] && [ -f public/css/app.css ] && [ -f public/js/app.js ]; then
        if [ ! -f /var/www/.env ]; then
            cp .env.example .env
            php artisan key:generate
            php artisan storage:link
        else
            printf '.env file is already exists \n'
        fi

        php artisan wipe
        chmod -R 775 storage
        chown -R www-data:www-data *

        if [ -f /etc/supervisor/conf.d/laravel-worker.conf ]; then
            supervisord && supervisorctl update && supervisorctl start laravel-worker:*
        fi

        printf 'DONE! You can go to a localhost:3000 \n'
        break;
    fi
done


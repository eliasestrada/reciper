#! /bin/bash

echo 'Waiting for 5 seconds'
sleep 5

if [ -f /var/www/vendor/autoload.php ]; then
    cd /var/www

    if [ ! -f /var/www/.env ]; then
        cp .env.example .env
        php artisan key:generate
        php artisan storage:link

        sleep 2
        php artisan wipe
    else
        echo 'Seems like .env file is already created'
    fi
else
    echo 'Try again, vendor/autoload.php is not created yet'
fi

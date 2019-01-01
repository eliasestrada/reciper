![reciper](https://github.com/SerhiiCho/reciper/blob/master/storage/app/public/other/wallpaper.jpg?raw=true)

## About

It's a free web application that unites people who love cooking and charing their recipes with other people. People can register and have their own account where they can publish cooking recipes, and earn experience and popularity points for different actions. Such as publishing recipe, likes, views and starts that they receive from other users. Every register user also has free access to the statistic page, where they can watch stats. For example chart (chart.js with vue.js) with data that shows how many likes, views and stars they received in particular month and general statistic.

## Technologies

* [Laravel - PHP framework](https://github.com/laravel/laravel)
* [Vue.js - JavaScript framework](https://github.com/vuejs/vue)
* [Materialize - CSS framework](https://materializecss.com)
* [Intervention/image](http://image.intervention.io/)
* [ARCANEDEV/LogViewer](https://github.com/ARCANEDEV/LogViewer)
* [laravel/dusk](https://github.com/laravel/dusk)
* [TinyMCE Editor](https://www.tinymce.com/)

## Get started (without Docker)

1. `cp .env.example .env` copy the *env.example* and create *.env*
2. Open just created *.env* file and fill database credentials
3. Create database with the name that you filled in *.env* file in DB_DATABASE field
4. `composer install` to install all PHP packages
5. `php artisan key:generate` to generate laravel app key
6. `php artisan wipe`, migrate all migrations and seed the database
7. `php artisan storage:link`, create a link in public folder to storage
8. `php artisan serve` to start a server *(go to localhost:8000)*
9. `vendor/bin/phpunit` make sure tests are green

## Get started (with Docker)

1. `docker-compose up -d` and wait untill it's done
2. `docker-compose exec server /start.sh` *(go to localhost)*
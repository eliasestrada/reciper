![reciper](https://github.com/SerhiiCho/reciper/blob/master/storage/app/public/other/wallpaper.jpg?raw=true)

# About

##### What is it?

It's a free web application that unites people who love cooking and charing their recipes with other people. People can register and have their own account where they can publish cooking recipes, and earn experience and popularity points for different actions. Such as publishing recipe, likes, views and starts that they receive from other users. Every register user also has free access to the statistic page, where they can watch stats. For example chart (chart.js with vue.js) with data that shows how many likes, views and stars they received in particular month and general statistic.

# Languages

##### Where we at?

For this moment, the application fully supports Russian language and will be supporting English as well. There is no hard coded text in blade files, all text is going through **trans()** laravel function and **@lang()** blade directive. 

##### Files

All Russian translation files are in `resources/lang/ru` folder, they will be copied to `resources/lang/en` folder and translated to English in a future.

##### Database tables

The idea is that depending on what language is currently selected, user or visitor sees materials with chosen language. I have some duplicate fields in database like *title_ru* and *title_en*, *text_ru* and *text_en* etc.. And depending on what language is selected it shows needed fields. Also any author of the recipe will be able to translate his or her recipe from Russian to English or vice versa.

# Get started

##### For non docker people

* Clone and enter downloaded folder
* `cp .env.example .env` copy the *env.example* and create *.env*
* Open just created *.env* file and fill database credentials
* Create database with the name that you filled in *.env* file in DB_DATABASE field
* `composer install` to install all PHP packages
* `npm install` to install node modules
* `npm run prod` to compile sass and vue files
* `php artisan key:generate` to generate laravel app key
* `php artisan wipe`, migrate all migrations and seed the database
* `php artisan storage:link`, create a link in public folder to storage
* `php artisan serve` to start a server *(go to localhost:8000)*
*. `vendor/bin/phpunit` make sure tests are green

##### For docker people

* Clone and enter downloaded folder
* `docker-compose up -d` and wait untill it's done
* `docker-compose exec server /start.sh` *(go to localhost)*

# Editional information

##### Used technologies

* [PHP](http://php.net/)
* [Redis](https://redis.io/)
* [MySQL](https://www.mysql.com/)
* [JavaScript](https://www.javascript.com/)
* [Docker](https://www.docker.com/)

##### Used frameworks

* [laravel/laravel](https://github.com/laravel/laravel) | PHP framework
* [vuejs/vue](https://github.com/vuejs/vue) | JavaScript framework
* [Dogfalo/materialize](https://materializecss.com) | CSS framework
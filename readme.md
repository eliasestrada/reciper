![reciper](https://github.com/SerhiiCho/reciper/blob/master/storage/app/public/other/wallpaper.jpg?raw=true)

**Reciper is a micro-service app and requires [Docker](https://www.docker.com)**

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

> Note that if you want to login as admin, you need to use these credentials:
> **Username:** master
> **Password:** 111111

# Get started

**Clone, enter reciper folder and run `./run`**
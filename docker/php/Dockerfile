FROM php:7.3-fpm

COPY ./start.sh /

########## Install packages ##########
RUN apt-get update \
    && apt-get install -y \
        software-properties-common \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        build-essential \
        libmcrypt-dev \
        mysql-client \
        libcurl3-dev \
        libjpeg-dev \
        libpng-dev \
        libzip-dev \
        libbz2-dev \
        supervisor \
        apt-utils \
        libcurl3 \
        gnupg2 \
        gnupg1 \
        gnupg \
        zip \
        vim \
        \
    ########## Install php extentions ##########
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        gd \
        bz2 \
        zip \
        pcntl \
        bcmath \
        \
    ########## Configure php extentions ##########
    && docker-php-ext-configure \
        gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        \
    ########## Add aliases to a .bashrc file ##########
    && echo 'alias phpunit="vendor/bin/phpunit"' >> ~/.bashrc \
    && echo 'alias pa="php artisan"' >> ~/.bashrc \
    && chmod u+x /start.sh

########## Supervisor ##########
COPY ./laravel-worker.conf /etc/supervisor/conf.d/
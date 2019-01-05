FROM php:7.3-apache

COPY ./start.sh /

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
        apt-utils \
        libcurl3 \
        gnupg2 \
        gnupg1 \
        gnupg \
        zip \
        vim \
    && a2enmod rewrite \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install \
        pdo_mysql \
        bz2 \
        zip \
        pcntl \
        bcmath \
    && echo 'alias phpunit="vendor/bin/phpunit"' >> ~/.bashrc \
    && echo 'alias pa="php artisan"' >> ~/.bashrc \
    && chmod u+x /start.sh
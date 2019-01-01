FROM php:7.3-apache

RUN apt-get update \
    && apt-get install -y \
        apt-utils \
        build-essential \
        mysql-client \
        libbz2-dev \
        libmcrypt-dev \
        libcurl3 \
        libcurl3-dev \
        libzip-dev \
        zip \
        vim \
        software-properties-common \
        gnupg \
        gnupg2 \
        gnupg1 \
        nodejs \
        yarn \
    && curl -sL https://deb.nodesource.com/setup_11.x | bash - \
    && apt-get install npm \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install \
        pdo_mysql \
        bz2 \
        zip \
        pcntl \
        bcmath \
    && a2enmod rewrite \
    && service apache2 restart

COPY ./start.sh /
COPY ./.bashrc ~/.bashrc
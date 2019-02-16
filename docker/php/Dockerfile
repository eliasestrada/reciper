FROM php:7.3-fpm

########## Install packages ##########
RUN apt-get update \
    && apt-get install -y \
        software-properties-common \
        build-essential \
        apt-utils \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libbz2-dev \
        libwebp-dev \
        libmcrypt-dev \
        libcurl3-dev \
        libzip-dev \
        libcurl3-dev \
        mysql-client \
        curl \
        supervisor \
        vim \
        zip \
        unzip \
        gnupg \
        gnupg2 \
        gnupg1 \
    && rm -rf /var/lib/apt/lists/* \
    ########## Configure php extentions ##########
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-webp-dir=/usr/include/ \
    ########## Install php extentions ##########
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        bz2 \
        zip \
        pcntl \
        bcmath \
    ########## Add aliases to a .bashrc file ##########
    && echo 'alias phpunit="vendor/bin/phpunit"' >> ~/.bashrc \
    && echo 'alias pa="php artisan"' >> ~/.bashrc

########## Supervisor ##########
COPY start.sh laravel-worker.conf /etc/supervisor/conf.d/
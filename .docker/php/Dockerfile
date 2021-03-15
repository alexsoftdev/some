FROM php:7.4-fpm

WORKDIR /var/www

RUN apt-get update \
    && apt-get install -y unzip git

# php-opcache
RUN docker-php-ext-install opcache \
    && docker-php-ext-enable opcache

# php-mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql

# php-gd
RUN apt-get install -y libpng-dev \
    && docker-php-ext-install gd

# php-intl
RUN apt-get install -y libicu-dev \
    && docker-php-ext-install intl

# php-zip
RUN apt-get install -y libzip-dev \
    && docker-php-ext-install zip

# php-memcached
RUN apt-get install -y libzip-dev libmemcached-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

# php-redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# composer
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
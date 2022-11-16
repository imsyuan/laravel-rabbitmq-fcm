FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

ARG COMPOSER_ALLOW_SUPERUSER=1

RUN apk update && apk add --no-cache \
    busybox-extras \
    build-base shadow vim curl \
    php8-pdo_mysql \
    nodejs npm

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install sockets
# Install Composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin/ --filename=composer

COPY . .

RUN composer install --ignore-platform-req=ext-sockets
RUN npm install

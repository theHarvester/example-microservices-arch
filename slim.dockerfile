FROM php:7

# PHP extensions

RUN docker-php-ext-install pdo pdo_mysql
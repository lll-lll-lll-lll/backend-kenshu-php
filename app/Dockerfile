FROM php:8.2-apache

WORKDIR /var/www/html

RUN a2enmod rewrite
# compose image
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
&& apt-get install -y \
libpq-dev \
&& docker-php-ext-install \
pdo \
pdo_pgsql \
pgsql


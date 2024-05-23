FROM php:8.2-apache

WORKDIR /var/www/html
RUN a2enmod rewrite

RUN apt-get update \
&& apt-get install -y \
libpq-dev \
&& docker-php-ext-install \
pdo \
pdo_pgsql \
pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json composer.lock ./

# Composerの依存関係をインストールとautoloadの生成
RUN composer install --no-dev --optimize-autoloader

COPY . .

EXPOSE 80

# Apacheをフォアグラウンドで実行
CMD ["apache2-foreground"]

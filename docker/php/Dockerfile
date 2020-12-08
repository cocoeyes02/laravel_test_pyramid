FROM php:5.6-fpm

RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --version=1.10.15 \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html/quickstart-intermediate
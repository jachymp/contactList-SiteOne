FROM php:8.1-fpm

RUN apt-get update
RUN apt-get -y install lsb-release ca-certificates apt-transport-https wget git zip unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli pdo pdo_mysql

WORKDIR /var/www/project

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
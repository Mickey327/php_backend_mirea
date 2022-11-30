FROM composer:latest as composer

FROM php:8.1-apache
COPY --from=composer /usr/bin/composer /usr/local/bin/composer
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get install curl && apt-get install -y git && curl https://jpgraph.net/download/download.php?p=55 --output jpgraph.tar.gz
RUN tar -xzf jpgraph.tar.gz && rm jpgraph.tar.gz && mv jpgraph-4.4.1 jpgraph &&  mv jpgraph/src/ /var/www/ && rm -R jpgraph && cd /var/www/ && mv src jpgraph
COPY composer.json /var/www/composer.json
COPY composer.lock /var/www/composer.lock
RUN cd /var/www/ && composer install
COPY ports.conf /etc/apache2/ports.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
ADD php.ini /usr/local/etc/php
RUN a2enmod rewrite &&  \
    docker-php-ext-install mysqli && \
    a2enmod authn_dbd && \
    pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis && \
    apt-get update && \
    apt-get install -y apache2-utils libaprutil1-dbd-mysql git libfreetype6-dev libjpeg62-turbo-dev libpng-dev unzip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd
FROM php:8.1-apache
RUN docker-php-ext-install mysqli
COPY ports.conf /etc/apache2/ports.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
ADD php.ini /usr/local/etc/php
COPY vendor /var/www/vendor
COPY jpgraph /var/www/jpgraph
RUN docker-php-ext-install mysqli && \
    a2enmod authn_dbd && \
    pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis && \
    apt-get update && \
    apt-get install -y apache2-utils libaprutil1-dbd-mysql git libfreetype6-dev libjpeg62-turbo-dev libpng-dev unzip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd && \
    service apache2 restart
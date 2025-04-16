FROM php:8.4-apache as base

LABEL maintainer="Paul Redmond"

RUN docker-php-ext-install pdo_mysql opcache && \
    a2enmod rewrite negotiation

COPY build/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

FROM base as development

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY build/php/conf.d/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

RUN pecl channel-update pecl.php.net && \
    pecl install xdebug-3.4.0 && \
    docker-php-ext-enable xdebug

FROM base as app

RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
#COPY . /srv/app

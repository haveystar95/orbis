FROM php:8.1.0-fpm-alpine

RUN apk add --update linux-headers
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash

ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql

COPY . /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm
COPY ../../entrypoint.sh /usr/local/bin/

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
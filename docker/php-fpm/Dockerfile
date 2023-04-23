FROM php:8.1.0-fpm-alpine

RUN apk add --update linux-headers
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash su-exec

ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql

COPY . /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ../../entrypoint.sh /usr/local/bin/

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000

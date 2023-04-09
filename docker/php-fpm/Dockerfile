FROM php:8.1.0-fpm-alpine

ARG user=user
ARG uid=1000

RUN apk add --update linux-headers
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash

ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; \
    then \
      pecl install xdebug && docker-php-ext-enable xdebug; \
    fi;

COPY ./docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo_pgsql


RUN adduser -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN chown user:user /var/www
COPY --chown=user:user ./ /var/www
WORKDIR /var/www

USER $user

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#RUN composer install --no-interaction

CMD php-fpm

EXPOSE 9000
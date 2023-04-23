FROM nginx:alpine
COPY nginx.conf /etc/nginx/
COPY default.conf /etc/nginx/conf.d/
COPY . /var/www/

ARG PHP_UPSTREAM_CONTAINER=php-fpm
ARG PHP_UPSTREAM_PORT=9000
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.con

EXPOSE 80

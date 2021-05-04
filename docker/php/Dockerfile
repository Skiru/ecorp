FROM composer:2.0.13 as composer-prod
WORKDIR /app
COPY ./ ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-progress --ignore-platform-reqs

FROM php:7.4-fpm-alpine
RUN set -ex
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    postgresql-dev && \
    docker-php-ext-install bcmath && \
    docker-php-ext-enable bcmath && \
    docker-php-ext-install pdo pdo_pgsql && \
    docker-php-ext-enable pdo pdo_pgsql && \
    docker-php-ext-install opcache && \
    docker-php-ext-enable opcache && \
    rm -rf /tmp/pear

ENV APP_ENV=prod \
    APP_SECRET=ca6777ca3b9d07d5a38d4f68036f232d \
    DATABASE_URL="pgsql://mrrobot:root@ecorp_purple_clouds_postgres/idp_purpleclouds"

RUN  mkdir -p /var/www/html/var/log/
COPY ./docker/php/php.ini /etc/php7/conf.d/php.ini
COPY ./ /var/www/html
COPY --from=composer-prod /app/vendor /var/www/html/vendor
RUN chmod 777 -R /var/www/html
FROM php:7.3-fpm

RUN apt-get update && apt-get install -y libpq-dev git unzip zlib1g-dev libzip-dev
RUN docker-php-ext-install pdo pdo_pgsql zip mbstring bcmath
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./composer.json ./
COPY ./composer.lock ./

RUN composer install --no-dev --no-scripts --ignore-platform-reqs
# Install xdebug

RUN  mkdir -p /var/www/html/var/log/
COPY ./ /var/www/html

COPY ./.env.dist ./.env
ENV APP_ENV=prod \
    APP_SECRET=ca6777ca3b9d07d5a38d4f68036f232d \
    KERNEL_CLASS=App\Kernel \
    APP_SECRET=s$cretf0rt3s \
    SYMFONY_DEPRECATIONS_HELPER=999999 \
    DATABASE_URL="pgsql://mrrobot:root@77.55.222.35:5432/purpleclouds"

RUN chmod 777 -R /var/www/html

RUN pecl install xdebug
RUN docker-php-ext-enable --ini-name xdebug.ini xdebug
RUN { \
    echo 'xdebug.remote_enable=On'; \
    echo 'xdebug.remote_autostart=Off'; \
    echo 'xdebug.idekey=PHPSTORM'; \
    echo 'xdebug.remote_connect_back=On'; \
} >> /usr/local/etc/php/conf.d/xdebug.ini

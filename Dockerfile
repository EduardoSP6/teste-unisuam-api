FROM php:8.3-fpm

ARG APP_DIR=/var/www

USER root

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_pgsql

RUN chmod 777 /run
RUN usermod -u 1000 www-data

WORKDIR $APP_DIR
RUN cd $APP_DIR

RUN chmod 755 -R * || true
RUN chown -R www-data:www-data * || true

COPY --from=composer /usr/bin/composer /usr/bin/composer

USER www-data

EXPOSE 9000

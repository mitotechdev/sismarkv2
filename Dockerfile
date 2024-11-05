# FROM php:8.2-fpm-alpine

# WORKDIR /var/www/app

# RUN apk update && apk add \
#     curl \
#     libpng-dev \
#     libxml2-dev \
#     zip \
#     unzip

# RUN docker-php-ext-install pdo pdo_mysql \
#     && apk --no-cache add nodejs npm

# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# USER root

# RUN chmod 777 -R /var/www/app


# versi baru
FROM php:8.2-fpm

WORKDIR /var/www/app

RUN apt-get update \
  && apt-get install -y build-essential zlib1g-dev default-mysql-client curl gnupg procps vim git unzip libzip-dev libpq-dev \
  && docker-php-ext-install zip pdo_mysql pdo_pgsql pgsql

RUN apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN chmod 777 -R /var/www/app 
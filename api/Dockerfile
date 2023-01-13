
FROM php:8.1-fpm

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN apt-get install -y openssl
RUN apt-get install -y libzip-dev libonig-dev libicu-dev
RUN apt-get install -y autoconf pkg-config libssl-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring pcntl bcmath gd
RUN docker-php-ext-install bcmath mbstring intl opcache
RUN docker-php-ext-install pdo mysqli

RUN pecl install mongodb
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN echo "extension=mongodb.so" > /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#RUN php artisan config:clear

RUN composer install

#RUN composer require jenssegers/mongodb
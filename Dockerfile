FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev

RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

RUN docker-php-ext-install \
    pdo_mysql \
    bcmath \
    intl \
    mbstring \
    exif \
    zip \
    gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

CMD ["php-fpm"]


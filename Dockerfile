FROM php:8.4-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 10000

CMD ["sh", "-c", "php artisan config:clear && php artisan migrate:fresh --seed --force && php-fpm -D && nginx -g 'daemon off;'"]

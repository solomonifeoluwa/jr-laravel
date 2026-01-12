FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev curl

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t public"]

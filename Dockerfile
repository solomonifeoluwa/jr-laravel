FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev curl

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www
COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t public"]

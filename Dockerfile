FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www

# Copy app files
COPY . .

# Install dependencies
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer install --no-interaction --prefer-dist

CMD ["php-fpm"]

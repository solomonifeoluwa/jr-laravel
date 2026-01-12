FROM php:8.3-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev curl \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www

# Copy app
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel optimizations
RUN php artisan key:generate --force || true
RUN php artisan config:clear
RUN php artisan config:cache
RUN php artisan route:cache || true
RUN php artisan view:clear

# Storage permissions
RUN chmod -R 775 storage bootstrap/cache

# Start server on Railway-assigned port
CMD php -S 0.0.0.0:$PORT -t public


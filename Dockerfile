# Use the official PHP image with Apache (best for Laravel)
FROM php:8.2-apache

# Install system dependencies and PHP extensions required by Laravel + Firebase
RUN apt-get update && apt-get install -y \
    unzip git curl libpq-dev libonig-dev libxml2-dev libzip-dev \
    libjpeg62-turbo-dev libpng-dev libssl-dev libgmp-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip gmp

# Enable Apache mod_rewrite (important for Laravel routes)
RUN a2enmod rewrite

# Install Composer (latest stable)
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install PHP dependencies (skip artisan during build)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set correct permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose Render’s default port
EXPOSE 10000

# Update Apache to listen on Render’s port
RUN sed -i 's/80/10000/' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Start Apache in foreground
CMD sh -c "php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && exec apache2-foreground"



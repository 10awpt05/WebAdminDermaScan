# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    curl \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mbstring bcmath xml pdo pdo_pgsql zip
RUN docker-php-ext-enable mbstring bcmath xml pdo pdo_pgsql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/html/

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy application code
COPY . /var/www/html

# Ensure storage and cache directories are writable
RUN mkdir -p bootstrap/cache storage/logs storage/framework/cache/data storage/framework/sessions storage/framework/views \
    && chmod -R 777 bootstrap/cache storage

# Expose port 80
EXPOSE 80

# Run Laravel package discovery
RUN php artisan package:discover

# Start Apache
CMD ["apache2-foreground"]

# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    curl \
    && docker-php-ext-install mbstring bcmath xml pdo pdo_pgsql curl zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Create storage and bootstrap/cache directories with writable permissions
RUN mkdir -p bootstrap/cache storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && chmod -R 777 bootstrap/cache storage

# Copy composer files first (for Docker layer caching)
COPY composer.lock composer.json /var/www/html/

# Install Composer (from official Composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy .env example so Laravel can run during build
COPY .env.example .env

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the app files
COPY . /var/www/html

# Run Laravel package discovery
RUN php artisan package:discover

# Ensure storage and cache directories remain writable
RUN chmod -R 777 bootstrap/cache storage

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

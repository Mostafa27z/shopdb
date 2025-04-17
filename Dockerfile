# Use the official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files to the container
COPY . .

# Install Composer (fetch from the latest official Composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies via Composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Set permissions for storage and cache (ensure the web server can write)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose Apache port
EXPOSE 80

# Set the default command to run Apache in the foreground
CMD ["apache2-foreground"]

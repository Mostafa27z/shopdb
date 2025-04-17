FROM php:8.2-apache

# System & PHP deps
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable rewrite and serve Laravel from /public
RUN a2enmod rewrite \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Use dynamic port for Railway
ENV PORT=8080
EXPOSE 8080

CMD ["apache2-foreground"]

# Use the official PHP image as base
FROM php:8.1-fpm

# Install necessary packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Install Xdebug
RUN pecl install xdebug-3.2.2 && docker-php-ext-enable xdebug

# Set the working directory
WORKDIR /var/www

# Copy Composer from official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the default command
CMD ["php-fpm"]

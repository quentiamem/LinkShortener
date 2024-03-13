FROM php:7.4-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache modules
RUN a2enmod rewrite

# Copy project files to Apache root directory
COPY . /var/www/html

# Set Apache document root
WORKDIR /var/www/html
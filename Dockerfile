FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libcurl4-openssl-dev

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql curl

# Enable Apache rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
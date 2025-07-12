# Use official PHP Apache image
FROM php:8.1-apache

# Install MySQLi extension for database access
RUN docker-php-ext-install mysqli

RUN sed -i 's|http://deb.debian.org|https://deb.debian.org|g'  /etc/apt/sources.list.d/debian.sources && \
    apt-get update && \
    apt-get install -y default-mysql-client && \
    docker-php-ext-install mysqli && \
    apt-get clean && rm -rf /var/lib/apt/lists/*
COPY index.php /var/www/html/.

# Set file permissions (optional but useful in dev)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80


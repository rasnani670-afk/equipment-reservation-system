# Use an official PHP image with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite (important for many PHP apps)
RUN a2enmod rewrite

# Copy all files from your project to the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Set correct permissions (optional, helpful)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

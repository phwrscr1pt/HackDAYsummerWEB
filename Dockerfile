# PTPetho CTF - PHP + Apache Docker Image
FROM php:8.1-apache

# Install PHP extensions for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure PHP for development (show errors for educational purposes)
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Custom PHP settings
RUN echo "display_errors = On" >> "$PHP_INI_DIR/php.ini" && \
    echo "error_reporting = E_ALL" >> "$PHP_INI_DIR/php.ini" && \
    echo "session.cookie_httponly = Off" >> "$PHP_INI_DIR/php.ini" && \
    echo "session.cookie_samesite = " >> "$PHP_INI_DIR/php.ini"

# Apache configuration for .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

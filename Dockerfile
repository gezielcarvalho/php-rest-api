FROM php:8.1-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Copy .htaccess from example if it doesn't exist
RUN if [ ! -f /var/www/html/public/.htaccess ]; then \
        cp /var/www/html/public/.htaccess.example /var/www/html/public/.htaccess; \
    fi

# Copy .env for Docker
RUN if [ -f /var/www/html/.env.docker ]; then \
        cp /var/www/html/.env.docker /var/www/html/public/.env; \
    elif [ ! -f /var/www/html/public/.env ]; then \
        cp /var/www/html/public/.env.example /var/www/html/public/.env; \
    fi

# Update Apache configuration to point to public directory
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

FROM php:8.2-apache

# Install Composer
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Copy Apache configuration
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Install necessary packages and enable Apache modules
RUN apt-get update && apt-get install -y zip unzip && \
    docker-php-ext-install pdo pdo_mysql bcmath && \
    a2enmod rewrite && \
    a2ensite 000-default.conf

# Set the working directory
WORKDIR /var/www/reane-backend

# Copy the project files to the container
COPY . .

# Install Composer dependencies
RUN cd src && composer install

# Generate Laravel application key
RUN cd src && php artisan key:generate

# Start Apache server
CMD ["apache2-foreground"]
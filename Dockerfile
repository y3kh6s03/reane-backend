FROM php:8.2-apache

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get install -y zip unzip && \
    docker-php-ext-install pdo pdo_mysql bcmath

WORKDIR /var/www/reane-backend/src

COPY . /var/www/reane-backend/src

RUN echo "Listen 80" >> /etc/apache2/ports.conf && \
    a2enmod rewrite && \
    a2ensite 000-default.conf && \
    a2dissite 000-default.conf && \
    service apache2 restart

RUN composer install
RUN php artisan key:generate

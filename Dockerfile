FROM php:8.2-apache

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get install -y zip unzip && \
    docker-php-ext-install pdo pdo_mysql bcmath && \
    a2enmod rewrite && \
    a2ensite 000-default.conf

WORKDIR /var/www

COPY . /var/www/reane-backend

RUN cd /var/www/reane-backend/src && composer install
RUN cd /var/www/reane-backend/src && php artisan key:generate

CMD ["apache2-foreground"]

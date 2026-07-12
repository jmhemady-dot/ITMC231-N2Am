FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

RUN mkdir -p /var/www/html/uploads
RUN chmod -R 777 /var/www/html/uploads
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

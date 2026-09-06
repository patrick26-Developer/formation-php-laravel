FROM php:8.3-apache

# Active l'extension PDO MySQL, nécessaire au mini-projet (module 02.8)
RUN docker-php-ext-install pdo_mysql

COPY . /var/www/html/

EXPOSE 80

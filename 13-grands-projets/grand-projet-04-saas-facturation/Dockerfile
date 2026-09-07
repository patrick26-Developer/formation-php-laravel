FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

FROM php:8.3-fpm-alpine
WORKDIR /var/www/html

RUN docker-php-ext-install pdo_mysql

COPY --from=vendor /app/vendor ./vendor
COPY . .

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache

USER www-data
EXPOSE 9000
CMD ["php-fpm"]

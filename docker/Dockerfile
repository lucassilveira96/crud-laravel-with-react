FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev zip \
    && docker-php-ext-install pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && HASH=`curl -sS https://composer.github.io/installer.sig` \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

CMD cd /var/www/html/api-laravel \
   && composer update --prefer-dist \
   && php artisan key:generate \
   && php artisan cache:clear \
   && php artisan config:cache \
   && php artisan l5-swagger:generate \
   && php artisan config:clear \
   && php artisan migrate:fresh \
   && php artisan route:clear \
   && php artisan test \
   && php artisan serve --host=0.0.0.0 --port=8000


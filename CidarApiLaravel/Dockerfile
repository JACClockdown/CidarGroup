FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpq-dev \
  libpng-dev \
  libzip-dev \
  unzip

RUN docker-php-ext-install pdo pdo_pgsql pgsql gd zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY ./ /var/www/html

RUN composer update

RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

RUN php artisan key:generate

RUN php artisan jwt:secret

RUN php artisan config:clear


RUN chmod -R 777 /var/www/html

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
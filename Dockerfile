FROM php:7.4-apache

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update \
        && apt-get install -y vim unzip curl openssl \
        && curl -sL https://deb.nodesource.com/setup_14.x | bash - \
        && apt-get install -y nodejs

# Install system dependencies library
RUN apt-get install -y libonig-dev libxml2-dev zlib1g-dev libpng-dev libjpeg-dev libzip-dev

RUN pecl install redis

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath zip
RUN docker-php-ext-configure gd \
    && docker-php-ext-install gd \
    && docker-php-ext-enable redis

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

COPY . .

RUN composer install

RUN chown -R www-data:www-data ./
RUN chmod -R 755 storage/
#RUN php artisan tenants:migrate

EXPOSE 80
#CMD apache2-foreground -k restart

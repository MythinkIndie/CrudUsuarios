# Imagen base oficial de PHP con Apache
FROM php:8.3-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev zip libxml2-dev libpng-dev libonig-dev \
    && docker-php-ext-install intl pdo pdo_mysql opcache zip gd mbstring xml

RUN a2enmod rewrite

# Establece el directorio de trabajo
WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# COPY crud/composer.json ./

COPY crud/ .

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN php bin/console debug:router --env=prod

RUN chown -R www-data:www-data var
RUN chmod -R 775 var

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
# Imagen base oficial de PHP con Apache
FROM php:8.3-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev zip libxml2-dev libpng-dev libonig-dev \
    && docker-php-ext-install intl pdo pdo_mysql opcache zip gd mbstring xml

RUN a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia solo los archivos de Composer primero (para aprovechar cache)
COPY crud/composer.json crud/composer.lock ./

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY crud/ .

RUN php bin/console cache:clear --env=prod
RUN php bin/console cache:warmup --env=prod

RUN chown -R www-data:www-data var
RUN chmod -R 775 var

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN php bin/console debug:router --env=prod

EXPOSE 80
CMD ["apache2-foreground"]
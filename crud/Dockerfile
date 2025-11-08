# Imagen base con PHP y Composer
FROM php:8.2-apache

# Instala dependencias necesarias para Symfony
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql opcache zip

# Habilita Apache mod_rewrite
RUN a2enmod rewrite

# Copia el proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# Instala dependencias de PHP
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Configura Apache para usar la carpeta 'public'
RUN echo "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

# Expone el puerto HTTP
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
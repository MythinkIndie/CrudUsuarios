# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql opcache zip \
    && a2enmod rewrite

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia solo los archivos de Composer primero (para aprovechar cache)
COPY composer.json ./

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Luego copia el resto del código
COPY . .

# Configura Apache para servir desde 'public'
RUN echo "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
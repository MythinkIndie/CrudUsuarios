# Imagen base oficial de PHP con Apache
FROM php:8.3-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev zlib1g-dev libxml2-dev libpng-dev libonig-dev \
    && docker-php-ext-install intl pdo pdo_mysql opcache zip gd mbstring xml

# Habilitar mod_rewrite para Symfony
RUN a2enmod rewrite

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar Composer desde la imagen oficial de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar todo el proyecto desde la carpeta `crud/`
COPY crud/ .

# Instalar dependencias PHP sin ejecutar scripts automáticos
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Ejecutar manualmente los scripts Symfony (limpiar y precargar caché)
RUN php bin/console cache:clear --env=prod
RUN php bin/console cache:warmup --env=prod

# Dar permisos adecuados
RUN chown -R www-data:www-data var
RUN chmod -R 775 var

# Configurar Apache para que use public/ como root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Exponer puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]

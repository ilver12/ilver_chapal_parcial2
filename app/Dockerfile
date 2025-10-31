# Usa la imagen base de PHP 8.2 con Apache
FROM php:8.2-apache

# Información del mantenedor
LABEL maintainer="ilverand"
LABEL description="Aplicación PHP con MySQL para proyecto Docker"

# Instalar extensiones necesarias de PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite de Apache (útil para rutas limpias)
RUN a2enmod rewrite

# Copiar archivos de la aplicación al directorio web de Apache
COPY . /var/www/html/

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer el puerto 80
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]

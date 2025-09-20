# Image de base PHP + Apache
FROM php:8.2-apache

# Installer les extensions PHP pour MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Copier tout le site web
COPY . /var/www/html/

# S'assurer que les fichiers appartiennent à Apache
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80
EXPOSE 80


FROM php:5.6-apache

# Instala as extensões do PHP necessárias para o MySQL
RUN docker-php-ext-install mysql mysqli pdo_mysql && a2enmod rewrite

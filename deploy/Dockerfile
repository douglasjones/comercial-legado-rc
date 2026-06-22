FROM php:5.6-apache

RUN docker-php-ext-install mysql mysqli pdo_mysql \
    && a2enmod rewrite headers \
    && { \
        echo 'file_uploads = On'; \
        echo 'upload_max_filesize = 6M'; \
        echo 'post_max_size = 8M'; \
        echo 'memory_limit = 256M'; \
        echo 'max_execution_time = 120'; \
        echo 'date.timezone = America/Sao_Paulo'; \
      } > /usr/local/etc/php/conf.d/99-uploads.ini \
    && mkdir -p /var/appdata/uploads

COPY apache/security.conf /etc/apache2/conf-available/rc-security.conf
COPY docker-entrypoint-rc.sh /usr/local/bin/docker-entrypoint-rc.sh
COPY app/ /var/www/html/

RUN a2enconf rc-security \
    && chown -R www-data:www-data /var/www/html /var/appdata/uploads \
    && chmod +x /usr/local/bin/docker-entrypoint-rc.sh

WORKDIR /var/www/html

ENTRYPOINT ["docker-entrypoint-rc.sh"]
CMD ["apache2-foreground"]

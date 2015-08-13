FROM php:5.6-apache

# Install libraries and tools
RUN apt-get update && apt-get install -y \
      curl git unzip
RUN a2enmod rewrite
ADD setup/php.ini /usr/local/etc/php/php.ini
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer
ADD . /var/www/html
WORKDIR /var/www/html
RUN composer --optimize-autoloader install
CMD ["/usr/local/bin/apache2-foreground"]

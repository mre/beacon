FROM php:5.6-apache

# Install libraries and tools
RUN apt-get update && apt-get install -y \
      curl git unzip
RUN a2enmod rewrite

# Install tideways profiler which is compatible with xhprof, but more modern
WORKDIR /usr/src/php/ext
ADD https://github.com/tideways/php-profiler-extension/archive/v2.0.10.zip tideways.zip
RUN unzip tideways.zip && mv php-profiler-extension-2.0.10 tideways && rm tideways.zip \
    && docker-php-ext-install tideways \
    && mkdir /profiler_output && chown www-data:www-data /profiler_output/

ADD setup/php.ini /usr/local/etc/php/php.ini
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

ADD . /var/www/html
WORKDIR /var/www/html

RUN chmod +x setup/run.sh
CMD ["setup/./run.sh"]

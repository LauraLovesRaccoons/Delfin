FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"
# RUN mv composer.phar /usr/local/bin/composer
RUN apt-get update && apt-get upgrade -y

RUN apt-get install -y libzip-dev git && \
    docker-php-ext-install zip

# Increase max upload size to 20MB
RUN echo "upload_max_filesize=20M" > /usr/local/etc/php/conf.d/upload_large_dumps.ini && \
    echo "post_max_size=20M" >> /usr/local/etc/php/conf.d/upload_large_dumps.ini

EXPOSE 8000-8010
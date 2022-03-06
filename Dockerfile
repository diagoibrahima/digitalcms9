FROM php:8.1.3-apache-buster
COPY ./docker/my-httpd.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        zlib1g-dev \
        libzip-dev \
        libxml2-dev \
        libicu-dev \
        libpng-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install mysqli pdo pdo_mysql intl gd zip

RUN mv ${PHP_INI_DIR}/php.ini-production ${PHP_INI_DIR}/php.ini \
    && sed -E -i -e 's/upload_max_filesize = 2M/upload_max_filesize = 128M/' ${PHP_INI_DIR}/php.ini \
    && sed -E -i -e 's/post_max_size = 8M/post_max_size = 128M/' ${PHP_INI_DIR}/php.ini \
    && sed -E -i -e 's/memory_limit = 128M/memory_limit = 256M/' ${PHP_INI_DIR}/php.ini

WORKDIR /var/www

#ARG DIGITALCMS_APP_VERSION=CmstNewVersion2
#ENV DIGITALCMS_APP_VERSION=${DIGITALCMS_APP_VERSION}

#RUN git clone --depth 1 --branch "$DIGITALCMS_APP_VERSION" https://github.com/diagoibrahima/digitalcms9.git \
RUN git clone --depth 1 --branch main https://github.com/diagoibrahima/digitalcms9.git \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && cd digitalcms9 \
    && /usr/local/bin/composer install \
    && chown -R www-data:www-data /var/www/digitalcms9
    #&& php /var/www/digitalcms9/bin/console cache:clear


CMD ["apachectl", "-D", "FOREGROUND"]

EXPOSE 80
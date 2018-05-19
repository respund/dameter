FROM hermsi/alpine-fpm-php

# get compser
RUN	apk update && \
	apk upgrade && \
	apk add --update curl openssl && \
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  && \
	chmod +x /usr/local/bin/composer && \
	apk del curl openssl && \
    rm -rf /var/cache/apk/*

#install phpUnit & composer and add a healthcheck we can use in AWS
RUN \
    wget "https://phar.phpunit.de/phpunit.phar" && \
    chmod +x phpunit.phar && \
    mv phpunit.phar /usr/local/bin/phpunit

# add php extensions
RUN docker-php-ext-install bcmath

#add mysql-client for running tests
RUN	apk add --update mysql-client

#install xdebug

RUN apk update \
    && apk add  --no-cache libmcrypt libmcrypt-dev \
    && apk add --no-cache --virtual build-dependencies icu-dev \
    libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf \
    && docker-php-source extract \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug redis \
    && docker-php-source delete \
    && apk del build-dependencies \
    && apk del libmcrypt-dev \
    && rm -rf /tmp/*

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug-dev.ini

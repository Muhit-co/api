FROM php:fpm-alpine3.10

RUN apk --update add wget \
        curl \
        git \
        grep \
        nginx \
        build-base \
        libmemcached-dev \
        libmcrypt-dev \
        libxml2-dev \
        zlib-dev \
        autoconf \
        cyrus-sasl-dev \
        libgsasl-dev \
        supervisor \
        re2c \
        openssl \
        nodejs \
        npm

RUN docker-php-ext-install mysqli mbstring pdo pdo_mysql tokenizer xml opcache soap

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install igbinary
RUN cd /tmp && \
        wget https://github.com/igbinary/igbinary/archive/3.0.1.zip && \
        unzip 3.0.1.zip && cd igbinary-3.0.1 && \
        phpize && ./configure && make && make install && \
        docker-php-ext-enable igbinary

# install memcached
RUN cd /tmp && \
        wget https://github.com/php-memcached-dev/php-memcached/archive/v3.1.3.zip && \
        unzip v3.1.3.zip && cd php-memcached-3.1.3 && \
        phpize && ./configure --enable-memcached-igbinary && make && make install && \
        docker-php-ext-enable memcached

# clean up and create www
RUN mkdir -p /var/www && \
        rm -rf /tmp/*

WORKDIR /var/www/html

COPY . ./
RUN composer install
RUN chown -R www-data:www-data ./

# copy service configs and files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/php-uploads.ini /usr/local/etc/php/conf.d/uploads.ini
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

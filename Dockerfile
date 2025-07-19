FROM php:8.4-cli
LABEL maintainer="Majid Akbari <majidakbariiii@gmail.com"

RUN apt-get update -y && \
    apt-get install -y --no-install-recommends \
        git \
        libonig-dev \
        libssl-dev \
        libzip-dev \
        unzip \
        zlib1g-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install -j"$(nproc)" \
        bcmath \
        mbstring \
        pcntl \
        sockets \
        zip && \
    docker-php-ext-configure bcmath --enable-bcmath

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader
COPY src/ .
CMD ["php", "main.php"]
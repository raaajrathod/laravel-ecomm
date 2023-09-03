FROM php:8.2-fpm

COPY ./app /var/www

WORKDIR /var/www

RUN apt -y install gcc make autoconf libc-dev pkg-config

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libonig-dev \
    libzip-dev \
    libcurl4-openssl-dev libssl-dev \
    locales \
    zip \
    vim \
    unzip \
    git \
    curl \
    openssl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip pcntl opcache

RUN apt-get update && apt-get install -y

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 2000 www
RUN useradd -u 2000 -ms /bin/bash -g www www

COPY --chown=www:www ./app /var/www

RUN composer install

USER www

EXPOSE 9000

CMD ["php-fpm"]

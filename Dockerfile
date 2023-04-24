FROM php:apache

# Name the Image
LABEL maintainer="bepositve"
LABEL name="bepositve"

# Copy the application files
COPY . /var/www/html

# Install the Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install extensions : ext-gd, ext-mysqli, ext-pdo_mysql, ext-zip
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo_mysql zip

# Change the working directory
WORKDIR /var/www/html


# Install the composer dependencies
RUN composer install








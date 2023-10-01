FROM php:8.1.5-apache
RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y \
  zip \
  git \
  && rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer
RUN composer require google/apiclient:^2.12 \
    && composer clear-cache

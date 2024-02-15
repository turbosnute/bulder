FROM php:8.3.0-apache-bullseye
RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y \
  zip \
  git \
  && rm -rf /var/lib/apt/lists/*
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer
RUN composer require google/apiclient:^2.15.0 \
    && composer clear-cache
WORKDIR /var/www/html
COPY web/ /var/www/html
RUN find . -type f -name "*.php" ! -path "*/vendor/*" -exec chmod 644 {} \;

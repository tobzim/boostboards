# BoostBoards — Kirby CMS in Docker
# PHP 8.3 + Apache, optimized for Kirby's flat-file CMS

FROM php:8.3-apache

# ----- System dependencies for Kirby (image processing, intl, zip)
RUN apt-get update && apt-get install -y --no-install-recommends \
        libfreetype-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libavif-dev \
        libicu-dev \
        libzip-dev \
        libxml2-dev \
        libonig-dev \
        unzip \
        git \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
        --with-avif \
    && docker-php-ext-install -j$(nproc) \
        gd \
        intl \
        zip \
        exif \
        opcache \
    && rm -rf /var/lib/apt/lists/*

# ----- Apache config
RUN a2enmod rewrite headers expires deflate
ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess
RUN printf '<Directory /var/www/html>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
    > /etc/apache2/conf-available/kirby.conf \
    && a2enconf kirby

# ----- PHP runtime tuning
RUN { \
        echo 'memory_limit=512M'; \
        echo 'upload_max_filesize=128M'; \
        echo 'post_max_size=128M'; \
        echo 'max_execution_time=120'; \
        echo 'opcache.enable=1'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.max_accelerated_files=20000'; \
        echo 'opcache.revalidate_freq=2'; \
    } > /usr/local/etc/php/conf.d/kirby.ini

# ----- Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Install Kirby + dependencies first (better layer caching)
COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Copy the rest of the project
COPY . .

# Permissions for content and media
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Ensure mounted /media and /site/accounts volumes belong to www-data
# on every container start (named volumes mount as root by default).
RUN { \
        echo '#!/bin/sh'; \
        echo 'set -e'; \
        echo 'chown -R www-data:www-data /var/www/html/media /var/www/html/site/accounts 2>/dev/null || true'; \
        echo 'exec "$@"'; \
    } > /usr/local/bin/boost-entrypoint.sh \
    && chmod +x /usr/local/bin/boost-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/boost-entrypoint.sh"]
CMD ["apache2-foreground"]

EXPOSE 80

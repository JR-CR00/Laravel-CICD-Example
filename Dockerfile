# Stage 1 — builder + tests
FROM php:8.4-fpm-alpine AS builder

RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    curl

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip \
    bcmath \
    opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
COPY .env.example .env

# Instala TODO para correr los tests
RUN composer install --optimize-autoloader
RUN php artisan key:generate
RUN php artisan test

# Reinstala sin dev para producción
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Stage 2 — producción limpia
FROM php:8.4-fpm-alpine AS production

# Copia las extensiones compiladas del builder en lugar de recompilarlas
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Solo las libs de sistema necesarias en runtime
RUN apk add --no-cache \
    libpq \
    libzip

WORKDIR /var/www/html


COPY --from=builder /var/www/html/app ./app
COPY --from=builder /var/www/html/bootstrap ./bootstrap
COPY --from=builder /var/www/html/config ./config
COPY --from=builder /var/www/html/database ./database
COPY --from=builder /var/www/html/public ./public
COPY --from=builder /var/www/html/resources ./resources
COPY --from=builder /var/www/html/routes ./routes
COPY --from=builder /var/www/html/storage ./storage
COPY --from=builder /var/www/html/vendor ./vendor
COPY --from=builder /var/www/html/artisan .
COPY --from=builder /var/www/html/composer.json .
COPY --from=builder /var/www/html/composer.lock .

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
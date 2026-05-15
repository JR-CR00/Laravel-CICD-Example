# =========================
# Stage 1 — Builder
# =========================
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

# Instala dependencias (PROD)
RUN composer install --no-dev --optimize-autoloader

# =========================
# Stage 2 — Production
# =========================
FROM php:8.4-fpm-alpine AS production

RUN apk add --no-cache \
    libpq \
    libzip

# Copiar extensiones PHP
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

WORKDIR /var/www/html

# Copiar app ya construida
COPY --from=builder /var/www/html /var/www/html

# Permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
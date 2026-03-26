FROM php:8.3-fpm-alpine

WORKDIR /var/www

# Installera nödvändiga paket + linux-headers för sockets
RUN apk add --no-cache \
    icu-libs \
    libzip \
    freetype \
    libjpeg-turbo \
    libpng \
    oniguruma && \
  apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    icu-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    oniguruma-dev \
    linux-headers && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    gd \
    intl \
    zip \
    sockets \
    mbstring && \
  apk del .build-deps && \
  rm -rf /tmp/* /var/cache/apk/* /usr/src/php*

# Skapa användare som matchar host (viktigt för volym-mount i dev)
ARG UID=1000
ARG GID=1000

RUN addgroup -g ${GID} -S www && \
    adduser -u ${UID} -S -D -G www www

# Kopiera applikationen med rätt ägare från början
COPY --chown=www:www . /var/www

USER www

EXPOSE 9000

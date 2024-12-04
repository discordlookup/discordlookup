FROM node:22-alpine AS build

WORKDIR /build

COPY . .

RUN npm ci
RUN npm run prod


FROM trafex/php-nginx:3.6.0
RUN rm -rf /var/www/html/*

USER root

RUN apk add --no-cache \
    git \
    php83-exif \
    php83-pdo \
    php83-pdo_mysql \
    php83-pdo_pgsql \
    php83-pdo_redis

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

COPY . .
COPY --from=build /build/public /var/www/html/public

ENV APP_ENV=production
ENV APP_DEBUG=false

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/root

RUN chown -R nobody:nobody /var/www/html
RUN chmod -R 775 storage bootstrap/cache

USER nobody

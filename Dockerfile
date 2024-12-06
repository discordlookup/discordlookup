FROM node:22-alpine AS build

WORKDIR /build

COPY . .

RUN npm ci
RUN npm run prod


FROM alpine:3.20

WORKDIR /var/www/html

RUN apk add --no-cache \
    git \
    curl \
    busybox-suid \
    libcap \
    supervisor \
    nginx \
    php83 \
    php83-ctype \
    php83-curl \
    php83-dom \
    php83-fileinfo \
    php83-fpm \
    php83-gd \
    php83-intl \
    php83-mbstring \
    php83-mysqli \
    php83-opcache \
    php83-openssl \
    php83-phar \
    php83-session \
    php83-tokenizer \
    php83-xml \
    php83-xmlreader \
    php83-xmlwriter \
    php83-exif \
    php83-pdo \
    php83-pdo_mysql \
    php83-pdo_pgsql \
    php83-redis

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY docker/nginx /etc/nginx
COPY docker/fpm-pool.conf /etc/php83/php-fpm.d/www.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY . .
COPY --from=build /build/public /var/www/html/public

ENV APP_ENV=production
ENV APP_DEBUG=false

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN chown -R nobody:nobody /var/www/html /run /var/lib/nginx /var/log/nginx /usr/sbin/crond
RUN chmod -R 775 storage bootstrap/cache

RUN setcap cap_setgid=ep /bin/busybox

RUN rm /etc/crontabs/root
RUN echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/nobody
RUN sed -ri 's/^(nobody.*:)\/sbin\/nologin$/\1\/bin\/sh/' /etc/passwd

USER nobody

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping || exit 1

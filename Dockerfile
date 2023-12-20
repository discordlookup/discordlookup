FROM node:20-alpine AS build

WORKDIR /build

COPY . .

RUN npm ci
RUN npm run prod


FROM webdevops/php-nginx:8.2-alpine

RUN apk add oniguruma-dev postgresql-dev libxml2-dev
RUN docker-php-ext-install \
        bcmath \
        pdo_mysql \
        pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=build /build/public /app/public

ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV production
WORKDIR /app
COPY . .

RUN echo "server_tokens off;" > /etc/nginx/conf.d/server_tokens.conf
RUN echo "* * * * * cd /app && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/root

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN php artisan optimize:clear

RUN chown -R application:application .
RUN chmod -R 777 storage/

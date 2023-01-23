FROM webdevops/php-nginx:8.2-alpine

RUN apk add oniguruma-dev postgresql-dev libxml2-dev
RUN docker-php-ext-install \
        bcmath \
        pdo_mysql \
        pdo_pgsql

# Copy Composer binary from the Composer official Docker image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV production
WORKDIR /app
COPY . .

RUN echo "server_tokens off;" > /etc/nginx/conf.d/server_tokens.conf
RUN echo "* * * * * cd /app && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/root

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN php artisan optimize:clear

RUN chown -R application:application .

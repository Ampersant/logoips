# 1) PHP + Composer (Bedrock)
FROM composer:2 AS php-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --optimize-autoloader
COPY . .

WORKDIR /app/web/app/themes/logoips-sage-theme
RUN composer install --no-dev --prefer-dist --optimize-autoloader

WORKDIR /app
# 2) Node 18 + npm/Vite (Sage theme)
FROM node:18 AS node-builder
WORKDIR /theme
COPY web/app/themes/logoips-sage-theme/ ./
RUN npm ci && npm run build

# 3) Final: PHP-FPM + Nginx
FROM wordpress:php8.2-fpm-alpine
RUN apk update \
     && apk add --no-cache nginx \
     && docker-php-ext-install pdo_mysql

# Copying Nginx-configs
COPY docker/nginx/nginx.conf   /etc/nginx/nginx.conf
COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# Copying PHP-part (Bedrock + WP-core + theme/plugins)
COPY --from=php-builder /app /var/www/html

# Copying assets of theme
COPY --from=node-builder /theme/public/build \
     /var/www/html/web/app/themes/logoips-sage-theme/public/build

RUN mkdir -p /var/www/html/web/app/cache \
     /var/www/html/web/app/uploads \
     && chown -R www-data:www-data \
     /var/www/html/web/app/cache \
     /var/www/html/web/app/uploads \
     && chmod -R 775 \
     /var/www/html/web/app/cache \
     /var/www/html/web/app/uploads
# Logs in stdout/stderr
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
     && ln -sf /dev/stderr /var/log/nginx/error.log

EXPOSE 80
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
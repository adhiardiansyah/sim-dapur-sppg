FROM php:8.3-cli

RUN apt-get update && apt-get install -y --no-install-recommends git unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --no-scripts --no-autoloader

COPY . .
RUN composer dump-autoload --optimize

ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 10000

# Migrasi + seed idempoten (DatabaseSeeder memakai updateOrCreate)
CMD ["sh", "-c", "php artisan storage:link 2>/dev/null; php artisan migrate --force; php artisan db:seed --force; exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]

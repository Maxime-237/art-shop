FROM php:8.2-cli

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le projet
WORKDIR /app
COPY . .

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

# Permissions storage
RUN chmod -R 775 storage bootstrap/cache

# Exposer le port
EXPOSE 10000

# Démarrer
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan storage:link && \
    php -S 0.0.0.0:10000 -t public/ server.php

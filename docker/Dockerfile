# Dockerfile
# Optimized multi-stage build for a Laravel application.

#------------
# Base Stage
#------------
# Define a common base stage to share PHP setup
FROM php:8.4.4-fpm as base

# Arguments for user and UID
ARG user=www-data
ARG uid=1000

# Set up work directory
WORKDIR /var/www/html

# Install common runtime dependencies (NOT -dev packages)
RUN apt-get update && apt-get install -y \
    supervisor \
    nginx \
    nano \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libsodium-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required for Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sodium intl zip

# Switch to the non-root user
USER $user

#------------
# Builder Stage
#------------
# This stage installs composer dependencies
FROM base as builder

# Copy only the composer files to leverage cache
COPY --chown=$user:$user composer.json composer.lock ./

# Get the latest Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies for production
# --no-dev: Skips development packages
# --optimize-autoloader: Creates a more performant classmap
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist --optimize-autoloader

#------------
# Frontend Stage (Optional)
#------------
# This stage builds your frontend assets (e.g., with Vite or Mix)
FROM node:20-alpine as frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

#------------
# Final App Stage
#------------
# This is the final, lean image for production
FROM base as app

# Copy composer's autoloader and installed vendor packages from the builder stage
COPY --from=builder /var/www/html/vendor ./vendor
COPY --from=builder /var/www/html/composer.json ./composer.json

# Copy application code (excluding files defined in .dockerignore)
COPY --chown=$user:$user . .

# Copy compiled frontend assets from the frontend stage
COPY --from=frontend --chown=$user:$user /app/public/build ./public/build

# Run Laravel optimization commands for production
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port and define the main command
EXPOSE 9000
CMD ["php-fpm"]

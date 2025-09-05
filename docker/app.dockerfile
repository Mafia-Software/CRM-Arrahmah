# Dockerfile
# Optimized multi-stage build for a single-container Nginx + PHP setup.

#------------
# PHP Builder Stage
#------------
# This stage compiles PHP extensions and installs composer dependencies.
FROM php:8.4.4-fpm as php_builder

# Install build-time dependencies needed to compile extensions and run composer
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    libxslt-dev \
    libtidy-dev \
    libcurl4-openssl-dev \
    git \
    zip \
    unzip \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install \
    pdo_mysql mbstring zip exif intl xsl tidy pcntl curl fileinfo gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
WORKDIR /home/crm
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

#------------
# Frontend Builder Stage
#------------
# This stage builds the frontend assets.
FROM node:20-alpine as frontend_builder

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

#------------
# Final Production Stage
#------------
# This is the final, lean image. It starts fresh and copies artifacts from the builders.
FROM php:8.4.4-fpm

WORKDIR /home/crm

# Install only RUNTIME dependencies. No -dev packages or build tools.
RUN apt-get update && apt-get install -y \
    vim \
    nginx \
    git \
    supervisor \
    cron \
    locales \
    jpegoptim optipng pngquant gifsicle \
    ca-certificates \
    libpng16-16 \
    libjpeg62-turbo \
    libfreetype6 \
    libonig5 \
    libzip4 \
    libxslt1.1 \
    libtidy5deb1 \
    libcurl4 \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy compiled extensions and PHP config from the builder
COPY --from=php_builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=php_builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini

# Copy Composer and vendor directory
COPY --from=php_builder /usr/local/bin/composer /usr/local/bin/composer
COPY --from=php_builder /home/crm/vendor ./vendor

# Copy application code
COPY . .

# Copy built frontend assets from the frontend builder
COPY --from=frontend_builder /app/public ./public

# Copy configs for Nginx and Supervisor
COPY docker/supervisor.conf /etc/supervisord.conf
COPY docker/nginx.conf /etc/nginx/sites-enabled/default

# Set permissions
RUN chown -R www-data:www-data /home/crm && chmod 755 /home/crm
RUN chmod +x /home/crm/docker/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/home/crm/docker/entrypoint.sh"]

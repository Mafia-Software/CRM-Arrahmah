# Dockerfile
# This file defines the environment for the Laravel application container.

FROM php:8.4.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
# Node.js and npm are still included so you can run npm commands inside the container if needed.
# Added libicu-dev (for intl), libzip-dev (for zip), and libsodium-dev (for redis)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor \
    nodejs \
    npm \
    libicu-dev \
    libzip-dev \
    libsodium-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
# Added intl and zip extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sodium intl zip

# Install and enable Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=$user:$user . /var/www/html

# Change current user to user
USER $user

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

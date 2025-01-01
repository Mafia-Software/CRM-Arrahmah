FROM php:8.3.15-fpm-alpine

# Set working directory
WORKDIR /var/www/

# Install dependencies
RUN apk update && apk --no-cache add \
    zip \
    npm \
    nodejs \
    ca-certificates \
    nano \
    tmux \
    unzip \
    git \
    nginx \
    supervisor \
    curl

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    gd \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    intl \
    xsl \
    tidy \
    pcntl \
    curl \
    ffi \
    fileinfo \
    sockets \
    apcu


# Install extensions
# RUN docker-php-ext-install \
#     pdo_mysql \
#     mbstring \
#     zip \
#     exif \
#     intl \
#     xsl \
#     tidy \
#     pcntl \
#     curl \
#     ffi \
#     fileinfo \
#     sockets \
#     apcu \
#     composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project ke dalam container
COPY . /var/www/

# Copy directory project permission ke container
COPY --chown=www-data:www-data . /var/www/
RUN chown -R www-data:www-data /var/www
RUN chown -R www-data:www-data /var/log

# Install dependency
RUN composer install --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

# Add user for laravel application
RUN addgroup -g 1000 www
RUN adduser -D -u 1000 -s /bin/sh -G  www www

# Copy code to /var/www
COPY --chown=www:www-data . /var/www

# add root to www group
RUN chmod -R ug+w /var/www/storage

# Copy nginx/php/supervisor configs
RUN cp docker/supervisor.conf /etc/supervisord.conf
RUN cp docker/php.ini /usr/local/etc/php/conf.d/app.ini
RUN cp docker/nginx.conf /etc/nginx/sites-enabled/default

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

# Deployment steps
RUN chmod +x /var/www/docker/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/var/www/docker/entrypoint.sh"]

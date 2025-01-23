FROM php:8.3.15-fpm

# Set working directory
WORKDIR /home/crm/

# Install dependencies
RUN apt update && apt install -y \
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
    libffi-dev \
    locales \
    zip \
    npm \
    nodejs \
    jpegoptim optipng pngquant gifsicle \
    ca-certificates \
    vim \
    tmux \
    unzip \
    git \
    nginx \
    lua-zlib-dev \
    libmemcached-dev \
    cron \
    supervisor \
    curl

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install \
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
    sockets

RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project ke dalam container
COPY . /home/crm

# Install dependency
RUN composer install --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

# Copy nginx/php/supervisor configs
RUN cp docker/supervisor.conf /etc/supervisord.conf
RUN cp docker/php.ini /usr/local/etc/php/conf.d/app.ini
RUN cp docker/nginx.conf /etc/nginx/sites-enabled/default

RUN chown -R www-data:www-data /home/crm
RUN chmod 755 /home/crm
# Deployment steps
RUN chmod +x /home/crm/docker/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/home/crm/docker/entrypoint.sh"]

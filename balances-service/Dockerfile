FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    default-mysql-client

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Forçar PHP-FPM a escutar em 0.0.0.0:9000
RUN sed -i 's|listen = .*|listen = 0.0.0.0:9000|' /usr/local/etc/php-fpm.d/www.conf

COPY startup.sh /startup.sh
RUN chmod +x /startup.sh

# Não use USER www-data aqui, para garantir permissão de execução do script

EXPOSE 9000
CMD ["/startup.sh"]
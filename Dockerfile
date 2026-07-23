# Start from a PHP 8.2 image that already includes Apache
FROM php:8.2-apache

# Install system packages needed to build the PHP extensions below
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libicu-dev \
    libsodium-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# Install the exact PHP extensions NexoPOS needs
# (these are the same ones we had to manually enable in php.ini on XAMPP)
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    gd \
    zip \
    intl \
    sodium \
    mbstring \
    bcmath \
    exif \
    pcntl

# Install Composer (PHP's package manager)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set Apache's document root to Laravel's public folder
# (this solves the htdocs/public split problem we had on InfinityFree)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf

# Enable Apache's rewrite module (needed for Laravel's clean URLs)
RUN a2enmod rewrite

# Copy the project files into the container
WORKDIR /var/www/html
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# Set proper permissions so Laravel can write to storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run migrations and clear caches automatically every time the container starts,
# then hand off to Apache. This replaces the manual artisan commands
# we had no way to run on InfinityFree.
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 80
CMD ["apache2-foreground"]

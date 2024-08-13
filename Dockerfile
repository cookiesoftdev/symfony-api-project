# Define a imagem base
FROM php:8.2-apache

USER root

COPY .docker/apache/apache2.conf /etc/apache2/sites-available/000-default.conf

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    vim \
    zip \
    unzip \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install intl pdo pdo_pgsql opcache

# Ativa o módulo rewrite do Apache
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the project files into the container
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ajustar permissões da pasta /tmp para o usuário www-data
RUN chown -R www-data:www-data /tmp

# Ajustar permissões das pastas (assumindo que o usuário do Apache seja www-data)
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && chmod -R 775 /var/www/html/var

# Trocar para o usuário www-data
USER www-data

# Install Symfony dependencies
RUN composer install --no-interaction --optimize-autoloader

# Expose the port 80 to access the web application
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
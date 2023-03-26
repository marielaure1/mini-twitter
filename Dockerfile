# Utilisez l'image officielle de PHP avec Apache
FROM php:8.1-apache

# Installez les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libjpeg-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip

# Install the PHP extension for PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql


# Add the custom Apache configuration file
COPY apache.conf /etc/apache2/conf-available/custom.conf
COPY .docker/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN ln -s /etc/apache2/conf-available/custom.conf /etc/apache2/conf-enabled/custom.conf

# Installez Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installez Node.js avec NVM
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash \
    && . ~/.nvm/nvm.sh \
    && nvm install --lts \
    && nvm use --lts

# Copiez les fichiers du projet
COPY . /var/www/html

# Définissez les permissions de répertoire
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/public

# Installez les dépendances du projet
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader


# Installez les dépendances NPM et exécutez Vite pour construire les assets
RUN . ~/.nvm/nvm.sh && npm install && npm run build

# Activez le mod_rewrite d'Apache
RUN a2enmod rewrite

# Exposez le port 80 pour le serveur PHP
EXPOSE 80
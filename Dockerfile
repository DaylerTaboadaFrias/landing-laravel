# Usamos PHP 8.1 con FPM
FROM php:8.1-fpm

# Instalar dependencias necesarias para Laravel y Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_mysql zip bcmath
    
RUN rm /etc/nginx/sites-enabled/default

# Instalar composer (copiando desde imagen oficial)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar todo el proyecto al contenedor
COPY . /var/www/html

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Copiar configuración personalizada de Nginx
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Ajustar permisos de carpetas necesarias para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer puerto 80 para Nginx
EXPOSE 80 9000

# Comando para arrancar PHP-FPM y Nginx juntos
CMD service nginx start && php-fpm -F

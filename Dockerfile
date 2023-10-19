FROM php:8.1.10-apache

# Instala Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# Instalamos dependencias requeridas por Laravel y extensiones de PHP necesarias
RUN apt-get update \
  && apt-get install -y \
  git \
  zip \
  unzip \
  libpq-dev \
  libzip-dev \
  libgd-dev \
  && docker-php-ext-install \
  pdo \
  pdo_pgsql \
  bcmath \
  zip \
  gd

# Habilitamos el módulo de Apache necesario para Laravel
RUN a2enmod rewrite

# Agregamos la configuración al archivo apache2.conf
RUN echo "<Directory /var/www/html/>\n\
  Options Indexes FollowSymLinks\n\
  AllowOverride all\n\
  Require all granted\n\
  </Directory>" >> /etc/apache2/apache2.conf

# Instalamos las dependencias de Composer
WORKDIR /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Configuramos los permisos de almacenamiento en caché y registro de Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exponemos el puerto 80 para acceder a la aplicación desde el host
EXPOSE 80

# Ejecutamos el servidor Apache en primer plano
CMD ["apache2-foreground"]
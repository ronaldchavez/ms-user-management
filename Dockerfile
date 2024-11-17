FROM phpswoole/swoole:5.0-php8.2

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y mcrypt libssl-dev pkg-config unzip nodejs npm libboost-all-dev \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/*

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions gd intl pdo_mysql soap zip gmp xml pcntl

RUN git clone https://github.com/swoole/yasd.git \
    && cd yasd \
    && phpize --clean \
    && phpize \
    && ./configure \
    && make clean \
    && make \
    && make install

RUN echo "zend_extension=yasd" >> /usr/local/etc/php/conf.d/docker-php-ext-yasd.ini \
    && echo "yasd.debug_mode=remote" >> /usr/local/etc/php/conf.d/docker-php-ext-yasd.ini \
    && echo "yasd.remote_host=docker.for.mac.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-yasd.ini \
    && echo "yasd.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-yasd.ini

# Configura el directorio de trabaj
WORKDIR /var/www/app

# Copia los archivos del proyecto
COPY laravel .

RUN mkdir -p bootstrap/cache && chown -R www-data:www-data bootstrap/cache storage && chmod -R 775 storage

# Instalamos Chokidar
#RUN npm install --save-dev chokidar
#RUN npm install

# Instala las dependencias de PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install \
  --no-interaction \
  --no-ansi \
  --no-dev \
  && composer clear-cache


# Exponer el puerto 9501 para Swoole
EXPOSE 8059

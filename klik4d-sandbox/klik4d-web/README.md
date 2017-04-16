# Klik4D Sandbox Environment

> To develop and test standalone Klik4D Classes


## Container Setup

> Ports : 3300 for Nginx Web Server

Docker Compose

```
$ docker-compose up -d
```

Validate

```
$ docker-compose ps
   Name                 Command              State               Ports
----------------------------------------------------------------------------------
klik4d-fpm   docker-php-entrypoint php-fpm   Up      9000/tcp
klik4d-web   nginx -g daemon off;            Up      443/tcp, 0.0.0.0:3300->80/tcp
```

## PHP Additional Extensions

```
$ docker exec -it klik4d-fpm bash

#  apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd
```
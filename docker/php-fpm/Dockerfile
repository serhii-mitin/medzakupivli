ARG IMAGE_NAME

FROM $IMAGE_NAME

RUN set -xe; \
    apt-get update -yqq && \
    pecl channel-update pecl.php.net && \
    apt-get install -y --no-install-recommends \
      git \
      htop \
      procps \
      nano \
      curl \
      libzip-dev \
      zip \
      unzip \
      libmemcached-dev \
      libz-dev \
      libpq-dev \
      libjpeg-dev \
      libpng-dev \
      libfreetype6-dev \
      libssl-dev \
      libwebp-dev \
      libxpm-dev \
      libmcrypt-dev \
      libonig-dev;

RUN docker-php-ext-configure gd \
       --prefix=/usr \
       --with-jpeg \
       --with-webp \
       --with-xpm \
       --with-freetype; \
    docker-php-ext-install gd pdo exif pdo_mysql pdo_pgsql zip iconv mbstring; \
    php -m | grep -q 'zip';

###########################################################################
# XDebug:
###########################################################################
ARG INSTALL_XDEBUG

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug && docker-php-ext-enable xdebug; \
fi

###########################################################################
# ImageMagick:
###########################################################################
ARG INSTALL_IMAGEMAGICK
ARG IMAGEMAGICK_VERSION

RUN if [ ${INSTALL_IMAGEMAGICK} = true ]; then \
    apt-get install -yqq libmagickwand-dev imagemagick && \
    cd /tmp && \
    if [ ${IMAGEMAGICK_VERSION} = "latest" ]; then \
      git clone https://github.com/Imagick/imagick; \
    else \
      git clone --branch ${IMAGEMAGICK_VERSION} https://github.com/Imagick/imagick; \
    fi && \
    cd imagick && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    rm -r /tmp/imagick; \
    docker-php-ext-enable imagick; \
    php -m | grep -q 'imagick'; \
fi

###########################################################################
# Symfony CLI:
###########################################################################
ARG INSTALL_SYMFONY_CLI

RUN if [ ${INSTALL_SYMFONY_CLI} = true ]; then \
    curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony; \
fi

###########################################################################
# Supervisor:
###########################################################################
ARG INSTALL_SUPERVISOR

RUN if [ ${INSTALL_SUPERVISOR} = true ]; then \
    apt-get install -y supervisor; \
fi

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Configure non-root user.
ARG CONTAINER_USER
ARG GID
ARG UID
RUN groupadd -g $GID $CONTAINER_USER && \
    useradd -u $UID -g $CONTAINER_USER -m -d /var/www $CONTAINER_USER;

RUN chown -R $CONTAINER_USER:$CONTAINER_USER /var/www

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/app

CMD php-fpm

EXPOSE 9000
#
# This first image will be use as a base
# for production and development images
#
FROM debian:buster-slim AS base

ENV PHP_CONF_DATE_TIMEZONE=UTC \
    PHP_CONF_MAX_EXECUTION_TIME=60 \
    PHP_CONF_MEMORY_LIMIT=512M \
    PHP_CONF_OPCACHE_VALIDATE_TIMESTAMP=0 \
    PHP_CONF_MAX_INPUT_VARS=1000 \
    PHP_CONF_UPLOAD_LIMIT=40M \
    PHP_CONF_MAX_POST_SIZE=40M \
    XDEBUG_ENABLED=0

RUN echo 'APT::Install-Recommends "0" ; APT::Install-Suggests "0" ;' > /etc/apt/apt.conf.d/01-no-recommended && \
    echo 'path-exclude=/usr/share/man/*' > /etc/dpkg/dpkg.cfg.d/path_exclusions && \
    echo 'path-exclude=/usr/share/doc/*' >> /etc/dpkg/dpkg.cfg.d/path_exclusions && \
    apt-get update && \
    apt-get --yes install ca-certificates wget && \
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb https://packages.sury.org/php/ buster main" | tee /etc/apt/sources.list.d/php.list && \
    apt-get update  && \
    apt-get --yes install ca-certificates \
        build-essential \
        php-pear \
        php-dev \
        php7.4-fpm \
        php7.4-cli \
        php7.4-intl \
        php7.4-opcache \
        php7.4-pgsql \
        php7.4-xml \
        php7.4-mbstring \
        php7.4-bcmath \
        php7.4-apcu && \
    pecl install ds && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    ln -s /usr/sbin/php-fpm7.4 /usr/local/sbin/php-fpm && \
    usermod --uid 1000 www-data && groupmod --gid 1000 www-data && \
    mkdir /srv/todo && \
    sed -i "s#listen = /run/php/php7.4-fpm.sock#listen = 9000#g" /etc/php/7.4/fpm/pool.d/www.conf && \
    mkdir -p /run/php

COPY php/todo.ini /etc/php/7.4/cli/conf.d/99-todo.ini
COPY php/todo.ini /etc/php/7.4/fpm/conf.d/99-todo.ini

#
# Image used for development
#
FROM base AS dev

ENV PHP_CONF_OPCACHE_VALIDATE_TIMESTAMP=1

RUN apt-get update && \
    apt-get --yes install git && \
    apt-get --yes install ca-certificates && \
    apt-get --yes install unzip && \
    apt-get --yes install curl && \
    apt-get --yes install php7.4-xdebug php7.4-curl php7.4-zip && \
    phpdismod xdebug && \
    mkdir /etc/php/7.4/enable-xdebug && \
    ln -s /etc/php/7.4/mods-available/xdebug.ini /etc/php/7.4/enable-xdebug/xdebug.ini && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") && \
    curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version && \
    mkdir -p /tmp/blackfire && \
    tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire && \
    mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so && \
    printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > /etc/php/7.4/cli/conf.d/blackfire.ini && \
    printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > /etc/php/7.4/fpm/conf.d/blackfire.ini && \
    rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz && \
    mkdir -p /tmp/blackfire && \
    curl -A "Docker" -L https://blackfire.io/api/v1/releases/client/linux_static/amd64 | tar zxp -C /tmp/blackfire && \
    mv /tmp/blackfire/blackfire /usr/bin/blackfire && \
    rm -Rf /tmp/blackfire

COPY php/xdebug.ini /etc/php/7.4/cli/conf.d/99-todo-xdebug.ini
COPY php/xdebug.ini /etc/php/7.4/fpm/conf.d/99-todo-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

# Make XDEBUG activable at container start
COPY php/docker-php-entrypoint /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-php-entrypoint

RUN mkdir -p /var/www/.composer && chown www-data:www-data /var/www/.composer

ENTRYPOINT ["/usr/local/bin/docker-php-entrypoint"]

VOLUME /srv/todo

#
# Intermediate image to install
# the app dependencies for production
#
FROM dev AS builder

RUN apt-get --yes install yarnpkg \
        nodejs \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /srv/todo/

COPY .. .

ENV APP_ENV=prod
RUN php -d 'memory_limit=3G' /usr/local/bin/composer install --optimize-autoloader --no-scripts --no-interaction --no-ansi --no-dev --prefer-dist && \
    yarn install && \
    yarn run build && \
    rm -rf node_modules

#
# Image used for production
#
FROM base AS prod

ENV APP_ENV=prod \
    PHP_CONF_OPCACHE_VALIDATE_TIMESTAMP=0

# Copy the application with its dependencies
WORKDIR /srv/todo/
COPY --from=builder /srv/todo/ .

# Prepare the application
RUN chown -R www-data:www-data var
USER www-data
RUN rm -rf var/cache && bin/console cache:warmup

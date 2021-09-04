FROM php:8.0.3-fpm-alpine

RUN apk add --no-cache --update \
        libzip-dev curl-dev libxml2-dev mysql-dev icu-dev oniguruma-dev autoconf \
    && \
    apk add --update --no-cache --virtual .build-deps \
       g++ \
       gcc \
       gnupg \
       libgcc \
       make \
       alpine-sdk && \
    docker-php-ext-install \
        curl \
        xml \
        pdo_mysql \
        intl \
        phar \
        iconv \
        ctype \
        soap \
        dom \
        mbstring \
        tokenizer \
        pdo \
        bcmath \
        simplexml \
        sockets \
        opcache \
        zip \
        pcntl \
        xmlwriter

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions \
    && sync \
    && install-php-extensions xdebug-3.0.1 \
    && docker-php-ext-enable xdebug

RUN apk add --no-cache --update git openssh-client openssh-keygen

RUN install-php-extensions gd ldap soap intl zip pdo_pgsql sockets xsl

# Reset all configs
RUN rm $PHP_INI_DIR/conf.d/*

# Add PHP config:
COPY conf.d/ $PHP_INI_DIR/conf.d/

WORKDIR /app

# Composer section
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /root/composer/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown www-data:www-data /app

USER www-data

RUN mkdir -p ~/.ssh/ && chmod 0700 ~/.ssh/ && echo "Host github.com\n\tIdentityFile ~/.ssh/id_rsa\n" > ~/.ssh/config
RUN ssh-keyscan github.com >> ~/.ssh/known_hosts
RUN echo -e "Host github.com\n\tStrictHostKeyChecking no\n" >> ~/.ssh/config

CMD ["php-fpm"]
EXPOSE 9000

FROM php:7.1.6-apache

LABEL maintainer "Guillaume Limberger <glim.dev@gmail.com>"

# Apache
# Enable rewrite module
RUN a2enmod rewrite

RUN set -xe \
    && apt-get update \
    && apt-get install --no-install-recommends -y apt-utils git unzip vim wget libicu-dev \
    && apt-get clean

RUN set -xe \

    # PDO extensions
    && docker-php-ext-install pdo_mysql \

    # Xdebug
    && pecl install xdebug \
	&& docker-php-ext-enable xdebug \

    # opcache extension
    && docker-php-ext-install opcache

ARG ICU_MAJOR_VERSION=58
ENV ICU_MAJOR_VERSION ${ICU_MAJOR_VERSION}

ARG ICU_MINOR_VERSION=2
ENV ICU_MINOR_VERSION ${ICU_MINOR_VERSION}

RUN set -xe \
    # https://github.com/docker-library/php/issues/307#issuecomment-262491765
    && curl -sS -o /tmp/icu.tar.gz -L http://download.icu-project.org/files/icu4c/${ICU_MAJOR_VERSION}.${ICU_MINOR_VERSION}/icu4c-${ICU_MAJOR_VERSION}_${ICU_MINOR_VERSION}-src.tgz \
    && tar -zxf /tmp/icu.tar.gz -C /tmp \
    && cd /tmp/icu/source \
    && ./configure --prefix=/usr/local \
    && make \
    && make install \
    && docker-php-ext-configure intl --with-icu-dir=/usr/local \
    && docker-php-ext-install intl

ARG APCU_VERSION=5.1.6
ENV APCU_VERSION ${APCU_VERSION}

RUN set -xe \
    # APCu
    && pecl install apcu-${APCU_VERSION} \
    && docker-php-ext-enable apcu

# Composer
COPY ./install-composer.sh /usr/local/bin/docker-app-install-composer
RUN set -xe \
    && chmod +x /usr/local/bin/docker-app-install-composer \
    && docker-app-install-composer \
    && mv composer.phar /usr/local/bin/composer


# Install composer cache
RUN set -xe \
    && chown -R www-data: /var/www \
    && mkdir -p /var/www/.composer \
    && chown -R www-data: /var/www/.composer \
    && mkdir -p /root/.composer \
    && chown -R www-data: /root/.composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative

COPY ./php.ini /usr/local/etc/php/

ARG HOST_IP=127.0.0.1
ENV HOST_IP ${HOST_IP}

RUN echo '\nxdebug.remote_host='$HOST_IP >> /usr/local/etc/php/php.ini
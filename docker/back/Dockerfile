FROM php:7.1.6-apache

LABEL maintainer "Guillaume Limberger <glim.dev@gmail.com>"

COPY ./php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y \
	apt-utils \
	git \
	unzip \
	vim \
	wget

RUN git --version

ENV APCU_VERSION 5.1.8

RUN set -xe \
    # intl extension
    && apt-get install -y libicu-dev \

    # https://github.com/docker-library/php/issues/307#issuecomment-262491765
    && curl -sS -o /tmp/icu.tar.gz -L http://download.icu-project.org/files/icu4c/58.2/icu4c-58_2-src.tgz \
    && tar -zxf /tmp/icu.tar.gz -C /tmp \
    && cd /tmp/icu/source \
    && ./configure --prefix=/usr/local \
    && make \
    && make install \
    && docker-php-ext-configure intl --with-icu-dir=/usr/local \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl \

    # opcache extension
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache \

    # pdo extensions
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable pdo_mysql \

    # APCu
    && pecl install apcu-${APCU_VERSION} \
	&& docker-php-ext-enable apcu \

    # Xdebug
    && pecl install xdebug \
	&& docker-php-ext-enable xdebug

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

# Install PHPUnit
RUN set -xe \
    && curl -LsS https://phar.phpunit.de/phpunit.phar -o /usr/local/bin/phpunit \
	&& chmod a+x /usr/local/bin/phpunit

RUN phpunit --version

# Apache
# Enable rewrite module
RUN a2enmod rewrite

FROM php:8.1.0-cli-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
	COMPOSER_HOME=/composer

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get -y install git zip unzip \

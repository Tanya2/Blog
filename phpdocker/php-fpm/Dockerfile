FROM phpdockerio/php80-fpm:latest
WORKDIR "/application"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        libargon2-1 libidn2-0 libpcre2-8-0 libpcre3 libxml2 libzstd1 \
        php8.0-mysql default-mysql-client; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

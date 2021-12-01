FROM php:8-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN curl -sS https://get.composer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN apt-get update && apt-get install git -y
ARG user=www-data
ARG uid
ARG gid
RUN sed -i -e "s/^${user}:\([^:]*\):[0-9]*:[0-9]*/${user}:\1:${uid}:${gid}/"  /etc/passwd
RUN sed -i -e "s/^${user}:\([^:]*\):[0-9]*/${user}:\1:${gid}/"  /etc/group
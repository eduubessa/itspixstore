FROM php:8.1-cli

COPY 90-xdebug.ini "${PHP_INI_DIR}"/conf.d
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
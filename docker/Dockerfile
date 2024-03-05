FROM php:8.2-cli

RUN apt-get update -y && apt-get install -y && apt-get install -y git && apt-get install -y 7zip && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && \
    mkdir /.composer && echo "{\n}" > /.composer/auth.json && chmod -R 777 /.composer

USER 1000:1000
#VOLUME /var/www
WORKDIR /var/www
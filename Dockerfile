FROM php:7.4-apache

# Copy the web application files to the container
#COPY . /var/www/html
WORKDIR /var/www/html

RUN apt-get update -y && apt-get install -y libmariadb-dev

RUN docker-php-ext-install mysqli
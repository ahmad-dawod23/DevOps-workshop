FROM php:7.2-apache
WORKDIR /var/www/html
COPY index.php /var/www/html
COPY . /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
CMD ["env >> /var/www/html/.env"]
EXPOSE 80
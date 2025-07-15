FROM php:8.3-apache

RUN apt-get update && apt-get install -y libpq-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_pgsql && docker-php-ext-enable pdo pdo_pgsql 

EXPOSE 80

CMD ["apache2-foreground"]
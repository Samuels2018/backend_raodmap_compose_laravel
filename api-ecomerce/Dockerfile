FROM bitnami/laravel

WORKDIR /app
COPY . /app
RUN composer install
RUN php artisan key:generate
RUN php artisan migrate
RUN php artisan db:seed

EXPOSE 80
CMD ["php-fpm"]
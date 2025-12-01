FROM webdevops/php-apache:8.2

WORKDIR /app

COPY . /app

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

ENV WEB_DOCUMENT_ROOT=/app/public

RUN php artisan key:generate

EXPOSE 80

CMD ["supervisord"]

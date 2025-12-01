FROM webdevops/php-apache:8.2

WORKDIR /app

COPY . /app

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copie le .env
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Génère la key Laravel
RUN php artisan key:generate --force

# 👉 Lance automatiquement la migration + seed
RUN php artisan migrate --force || true
RUN php artisan db:seed --force || true

ENV WEB_DOCUMENT_ROOT=/app/public

EXPOSE 8080

CMD php artisan serve --host 0.0.0.0 --port 10000

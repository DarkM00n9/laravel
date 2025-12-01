FROM webdevops/php-apache:8.2

WORKDIR /app

# On copie tout le projet dans /app
COPY . /app

# On installe les dépendances PHP (Laravel)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# On crée un .env à partir du .env.example si besoin
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# On génère la APP_KEY de Laravel
RUN php artisan key:generate --force

# Dossier public pour Apache
ENV WEB_DOCUMENT_ROOT=/app/public

EXPOSE 8080

CMD php artisan serve --host 0.0.0.0 --port 10000

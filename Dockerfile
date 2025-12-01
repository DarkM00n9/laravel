FROM webdevops/php-apache:8.2

WORKDIR /app

# Copie le projet
COPY . /app

# Installe les dépendances
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Crée un .env si besoin
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Racine publique pour Apache (même si on utilise php artisan serve)
ENV WEB_DOCUMENT_ROOT=/app/public

# Port utilisé par php artisan serve
EXPOSE 10000

# 👇 ICI la magie : on passe par sh -lc pour pouvoir utiliser "&&"
CMD ["sh", "-lc", "php artisan key:generate --force || true && php artisan migrate --force || true && php artisan db:seed --force || true && php artisan serve --host 0.0.0.0 --port 10000"]

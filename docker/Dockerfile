# ─ Base PHP con FPM ───────────────────────────────────────────────
FROM php:8.3-fpm

# ─ Dependencias de sistema y extensiones PHP ─────────────────────
RUN apt-get update \
 && apt-get install -y git zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev curl \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# ─ Composer ──────────────────────────────────────────────────────
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ─ Directorio de trabajo ─────────────────────────────────────────
WORKDIR /var/www/html

# ─ Puerto para `php artisan serve` ───────────────────────────────
EXPOSE 8000

# ─ Arranque automático ───────────────────────────────────────────
# 1. Si aún no existe un proyecto Laravel (falta artisan),
#    lo crea con Composer.
# 2. Instala dependencias.
# 3. Genera APP_KEY.
# 4. Ejecuta migraciones (ignora error si no hay tablas aún).
# 5. Arranca servidor embebido.
CMD bash -c "\
  if [ ! -f artisan ]; then \
    composer create-project laravel/laravel . --prefer-dist --no-progress; \
  fi && \
  composer install --no-interaction --prefer-dist --no-progress && \
  php artisan key:generate --force && \
  php artisan migrate --force || true && \
  # ───────── Scheduler en segundo plano ─────────
  php artisan schedule:work --verbose --no-interaction & \
  php artisan serve --host=0.0.0.0 --port=8000"

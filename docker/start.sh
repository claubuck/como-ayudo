#!/bin/bash

# Script de inicio para el contenedor Docker

echo "Iniciando aplicación Laravel..."

# Esperar a que la base de datos esté disponible
echo "Verificando conexión a la base de datos..."
until php artisan db:show &> /dev/null; do
    echo "Esperando conexión a la base de datos..."
    sleep 2
done

echo "Base de datos conectada!"

# Generar clave de aplicación si no existe
if [ -z "$APP_KEY" ]; then
    echo "Generando clave de aplicación..."
    php artisan key:generate --force
fi

# Ejecutar migraciones
echo "Ejecutando migraciones..."
php artisan migrate --force

# Limpiar caché
echo "Limpiando caché..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimizar aplicación
echo "Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Construir assets si es necesario
if [ "$APP_ENV" != "production" ]; then
    echo "Construyendo assets de desarrollo..."
    npm run build
fi

echo "Aplicación lista!"

# Mantener el contenedor corriendo
exec php-fpm

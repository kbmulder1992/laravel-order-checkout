#!/usr/bin/env bash
echo "[Muted Output] Building & running docker services... may take a minute if no previous build has occurred"

docker-compose up -d --build &> /dev/null

echo "[] Installing composer packages... may take a minute to complete"

docker exec -it loc_app bash -c "XDEBUG_MODE=off composer install --no-interaction"

sleep 10 # Waiting for mariadb to startup

echo "[] Running database migrations"

docker exec -it loc_app bash -c "XDEBUG_MODE=off php artisan migrate"
docker exec -it loc_app bash -c "XDEBUG_MODE=off php artisan db:seed"

echo "-------------------------------------------"
echo "Services running - proceed to execute run.sh"

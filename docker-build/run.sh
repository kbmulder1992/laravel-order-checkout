#!/usr/bin/env bash
echo "#############################################"
echo "############### Running Tests ###############"
echo "#############################################"

docker exec -it loc_app bash -c "XDEBUG_MODE=off php artisan test"

#!/usr/bin/env bash

composer install -n
bin/console doctrine:migrations:migrate --no-interaction
#bin/console doctrine:fix:load --no-interaction
#bin/console server:run 0.0.0.0:8000

exec "$@"

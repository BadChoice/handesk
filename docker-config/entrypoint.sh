#!/bin/sh
set -e

php /var/www/html/artisan migrate --force
php /var/www/html/artisan passport:keys

service nginx start
supervisord -c /etc/supervisord.conf

exec "$@"
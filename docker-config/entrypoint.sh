#!/bin/sh
set -e

php /var/www/html/artisan migrate --force
php /var/www/html/artisan config:clear

service nginx start
supervisord -c /etc/supervisord.conf

exec "$@"
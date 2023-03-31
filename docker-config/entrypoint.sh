#!/bin/sh
set -e

php /var/www/html/artisan migrate --force

service nginx start
supervisord -c /etc/supervisord.conf

exec "$@"
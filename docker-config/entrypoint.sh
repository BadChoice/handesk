#!/bin/sh
set -e

echo "* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1" >> /etc/crontab

php /var/www/html/artisan october:migrate
php /var/www/html/artisan horizon:install
php /var/www/html/artisan horizon:publish
php /var/www/html/artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"

service nginx start
supervisord -c /etc/supervisord.conf

exec "$@"
#!/bin/bash

# Copy files to /var/www/html directory everywhere except in local
# If you're using mounted volumes in production, this will ensure your setup has the most recent files after deployment
if [ "${APP_ENV}" != "local" ]; then
cp -R /var/www/data/* /var/www/html/handesk/
fi

# Run composer install
composer install

# Generate app ket and clear cache
php artisan key:generate
php artisan config:clear
php artisan config:cache

# Wait for database to be up and running
until nc -z ${DB_HOST} ${MYSQL_PORT}; do sleep 1; echo "Waiting for DB to come up..."; done

# Run migrations
php artisan migrate --seed

# Enable xDebug in for local development alone
if [ "${APP_ENV}" == "local" ]; then
    # Enable xdebug
    ln -sf /var/www/html/handesk/scripts/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
    # Configure xdebug
    sed -i "s/xdebug\.remote_host\=.*/xdebug\.remote_host\=$XDEBUG_HOST/g" /usr/local/etc/php/conf.d/xdebug.ini
    docker-php-ext-enable xdebug
    # Start PHP-FPM
    php-fpm

    else
    # Start PHP-FPM
    php-fpm

fi

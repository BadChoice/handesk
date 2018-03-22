#!/bin/bash

main() {
    # Getting last version
    git pull

    # Shutdown the laravel app
    php artisan down

    # Install new composer packages
    composer install --no-dev --prefer-dist --optimize-autoloader

    # Cache boost configuration and routes
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
    php artisan queue:restart

    # Sync database changes
    if [ "$1" == "migrate" ]
        then
        php artisan migrate
    fi

    # Rise from the ashes
    php artisan up

    echo ''
    echo '🔥 Deploy finished 🔥'
    echo ''
}

main $1

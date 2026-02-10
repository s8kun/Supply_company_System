#!/bin/bash

# Install dependencies if vendor directory doesn't exist
if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader
fi

# Create .env if it doesn't exist
if [ ! -f ".env" ]; then
    cp .env.example .env
    # Update .env for Docker
    sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/g' .env
    sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/g' .env
    sed -i 's/DB_DATABASE=.*/DB_DATABASE=laravel/g' .env
    sed -i 's/DB_USERNAME=.*/DB_USERNAME=laravel/g' .env
    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=root/g' .env
fi

# Generate app key if not set
php artisan key:generate --no-interaction --force

# Run migrations and seeders

php artisan migrate:fresh --seed --force



# Install and build frontend assets

 if node is available
if command -v npm > /dev/null; then
    if [ ! -d "node_modules" ]; then
        npm install
    fi
    npm run build
fi

# Start PHP-FPM
php-fpm

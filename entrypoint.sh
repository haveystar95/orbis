#!/bin/sh
# Create a new user and group
addgroup -S mygroup
adduser -S myuser -G mygroup


# Set ownership of the application directory
chown -R myuser:mygroup /var/www
chown -R myuser:mygroup /var/www/storage
chmod -R 777 /var/www/storage

# Install composer dependencies
cd /var/www
#su-exec myuser composer install
#su-exec myuser php artisan key:generate
#su-exec myuser php artisan migrate
#su-exec myuser php artisan import:historical-data storage/app/historical_data.csv

exec php-fpm

# Start the PHP-FPM process

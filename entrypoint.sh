#!/bin/sh

# Create a new user and group
addgroup -S mygroup
adduser -S myuser -G mygroup

# Set ownership of the application directory
chown -R myuser:mygroup /var/www

# Install composer dependencies
cd /var/www
sudo -u myuser composer install
sudo -u myuser php artisan key:generate
sudo -u myuser php artisan migrate

# Start the PHP-FPM process
exec php-fpm

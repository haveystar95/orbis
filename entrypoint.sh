#!/bin/sh
echo "sdfsdf"
# Create a new user and group
addgroup -S mygroup
adduser -S myuser -G mygroup

# Set ownership of the application directory
chown -R myuser:mygroup /var/www

# Install composer dependencies
cd /var/www
su-exec myuser composer install
su-exec myuser php artisan key:generate
su-exec myuser php artisan migrate

exec php-fpm

# Start the PHP-FPM process
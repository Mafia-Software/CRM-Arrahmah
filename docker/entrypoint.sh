#!/bin/sh

cd /var/www

# php artisan migrate:fresh --seed
php artisan key:generate
php artisan optimize
php artisan filament:optimize

/usr/bin/supervisord -c /etc/supervisord.conf

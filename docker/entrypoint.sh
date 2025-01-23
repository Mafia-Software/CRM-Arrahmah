#!/bin/sh

cd /home/crm

# php artisan migrate:fresh --seed
php artisan key:generate
php artisan optimize
php artisan filament:optimize

/usr/bin/supervisord -c /etc/supervisord.conf

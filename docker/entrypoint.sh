#!/bin/sh
cd /home/crm

# php artisan migrate:fresh --seed
php artisan key:generate
php artisan optimize
php artisan filament:optimize
php artisan storage:link

/usr/bin/supervisord -c /etc/supervisord.conf

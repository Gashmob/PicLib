#!/usr/bin/env sh

php-fpm83
chmod 777 /var/run/php/php-fpm.sock
nginx -g 'daemon off;'

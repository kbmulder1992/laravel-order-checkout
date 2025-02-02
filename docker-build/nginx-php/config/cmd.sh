#!/bin/bash
set -euo pipefail

# update /etc/hosts with host.docker.internal
echo "$(/sbin/ip route|awk '/default/ { print $3 }') host.docker.internal" >> /etc/hosts && echo "/etc/hosts updated with host.docker.internal"

NGINX_ROOT=${NGINX_ROOT:=/var/www}
FASTCGI_PARAM_HTTPS=${FASTCGI_PARAM_HTTPS:=on}
ENABLE_XDEBUG=${ENABLE_XDEBUG:=0}

# Display PHP error's or not
sed -i -e "s/error_reporting =.*=/error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT/g" /etc/php/7.4/fpm/php.ini
sed -i -e "s/display_errors =.*/display_errors = Off/g" /etc/php/7.4/fpm/php.ini

# Tweak nginx to match the workers to cpu's
procs=$(cat /proc/cpuinfo |grep processor | wc -l)
sed -i -e "s/worker_processes 5/worker_processes $procs/" /etc/nginx/nginx.conf

# Set the root in the conf
sed -i -e "s#%%NGINX_ROOT%%#$NGINX_ROOT#" /etc/nginx/sites-available/default.conf
sed -i -e "s#%%FASTCGI_PARAM_HTTPS%%#$FASTCGI_PARAM_HTTPS#" /etc/nginx/sites-available/default.conf

XdebugEnabledFile='/etc/php/7.4/fpm/conf.d/20-xdebug.ini'
XdebugModFile='/etc/php/7.4/mods-available/xdebug.ini'
if [[ "$ENABLE_XDEBUG" == "1" ]] ; then
  if [ -f $XdebugEnabledFile ]; then
    echo "Xdebug enabled"
  else
    echo "Enabling xdebug"
    ln -s $XdebugModFile $XdebugEnabledFile
    echo "Xdebug enabled"
  fi
else
  if [ -f $XdebugEnabledFile ]; then
    echo "Disabling Xdebug"
    rm $XdebugEnabledFile
    echo "Xdebug disabled"
  fi
fi

: > /etc/cron.d/crontasks
# if commands are entered for crontab - check it
if [ $# -gt 0 ]; then
  args=("$@")
  argn=$#

  for i in $(seq $argn)
  do
    echo "${args[$i-1]}" >> /etc/cron.d/crontasks
  done
fi

chmod 600 /etc/cron.d/crontasks
crontab /etc/cron.d/crontasks

# Start supervisord and services
/usr/bin/supervisord -n -c /etc/supervisord.conf

#!/usr/bin/env bash
certbot --nginx --agree-tos --email ${EMAIL} --noninteractive --redirect --expand --domains ${DOMAINS} & > /dev/stout &

#write out current crontab
crontab -l > mycron
#echo new cron into cron file
echo '43 6 * * * certbot renew --post-hook "nginx -s reload"' >> mycron
#install new cron file
crontab mycron
rm mycron

nginx -g "daemon off;"

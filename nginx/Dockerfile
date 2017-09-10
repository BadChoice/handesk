FROM mofesola/nginx-certbot
LABEL Maintainer Mofesola Babalola <me@mofesola.com>

RUN rm /etc/nginx/conf.d/default.conf
COPY conf/ /etc/nginx/conf.d/
COPY entrypoint.sh /entrypoint.sh

WORKDIR /var/www/html/handesk

EXPOSE 80 443
ENTRYPOINT /entrypoint.sh
CMD ["nginx", "-g", "daemon off;"]

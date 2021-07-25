FROM nginx:alpine

COPY ./ /var/www

COPY ./docker-files/nginx/conf.d/ /etc/nginx/conf.d/
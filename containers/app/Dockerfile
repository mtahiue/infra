FROM phusion/baseimage:0.9.16

RUN locale-gen en_US.UTF-8
ENV LANG=en_US.UTF-8

RUN apt-get update --fix-missing
RUN apt-get install -y \
            git \
            nginx-light \
            php5-cli \
            php5-curl \
            php5-fpm \
            php5-imagick \
            php5-gd \
            php5-mcrypt \
            php5-mongo

RUN echo "" > /var/log/php5-fpm.log

RUN mkdir /var/kinoulink && cd /var/kinoulink && mkdir www config log tmp api api/master

ENV HOME=/var/kinoulink

ADD config              /var/kinoulink/config
#ADD app                 /var/kinoulink/www

RUN mkdir               /etc/service/nginx
ADD service/nginx.sh    /etc/service/nginx/run
RUN chmod +x            /etc/service/nginx/run

RUN mkdir               /etc/service/phpfpm
ADD service/php.sh      /etc/service/phpfpm/run
RUN chmod +x            /etc/service/phpfpm/run

EXPOSE 80

CMD ["/sbin/my_init"]
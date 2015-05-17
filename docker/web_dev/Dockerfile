FROM phusion/baseimage:0.9.16

RUN locale-gen en_US.UTF-8
ENV LANG=en_US.UTF-8

RUN apt-get update --fix-missing
RUN apt-get install -y \
            nginx-light \
            php5-cli \
            php5-curl \
            php5-fpm \
            php5-imagick \
            php5-gd \
            php5-mcrypt \
            php5-mongo \
            php5-xdebug

RUN echo "" > /var/log/php5-fpm.log

RUN mkdir /var/kinoulink && cd /var/kinoulink && mkdir log config tmp www

ADD config              /var/kinoulink/config

RUN mkdir               /etc/service/nginx
ADD service/nginx.sh    /etc/service/nginx/run
RUN chmod +x            /etc/service/nginx/run

RUN mkdir               /etc/service/phpfpm
ADD service/php.sh      /etc/service/phpfpm/run
RUN chmod +x            /etc/service/phpfpm/run

RUN chown www-data:www-data -R /var/kinoulink

EXPOSE 80

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

VOLUME /var/kinoulink/www

CMD ["/sbin/my_init"]
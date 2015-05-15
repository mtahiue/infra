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

RUN mkdir /var/kinoulink && cd /var/kinoulink && mkdir log config tmp www

ADD config              /var/kinoulink/config

RUN mkdir               /etc/service/nginx
ADD service/nginx.sh    /etc/service/nginx/run
RUN chmod +x            /etc/service/nginx/run

RUN mkdir               /etc/service/phpfpm
ADD service/php.sh   /etc/service/phpfpm/run
RUN chmod +x            /etc/service/phpfpm/run

RUN chown www-data:www-data -R /var/kinoulink

RUN curl -H "Authorization:token 25457ff7be8dafc8dd06ab19788a54d89a6f4d21" -L https://api.github.com/repos/kinoulink/api/tarball/master > /var/kinoulink/master.tar.gz
RUN cd /var/kinoulink/ && tar xzf master.tar.gz -C www --strip-components=1

RUN cd /var/kinoulink/www  && php composer.phar install && php ./bin/console dev config

RUN chown www-data:www-data -R /var/kinoulink/www

EXPOSE 80

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

CMD ["/sbin/my_init"]
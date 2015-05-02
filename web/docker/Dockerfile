FROM ebuildy/docker-nginx-php

RUN mkdir /var/kinoulink
RUN mkdir /var/kinoulink/log
RUN mkdir /var/kinoulink/tmp

RUN chown www-data:www-data -R /var/kinoulink

CMD ["/sbin/my_init"]
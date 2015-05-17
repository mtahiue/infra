FROM phusion/baseimage:0.9.16

RUN locale-gen en_US.UTF-8
ENV LANG=en_US.UTF-8

RUN apt-get update --fix-missing
RUN apt-get install -y \
            nginx-light

RUN mkdir /var/kinoulink && cd /var/kinoulink && mkdir log config tmp www templates

ADD https://github.com/hashicorp/consul-template/releases/download/v0.9.0/consul-template_0.9.0_linux_amd64.tar.gz /usr/bin/
RUN tar -C /usr/local/bin --strip-components 1 -zxf /usr/bin/consul-template_0.9.0_linux_amd64.tar.gz

ADD config              /var/kinoulink/config

RUN mkdir               /etc/service/nginx
ADD service/nginx.sh    /etc/service/nginx/run
RUN chmod +x            /etc/service/nginx/run

EXPOSE 80

VOLUME /var/kinoulink/templates

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

CMD ["/sbin/my_init"]
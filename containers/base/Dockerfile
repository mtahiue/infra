FROM ubuntu:15.10

MAINTAINER Thomas Decaux <ebuildy@gmail.com>

ENV HOME /root
ADD build build
ADD bin build/bin
ADD services build/runit
ADD config build/config

RUN chmod +x -R build/*

RUN /build/prepare.sh

RUN /build/system_services.sh && \
	/build/utilities.sh && \
	/build/cleanup.sh

CMD ["/sbin/my_init"]
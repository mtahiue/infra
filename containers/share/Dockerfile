FROM kinoulink/base:v1

RUN apt-get update

RUN apt-get install -y samba system-config-samba

ADD services/samba /etc/service/samba
ADD conf/samba.conf /etc/samba/smb.conf

RUN chmod a+x -R /etc/service/

RUN mkdir /var/share && chmod -R 0755 /var/share && chown -R nobody:nogroup /var/share

VOLUME "/var/share"

EXPOSE 138/udp
EXPOSE 139
EXPOSE 445
EXPOSE 445/udp
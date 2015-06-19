#!/usr/bin/env bash

export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8
locale-gen en_US.UTF-8
dpkg-reconfigure locales

sh -c "wget -qO- https://get.docker.io/gpg | apt-key add -"
sh -c "echo deb http://get.docker.io/ubuntu docker main\ > /etc/apt/sources.list.d/docker.list"

apt-get update

apt-get -y install lxc-docker curl wget htop

update-rc.d docker defaults

reboot

docker run -d -p 80:8080 --name admin_rancher rancher/server
docker run -d -p 5000:5000 --name admin_registry registry:2.0
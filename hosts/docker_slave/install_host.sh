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

echo "k-rancher.cloudapp.net 10.61.188.3" >> /etc/hosts

# https://azure.microsoft.com/fr-fr/documentation/articles/virtual-machines-linux-how-to-attach-disk/#initializeinlinux

fdisk /dev/sdc

mkfs -t ext4 /dev/sdc1

mkdir /var/kinoulink /var/kinoulink/share

mount /dev/sdc1 /var/kinoulink/share

blkid

echo "UUID=	/var/kinoulink/share	ext4	defaults	1	2" >> /etc/fstab
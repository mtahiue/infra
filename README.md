# Kinoulink total infrastructure with Vagrant and Docker

## Tree

- ````/cert```` certificates to authentificate to Azure and Docker
- ````/hosts```` build, configure bare metal servers and virtual machines
- ````/containers```` build, configure Docker containers

## The infrastructure

- Static web site
- Php
- MongoDB
- ElasticSearch
- Redis
- Consul

## For development

````docker-compose up -f docker/docker-compose-dev.yml````

## For test and production

````docker-compose up -f docker/docker-compose-prod.yml````

- consul: service discovery, templating
- registrator: register services into consul
- control: proxy HTTP:80 to the right web container
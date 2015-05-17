# Kinoulink API infra with Docker

## For development

````docker-compose up -f docker/docker-compose-dev.yml````

## For test and production

````docker-compose up -f docker/docker-compose-prod.yml````

- consul: service discovery, templating
- registrator: register services into consul
- control: proxy HTTP:80 to the right web container
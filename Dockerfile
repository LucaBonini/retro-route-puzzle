# Spacify a base image
FROM php:7.3-alpine

# Set my folder
#WORKDIR /mnt

# copy files
# COPY ./ /mnt

RUN wget -O phpunit https://phar.phpunit.de/phpunit-9.phar \
  && chmod +x phpunit \
  && mv phpunit /usr/local/bin/phpunit

  # && chmod +x phpunit 

EXPOSE 9090

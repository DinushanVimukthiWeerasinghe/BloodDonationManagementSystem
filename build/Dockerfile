FROM ubuntu:latest
LABEL authors="stdin"
RUN apt-get update && apt upgrade -y
RUN apt install -y php
# Install mysql
RUN apt install -y mysql-server
# Install php mysql extension
RUN apt install -y php-mysql
# Install php extensions
# RUN apt-get install -y php-gd
RUN mkdir -p /var/www/html/BDMS
COPY . /var/www/html/BDMS

ENTRYPOINT ["top", "-b"]
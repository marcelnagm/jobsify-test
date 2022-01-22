## PHP Challenge

First you have set all .env data

second migrate
php vendor/bin/phoenix migrate

to run with rabbitmq you MUST do the following step to use rabbitmq to queue the stock email
sudo su
docker volume create rabbitmq_data
docker-compose up rabbitmq



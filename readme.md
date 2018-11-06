# Laravel applications with Docker
This repo contains a Laravel installation setup to use Docker to create a development environment. This repo can be used as a starting point for developing Laravel apps with Docker.

You can check this medium [post](https://medium.com/@mrfoh/developing-laravel-applications-with-docker-7324c0a0789a) out for more information.

This setup contains;

 - PHP-FPM (PHP 7)
 - Nginx web server
 - MySQL database

## Run
Make sure your have composer and [Docker](https://docs.docker.com/) installed

Clone the repo

`git clone https://github.com/shayanadc/pik.git`

Change directory

`cd pik`
  
Install dependencies

`docker run --rm -v $(pwd):/app composer/composer install`
    
Build and run the Docker containers

`docker-compose up -d`

builds the containers to outputs their logs to the console.

You should be able to visit your app at http://localhost:8008

To stop the containers run `docker-compose kill`, and to remove them run `docker-compose rm`

## Final steps, prepare the Laravel Application.

We first need to copy the `.env.example` file into our own `.env` file. This file will not be checked into version control & we'll have separate ones for development & production. For now, just copy `.env.example -> .env`

## Application key & optimize

Next we’ll need to set the application key & run the optimize command. Both of these are handled by artisan, but because we have PHP and the entire Laravel app running inside of a container, we can’t just run php artisan key:generate on our local machine like you normally would— we need to be issuing these commands directly into the container instead.

Luckily docker-compose has a really nice abstraction for handling this, the two commands needed would look like:

```
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan optimize
```

Some other commands you’ll be running often in a Laravel project:

```
docker-compose exec app php artisan migrate
```

Once you've executed the two command mentioned before (artisan key:generate & artisan optimize) the application will now be ready to use, go ahead and hit http://0.0.0.0:8008 in your browser and you’ll presented with this lovely screen.

## Errors

If you faced this error:

```
The stream or file "/var/www/storage/logs/laravel.log" could not be opened: failed to open stream: Permission denied
```

just run this command:

```
docker-compose exec app chown -R 33 ./*
```

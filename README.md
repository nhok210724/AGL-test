# AGL-test
It's a test of skill


setup on docker

----- install laravel

step 1: cd laravel_backend/docker

step 2: run cmd "docker-compose up -d" waiting build project

step 3: run cmd {docker exec -it docker-app-1 bash -c "composer install"} waiting install vendor

step 4: run cmd {docker exec -it docker-app-1 bash -c "php artisan serve --host=0.0.0.0"}

step 5: check website run access url: "localhost:8000"


----- install reactjs

step 1: cd reactjs_fontend/docker

step 2: run cmd "docker-compose up -d" waiting build project

step 3: run cmd {docker exec -it docker-nginx_reactjs_app-1 bash -c "npm install"} waiting install node_modules

step 4: run cmd {docker exec -it docker-nginx_reactjs_app-1 bash -c "npm start -- --port 3337"}

step 5: check website run access url: "localhost:3337" and test features



setup on local

* required php >= 8.2.x

* required composer

* required nodejs > 22.x

----- install laravel

step 1: cd laravel_backend/src

step 1: run cmd "composer install" waiting install vendor

step 3: run cmd "php artisan serve"

step 4: check website run access url: "localhost:8000"


----- install reactjs

step 1: cd reactjs_fontend/src

step 2: run cmd "npm install" waiting install node_modules

step 3: run cmd "npm start -- --port 3337"

step 4: check website run access url: "localhost:3337" and test features

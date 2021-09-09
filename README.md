## To set up the application


- docker-compose up -d
- Attached to docker container *docker exec -it pastbook bash* and run the *composer install*
- Add the Facebook app id to .env
- *php artisan migrate*
- open browser and go http://localhost


Note : if you had any permission issue :
*chmod -R 0777 ./storage/logs* inside the docker container

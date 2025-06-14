

----------------------------------------------------------------------------------
solo si se va a ejecutar el container independientemente sin docker compose

docker build -t image-movie-reservation-system-service .

docker run -dit --name container-movie-reservation-system-service \
  --network="host" \
  -v $(pwd):/var/www/html \
  -w /var/www/html \
  -e APP_ENV=local \
  -e APP_DEBUG=true \
  -e DB_CONNECTION=pgsql \
  -e DB_HOST=localhost \
  -e DB_PORT=5432 \
  -e DB_DATABASE=movie_reservation \
  -e DB_USERNAME=your_db_usr \
  -e DB_PASSWORD=your_db_pass \
  -e SESSION_DRIVER=database \
  -e SESSION_CONNECTION=pgsql \
  image-movie-reservation-system-service 


migraciones
docker exec -it container-movie-reservation-system-service php artisan migrate
------------------------------------------------------------------------------------
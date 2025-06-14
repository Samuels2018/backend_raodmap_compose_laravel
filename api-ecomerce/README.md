

----------------------------------------------------------------------------------
solo si se va a ejecutar el container independientemente sin docker compose

docker build -t image-api-ecomerce-service .

docker run -dit --name container-api-ecomerce-service \
  --network="host" \
  -v $(pwd):/var/www/html \
  -w /var/www/html \
  -p 8000:8000 \
  -e APP_ENV=local \
  -e APP_DEBUG=true \
  -e DB_CONNECTION=pgsql \
  -e DB_HOST=localhost \
  -e DB_PORT=5432 \
  -e DB_DATABASE=api_ecomerce \
  -e DB_USERNAME=your_db_usr \
  -e DB_PASSWORD=your_db_pass \
  -e SESSION_DRIVER=database \
  -e SESSION_CONNECTION=pgsql \
  image-api-ecomerce-service 


migraciones
docker exec -it container-api-ecomerce-service php artisan migrate
------------------------------------------------------------------------------------

endpints
Post
http://0.0.0.0:8000/api/auth/register

{
  "name": "Juan Pérez",
  "email": "juan.perez@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}

spect response
{
  "message": "User successfully registered",
  "user": {
    "name": "Juan Pérez",
    "email": "juan.perez@example.com",
    "updated_at": "2025-06-11T19:19:37.000000Z",
    "created_at": "2025-06-11T19:19:37.000000Z",
    "id": 1
  }
}

Post
Login
http://0.0.0.0:8000/api/auth/login

{
  "email": "juan.perez@example.com",
  "password": "password123",
}

spect response
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMC4wLjAuMDo4MDAwL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzQ5NjcwNjE1LCJleHAiOjE3NDk2NzQyMTUsIm5iZiI6MTc0OTY3MDYxNSwianRpIjoiODg1MXQwNUVvelJpUmVuZyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.hIfUIbqEJY5oFfLFRPLMtWitOBPkcDigNX7uzZK8X5k",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "name": "Juan Pérez",
    "email": "juan.perez@example.com",
    "email_verified_at": null,
    "created_at": "2025-06-11T19:19:37.000000Z",
    "updated_at": "2025-06-11T19:19:37.000000Z"
  }
}



crete products
POST
http://0.0.0.0:8000/api/products

{
  "name": "Samsung Galaxy S22",
  "description": "8GB RAM, 256GB, Phantom Black",
  "price": 899.99,
  "stock": 25,
  "image": "https://example.com/s22.jpg"
}

spect response
{
  "name": "Samsung Galaxy S22",
  "description": "8GB RAM, 256GB, Phantom Black",
  "price": 899.99,
  "stock": 25,
  "updated_at": "2025-06-11T23:49:42.000000Z",
  "created_at": "2025-06-11T23:49:42.000000Z",
  "id": 1
}


get products
http://0.0.0.0:8000/api/products


spect response
[
  {
    "id": 1,
    "name": "Samsung Galaxy S22",
    "description": "8GB RAM, 256GB, Phantom Black",
    "price": "899.99",
    "stock": 25,
    "image": null,
    "created_at": "2025-06-11T23:49:42.000000Z",
    "updated_at": "2025-06-11T23:49:42.000000Z"
  }
]

get a specifict product
http://0.0.0.0:8000/api/products/1

spect response
{
  "id": 1,
  "name": "Samsung Galaxy S22",
  "description": "8GB RAM, 256GB, Phantom Black",
  "price": "899.99",
  "stock": 25,
  "image": null,
  "created_at": "2025-06-11T23:49:42.000000Z",
  "updated_at": "2025-06-11T23:49:42.000000Z"
}


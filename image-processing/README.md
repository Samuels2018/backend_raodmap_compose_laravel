


crete user 
http://0.0.0.0:8001/api/register

{
  "name": "man",
  "email": "mm@gmail.com",
  "password": "123456",
  "password_confirmation": "123456" 
}

spected response
{
    "user": {
        "name": "man",
        "email": "mm@gmail.com",
        "updated_at": "2025-06-13T01:50:26.000000Z",
        "created_at": "2025-06-13T01:50:26.000000Z",
        "id": 6
    }
}



login user 
http://0.0.0.0:8001/api/login

{
  "email": "mm@gmail.com",
  "password": "123456",
}

spected response
{
    "user": {
        "id": 6,
        "name": "man",
        "email": "mm@gmail.com",
        "email_verified_at": null,
        "created_at": "2025-06-13T01:50:26.000000Z",
        "updated_at": "2025-06-13T01:50:26.000000Z"
    },
    "token": "1|zikZwceAK1f1zM5E13g11zsmhA0xGDnphXCd9sOx134ca9be"
}
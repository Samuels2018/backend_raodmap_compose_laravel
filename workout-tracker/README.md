


create user
http://0.0.0.0:8003/api/auth/register
{
  "name": "mel",
  "email": "m@gmail.com",
  "password": "123456",
  "password_confirmation": "123456" 
}

spected response
{
  "message": "User successfully registered",
  "user": {
    "name": "mel",
    "email": "m@gmail.com",
    "updated_at": "2025-06-13T00:38:59.000000Z",
    "created_at": "2025-06-13T00:38:59.000000Z",
    "id": 1
  }
}


login user 
http://0.0.0.0:8003/api/auth/login
{
  "email": "m@gmail.com",
  "password": "123456"
}
spected response
{
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMC4wLjAuMDo4MDAzL2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNzQ5Nzc1MzgyLCJleHAiOjE3NDk3Nzg5ODIsIm5iZiI6MTc0OTc3NTM4MiwianRpIjoiQ0E3RlRUVHEyRnpBTFdFSyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.32_JLoQFCUzssZ2eW7yqXHxiUpk19yDfBxm7BwnyS1E",
  "token_type": "bearer",
  "expires_in": 3600,
  "user": {
    "id": 1,
    "name": "mel",
    "email": "m@gmail.com",
    "email_verified_at": null,
    "created_at": "2025-06-13T00:38:59.000000Z",
    "updated_at": "2025-06-13T00:38:59.000000Z"
  }
}


crete exercises
http://0.0.0.0:8003/api/exercises/create 


{
  "name": "Sentadillas con barra",
  "category": "strength",
  "muscle_group": "Piernas",
  "description": "Ejercicio compuesto para desarrollar fuerza en piernas y glúteos"
}

spected response

{
  "name": "Sentadillas con barra",
  "category": "strength",
  "muscle_group": "Piernas",
  "description": "Ejercicio compuesto para desarrollar fuerza en piernas y glúteos",
  "updated_at": "2025-06-13T01:17:41.000000Z",
  "created_at": "2025-06-13T01:17:41.000000Z",
  "id": 2
}


create workouts
http://0.0.0.0:8003/api/workouts

{
  "workout_id": 1,
  "title": "The title field is required.",
  "completed_at": "2025-06-15 14:30:00",
  "scheduled_at":"2025-06-15 14:30:00",
  "notes": "Entreno intenso, terminé agotado pero satisfecho",
  "duration_minutes": 45,
  "exercises": [
    {
      "exercise_id": 2,
      "sets": 4,
      "repetitions": 10,
      "weight": 15.0,
      "rest_seconds": 45
    }
  ]
}

spected response

{
  "title": "The title field is required.",
  "scheduled_at": "2025-06-15T14:30:00.000000Z",
  "user_id": 1,
  "updated_at": "2025-06-13T01:25:08.000000Z",
  "created_at": "2025-06-13T01:25:08.000000Z",
  "id": 1,
  "exercises": [
      {
          "id": 2,
          "name": "Sentadillas con barra",
          "description": "Ejercicio compuesto para desarrollar fuerza en piernas y glúteos",
          "category": "strength",
          "muscle_group": "Piernas",
          "created_at": "2025-06-13T01:17:41.000000Z",
          "updated_at": "2025-06-13T01:17:41.000000Z",
          "pivot": {
              "workout_id": 1,
              "exercise_id": 2,
              "sets": 4,
              "repetitions": 10,
              "weight": "15.00",
              "notes": null,
              "created_at": "2025-06-13T01:25:08.000000Z",
              "updated_at": "2025-06-13T01:25:08.000000Z"
          }
      }
  ]
}


create workout-logs
http://0.0.0.0:8003/api/workout-logs

{
  "workout_id": 1,
  "title": "The title field is required.",
  "completed_at": "2025-06-15 14:30:00",
  "scheduled_at":"2025-06-15 14:30:00",
  "notes": "Entreno intenso, terminé agotado pero satisfecho",
  "duration_minutes": 45,
  "exercises": [
    {
      "exercise_id": 2,
      "sets": 4,
      "repetitions": 10,
      "weight": 15.0,
      "rest_seconds": 45
    }
  ]
}

spected response
{
    "workout_id": 1,
    "completed_at": "2025-06-15T14:30:00.000000Z",
    "notes": "Entreno intenso, terminé agotado pero satisfecho",
    "duration_minutes": 45,
    "user_id": 1,
    "updated_at": "2025-06-13T01:29:42.000000Z",
    "created_at": "2025-06-13T01:29:42.000000Z",
    "id": 1,
    "workout": {
        "id": 1,
        "user_id": 1,
        "title": "The title field is required.",
        "description": null,
        "scheduled_at": "2025-06-15T14:30:00.000000Z",
        "completed": true,
        "comments": null,
        "created_at": "2025-06-13T01:25:08.000000Z",
        "updated_at": "2025-06-13T01:29:42.000000Z",
        "exercises": [
            {
                "id": 2,
                "name": "Sentadillas con barra",
                "description": "Ejercicio compuesto para desarrollar fuerza en piernas y glúteos",
                "category": "strength",
                "muscle_group": "Piernas",
                "created_at": "2025-06-13T01:17:41.000000Z",
                "updated_at": "2025-06-13T01:17:41.000000Z",
                "pivot": {
                    "workout_id": 1,
                    "exercise_id": 2,
                    "sets": 4,
                    "repetitions": 10,
                    "weight": "15.00",
                    "notes": null,
                    "created_at": "2025-06-13T01:25:08.000000Z",
                    "updated_at": "2025-06-13T01:25:08.000000Z"
                }
            }
        ]
    }
}



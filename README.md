# Laravel API

## Prerequisites

-   PHP
-   Composer
-   Laravel
-   MySQL

## Instructions

-   Setup mysql database
-   Copy .env.example and rename it to .env
-   Change the value of database connection. (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
-   composer install
-   php artisan migrate
-   php artisan passport:install
-   php artisan passport:keys --force
-   php artisan key:generate
-   php artisan serve

## How to use api

Register a user

```
POST http://localhost:8000/api/register
```

Login user

-   Token generated after successful login
-   Token can be used in creating, updating ip address

```
POST http://localhost:8000/api/login
```

Add ip address

```
POST http://localhost:8000/api/ip-address

Payload:
{
    "ip_add": "127.0.0.1",
    "label": "localhost"
}

Headers:
{
    "Authorization": "Bearer <Token>",
    "Accept": "application/json"
}
```

Fetch all ip address

```
GET http://localhost:8000/api/ip-address

Headers:
{
    "Authorization": "Bearer <Token>",
    "Accept": "application/json"
}
```

Fetch single ip address

```
GET http://localhost:8000/api/ip-address/1

Headers:
{
    "Authorization": "Bearer <Token>",
    "Accept": "application/json"
}
```

Update ip address

```
PUT http://localhost:8000/api/ip-address/1?label=Testing

Headers:
{
    "Authorization": "Bearer <Token>",
    "Accept": "application/json"
}
```

# PHP REST API

## Description

This is a simple REST API written in PHP for **instrucional purposes only**. It is written from scratch without using any framework and uses MySQL as database and uses PDO for database operations. It is developed following an MVC architecture.

## Installation

1. Clone the repository
2. To run the API, you need to have PHP and MySQL installed on your system. You can use XAMPP or WAMP. I used Laragon while developing this API.
3. Check if the Apache configuration file points to the public folder. If not, then change it to point to the public folder.
4. Set the database credentials in the .env file, that you can clone from .env.example file.
5. Clone the .hataccess file from .hataccess.example file.
   1. If your URL is `http://localhost/php-api`, then the `RewriteBase` should be `/php-api/`.
6. Import the database file in the database folder.

# API Documentation

## Standard JSON Response

```json
{
  "success": "true/false",
  "status": "200/400/401/404/500",
  "message": "Message",
  "error": "Error message if any",
  "data": {
    "object": {
      "key": "value"
    }
  }
}
```

## Endpoints

### User

#### List users

```http
POST /users/
```

##### Response

```json
{
  "success": true,
  "status": 200,
  "message": "Records found",
  "data": {
    "users": [
      {
        "id": 1,
        "fullname": "Johnny Doe",
        "username": "johndoe",
        "email": "john@email.com",
        "address": "123 King St"
      },
      {
        "id": 2,
        "fullname": "Jane Doe",
        "username": "janedoe",
        "email": "jane@email.com",
        "address": "124 Queen St"
      }
    ]
  }
}
```

#### Get user

```http
POST /users/{id}
```

##### Response

```json
{
  "success": true,
  "status": 200,
  "message": "Record found",
  "data": {
    "user": {
      "id": 1,
      "fullname": "John Doe",
      "username": "johndoe",
      "email": "john@email.com",
      "address": "123 King St"
    }
  }
}
```

#### Create user

```http
POST /users/create
```

##### Request

```json
{
  "fullname": "Jack Doe",
  "username": "jackdoe",
  "email": "jack@email.com",
  "password": "password",
  "address": "125 King St"
}
```

##### Response

```json
{
  "success": true,
  "status": 200,
  "message": "Record created",
  "data": {
    "user": {
      "id": 3,
      "fullname": "Jack Doe",
      "username": "jackdoe",
      "email": "jack@email.com",
      "address": "125 King St"
    }
  }
}
```

#### Update user

```http
PUT /users/{id}
```

##### Request

```json
{
  "fullname": "Jack Doe",
  "username": "jackdoe",
  "email": "jack@email.com",
  "address": "126 King St"
}
```

##### Response

```json
{
  "success": true,
  "status": 200,
  "message": "Record updated",
  "data": {
    "user": {
      "id": 3,
      "fullname": "Jack Doe",
      "username": "jackdoe",
      "email": "jack@email.com",
      "address": "126 King St"
    }
  }
}
```

#### Delete user

```http
DELETE /users/{id}
```

##### Response

No JSON is returned in the response body. The status code is 204.

# Reference

1. https://medium.com/@bojanmajed/standard-json-api-response-format-c6c1aabcaa6d

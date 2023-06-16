# PHP REST API

## Description

This is a simple REST API written in PHP. It is written from scratch without using any framework. It uses MySQL as database and uses PDO for database operations. It is a simple API which can be used as a base for any PHP project that needs a REST API. It is developed following an MVC architecture.

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
    "key": "value",
    "object": {
      "key": "value"
    },
    "token": "token"
  }
}
```

## Endpoints

### User

#### Register

```http
POST /api/user/register
```

##### Request

```json
{
  "name": "John Doe",
  "email": "john@email.com",
  "password": "password"
}
```

##### Response

```json
{
  "success": true,
  "status": 200,
  "message": "User registered successfully",
  "data": {
    "name": "John Doe",
    "email": "john@email.com"
  }
}
```

# Reference

1. https://medium.com/@bojanmajed/standard-json-api-response-format-c6c1aabcaa6d

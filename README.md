# PHP REST API

## Description

This is a simple REST API written in PHP for **instrucional purposes only**. It is written from scratch without using any framework, uses MySQL as database and PDO for database operations. It is developed following an MVC architecture.

## Installation

### Option 1: Using Docker (Recommended)

1. Clone the repository

   ```bash
   git clone <repository-url>
   cd php-rest-api
   ```

2. Make sure you have Docker and Docker Compose installed on your system

3. Build and start the containers

   ```bash
   docker-compose up -d
   ```

4. The application will be available at:

   - API: `http://localhost:8080`
   - phpMyAdmin: `http://localhost:8081`

5. The database will be automatically initialized with the schema and sample data from `database/migration.sql`

6. To stop the containers:

   ```bash
   docker-compose down
   ```

7. To stop and remove all data (including database):
   ```bash
   docker-compose down -v
   ```

### Option 2: Traditional Setup

1. Clone the repository
2. To run the API, you need to have PHP and MySQL installed on your system. You can use XAMPP or WAMP. I used Laragon while developing this API.
3. Check if the Apache configuration file points to the public folder. If not, then change it to point to the public folder.
4. Set the database credentials in the .env file, that you can clone from .env.example file.
5. Clone the .hataccess file from .hataccess.example file.
   1. If your URL is `http://localhost/php-api`, then the `RewriteBase` should be `/php-api/`.
6. Import the database file in the database folder.

## Docker Configuration

The application includes three services:

- **web**: PHP 8.1 with Apache server running the REST API
- **db**: MySQL 8.0 database server
- **phpmyadmin**: Web interface for database management

### Environment Variables

You can modify the following environment variables in `docker-compose.yml`:

- `DATABASE_HOST`: MySQL host (default: db)
- `DATABASE_NAME`: Database name (default: database_for_rest)
- `DATABASE_USER`: Database user (default: root)
- `DATABASE_PASSWORD`: Database password (default: root_password)

### Ports

- `8080`: PHP REST API
- `8081`: phpMyAdmin
- `3306`: MySQL database (accessible from host)

For detailed Docker documentation, see [DOCKER.md](DOCKER.md).

# API Documentation

## Base URL

- Docker: `http://localhost:8080`
- Traditional setup: `http://localhost` (or your configured URL)

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

### Testing the API

You can test the API using tools like:

- **cURL** (command line)
- **Postman** (GUI application)
- **Thunder Client** (VS Code extension)
- **REST Client** (VS Code extension)

Example cURL command:

```bash
# List all users (Docker setup)
curl http://localhost:8080/users

# Get a specific user
curl http://localhost:8080/users/1

# Create a new user
curl -X POST http://localhost:8080/users \
  -H "Content-Type: application/json" \
  -d '{"fullname":"Test User","username":"testuser","email":"test@email.com","password":"password123","address":"456 Test St"}'
```

### User

#### List users

```http
GET /users
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
GET /users/{id}
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

## Quick Start with Docker

**Windows Users:** You can simply double-click `start.bat` to start the application!

```bash
# Clone the repository
git clone <repository-url>
cd php-rest-api

# Start the application
docker-compose up -d

# Wait a few seconds for the database to initialize, then test the API
curl http://localhost:8080/users

# View logs
docker-compose logs -f

# Stop the application
docker-compose down
```

### Using Makefile (Optional)

If you have `make` installed, you can use the provided Makefile for easier management:

```bash
# Start the application
make up

# View logs
make logs

# Test the API
make test

# Stop the application
make down

# Clean everything (including database)
make clean

# See all available commands
make help
```

## Troubleshooting

### Docker Issues

**Port already in use**

- If port 8080, 8081, or 3306 is already in use, modify the ports in `docker-compose.yml`

**Database connection errors**

- Wait a few seconds after running `docker-compose up` for the database to fully initialize
- Check database logs: `docker-compose logs db`

**Permission errors**

- On Linux/Mac, you may need to adjust file permissions: `chmod -R 755 .`

# Reference

1. https://medium.com/@bojanmajed/standard-json-api-response-format-c6c1aabcaa6d

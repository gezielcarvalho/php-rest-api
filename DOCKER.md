# Docker Deployment Guide

This guide explains how to deploy the PHP REST API using Docker.

## Prerequisites

- Docker Engine 20.10 or higher
- Docker Compose 1.29 or higher

## Architecture

The application consists of three Docker containers:

1. **web** (php:8.1-apache)

   - Runs the PHP REST API
   - Apache web server with mod_rewrite enabled
   - PDO MySQL extension installed
   - Exposed on port 8080

2. **db** (mysql:8.0)

   - MySQL database server
   - Automatically initializes with migration.sql
   - Persistent data storage with Docker volume
   - Exposed on port 3306

3. **phpmyadmin** (phpmyadmin:latest)
   - Web-based database management interface
   - Exposed on port 8081

## Quick Start

```bash
# Start all services
docker-compose up -d

# Verify services are running
docker-compose ps

# View logs
docker-compose logs -f

# Test the API
curl http://localhost:8080/users
```

## Configuration

### Environment Variables

The application uses the following environment variables (configured in `docker-compose.yml`):

| Variable          | Default Value     | Description        |
| ----------------- | ----------------- | ------------------ |
| DATABASE_HOST     | db                | MySQL host address |
| DATABASE_NAME     | database_for_rest | Database name      |
| DATABASE_USER     | root              | Database username  |
| DATABASE_PASSWORD | root_password     | Database password  |

### Customizing Configuration

1. **Using docker-compose.override.yml** (recommended)

   ```bash
   cp docker-compose.override.yml.example docker-compose.override.yml
   # Edit docker-compose.override.yml with your custom settings
   ```

2. **Modifying docker-compose.yml directly**
   - Not recommended as it affects version control

### Changing Ports

Edit `docker-compose.yml` to change the exposed ports:

```yaml
services:
  web:
    ports:
      - "9000:80" # Change 8080 to your preferred port
```

## Volumes

### Database Persistence

Database data is stored in a Docker named volume `db-data`. This ensures data persists between container restarts.

```bash
# List volumes
docker volume ls

# Inspect database volume
docker volume inspect php-rest-api_db-data

# Remove volume (WARNING: This deletes all data)
docker volume rm php-rest-api_db-data
```

### Application Code

The application code is mounted as a volume from the host:

- Host: `./` (project root)
- Container: `/var/www/html`

This allows live code updates during development.

## Database

### Accessing MySQL

**Via phpMyAdmin:**

- URL: http://localhost:8081
- Server: db
- Username: root
- Password: root_password

**Via MySQL CLI:**

```bash
# From host machine
docker-compose exec db mysql -uroot -proot_password database_for_rest

# Or connect directly to port 3306
mysql -h 127.0.0.1 -P 3306 -uroot -proot_password database_for_rest
```

### Database Initialization

The database is automatically initialized on first run using `database/migration.sql`. The file is mounted to `/docker-entrypoint-initdb.d/` in the MySQL container.

### Backup and Restore

**Backup:**

```bash
docker-compose exec db mysqldump -uroot -proot_password database_for_rest > backup.sql
```

**Restore:**

```bash
docker-compose exec -T db mysql -uroot -proot_password database_for_rest < backup.sql
```

## Development

### Live Reloading

Code changes are automatically reflected because the project directory is mounted as a volume. Just refresh your browser or re-send API requests.

### Debugging

**View Web Server Logs:**

```bash
docker-compose logs -f web
```

**View Database Logs:**

```bash
docker-compose logs -f db
```

**Access Web Container Shell:**

```bash
docker-compose exec web bash
```

**Check Apache Configuration:**

```bash
docker-compose exec web apache2ctl -S
```

## Production Deployment

### Security Considerations

1. **Change default passwords:**

   - Update `MYSQL_ROOT_PASSWORD` in docker-compose.yml
   - Update `DATABASE_PASSWORD` accordingly

2. **Disable phpMyAdmin:**

   - Comment out the phpmyadmin service in docker-compose.yml for production

3. **Use environment files:**

   ```bash
   # Create .env file
   echo "MYSQL_ROOT_PASSWORD=your_secure_password" > .env

   # Reference in docker-compose.yml
   environment:
     - MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
   ```

4. **Enable HTTPS:**
   - Use a reverse proxy like Nginx or Traefik
   - Configure SSL certificates (Let's Encrypt)

### Performance Optimization

1. **Use bind mounts only in development:**

   - In production, copy files during build instead of mounting

2. **Optimize Docker image:**

   - Use multi-stage builds
   - Minimize layers
   - Remove development dependencies

3. **Database tuning:**
   - Configure MySQL performance parameters
   - Add custom my.cnf file

### Scaling

For production environments, consider:

- Load balancing multiple web containers
- Separating database to external service
- Using container orchestration (Kubernetes, Docker Swarm)

## Troubleshooting

### Port Conflicts

**Error:** `Bind for 0.0.0.0:8080 failed: port is already allocated`

**Solution:** Change the port in docker-compose.yml or stop the conflicting service.

### Database Connection Refused

**Issue:** API cannot connect to database

**Solutions:**

1. Wait a few seconds for MySQL to fully start
2. Check if db container is running: `docker-compose ps`
3. Verify environment variables are correct
4. Check network connectivity: `docker-compose exec web ping db`

### Permission Errors

**Issue:** Permission denied errors in logs

**Solution:**

```bash
# Fix permissions
sudo chown -R www-data:www-data ./
sudo chmod -R 755 ./
```

### Database Not Initialized

**Issue:** Database tables don't exist

**Solutions:**

1. Remove volume and restart:

   ```bash
   docker-compose down -v
   docker-compose up -d
   ```

2. Manually import migration:
   ```bash
   docker-compose exec -T db mysql -uroot -proot_password database_for_rest < database/migration.sql
   ```

### Container Keeps Restarting

**Diagnosis:**

```bash
# Check logs
docker-compose logs web

# Check container status
docker-compose ps
```

Common causes:

- Syntax errors in PHP code
- Missing dependencies
- Configuration issues

## Maintenance

### Updating Docker Images

```bash
# Pull latest images
docker-compose pull

# Rebuild and restart
docker-compose up -d --build
```

### Cleaning Up

```bash
# Stop and remove containers
docker-compose down

# Remove containers and volumes
docker-compose down -v

# Remove unused Docker resources
docker system prune -a
```

## Useful Commands

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# Restart a specific service
docker-compose restart web

# View logs
docker-compose logs -f

# Execute command in container
docker-compose exec web bash

# Check container status
docker-compose ps

# View resource usage
docker stats

# Rebuild images
docker-compose build --no-cache
```

## References

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [PHP Docker Official Image](https://hub.docker.com/_/php)
- [MySQL Docker Official Image](https://hub.docker.com/_/mysql)

# Changelog

All notable changes to this project will be documented in this file.

## [Dockerized] - 2025-11-11

### Added

- Docker support with multi-container setup
  - `Dockerfile` for PHP 8.1 with Apache
  - `docker-compose.yml` with web, database, and phpMyAdmin services
  - `.dockerignore` to exclude unnecessary files from Docker build
  - `.env.docker` for Docker-specific environment variables
- Documentation
  - `DOCKER.md` - Comprehensive Docker deployment guide
  - Updated `README.md` with Docker installation instructions
  - Added Quick Start section
  - Added API testing examples
  - Added troubleshooting section
- Development tools
  - `Makefile` with common Docker commands
  - `docker-compose.override.yml.example` for custom configurations
  - `health-check.sh` script to verify services are running
- Configuration improvements
  - Updated `.gitignore` with Docker-related entries
  - Fixed SQL syntax in `database/migration.sql`

### Changed

- README.md now prioritizes Docker as the recommended installation method
- Traditional installation moved to "Option 2"

### Features

- One-command setup: `docker-compose up -d`
- Automatic database initialization from migration.sql
- Persistent database storage with Docker volumes
- phpMyAdmin included for easy database management
- Live code reloading during development
- Network isolation for security

### Services

- **Web Service**: PHP 8.1 + Apache (Port 8080)
- **Database Service**: MySQL 8.0 (Port 3306)
- **phpMyAdmin**: Database management UI (Port 8081)

### Technical Details

- PHP extensions: PDO, PDO MySQL
- Apache modules: mod_rewrite enabled
- Automatic .htaccess and .env setup
- Proper file permissions set automatically
- Document root configured to /public directory

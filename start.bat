@echo off
REM Quick start script for Windows users

echo ============================================
echo PHP REST API - Docker Quick Start
echo ============================================
echo.

REM Check if Docker is running
docker info >nul 2>&1
if errorlevel 1 (
    echo ERROR: Docker is not running!
    echo Please start Docker Desktop and try again.
    pause
    exit /b 1
)

echo [1/4] Docker is running...
echo.

echo [2/4] Starting containers...
docker-compose up -d

echo.
echo [3/4] Waiting for services to initialize (10 seconds)...
timeout /t 10 /nobreak >nul

echo.
echo [4/4] Testing API endpoint...
curl -s http://localhost:8080/users
echo.
echo.

echo ============================================
echo Application started successfully!
echo ============================================
echo.
echo API URL:        http://localhost:8080
echo phpMyAdmin:     http://localhost:8081
echo.
echo Test the API:   curl http://localhost:8080/users
echo View logs:      docker-compose logs -f
echo Stop services:  docker-compose down
echo.
echo For more commands, see README.md or run: make help
echo.
pause

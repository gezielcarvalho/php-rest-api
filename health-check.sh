#!/bin/bash

# Health check script for PHP REST API
# This script verifies that all services are running correctly

echo "=== PHP REST API Health Check ==="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if Docker is running
echo -n "Checking Docker... "
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}FAILED${NC}"
    echo "Docker is not running. Please start Docker and try again."
    exit 1
fi
echo -e "${GREEN}OK${NC}"

# Check if containers are running
echo -n "Checking containers... "
if docker-compose ps | grep -q "Up"; then
    echo -e "${GREEN}OK${NC}"
else
    echo -e "${RED}FAILED${NC}"
    echo "Containers are not running. Run 'docker-compose up -d' first."
    exit 1
fi

# Check web container
echo -n "Checking web container... "
if docker-compose ps web | grep -q "Up"; then
    echo -e "${GREEN}OK${NC}"
else
    echo -e "${RED}FAILED${NC}"
fi

# Check database container
echo -n "Checking database container... "
if docker-compose ps db | grep -q "Up"; then
    echo -e "${GREEN}OK${NC}"
else
    echo -e "${RED}FAILED${NC}"
fi

# Check phpMyAdmin container
echo -n "Checking phpMyAdmin container... "
if docker-compose ps phpmyadmin | grep -q "Up"; then
    echo -e "${GREEN}OK${NC}"
else
    echo -e "${YELLOW}WARNING${NC}"
fi

# Check web service HTTP response
echo -n "Checking API endpoint (http://localhost:8080/users)... "
if curl -s -o /dev/null -w "%{http_code}" http://localhost:8080/users | grep -q "200"; then
    echo -e "${GREEN}OK${NC}"
else
    echo -e "${RED}FAILED${NC}"
    echo "API is not responding. Check logs with 'docker-compose logs web'"
fi

# Check database connection
echo -n "Checking database connection... "
if docker-compose exec -T db mysql -uroot -proot_password -e "USE database_for_rest; SELECT 1;" > /dev/null 2>&1; then
    echo -e "${GREEN}OK${NC}"
else
    echo -e "${RED}FAILED${NC}"
fi

# Check phpMyAdmin
echo -n "Checking phpMyAdmin (http://localhost:8081)... "
if curl -s -o /dev/null -w "%{http_code}" http://localhost:8081 | grep -q "200"; then
    echo -e "${GREEN}OK${NC}"
else
    echo -e "${YELLOW}WARNING${NC}"
fi

echo ""
echo "=== Summary ==="
echo "API: http://localhost:8080"
echo "phpMyAdmin: http://localhost:8081"
echo ""
echo "Test the API with: curl http://localhost:8080/users"

.PHONY: help build up down restart logs clean test

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build Docker images
	docker-compose build

up: ## Start the application in detached mode
	docker-compose up -d
	@echo "Application is starting..."
	@echo "API will be available at: http://localhost:8080"
	@echo "phpMyAdmin will be available at: http://localhost:8081"
	@echo "Waiting for services to be ready..."
	@sleep 5

down: ## Stop and remove containers
	docker-compose down

restart: ## Restart all services
	docker-compose restart

logs: ## View logs from all services
	docker-compose logs -f

logs-web: ## View logs from web service
	docker-compose logs -f web

logs-db: ## View logs from database service
	docker-compose logs -f db

clean: ## Stop containers and remove volumes
	docker-compose down -v
	@echo "All containers and volumes removed"

shell-web: ## Open shell in web container
	docker-compose exec web bash

shell-db: ## Open MySQL shell
	docker-compose exec db mysql -uroot -proot_password database_for_rest

test: ## Test the API (list users)
	@echo "Testing API endpoint..."
	@curl -s http://localhost:8080/users | python -m json.tool || curl http://localhost:8080/users

status: ## Show status of containers
	docker-compose ps

rebuild: ## Rebuild and restart services
	docker-compose down
	docker-compose build --no-cache
	docker-compose up -d

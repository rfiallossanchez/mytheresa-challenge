.PHONY: start
start:  ## Starts api service with Docker Compose
	@echo "🚀 Starting api service"
	docker-compose -p challenge -f ./deploy/docker-compose.api.yaml up -d --remove-orphans

.PHONY: start-no-cache
start-no-cache: build start-verbose ## Start all services without cache

.PHONY: start-verbose
start-verbose: start logs-api ## Start all services showing all the logs

.PHONY: build
build:  ## Builds the Docker image without cache
	@echo "🚀 Building image"
	docker-compose -p challenge -f ./deploy/docker-compose.api.yaml build --no-cache
	
.PHONY: stop
stop: ## Stop api service
	@echo '🛑 Stopping api service'
	docker-compose -p challenge -f ./deploy/docker-compose.api.yaml down --remove-orphans

.PHONY: bash-api
bash-api: ## Enter into the API service container
	@echo '🔍 Entering service challenge-api'
	docker exec -it challenge-api bash

.PHONY: bash-db
bash-db: ## Enter into the API service container
	@echo '🔍 Entering service challenge-db'
	docker exec -it challenge-db psql -U postgres -d challenge_db

.PHONY: logs-api
logs-api: ## Show logs of the API service
	@echo '📜 Showing logs of the challenge-api service'
	docker logs challenge-api -f

.PHONY: test-api
test-api: ## Execute API unit tests
	@echo '📜 Executes API unit test with phpunit'
	 docker exec -it challenge-api php bin/phpunit

.PHONY: help
help: ## Show this help message
	@grep -E '^[a-zA-Z0-9_-]+:.*?## ' Makefile | \
		awk 'BEGIN {FS = ":.*?## "}; {printf "🛠️  %-20s %s\n", $$1, $$2}'

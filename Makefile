start:  ## Starts api service with Docker Compose
	@echo "🚀 Starting api service"
	docker-compose -p challenge -f ./infra/docker-compose.api.yaml up -d --remove-orphans

start-no-cache: build start-verbose

start-verbose: start logs-api

build:  ## Builds the Docker image without cache
	@echo "🚀 Building image"
	docker-compose -p challenge -f ./infra/docker-compose.api.yaml build --no-cache
	
.PHONY: stop
stop: ## Stop api service
	@echo '🛑 Stopping api service'
	docker-compose -p challenge -f ./infra/docker-compose.api.yaml down --remove-orphans

.PHONY: bash-api
bash-api: ## Enter into the API service container
	@echo '🔍 Entering service challenge-api'
	docker exec -it challenge-api bash


.PHONY: logs-api
logs-api: ## Show logs of the API service
	@echo '📜 Showing logs of the challenge-api service'
	docker logs challenge-api -f
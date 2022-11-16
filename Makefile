dev: .docker-up migrate queue

.docker-up:
	@docker-compose up -d


del: .docker-down

.docker-down:
	docker-compose down

migrate:
	docker exec mq-producer php artisan migrate

queue:
	docker exec mq-producer php artisan queue:work

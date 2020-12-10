PHP = docker-compose run --rm app

.PHONY: up down artisan composer

up:
	docker-compose up -d --force-recreate --build

down:
	docker-compose down

artisan:
	$(PHP) php artisan $(CMD)

composer:
	$(PHP) composer $(CMD)

test:
	$(PHP) vendor/phpunit/phpunit/phpunit tests/
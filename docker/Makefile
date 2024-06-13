ifneq (,$(wildcard ./.env))
    include .env
    export
endif

.PHONY: reset

#Docker commands
build:
	docker-compose build

build-nc:
	docker-compose build --no-cache

up-d:
	docker-compose up --build -d

up:
	docker-compose up --build

down:
	docker-compose down

down-v:
	docker-compose down -v

start:
	docker-compose start

stop:
	docker-compose stop


#APP commands
app-bash:
	docker exec -it ${PROJECT_NAME}-app bash

app-bash-u:
	docker exec -u root -it ${PROJECT_NAME}-app bash
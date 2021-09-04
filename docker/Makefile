#Набор команд/alias для упрощения их запуска на локальной (тестовой) среде
define compose
	docker-compose $1
endef

define recreate-postgres-volume
	docker volume rm pgdata
	docker volume create --name=pgdata
endef

#ждем пока база будет готова к приему соединений
define db-wait
	$(call about,Waiting for Postgres)
	$(call compose, ps)
	$(call compose, exec -T --user postgres postgres bash -c "until pg_isready 2>/dev/null; do sleep 1 ; done")
endef

up:
	docker-compose up -d
ps:
	docker-compose ps
php:
	docker-compose exec php-dev sh

go: up ps php

machine:
	docker-machine start kann

down:
	docker-compose down

restore:
	cat $(path) | docker exec -i docker_postgres_1 psql -U default

migrate:
	docker-compose exec php-dev php artisan migrate

seed:
	docker-compose exec php-dev php artisan db:seed

clear: cache-clear config-clear

#создает виртуальную машину для локальной работы
kann-machine-create:
	docker-machine create lms-api --virtualbox-memory 8096 --virtualbox-disk-size 20000

cache-clear:
	docker-compose exec php-dev php artisan config:cache

config-clear:
	docker-compose exec php-dev php artisan config:clear

pg-volume-create:
	docker volume create --name=pgdata

db-recreate:
	$(call about,Recreate database)
	$(call compose,exec php-dev php artisan db:wipe)

#накатывает миграции и запускает seed
db-seed:
	$(call compose,up -d postgres)
	$(call db-wait)
	$(call compose,exec php-dev php artisan migrate)
	$(call compose,exec php-dev php artisan db:seed)

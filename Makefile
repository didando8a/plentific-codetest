build:
	docker compose up --build --force-recreate

composer-install:
	docker compose run app composer install

composer-update:
	docker compose run app composer update

composer-dump-autoload:
	docker compose run app composer dump-autoload

composer-install-one:
	docker compose run app composer require json-mapper/json-mapper

test-unit: build composer-install
	docker compose run app ./vendor/bin/phpunit -vvv tests/unit/

test-integration: build composer-install
	docker compose run app ./vendor/bin/phpunit tests/integration/

container-bash: build
	docker compose run app bash

run-analyse:
	docker compose run app vendor/bin/phpstan analyse -c phpstan.neon

run-application:
	docker compose run app ./console lendinvest:investors-loan


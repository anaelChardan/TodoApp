ROOT_DIR=$(shell pwd)
BACK_DIR=$(ROOT_DIR)/back
FRONT_DIR=$(ROOT_DIR)/front

DOCKER_COMPOSE=docker-compose
PHP_RUN=$(DOCKER_COMPOSE) run --rm -u www-data php php
PHP_EXEC=$(DOCKER_COMPOSE) exec fpm php
YARN_EXEC=$(DOCKER_COMPOSE) run --rm -u node node yarn

CI ?= false

#### Docker ####
.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d --remove-orphan

.PHONY: down
down:
	$(DOCKER_COMPOSE) down -v

.PHONY: php-image-dev
php-image-dev:
	DOCKER_BUILDKIT=1 docker build --progress=plain --pull --tag todo/dev/php:7.4 --target dev ./infra

.PHONY: php-image-prod
php-image-prod:
	DOCKER_BUILDKIT=1 docker build --progress=plain --pull --tag todo/prod:${IMAGE_TAG} --target prod ./infra

.PHONY: php-images
php-images: php-image-dev php-image-prod

### Tools ###
.PHONY: sf
sf:
	$(PHP_RUN) bin/console ${F}

### Install ####
.PHONY: composer-dev
composer-dev:
	APP_ENV=dev $(PHP_RUN) /usr/local/bin/composer ${F}

.PHONY: composer-in_memory
composer-in_memory:
	APP_ENV=in_memory $(PHP_RUN) /usr/local/bin/composer ${F}

.PHONY: cache
cache: back/vendor
	rm -rf back/var/cache && $(PHP_RUN) bin/console cache:warmup

back/composer.lock: back/composer.json
	$(PHP_RUN) /usr/local/bin/composer update

back/vendor: back/composer.lock
	$(PHP_RUN) /usr/local/bin/composer install

back/node_modules: back/package.json
	$(YARN_EXEC) install

.PHONY: app-dev
app-dev:
	APP_DEV=dev $(MAKE) back/vendor
	APP_ENV=dev $(MAKE) up
	APP_ENV=dev $(MAKE) cache

.PHONY: app-prod
app-prod:
	APP_ENV=prod $(MAKE) back/vendor
	APP_ENV=prod $(MAKE) up
	APP_ENV=prod $(MAKE) cache

.PHONY: app-in-memory
app-in-memory:
	APP_ENV=in_memory $(MAKE) back/vendor
	APP_ENV=in_memory $(MAKE) up
	APP_ENV=in_memory $(MAKE) cache

.PHONY: install
install: back/vendor

.PHONY: db-schema
db-schema:
	$(PHP_RUN) bin/console d:s:u --dump-sql
	$(PHP_RUN) bin/console d:s:u --force

### TODO

.PHONY: todo-php-cs-fixer
todo-php-cs-fixer:
	$(PHP_RUN) vendor/bin/php-cs-fixer fix --diff --config=config/tests/todo/.php_cs src/Todo

.PHONY: todo-phpstan
todo-phpstan:
	$(PHP_RUN) vendor/bin/phpstan analyse src/Todo --level=7 -c config/tests/todo/phpstan.neon

.PHONY: todo-psalm
todo-psalm:
	$(PHP_RUN) vendor/bin/psalm --config=config/tests/todo/psalm.xml

.PHONY: todo-back-static
todo-back-static: todo-php-cs-fixer todo-phpstan todo-psalm

.PHONY: todo-back-run-spec
todo-back-run-spec:
	$(PHP_RUN) vendor/bin/phpspec run -c config/tests/todo/phpspec.yml ${F}

.PHONY: todo-back-desc-spec
todo-back-desc-spec:
	$(PHP_RUN) vendor/bin/phpspec desc -c config/tests/todo/phpspec.yml ${F}

.PHONY: todo-back-integration
todo-back-integration:
	$(PHP_RUN) bin/phpunit -c config/tests/todo/phpunit.xml.dist

.PHONY: todo-back-acceptance
todo-back-acceptance:
	$(PHP_RUN) vendor/bin/behat -p acceptance_todo -c config/tests/todo/behat.yml ${F}

.PHONY: todo-back-end-to-end
todo-back-end-to-end:
	$(PHP_RUN) vendor/bin/behat -p default -s end_to_end_todo -c config/tests/todo/behat.yml ${F}

.PHONY: todo-back-end-to-end-api
todo-back-end-to-end-api:
	$(PHP_RUN) vendor/bin/behat -p end_to_end_api_todo -c config/tests/todo/behat.yml ${F}

.PHONY: todo-back
todo-back: todo-back-static todo-back-run-spec todo-back-acceptance todo-back-end-to-end-api todo-back-integration

.PHONY: todo
todo: todo-back

.PHONY: sharespace-php-cs-fixer
sharespace-php-cs-fixer:
	$(PHP_RUN) vendor/bin/php-cs-fixer fix --diff --config=config/tests/sharespace/.php_cs src/ShareSpace

.PHONY: sharespace-phpstan
sharespace-phpstan:
	$(PHP_RUN) vendor/bin/phpstan analyse src/ShareSpace --level=7 -c config/tests/sharespace/phpstan.neon

.PHONY: sharespace-psalm
sharespace-psalm:
	$(PHP_RUN) vendor/bin/psalm --config=config/tests/sharespace/psalm.xml

.PHONY: sharespace-back-static
sharespace-back-static: sharespace-php-cs-fixer sharespace-phpstan sharespace-psalm

.PHONY: sharespace-back-run-spec
sharespace-back-run-spec:
	$(PHP_RUN) vendor/bin/phpspec run -c config/tests/sharespace/phpspec.yml ${F}

.PHONY: sharespace-back-integration
sharespace-back-integration:
	$(PHP_RUN) bin/phpunit -c config/tests/sharespace/phpunit.xml.dist

.PHONY: sharespace-back-acceptance
sharespace-back-acceptance:
	$(PHP_RUN) vendor/bin/behat -p default -s test_demo -c config/tests/sharespace/behat.yml ${F}

.PHONY: sharespace-back
sharespace-back: sharespace-php-cs-fixer sharespace-phpstan sharespace-psalm sharespace-back-run-spec sharespace-back-acceptance sharespace-back-integration

.PHONY: sharespace
sharespace: sharespace-back

#### All ####
.PHONY: php-cs-fixer
php-cs-fixer: todo-php-cs-fixer sharespace-php-cs-fixer

.PHONY: phpstan
phpstan: todo-phpstan sharespace-phpstan

.PHONY: pslam
psalm: todo-psalm sharespace-psalm

.PHONY: back-static
back-static: php-cs-fixer phpstan psalm

.PHONY: back-spec
back-spec: todo-back-run-spec sharespace-back-run-spec

.PHONY: back-integration
back-integration: todo-back-integration sharespace-back-integration

.PHONY: back-acceptance
back-acceptance: todo-back-acceptance sharespace-back-acceptance

.PHONY: back-end-to-end
back-end-to-end: todo-back-end-to-end

.PHONY: back-test
back-test: back-static back-spec back-acceptance back-end-to-end

.PHONY: codeclean
codeclean: back-static

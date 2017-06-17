FIG=docker-compose
RUN=$(FIG) run --rm app-back
EXEC=$(FIG) exec app-back
CONSOLE=php bin/console

.DEFAULT_GOAL := help
.PHONY: help stop db db-diff db-migrate db-rollback db-load build up perm deps cc composer back test phpunit

help:
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'


##
## Project setup
##---------------------------------------------------------------------------

stop:           ## Remove docker containers
	$(FIG) kill
	$(FIG) rm -v --force

cc:             ## Clear the cache in dev env
cc:
	$(RUN) $(CONSOLE) cache:clear --no-warmup
	$(RUN) $(CONSOLE) cache:warmup

composer:       ## Composer update
composer:
	@$(RUN) composer update

back:           ## Bash in back server container
back:
	$(EXEC) bash


##
## Database
##---------------------------------------------------------------------------

db:             ## Reset the database and load fixtures
db: vendor
	$(RUN) php -r "for(;;){if(@fsockopen('db',3306)){break;}}" # Wait for MySQL
	$(RUN) $(CONSOLE) doctrine:database:drop --force --if-exists
	$(RUN) $(CONSOLE) doctrine:database:create --if-not-exists
	$(RUN) $(CONSOLE) doctrine:migrations:migrate -n
	$(RUN) $(CONSOLE) doctrine:fixtures:load -n

db-status:      ## Display the status of migrations
db-status:
	$(RUN) $(CONSOLE) doctrine:migration:status

db-diff:        ## Generate a migration by comparing your current database to your mapping information
db-diff: vendor
	$(RUN) $(CONSOLE) doctrine:migration:diff

db-migrate:     ## Migrate database schema to the latest available version
db-migrate: vendor
	$(RUN) $(CONSOLE) doctrine:migration:migrate -n

db-rollback:    ## Rollback the latest executed migration
db-rollback: vendor
	$(RUN) $(CONSOLE) d:m:e --down $(shell $(RUN) $(CONSOLE) d:m:l) -n

db-load:        ## Reset the database fixtures
db-load: vendor
	$(RUN) $(CONSOLE) doctrine:fixtures:load -n

##
## Logs
##-----------------------------------------------------------------------------

logs:             ## Display app-back container logs
logs:
	$(FIG) logs -f

##
## Tests
##-----------------------------------------------------------------------------

tests:            ## Run all tests
tests:
	phpunit

phpunit:          ## Run PHPUnit tests
phpunit:
	$(EXEC) /var/www/html/vendor/bin/phpunit

coverage:         ## PHPUnit Code coverage measurement
coverage:
	$(EXEC) /var/www/html/vendor/bin/phpunit --coverage-text


##

# Internal rules

build:
	$(FIG) build

up:
	$(FIG) up -d

perm:
	-$(EXEC) chmod -R 777 var

# Rules from files

vendor: composer.lock
	@$(RUN) composer install

composer.lock: composer.json
	@echo compose.lock is not up to date.

app/config/parameters.yml: app/config/parameters.yml.dist
	@$(RUN) composer run-script post-install-cmd




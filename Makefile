.PHONY: build build-prod composer dev check test docker-dev docker-build ci dev-db release gulp

# Install composer and node deps and run composer scripts.
build:
	docker build -t muhit/web .

# This will install composer packages but will not run scripts.
build-prod:
	composer install --no-scripts --no-dev

# Alias for building and running docker composer
dev: docker-dev

# Alias for running composer checks script
check:
	composer checks

# Alias for running composer test script
test:
	composer test

# Creates the development environment with docker compose
docker-dev:
	-chmod -Rf 777 storage/
	docker-compose -f docker-compose-dev.yml up

# Rebuilds the docker images if something changes.
docker-build:
	docker-compose -f docker-compose-dev.yml build

# Alias to run on CI environment.
ci:
	make build-prod

# Runs the artisan db commands
dev-db:
	docker exec -i api_muhitweb_1 /usr/local/bin/php artisan migrate
	docker exec -i api_muhitweb_1 /usr/local/bin/php artisan db:seed

# Removes everything in development database
dev-db-refresh:
	docker exec -i api_muhitweb_1 /usr/local/bin/php artisan migrate:fresh

# Runs the rollback command on the docker
dev-rollback:
	docker exec -i api_muhitweb_1 /usr/local/bin/php artisan migrate:rollback

# clears caches on docker
view-clear:
	docker exec -i api_muhitweb_1 /usr/local/bin/php artisan view:clear
	docker exec -i api_muhitweb_1 /usr/local/bin/php artisan view:cache

# install npm and run gulp
gulp:
	docker exec -i api_muhitweb_1 npm install
	docker exec -i api_muhitweb_1 ./node_modules/.bin/gulp --production

# reads the latest tag, creates a new release incrementing the patch number
release:
	$(eval branch := $(shell git rev-parse --abbrev-ref HEAD))
	$(eval v := $(shell git describe --tags --abbrev=0 | sed -Ee 's/^v|-.*//'))
	$(eval f := 3)
	$(eval n := $(shell echo $(v) | awk -F. -v OFS=. -v f=$(f) '{ $$f++  } 1'))
	git flow release start $(n)
	git flow release finish $(n)
	git push origin develop
	git push --tags
	git checkout master
	git push origin master
	git checkout develop

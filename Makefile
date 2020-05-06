.PHONY: install
install:
	composer require --dev phpunit/phpunit ^9.0 phpstan/phpstan roave/security-advisories:dev-master -vvv

.PHONY: test
test:
	./vendor/bin/phpunit tests

.PHONY: lint
lint:
	vendor/bin/phpstan analyse src tests

.PHONY: security
security:
	composer update --dry-run roave/security-advisories


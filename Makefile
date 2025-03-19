install:
	composer install
validate:
	composer validate
update:
	composer dump-autoload
gendiff:
	./bin/gendiff
addToPathGendiff:
	sudo ln -sf $(shell pwd)/bin/gendiff /usr/local/bin/gendiff
deleteFromPathGendiff:
	sudo rm -f /usr/local/bin/gendiff
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin
test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
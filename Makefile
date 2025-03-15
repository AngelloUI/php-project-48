install:
	composer install
validate:
	composer validate
gendiff:
	./bin/gendiff
addToPathGendiff:
	sudo ln -sf $(shell pwd)/bin/gendiff /usr/local/bin/gendiff
deleteFromPathGendiff:
	sudo rm -f /usr/local/bin/gendiff
build:
	docker build --tag=json-to-code/php .

run:
	docker run -it -v $(PWD):/var/www/html -w /var/www/html  json-to-code/php sh

test:
	docker run -it -v $(PWD):/var/www/html -w /var/www/html  json-to-code/php ./vendor/bin/phpunit
# Makefile for OAuth CMSMS Module

.PHONY: all test build clean install help start stop

DDEV_STATUS := $(shell ddev describe 2>/dev/null | grep -q "running" && echo "running" || echo "stopped")

all: test build

start:
	@echo "Starting DDEV..."
	ddev start

stop:
	@echo "Stopping DDEV..."
	ddev stop

test:
	@echo "Running tests..."
	@if [ "$(DDEV_STATUS)" = "running" ]; then \
		ddev exec ./vendor/bin/phpunit; \
	else \
		echo "Starting DDEV first..."; \
		ddev start && ddev exec composer install --no-interaction && ddev exec ./vendor/bin/phpunit; \
	fi

test-coverage:
	@echo "Running tests with coverage..."
	ddev exec ./vendor/bin/phpunit --coverage-html coverage

build:
	@echo "Building distribution package..."
	./build.sh

install:
	@echo "Installing dependencies..."
	ddev exec composer install

update:
	@echo "Updating dependencies..."
	ddev exec composer update

clean:
	@echo "Cleaning..."
	rm -rf dist/
	rm -rf coverage/
	rm -rf .phpunit.cache/
	rm -rf vendor/

lint:
	@echo "Linting PHP files..."
	ddev exec find . -name "*.php" -not -path "./vendor/*" -exec php -l {} \;

help:
	@echo "OAuth Module - Available targets:"
	@echo ""
	@echo "  make start    - Start DDEV environment"
	@echo "  make stop     - Stop DDEV environment"
	@echo "  make install  - Install composer dependencies (via DDEV)"
	@echo "  make test     - Run PHPUnit tests (via DDEV)"
	@echo "  make test-coverage - Run tests with coverage report"
	@echo "  make build    - Build distribution package (.xml.gz)"
	@echo "  make clean    - Remove build artifacts"
	@echo "  make lint     - Check PHP syntax"
	@echo "  make all      - Run tests and build (default)"
	@echo ""
	@echo "Requires: DDEV (https://ddev.com)"

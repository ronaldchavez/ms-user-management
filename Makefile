#!/bin/bash

OS := $(shell uname)

ifeq ($(OS),Darwin)
	UID = $(shell id -u)
	IP_DEBUG = host.docker.internal
else ifeq ($(OS),Linux)
	UID = $(shell id -u)
	IP_DEBUG = 172.17.0.1
else
	UID = 1000
	IP_DEBUG = host.docker.internal
endif


# Define default target
.PHONY: all up down rebuild

# Target to build and run Docker containers using docker-compose-debug.yml
all: up

# Target to start the containers in detached mode
run:
	docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env up -d

# Target to stop the containers
down:
	docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env down

# Target to rebuild the containers
rebuild:
	docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env build --no-cache

# Target to start the containers in detached mode
up:
	docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env up -d

# Target to create a shell within the "php-apache" service container for debugging
shell:
	docker-compose -f docker-compose-debug.yml --env-file ./docker/api.env exec -ti php-apache /bin/bash

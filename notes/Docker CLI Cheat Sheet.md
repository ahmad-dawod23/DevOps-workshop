# Docker CLI Cheat Sheet

A quick reference for managing Docker images, containers, volumes, networks, and Docker Compose.

## Table of Contents

- [Images](#images)
- [Containers](#containers)
- [Common Database Container Examples](#common-database-container-examples)
- [Logs, Shell & Inspection](#logs-shell--inspection)
- [Volumes & Networks](#volumes--networks)
- [Docker Compose](#docker-compose)
- [System & Cleanup](#system--cleanup)

---

## Images

```bash
# Build an image from the Dockerfile in the current directory
docker build -t <image_name>:<tag> .

# Build an image without using the build cache
docker build --no-cache -t <image_name>:<tag> .

# List locally stored images
docker images
# (equivalent modern command)
docker image ls

# Pull an image from a registry
docker pull <image_name>:<tag>

# Tag a local image for a registry
docker tag <local_image>:<tag> <username>/<repo>:<new_tag>

# Log in to a registry and push an image
docker login
docker push <username>/<repo>:<tag>

# Remove a specific image
docker rmi <image_name>:<tag>
# (equivalent modern command)
docker image rm <image_name>:<tag>

# Remove all dangling (unused) images
docker image prune

# Remove all unused images (not just dangling ones)
docker image prune -a
```

---

## Containers

### Running Containers

```bash
# Run a container in the background (detached) with a custom name
docker run -d --name <container_name> <image_name>

# Run a container and publish a container port to the host
docker run -d -p <host_port>:<container_port> --name <container_name> <image_name>

# Run a container with environment variables and a bind mount / volume
docker run -d -e <KEY>=<VALUE> -v <host_path_or_volume>:<container_path> <image_name>

# Run an interactive temporary container (auto-removed on exit)
docker run --rm -it <image_name> /bin/sh
```

### Managing Container Lifecycle

```bash
# List running containers
docker ps

# List all containers (running and stopped)
docker ps -a

# Start, stop, or restart an existing container
docker start <container_name_or_id>
docker stop <container_name_or_id>
docker restart <container_name_or_id>

# Force-stop a running container immediately (SIGKILL)
docker kill <container_name_or_id>

# Rename a container
docker rename <old_name> <new_name>

# Remove a stopped container
docker rm <container_name_or_id>

# Force-remove a running container
docker rm -f <container_name_or_id>

# Remove all containers (running and stopped)
docker rm -f $(docker ps -aq)

# Copy files between host and container
docker cp <local_file> <container_name>:<container_path>
docker cp <container_name>:<container_path> <local_path>
```

---

## Common Database Container Examples

```bash
# SQL Server
docker run -d --name mssql \
  -e "ACCEPT_EULA=Y" \
  -e "MSSQL_SA_PASSWORD=<strong_password>" \
  -e "MSSQL_PID=Express" \
  -p 1433:1433 \
  mcr.microsoft.com/mssql/server:2022-latest

# MySQL
docker run -d --name mysql \
  -e MYSQL_ROOT_PASSWORD=<root_password> \
  -p 3306:3306 \
  mysql:latest

# PostgreSQL
docker run -d --name postgres \
  -e POSTGRES_PASSWORD=<password> \
  -p 5432:5432 \
  postgres:latest
```

---

## Logs, Shell & Inspection

```bash
# Open an interactive shell inside a running container
docker exec -it <container_name> /bin/sh
# (or /bin/bash if available)
docker exec -it <container_name> /bin/bash

# View and stream container logs
docker logs <container_name>
docker logs -f <container_name>

# View the last 100 lines of logs
docker logs --tail 100 <container_name>

# Inspect low-level JSON metadata of a container or image
docker inspect <container_name_or_id>

# View live CPU, memory, and network usage stats
docker stats

# View running processes inside a container
docker top <container_name>

# Show port mappings for a container
docker port <container_name>
```

---

## Volumes & Networks

### Volumes

```bash
# List volumes
docker volume ls

# Create a named volume
docker volume create <volume_name>

# Inspect or remove a volume
docker volume inspect <volume_name>
docker volume rm <volume_name>

# Remove all unused volumes
docker volume prune
```

### Networks

```bash
# List networks
docker network ls

# Create a custom bridge network
docker network create <network_name>

# Inspect or remove a network
docker network inspect <network_name>
docker network rm <network_name>

# Connect or disconnect a container to/from a network
docker network connect <network_name> <container_name>
docker network disconnect <network_name> <container_name>
```

---

## Docker Compose

> Uses Docker Compose v2 (`docker compose`). If using legacy v1, replace `docker compose` with `docker-compose`.

```bash
# Start services in the foreground
docker compose up

# Start services in the background (detached) and rebuild images if needed
docker compose up -d --build

# Use a specific compose file
docker compose -f docker-compose.yaml up -d

# Stop and remove containers and networks
docker compose down

# Stop and also remove named volumes
docker compose down -v

# List running compose services
docker compose ps

# Follow logs for all services (or a specific service)
docker compose logs -f
docker compose logs -f <service_name>

# Execute a command in a running service container
docker compose exec <service_name> /bin/sh
```

---

## System & Cleanup

```bash
# Show Docker disk usage (images, containers, volumes, build cache)
docker system df

# Remove all stopped containers, unused networks, dangling images, and build cache
docker system prune

# Aggressive cleanup: also remove all unused images and volumes
docker system prune -a --volumes
```

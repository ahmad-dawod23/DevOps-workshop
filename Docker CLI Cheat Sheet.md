
## Images:

Build an Image from a Dockerfile

`docker build -t <image_name>`

Build an Image from a Dockerfile without the cache

`docker build -t <image_name> . –no-cache`

List local images

`docker images`

 Delete an Image
 
`docker rmi <image_name>`

 Remove all unused images
 
`docker image prune`

 Build an image from the Dockerfile in the current directory and tag the image
 
`docker build -t myimage:1.0 .`

 List all images that are locally stored with the Docker Engine
 
`docker image ls`

 Delete an image from the local image store
 
`docker image rm alpine:3.4`

 Pull an image from a registry
 
`docker pull myimage:1.0`

 Retag a local image with a new image name and tag
 
`docker tag myimage:1.0 myrepo/myimage:2.0`

 Push an image to a registry
 
`docker push myrepo/myimage:2.0`

## Containers:

 Create and run a container from an image, with a custom name:
 
`docker run --name <container_name> <image_name>`

 Run a container with and publish a container’s port(s) to the host.
 
`docker run -p <host_port>:<container_port> <image_name>`

 Run a container in the background
 
`docker run -d <image_name>`

 docker run for a webapp: 
 
`docker run -p 5000:5000 -d --name [container name] [container id]`

 sql server run:
 
`docker run -e "ACCEPT_EULA=Y" -e "SA_PASSWORD=ahmad@123" -e "MSSQL_PID=Express" -p 1433:1433 -d mcr.microsoft.com/mssql/server:2019-latest`

 mysql run:
 
`docker run -p 3306:3306 --name mysql -e MYSQL_ROOT_PASSWORD=ahmad@123 -d 5a4e492065c7`

 Start or stop an existing container:
 
`docker start|stop <container_name> (or <container-id>)`

 Remove a stopped container:
 
`docker rm <container_name>`

 Open a shell inside a running container:
 
`docker exec -it <container_name> sh`

 Fetch and follow the logs of a container:
 
`docker logs -f <container_name>`

 To inspect a running container:
 
`docker inspect <container_name> (or <container_id>)`

 To list currently running containers:
 
`docker ps`

 List all docker containers (running and stopped):
 
`docker ps --all`

 View resource usage stats
 
`docker stats`

 copy files into a containers:
 
`docker cp [file] [container name]:/[file]`

 docker rename container:
 
`docker rename flask_restapi flask_webservice`

 Stop a running container through SIGKILL
 
`docker container kill web`

 List the networks
 
`docker network ls`

 List the running containers (add --all to include stopped containers)
 
`docker ls`

 Delete all running and stopped containers
 
`docker rm -f $(docker ps -aq)`

 Print the last 100 lines of a container’s logs
 
`docker logs --tail 100 web`

 How to run a docker compose file:
 
`docker-compose -f docker-compose.yml up`

 How to stop a composed docker container:
 
`docker-compose -f docker-compose.yml down`
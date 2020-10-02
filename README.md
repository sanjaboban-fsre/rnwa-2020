# RNWA Project tasks

Due to working environment XAMPP and other "out of box solutions" wouldn't work well so Docker was used.

## General info

- Each directory other than mysql contains project task and all tasks depend on mysql directory and it's content
- Each directory contains it's `docker-compose.yml` file used for service/task definition and execution
- Before starting any of the project's tasks it's necessary to run MySQL as prerequisite
- General docker commands and usage in script bellow:

  ```bash
  docker-compose up -d # starts container for specific task/directory in daemon mode - run this for start
  docker-compose down # stops and removes task/directory docker container - run this to stop
  ```

## Prerequisites

- Docker
- Docker network named `rnwa-net` is required, to create it run:

  ```sh
  docker network create rnwa-net
  ```

- All tasks share same mysql database located in `mysql` directory

  - To initialize/set-up mysql database run following commands from repository root

    ````bash
        # this will enter mysql directory
        cd mysql;
        # this will start mysql container and mount necessary things defined in file
        docker-compose up -d;
        # wait for a minute or 2 before continuing with commands bellow as MySQL needs some time to initialize
        # this will enter running container and create hr database required for projects to work
        docker exec -it mysql_rnwa_projects mysql --password="root" --execute="CREATE DATABASE hr;"
        # this will create database structure and initial data from script provided in project tasks
        docker exec -it mysql_rnwa_projects bash -c "mysql hr --password='root' < /home/mysql_seed.sql;"
        # now we're done and can go back to repository root and mysql will be left running
        cd ../;
        ```
    ````

## Repository structure

After first run and MySQL initialization, repository structure should look like this:

```bash
├── README.md # -> this file, contains general info and commands
├── docker_data # -> mysql data persisted, can be ignored and not touched
├── mysql # -> contains mysql setup/definition
├── rest_1 # -> contains REST task P.Z.1
├── rest_2 # -> contains REST task P.Z.2, available at http://localhost:8084/
├── rest_2_basic_auth # -> contains REST task P.Z.2 with basic auth, available at http://localhost:8085/
├── rest_2_oauth2 # -> contains REST task P.Z.2 with OAuth2, available at http://localhost:8086/
├── ws_1 # -> contains Web Service task 1, drop index.html from task into browser, API on https://localhost:5003
└── ws_2 # -> contains Web Service task 2, available at http://localhost:8082/ when running
```

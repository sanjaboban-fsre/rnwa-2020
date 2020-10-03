# RNWA Project tasks

Due to working environment, XAMPP and similar "out of the box solutions" wouldn't work well, so Docker was used.

## General info

- Before actually running and using any tasks, MySQL database needs to be initialized.
- General docker commands and usage in script bellow:

  ```bash
  docker-compose up -d # starts container for specific task/directory in daemon mode - run this for start
  docker-compose down # stops and removes task/directory docker container - run this to stop
  ```
  
- After containers are started, homepage should be available at [port 10000](http://localhost:10000/).

## Prerequisites and starting the tasks

- Docker
- docker-compose
- MySQL initialization and initial seed

  - To initialize/set-up mysql database, run following commands from repository root:

    ````bash
        # this will start containers and mount necessary things defined in docker-compose.yml file
        docker-compose up -d;
        # wait for a minute or 2 before continuing with commands bellow as MySQL needs some time to initialize
        # this will enter running container and create hr database required for projects to work
        docker-compose exec mysql mysql --password="root" --execute="CREATE DATABASE hr;"
        # this will create database structure and initial data from script provided in project tasks
        docker-compose exec mysql bash -c "mysql hr --password='root' < /home/mysql_seed.sql;"
        # now we're done and can go test our tasks
        ```
    ````

  - All PHP-based tasks/services will be up and running after executing above listed `docker-compose` command.
  - To run .NET-based task/service (`ws_1`):
    - Open project in Visual Studio
    - Or navigate to `ws_1/net_proj` via terminal and execute `dotnet run` command

## Repository structure

```bash
├── README.md # -> this file, contains general info and commands
├── RNWA_projektni_zadaci_Boban.pdf # -> document containing project tasks description
├── -------------------------------------------------------------------------------------------------------------
├── docker-compose.yml # -> docker-compose file for definition and running of services required
├── site.conf # -> Configuration file for NGINX web server & FastCGI setup
├── mysql # -> helper directory, containing MySQL script for creation and initial data seed of hr database
├── -------------------------------------------------------------------------------------------------------------
├── index.html and style.css # -> homework HTML+CSS Responsive Web Site
├── hw_ajax_jquery # -> homework Ajax + jQuery task
├── -------------------------------------------------------------------------------------------------------------
├── ws_1 # Project Web Service task 1
├── ws_2 # Project Web Service task 2
├── -------------------------------------------------------------------------------------------------------------
├── rest_1 # -> Project REST task P.Z.1
├── rest_1_basic_auth # -> Project REST task P.Z.1, with basic auth
├── rest_1_oauth2 # -> Project REST task P.Z.1, with Google OAuth2
├── rest_2 # -> Project REST task P.Z.2
├── rest_2_basic_auth # -> Project REST task P.Z.2, with basic auth
├── rest_2_oauth2 # -> Project REST task P.Z.2, with Google OAuth2
├── -------------------------------------------------------------------------------------------------------------
├── RNWA_Departments_API.postman_collection.json # -> Postman collection containing requests for REST task P.Z.1
└── RNWA_Jobs_API.postman_collection.json # -> Postman collection containing requests for REST task P.Z.2
```

## Notes

Further details about each task:

  1) `Homework - HTML+CSS Responsive Website`

      Result of this task is an `index.html` page (and separate `style.css` stylesheet)
      set in root of the repository.
      
      Open in browser: [Home page](http://localhost:10000/)
  
  2) `Homework - AJAX+jQuery`, `Web Service 1` and `Web service 2`
  
      Homepage contains navigation bar with links to these 3 tasks.
   
  3) `REST service - CRUD operations` (`no-auth`, `basic-auth` and `oauth2` tasks)
     
      REST services have an API interface.
      
      POSTMAN collections containing available API routes for executing CRUD operations on 2 tables
      are attached in this repository:
        - `RNWA_Departments_API.postman_collection.json`
        - `RNWA_Jobs_API.postman_collection.json`
        
      ##### Additional note:
      
      Google OAuth through Postman posed a bit of an issue, so it isn't available in collections mentioned above.
   
      We can access OAuth REST service through browser:
      [REST_1 Google OAuth - GET request](http://localhost:10000/rest_1_oauth2/api/v1/departments.php).
      
      We will be prompted to log in with our Google account.
      After successful log in, fetched data will be displayed.

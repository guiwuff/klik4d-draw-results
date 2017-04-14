# Docker Containers Setup and Configuration for Wordpress Development

> Notes on docker command, containers, setup and configuration 

`GUI Wuff <gui.wuff@gmail.com>`

## Required

- [ ] Database Container (MySQL)
- [ ] Web Server (Nginx with php-fpm)
- [ ] MySQL admin console / interface

For MySQL admin I am exploring Sequel Pro [https://www.sequelpro.com/](https://www.sequelpro.com/)

## Docker Commands

### General Commands

List downloaded images

``` bash
guiwuff$ docker images
REPOSITORY           TAG                 IMAGE ID            CREATED             SIZE
mysql                latest              d5127813070b        2 days ago          407 MB
nginx                latest              db079554b4d2        8 weeks ago         182 MB
opencoconut/ffmpeg   latest              cb86929d414f        11 months ago       103 MB

```

List active containers 

```
guiwuff$ docker ps
CONTAINER ID        IMAGE               COMMAND                  CREATED              STATUS              PORTS               NAMES
91529cbcb8e1        mysql:latest        "docker-entrypoint..."   About a minute ago   Up About a minute   3306/tcp            sql-container
```

### MySQL Server Install and Config

Official Container [https://hub.docker.com/_/mysql/](https://hub.docker.com/_/mysql/)

Pull MySQL image from repository

``` bash
guiwuff$ docker pull mysql
Using default tag: latest
latest: Pulling from library/mysql
6d827a3ef358: Pull complete
ed0929eb7dfe: Pull complete
...
Digest: sha256:3ea679cbde178e346dcdeb538fd1ea4f1af256020ebeb464ccb72a1646a2ba6d
Status: Downloaded newer image for mysql:latest
```

Start MySQL Instance, change my-secret-pw with your password and :tag with the tag of your images, in this case :latest

And change folder information to map MySQL database storage mapping



```bash
guiwuff$ docker run -p 3306:3306 --name sql-container -v /Users/guiwuff/Documents/Containers/sql-container:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=blabla123 -d mysql:latest
91529cbcb8e1c0417f7b7b9f9185bf58c4b83327e6ca2d50dec39386fd3af712
```
This mysql image expose standard mysql port (3306), application in another container will use this port to utilize mysql database.

Shell access and view MySQL logs

```
guiwuff$ docker exec -it sql-container bash
root@91529cbcb8e1:/# uname -a
Linux 91529cbcb8e1 4.9.13-moby #1 SMP Sat Mar 25 02:48:44 UTC 2017 x86_64 GNU/Linux
root@91529cbcb8e1:/# exit

guiwuff$ docker logs sql-container
Initializing database
2017-04-14T19:03:35.833116Z 0 [Warning] TIMESTAMP with implicit DEFAULT value is deprecated. Please use --explicit_defaults_for_timestamp server option (see documentation for more details).
2017-04-14T19:03:36.739477Z 0 [Warning] InnoDB: New log files created, LSN=45790
2017-04-14T19:03:36.927283Z 0 [Warning] InnoDB: Creating foreign key constraint system tables.
2017-04-14T19:03:36.970521Z 0 [Warning] No existing UUID has been found, so we assume that this is the first time that this server has been started. Generating a new UUID: 10668ac0-2145-11e7-8253-0242ac110002.
2017-04-14T19:03:36.980456Z 0 [Warning] Gtid table is not ready to be used. Table 'mysql.gtid_executed' cannot be opened.
2017-04-14T19:03:36.981187Z 1 [Warning] root@localhost is created with an empty password ! Please consider switching off the --initialize-insecure option.
```

### Nginx Web Server with php-fpm Container

Deploy using docker compose; Prepare folder for volumes mapping
Create docker-compose.yml

```
version: '2'
services:
    nginx:
        image: nginx:latest
        container_name: web-neofb-container
        restart: always
        ports:
            - "80:80"
        volumes:
            - ./www-wp-neofb:/www-data
            - ./site.conf:/etc/nginx/conf.d/default.conf
        networks:
            - wp-neofb-net
    php:
        image: php:7-fpm
        container_name: phpfpm-neofb-container
        restart: always
        volumes:
            - ./www-wp-neofb:/www-data
            - ./logs.conf:/usr/local/etc/php-fpm.d/zz-log.conf
        networks:
            - wp-neofb-net
    sql:
        image: mysql:latest
        container_name: mysql-neofb-container
        restart: always
        environment:
            MYSQL_ROOT_PASSWORD: blabla123
            MYSQL_DATABASE: wpneofb
            MYSQL_USER: wpneofb
            MYSQL_PASSWORD: blabla123
        volumes:
            - ./sql-wp-neofb:/var/lib/mysql
        networks:
            - wp-neofb-net
networks:
    wp-neofb-net:
        driver: bridge

```

Create site.conf in the same folder with docker-compose.yml and map the file into container in docker-compose.yml `/etc/nginx/conf.d/default.conf`

```
server {
    listen 80;
	index index.php index.html;
    server_name neofb.local;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /www-data;
	
	location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
   	}

}   
```

site.conf file above configure nginx to use php-fpm and listen to neofb.local server name. 
Map neofb.local into your hosts file

docker-compose up then will pull the images required (nginx and php-fpm), and create necessary link to other project related container

```
guiwuff$ docker-compose up -d
Creating mysql-neofb-container
Creating phpfpm-neofb-container
Creating web-neofb-container

guiwuff$ docker-compose ps
         Name                       Command              State              Ports
--------------------------------------------------------------------------------------------
mysql-neofb-container    docker-entrypoint.sh mysqld     Up      3306/tcp
phpfpm-neofb-container   docker-php-entrypoint php-fpm   Up      9000/tcp
web-neofb-container      nginx -g daemon off;            Up      443/tcp, 0.0.0.0:80->80/tcp
```

## Linux Commands or Other


Create database for wordpress deployment

```
guiwuff$ docker exec -it sql-container bash
root@8e961c6f32ee:/# mysql -u root -p
Enter password:
...
mysql> create database wpfb;
Query OK, 1 row affected (0.01 sec)

mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| ...                |
| wpfb               |
+--------------------+
5 rows in set (0.02 sec)
mysql> exit
Bye
root@8e961c6f32ee:/# exit
exit
guiwuff$
```

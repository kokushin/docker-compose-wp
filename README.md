# docker-compose-wp

docker-compose for wordpress

## Setup

1. Edit `docker-compose.yml` file

```
wordpress:
    ...
    container_name: wordpress <-
    ...
    ports:
      - "8000:80" <-
    ...
    networks:
      - wordpress_network <-
    ...

  db:
    ...
    container_name: wordpress_db <-
    ...
    networks:
      - wordpress_network <-
    ...

...

networks:
  wordpress_network: <-
```

2. Create `.env` file, write environment variables

examples:

```
WORDPRESS_DB_NAME=wordpress
WORDPRESS_DB_USER=admin
WORDPRESS_DB_PASSWORD=password

MYSQL_RANDOM_ROOT_PASSWORD=yes
MYSQL_DATABASE=wordpress
MYSQL_USER=admin
MYSQL_PASSWORD=password
```

3. Run `docker-compose up` command

```
$ docker-compose up -d
```
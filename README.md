# docker-compose-wp

docker-compose for wordpress

## Setup

I. Edit `docker-compose.yml` file.

```
wordpress:
    ...
    container_name: OPTIONAL <-
    volumes:
      - ./themes/OPTIONAL:/var/www/html/wp-content/themes/OPTIONAL <-
    ...
    ports:
      - "8000:80" <-
    ...
    networks:
      - OPTIONAL_network <-
    ...

  db:
    ...
    container_name: OPTIONAL_db <-
    ...
    networks:
      - OPTIONAL_network <-
    ...

...

networks:
  OPTIONAL_network: <-
```

II. Create `.env` file, write environment variables.

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

III. Run `docker-compose up` command.

```
$ docker-compose up -d
```

IV. Open `http://localhost:8000/`

## Backup

```
$ docker exec wordpress_db /usr/bin/mysqldump -u admin --password=pass wordpress > wordpress.sql
```

## Restore

```
$ docker-compose build
```

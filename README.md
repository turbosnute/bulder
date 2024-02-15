# bulder
Attempt to make app for logging your first ascent of boulders optimized for Trondheim (Norway) color graded indoor boulders.

## Components
Apache, PHP, MariaDB and Bootstrap.

### Containers
* php-apache + mysqli
* mariadb
* backup cointainer

### External APIs
* Google Maps Places API.
* Google Oauth

## Build 

Clone:
```
git@github.com:turbosnute/bulder.git
cd bulder
```

Change the default password for user 'adamondra':
```
nano webserver/web/config.php
```

Build:
```
docker compose build
```

## Setup
Login with adamondra to set up databases and google apis.

## Screen shots
 ![Logbook](bulder1.png)
 ![Register new send](bulder2.png)
 ![Diary](bulder3.png)
 ![Stats](bulder4.png)

## Needs fixing
* change locale on calendar so weeks start on monday.
* restart policy in docker-compose.yml
* iso dates shold be replaced with nicer dates, maybe locale js stuff.
* favicon?
* add send buttons should be fetched from db to make it possible to change grading systems in the future.
* users.php should have edit/delete?
* sends: terrain: slab/vert/overhang (?).

# bulder
Attempt to make app for logging your first ascent of boulders optimized for Trondheim (Norway) color graded indoor boulders.

## Components
Apache, PHP, MariaDB and Bootstrap.

### Containers
* php8.1.5:apache + mysqli
* mariadb

### External APIs
* Google Maps Places API.

## Needs fixing
* number of sends in sendlog (?)
* logo + favicon
* add send buttons should be fetched from db to make it possible to change grading systems in the future.
* try making compatible with linuxserver.io/mariadb (by adding mysql_password env variables in addition to mariadb envs.)
* users.php should have edit/delete?
* iso dates shold be replaced with nicer dates, maybe locale js stuff.
* sends: terrain: slab/vert/overhang (?).
* google auth.
* change locale on calendar so weeks start on monday.
* diary (https://stackoverflow.com/questions/66624190/how-to-create-in-php-a-full-year-table-html).
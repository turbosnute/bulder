# bulder
Attempt to make app for logging your first ascent of boulders optimized for Trondheim (Norway) color graded indoor boulders.

## Components
Apache, PHP, MariaDB and Bootstrap.

### Containers
* php7.2:apache + mysqli
* mariadb

### External APIs
* Google Maps Places API.

## Needs fixing
* iso dates shold be replaced with nicer dates, maybe locale js stuff.
* change locale on calendar so weeks start on monday.
* salt local users md5 hashes for local users
* favicon+logo?
* send-count on logbook page.
* add send buttons should be fetched from db to make it possible to change grading systems in the future.
* try making compatible with linuxserver.io/mariadb (by adding mysql_password env variables in addition to mariadb envs.)
* it should not be possible to delete the last crag.
* users.php should have edit/delete?
* sends: terrain: slab/vert/overhang (?).
* Update ER-diagram.
* diary (https://stackoverflow.com/questions/66624190/how-to-create-in-php-a-full-year-table-html).
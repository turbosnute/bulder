# bulder
Attempt to make app for logging your first ascent of boulders optimized for norwegian color graded indoor boulders.

## Components
Apache, PHP, MariaDB and Bootstrap.

### Containers
* php7.2:apache + mysqli
* mariadb

### External APIs
* Google Maps Places API.

## Database Diagram
  ![Database diagram](bulder.drawio.png)

## Needs fixing
 * grade database must be created and populated in setup.php
 * delete functionality on edit sends.
 * confirmation dialog on deletes?
 * diary (github contributors style?)
 * change locale on calendar so weeks start on monday.
 * google auth
 * User classes (all should probably not be admins).
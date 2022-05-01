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

* link hover on sends should have similar effect to buttons.
* Add Send: Repeat-send?
* sends: terrain: slap/vert/overhang (?)
* Download logbook to csv.
* confirmation dialog on deletes?
* google auth.
* grades should have friendlyname (Blue-Red instead of bluered)
* Setup should add first admin user
* change locale on calendar so weeks start on monday.
* Update ER-diagram.
* diary (https://stackoverflow.com/questions/66624190/how-to-create-in-php-a-full-year-table-html).

## Fixed
* stats: visited x times is wrong.
* stats: hardest flash should not be shown if user has no flashes.
* stats: max send in a day.
* x sends logged should have other icon. maybe a list icon.
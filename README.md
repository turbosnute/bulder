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
 * grade database must be created and populated in setup.php.
 * delete functionality on edit sends.
 * confirmation dialog on deletes?
 * diary (github contributors style?).
 * change locale on calendar so weeks start on monday.
 * google auth.
 * Download logbook to csv.
 * Stats: max send in a day.
 * Update ER-diagram.
 * grades should have friendlyname (Blue-Red instead of bluered)
 * Setup should add first admin user
 * stats: visited x times is wrong.
 * stats: hardest flash should not be shown if user has no flashes.
 * x sends logged should have other icon. maybe a list icon.
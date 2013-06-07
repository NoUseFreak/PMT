Installation
------------

1. Clone the repository
2. Copy `app/config/parameters.yml.dist` to `app/config/parameters.yml` and edit the relevant values for your setup.
3. Install dependencies: `php composer.phar install`
4. Run `php app/console doctrine:schema:create` to setup the DB
5. Optionally import dummy data in the database. `mysql [dbname] < doc/dummy_data.sql`
6. Run `php app/console assets:install web` to deploy the assets on the web dir
7. Make a VirtualHost with DocumentRoot pointing to web/ or run `php app/console server:run`
8. Create a user using terminal: `php app/console fos:user:create`

You should now be able to access the site.

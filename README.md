# Stream Plus

1. Rename the .env_sample file .env and update the DATABASE_URL to proper mysql connection string.

2. Create Database using 
php bin/console doctrine:database:create

3. Run the Migrations
php bin/console doctrine:migrations:migrate
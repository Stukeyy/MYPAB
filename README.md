# Ulster University Final Year Project

1. Clone Repo
    - git clone https://gitlab.scm.ulster.ac.uk/final-project/backend.git

2. Install dependencies
    - composer install

3. start local postgres server and connect
    - brew services start postgresql
    - psql postgres
    - CREATE DATABASE database;

4. Update env file to point to database
    - DB_CONNECTION=pgsql
    - DB_HOST=127.0.0.1
    - DB_PORT=5432
    - DB_DATABASE=database
    - DB_USERNAME=user
    - DB_PASSWORD=password

5. To backup the application
    - php artisan backup:run --only-files
    - This is stored in storage/app/backups
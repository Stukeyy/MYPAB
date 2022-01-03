# Ulster University Final Year Project

#### Dependencies
- php
- composer
- node
- npm
- postgres
- vue
- git

1. Create new directory
    - mkdir project
    - cd project

2. Clone Repos
    - backend - git clone https://gitlab.com/final-project24/backend.git
    - frontend - git clone https://gitlab.com/final-project24/frontend.git

3. Install dependencies
    - cd backend
    - composer install
    - cd ../frontend
    - npm install

4. start local postgres server and connect
    - brew services start postgresql
    - psql postgres
    - CREATE DATABASE database;

5. Update .env file in backend to point to database
    - DB_CONNECTION=pgsql
    - DB_HOST=127.0.0.1
    - DB_PORT=5432
    - DB_DATABASE=database
    - DB_USERNAME=user
    - DB_PASSWORD=password

6. Migrate and seed database
    - cd ../backend
    - php artisan migrate:fresh --seed

7. Host application
    - php artisan serve
    - cd ../frontend
    - npm run dev
    - visit http://localhost:8001

8. Register or sign in to application
    - demo@mail.com
    - password

9. To backup the application
    - php artisan backup:run --only-files
    - This is stored in storage/app/backups
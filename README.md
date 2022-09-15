# Ulster University Final Year Project

**application available at https://mypa.ml**
**any issues please contact the developer ross-s21@ulster.ac.uk**

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

10. Connect to AWS Server
    - cd into keys dir
    - ssh -i key.pem ubuntu@mypa.ml

11. Start Runners
    - gitlab-runner run

#### Unsafe shutdown

- If your mac is not shut down correctly, some services may become corrupted

postgresql

gitlab-runner
1. gitlab-runner install
2. register new runners via GitLab CICD Settings Runners Page
3. Remove old runners
4. gitlab-runner run


#### CI PROCESS

1. Start Runners
    - gitlab-runner run
2. push all frontend changes with a [ci skip] commit message
    - latest changes now available in remote GitLab repo
3. push all backend changes
    - latest changes now available in remote GitLab repo
    - trigger job will initiate frontend pipeline to deploy
    - frontend deploy script will pull latest backend changes, then latest frontend changes, build and integrate
4. after frontend rebuild and job success, connect to AWS server
    - cd into keys dir
    - ssh -i key.pem ubuntu@mypa.ml
    - then update application
    - php artisan migrate
    - update .env file
    - php artisan config:clear
    - sudo php artisan cache:clear
    - composer dump-autoload

#### Dev Process

1. Open Term2
2. Select Scripts Tab
3. Run project_startup.py

#### PM2 Queue

1. Install PM2
    - npm install -g pm2
2. Install logs extension
    - this will help reduce log file size on disk
    - pm2 install pm2-logrotate
    - can also flush logs entirely
    - pm2 flush
3. Start service
    - cd into backend directory
    - pm2 start "php artisan queue:work --timeout=0"
4. Monitor service
    - pm2 monit


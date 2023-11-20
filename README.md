## About The Project

Simple Transactions tracking app for companies

- this project includes single file to run the app, it uses docker and laravel sail behind the scene.
- cd to project directory then [ ./run ] it will create containers, and it will run artisan init:app which will migrate the db and seed test data.
- if you prefer to run it manually, copy .env.example to .env and run php artisan init:app.
- The app will run on port ( :8844 ) if you are going change it don't forget to add domain with port e.g (localhost:port) to SANCTUM_STATEFUL_DOMAINS env so authentication work as intended.
- make sure to run TestDataSeeder to populate the db with rest data admin, customer users and transactions.
- this project includes simple web app in vue for auth and displaying transactions for both admin and customer.

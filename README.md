## About The Project

Simple Transactions tracking app for companies

- this project includes a single file to run the app, it uses docker and laravel sail behind the scenes.
- cd to the project directory then [ ./run ] it will create containers, and it will run artisan init:app which will migrate the db and seed test data.
- if you prefer to run it manually, copy .env.example to .env and run php artisan init:app.
- The app will run on port ( :8844 ) if you are going to change it don't forget to add a domain with port e.g. (localhost:port) to SANCTUM_STATEFUL_DOMAINS env so authentication works as intended.
- make sure to run TestDataSeeder to populate the db with test data admin, customer users, and transactions.
- this project includes a simple web app in vue for auth and displaying transactions for both admin and customer.
- postman collection included Bim.postman_collection

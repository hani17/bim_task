## About The Project

Simple Transactions tracking app for companies

- I have created single file to run the app, it uses docker and laravel sail behind the scene.
- cd to project main directory then [ ./run ] it will create containers, and it will run artisan init:app which will migrate the db and seed test data.
- The app will run on port 8844 if you are going change it dont forget to add it to SANCTUM_STATEFUL_DOMAINS env so authentication work as intended.
- make sure to run TestDataSeeder to populate the db with rest data admin, customer users and transactions.
- this project includes simple web app in vue for auth and displaying transactions for both admin and customer.

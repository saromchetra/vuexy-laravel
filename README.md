// first project
composer install 

// start project 
php artisan serv

// create seeder
php artisan make:migration create_flights_table
php artisan make:seeder UserSeeder

// create table 
php artisan migrate:refresh --seed
php artisan db:seed

php artisan db:seeder


// show route list
php artisan route:list


//example request api with postman  http://127.0.0.1:8000/api/login
body
{
  "username": "chetra",
  "password": "password"
}


//get user http://127.0.0.1:8000/api/user 

Header value 
Authorization: Bearer api_token

limit_memory sudo nano /private/etc/php.ini




# Project: Test_System For InoviTech

This system is an ambiguous system aimed at testing Laravel v11.9 skills like:

- API generation
- Databse accessing and mutations
- Middleware implementtion
- Role Based accessing of routes and functions
- Introduction to testing

# Project Structure

The regular folder structure is maintained for the application with:

- Middlewares registered in bootstrap/app.php and stored in app/HTTP/Middleware
- Controllers stored in app/HTTP/Controllers
- Helper functions (D-R-Y Codes) found in app/Helpers
- Mailer functions in app/Mail
- Model and database migration in app/Models and database/migrations
- Routes in routes/api.php

# How system works

Before accessing the system provided prerequirements are met (Laravel and Composer installed). Run

- composer install

For every authentication function, the following headers are required:

- "APP_KEY": Gotten from .env file

For every other api which are grouped based on their roles and require an access toke

- Role: "SUPER_ADMIN", "ADMIN", "HOD", "LIBRARIAN", "USER"
- "authorization": Role of user and Access token gotten from response upon login or register +
- Thus example "authorization"=> "ADMIN $$2y$12$ampezlIc4jwbqd5F27YBKOiIeCiBpskPdjM5TlULIfjUexaT3fABa"

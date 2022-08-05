# Pet Store

## Installation

1. Clone the repository.  
2. Composer install.  
3. Create a .env file from the .env.example file. `cp .env.example .env`.
4. Create a database.
5. Set JWT_SECRET in .env.
6. Add the database connection details to the .env file.
7. Run migrations. `php artisan migrate`.
8. Run seeds. `php artisan db:seed`.
9. Serve project. `php artisan serve`.
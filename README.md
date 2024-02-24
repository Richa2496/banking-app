
## Features

- User authentication (register, login, logout)
- Account management (view balance, deposit, withdraw,transfer)
- Transaction history
- Responsive design with Tabler CSS theme

## Requirements

- PHP >= 8.3.1
- Composer
- node >= 21.5.0
- npm or yarn
- MySQL database
- Tabler css

## Installation

1. Clone the repository:
    git clone https://github.com/your-username/laravel-bank.git

2. Navigate into the project directory:
    cd BANKING-APP

3. Install PHP dependencies using Composer:
    composer install

4. Install JavaScript dependencies using npm:
    npm install

5. Copy the `.env.example` file to `.env` and configure your database connection settings:
    cp .env.example .env

    Update the following lines in the `.env` file with your database credentials:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

6. Install tabler css 
    npm install  @tabler/core

7. Generate the application key:
    php artisan key:generate

8. Run the database migrations to create necessary tables:
    php artisan migrate

9. Serve the application:
    php artisan serve
    

# Cinema Booking Application

A cinema booking system where users can reserve a seat. The system allows an admin user to manage movie sessions and bookings.

- Seat Reservation: Users can select and book seats for movies.
- Admin Panel: Admins can manage movies, movie schedules, and bookings.

## Setup
### Prerequisites
Ensure you have the following installed:

- Docker
- Node.js

## Installation
- Clone the repository: git clone https://github.com/ani7187/cinema-app.git
- cd cinema-app
- Copy the .env.example file to .env and configure your environment variables
- npm install
- npm run dev

## Run without Docker
- In your .env file, change the database connection to SQLite: DB_CONNECTION=sqlite
- Create db file: database/database.sqlite

## Run with Docker
- docker-compose up --build -d 
- Go into container: docker-compose exec php bash

## Config
- composer install
- php artisan key:generate
- Run database migrations: php artisan migrate
- Seed data: php artisan db:seed
- php artisan storage:link
- php artisan serve
- Access the app at http://localhost:8000.

## Usage
### Admin User Setup

- Create an admin user via the command:
  php artisan app:create-admin-user
- Admin tools: http://localhost:8000/admin

## Contact
For more details or to report bugs, contact us at:
- Email: azizyana02@gmail.com

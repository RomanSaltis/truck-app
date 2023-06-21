# truck-app
This is a CRUD (Create, Read, Update, Delete) application for managing trucks. It allows users to input and manage 
truck information, including unit number, year of registration, and optional notes. Additionally, it provides the 
functionality to assign subunits to trucks.

## Getting Started

### Prerequisites

- PHP (version 8.1.20)
- Laravel (version 10.13.5)
- PostgreSQL (version 14.8)

### Installation

1. Clone the repository:

   https://github.com/RomanSaltis/truck-app

2. Install dependencies:
   composer install

3. Configure the environment variables:

   Update the .env file
   APP_NAME=Laravel
   APP_ENV=local
   APP_KEY=base64:Gw+M1mKnOOIhMXhuAWO/qjJzFAnMFUTp61dtB5XwFAc=
   APP_DEBUG=true
   APP_URL=http://localhost

4. Run database migrations:

   php artisan migrate

### Usage

1. Start the local development server:

   php artisan serve

2. Open your web browser http://localhost:8000 to access the application.

3. Create new trucks

4. Create new trucks subunits

5. View and manage your trucks and subunits.

### License Information:

This project is licensed under the MIT License (opensource.org/licenses/MIT).

### Contact

For any inquiries or questions, please contact roman.saltis@gmail.com


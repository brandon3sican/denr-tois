# DENR Travel Order Information System (TOIS)

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)

## About DENR TOIS

The DENR Travel Order Information System (TOIS) is a web-based application designed to streamline the process of creating, managing, and tracking travel orders within the Department of Environment and Natural Resources (DENR).

## Features

- **User Authentication & Management**
  - Username/password login
  - Role-based access control (Admin/Regular User)
  - Secure password hashing with bcrypt
  - One-to-one employee-user relationship
  - Auto-generated usernames (first initial + last name)
  - Sortable user listings with pagination

- **Employee Management**
  - Employee records with personal information
  - Position and department tracking
  - Employment status monitoring
  - Sortable employee listings by name, position, department, and status
  - Default sort by creation date (newest first)
  - Unique user account association

- **Travel Order Management**
  - Create and submit travel orders
  - Track travel order status
  - Multi-level approval workflow
  - Document generation

- **Reporting**
  - Travel order history
  - Status tracking
  - Export capabilities

## System Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or MariaDB 10.3+
- Node.js 16+ and NPM
- Web server (Apache/Nginx)

## Default Accounts

### Admin User
- **Username**: admin
- **Password**: admin123
- **Employee**: System Administrator

### Sample Regular Users
- **Username Format**: First initial + last name (e.g., jdelacruz)
- **Password**: password123
- **Note**: All sample users are linked to employee records

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/brandon3sican/denr-tois.git
   cd denr-tois
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Configure database**
   Update `.env` with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=denr_tois
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

7. **Run migrations and seed database**
   ```bash
   php artisan migrate --seed
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Compile assets**
   ```bash
   npm run dev
   ```

10. **Access the application**
    Open your browser and go to: [http://localhost:8000](http://localhost:8000)

## Default Credentials

- **Admin User**
  - Username: `admin`
  - Password: `admin123`

## Documentation

- [Database Schema](docs/DATABASE.md) - Detailed database structure and relationships

## Contributing

Contributions are welcome! Please read our [contributing guidelines](CONTRIBUTING.md) before submitting pull requests.

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

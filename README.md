<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Mini E-Commerce Application

A complete e-commerce solution built with Laravel featuring product management, shopping cart, and order processing with
role-based access control.

## Key Features

- **User Roles**: Admin and Customer accounts
- **Product Management**: Full CRUD operations for products
- **Shopping Cart**: Add/remove items, quantity adjustment
- **Order Processing**: Checkout flow with stock validation
- **Admin Dashboard**: Manage products and orders
- **Responsive Design**: Works on all devices

## Installation

### Prerequisites

- PHP 8.1+
- Composer 2.0+
- MySQL 8.0+
- Node.js 16+

### Setup Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/HatoumHadi/mini-e-commerce.git
   cd mini-ecommerce-app


2. Install dependencies:
    ```bash
    composer install
    npm install
    npm run build

3. Configure environment:
    ```bash
    cp .env.example .env
    php artisan key:generate

4. Set up database:

- Create a MySQL database

- Update .env with your database credentials

- Run migrations and seed data:
    ```bash
    php artisan migrate --seed

5. Create storage link
    ```bash
    php artisan storage:link

6. Start the development server:
    ```bash
    php artisan serve

7. Access the application at http://localhost:8000


8. Default Accounts:
    - Admin:
        - email: admin@example.com
        - password: password
        - Access: Full admin privileges
    - Customer:
        - email: customer@example.com
        - password: password
        - Access: Standard shopping features


9. Troubleshooting:
   If you encounter issues:
    ```bash
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear

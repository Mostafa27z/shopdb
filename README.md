<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

# T-shirt Customization Backend API

This is a Laravel-based RESTful API for a custom T-shirt e-commerce system. It supports user registration, product management, image uploads, coupon codes, and customizable order placement.

---

## Features

- User authentication with Laravel Sanctum
- Admin-only product and order management
- Multiple product images
- Order customization: size, color, image, print location
- Order filtering and status control
- Image uploads with validation
- Coupon support
- RESTful API with clear structure

---

## Tech Stack

- Laravel 10+
- Sanctum (API Auth)
- MySQL
- File upload via Storage
- Docker / Railway compatible

---

## Installation

```bash
git clone https://github.com/your-username/your-project.git
cd your-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve


---

API Endpoints

Auth

POST /api/register – User registration

POST /api/login – User login


Products

GET /api/products – All products

GET /api/products/{id} – Single product

POST /api/products – Add product (Admin only)

PUT /api/products/{id} – Update product

DELETE /api/products/{id} – Delete product


Orders

POST /api/orders – Place an order

GET /api/orders/my – Get user's orders

GET /api/orders – Get all orders (Admin only)

PUT /api/orders/{id} – Update status (Admin)


Categories

GET /api/categories – All categories

POST /api/categories – Add category (Admin)



---

Image Uploads

Images are uploaded to:
storage/app/public/images/
and accessed via:
/storage/images/filename.jpg

To enable public access:

php artisan storage:link


---

License

This project is open-sourced under the MIT license.




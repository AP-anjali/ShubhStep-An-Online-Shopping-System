# ShubhStep -- An Online Shopping System

ShubhStep is a complete online shopping platform built with Laravel. It
focuses on selling handcrafted products and supports four user roles:
**Customer**, **Seller**, **Admin (Seller)**, and **Delivery Agency**.\
This project was developed as a freelance assignment, and I handled the
full frontend and backend development.

------------------------------------------------------------------------

## ⭐ Features

### 🛍 Customer

-   Browse handcrafted items\
-   Add to cart and wishlist\
-   Secure checkout\
-   Online payment through Razorpay\
-   Order history and tracking\
-   Manage profile

### 🧵 Seller

-   Add and manage product listings\
-   Track orders\
-   Update inventory\
-   View sales history

### 🛠 Admin (Seller)

-   Approve or reject sellers\
-   Manage categories and products\
-   Manage customers and sellers\
-   Platform-level analytics

### 🚚 Delivery Agency

-   View assigned orders\
-   Update delivery status

------------------------------------------------------------------------

## 💳 Payment Integration

The system includes **Razorpay Payment Gateway** integration for safe
online transactions.\
Supports: - Order creation\
- Payment verification\
- Auto-status update

------------------------------------------------------------------------

## 🧰 Tech Stack

-   **Framework:** Laravel\
-   **Frontend:** Blade, TailwindCSS, JavaScript\
-   **Database:** MySQL\
-   **Payment:** Razorpay PHP SDK\
-   **Build Tools:** Vite, NPM

------------------------------------------------------------------------

## 📂 Project Structure

    app/
    bootstrap/
    config/
    database/
    public/
    razorpay-php/
    resources/
    routes/
    storage/
    tests/

------------------------------------------------------------------------

## ⚙️ Installation & Setup

### 1. Clone the repository

``` bash
git clone https://github.com/AP-anjali/ShubhStep-An-Online-Shopping-System.git
cd ShubhStep-An-Online-Shopping-System
```

### 2. Install dependencies

``` bash
composer install
npm install
```

### 3. Create and configure `.env`

``` bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with: - DB settings\
- Razorpay key & secret

### 4. Run migrations

``` bash
php artisan migrate
```

### 5. Start the development servers

``` bash
php artisan serve
npm run dev
```

------------------------------------------------------------------------

## 📦 User Roles Overview

  Role              Description
  ----------------- -----------------------------------
  Customer          Browse and buy products
  Seller            Upload and manage items
  Admin (Seller)    Approvals and platform management
  Delivery Agency   Handle deliveries

------------------------------------------------------------------------

## 🤝 Contribution

Contributions are welcome. Please open an issue before major changes.

------------------------------------------------------------------------

## 📜 License

This project is licensed under the **MIT License**.

------------------------------------------------------------------------

## 📧 Contact

**Developer:** Anjali Patel\
**GitHub:** AP-anjali

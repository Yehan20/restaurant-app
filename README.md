# 🍽️ Restaurant Concession & Order Management System

This is a Restaurant Concession & Order Management System built using **Laravel 11**, and **Tailwind CSS**. The system efficiently manages concessions, orders, and kitchen workflow, with real-time updates using **Laravel Echo** & **Pusher**. made using mvc architecture and repistory pattern

## 🛠️ Prerequisites

Before setting up the project, ensure you have the following installed:

- **PHP** (>= 8.2)
- **Composer** (Dependency Manager for PHP)
- **Laravel** (Installed via Composer)
- **Node.js & npm** (For frontend dependencies)
- **MySQL** (For database)

### 🔹 Installing Prerequisites

```bash
# Installing PHP (Linux/macOS/Windows)

# Windows
# Install XAMPP or Laragon (Both come with PHP and MySQL).
# Verify PHP installation:
php -v

# Ubuntu (Linux)
sudo apt update
sudo apt install php-cli php-mbstring php-xml php-bcmath unzip curl
php -v

# macOS (Using Homebrew)
brew install php
php -v

# Installing Composer

# Windows
# Download and install from https://getcomposer.org

# Linux/macOS
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer -V

# Installing Laravel
# Once Composer is installed, install Laravel globally:
composer global require laravel/installer
laravel --version

# Installing Node.js & npm

# Windows/macOS/Linux
# Download and install from https://nodejs.org
# Verify installation:
node -v
npm -v
```

## 🛠️ Local Setup

```bash
# 1️⃣ Clone the Repository
git clone https://github.com/your-username/restaurant-management.git
cd restaurant-management

# 2️⃣ Install PHP Dependencies
composer install

# 3️⃣ Install Node.js Dependencies
npm install

# 4️⃣ Setup Environment Variables
# Copy .env.example to .env:
cp .env.example .env

# Update database credentials in .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=restaurant_db
# DB_USERNAME=root
# DB_PASSWORD=yourpassword

# Configure Pusher for real-time updates:
# BROADCAST_DRIVER=pusher
# PUSHER_APP_ID=your-pusher-app-id
# PUSHER_APP_KEY=your-pusher-app-key
# PUSHER_APP_SECRET=your-pusher-app-secret
# PUSHER_APP_CLUSTER=your-pusher-app-cluster

# 5️⃣ Run Migrations & Seeders
php artisan migrate --seed

# 6️⃣ Run the Development Server
php artisan serve

# 7️⃣ Run Vite for Frontend Assets
npm run dev

# 8️⃣ Run Laravel Scheduler & Queue Worker
# Run the scheduler (handles automatic order processing):
php artisan schedule:work

# Run queue worker (handles background jobs & notifications):
php artisan queue:work
```
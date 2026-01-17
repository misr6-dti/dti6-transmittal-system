# DTI Region VI - Transmittal Management System (DTI6-TMS)

## Overview

The **DTI6-TMS** is an upgraded, web-based platform that replaces the previous Microsoft Access–based system. It modernizes the creation, routing, tracking, and archiving of official transmittal documents across all DTI Region VI offices.

## Key Features

- **Excel-like Interface**: Single-reference transmittal form for familiar and efficient data entry.
- **Real-time Tracking**: Monitor the status and movement of documents in real-time.
- **QR Code Integration**: Secure verification and easy tracking using generated QR codes.
- **Audit Logs**: Comprehensive logs for accountability and transparency.
- **Printable Outputs**: High-quality PDF and printed transmittal forms.
- **Office Analytics**: Monitor office performance and workload distribution.

## Tech Stack

- **Framework**: [Laravel 8](https://laravel.com)
- **Language**: PHP 7.4
- **Frontend**: Blade, JavaScript, CSS (Bootstrap 5, Icons, Alpine.js - Localized)
- **Database**: MySQL/SQLite
- **Features**:
    - `barryvdh/laravel-dompdf` for PDF generation.
    - `chillerlan/php-qrcode` for QR code generation.
    - `spatie/laravel-permission` for role-based access control.

## Installation

1. **Clone the repository**:

    ```bash
    git clone https://github.com/misr6-dti/dti6-transmittal-system.git
    cd dti6-transmittal-system
    ```

2. **Install dependencies**:

    ```bash
    composer install
    npm install
    ```

3. **Environment Setup**:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database Migration**:

    ```bash
    php artisan migrate
    ```

5. **Build Assets**:

    ```bash
    npm run dev
    ```

6. **Run the Application**:
    ```bash
    php artisan serve
    ```

## License

This project is licensed under the MIT License.

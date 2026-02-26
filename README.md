<p align="center">
  <strong>DTI6-TMS</strong><br/>
  <em>Transmittal Management System — DTI Region VI</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-8.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel 8"/>
  <img src="https://img.shields.io/badge/PHP-≥7.4-777BB4?logo=php&logoColor=white" alt="PHP"/>
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind"/>
  <img src="https://img.shields.io/badge/License-MIT-green" alt="MIT License"/>
</p>

---

## Overview

**DTI6-TMS** is a web-based platform that replaces the legacy Microsoft Access system for managing official document transmittals across all DTI Region VI offices. It provides real-time tracking, QR code verification, and comprehensive audit logging for document bundles routed between the Regional Office, six Provincial Offices, Negosyo Centers, and attached agencies in Western Visayas.

---

## Key Features

| Feature | Description |
|---|---|
| 📦 **Transmittal Management** | Create, route, and track office-to-office document bundles with auto-generated reference numbers (`T-OFFICE-YEAR-SEQ`) |
| 📂 **Document Logs** | Division-to-division internal document routing within the same office (`DL-OFFICE-YEAR-SEQ`) |
| 📱 **QR Code Tracking** | Embedded QR codes in printed PDFs link to a public tracking page — no login required |
| 📊 **Dashboard & Analytics** | Real-time statistics for transmittals and document logs, scoped per office/division |
| 🔔 **In-App Notifications** | Automatic alerts for incoming transmittals, received confirmations, and document log events |
| 📜 **Audit Trail** | Immutable, observer-driven logs of every create, edit, submit, and receive action |
| 🔐 **Role-Based Access** | Spatie permission-based RBAC with office-scoped and division-scoped data isolation |
| 🖨️ **PDF Generation** | Professional transmittal sheets with embedded QR codes via DomPDF |
| 👤 **Admin Panel** | Manage users, roles & permissions, offices (with parent-child hierarchy), and divisions |

---

## Tech Stack

### Backend

| Component | Version |
|---|---|
| [Laravel](https://laravel.com) | 8.x |
| PHP | ≥ 7.4 |
| MySQL | 5.7+ |
| Apache (XAMPP) | 2.4+ |

### Frontend

| Component | Version |
|---|---|
| [Tailwind CSS](https://tailwindcss.com) + Bootstrap 5 | 3.x + 5.x |
| [Alpine.js](https://alpinejs.dev) | 3.x |
| Laravel Blade | (built-in) |
| [Laravel Mix](https://laravel-mix.com) | 6.x |

### Key Libraries

| Package | Purpose |
|---|---|
| [`spatie/laravel-permission`](https://github.com/spatie/laravel-permission) | Role & permission management |
| [`barryvdh/laravel-dompdf`](https://github.com/barryvdh/laravel-dompdf) | PDF generation |
| [`chillerlan/php-qrcode`](https://github.com/chillerlan/php-qrcode) | SVG QR code generation |

---

## Quick Start

### 1. Clone & Install

```bash
git clone https://github.com/misr6-dti/dti6-transmittal-system.git
cd dti6-transmittal-system

composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials:

```ini
DB_DATABASE=dtsdb
DB_USERNAME=dtsuser
DB_PASSWORD=your_password
```

### 3. Database

```bash
php artisan migrate
php artisan db:seed
```

This seeds **7 offices**, **5 divisions**, **2 roles** (Admin, User), **13 permissions**, and **2 default accounts**.

### 4. Compile Assets

```bash
npm run dev          # Development
npm run production   # Production (minified)
```

### 5. Run

```bash
php artisan serve
```

Or configure Apache to point to the `public/` directory.

---

## Default Accounts

| Role | Email | Password |
|---|---|---|
| Admin | `admin@dti6.gov.ph` | `password` |
| User | `user@dti6.gov.ph` | `password` |

> ⚠️ **Change default passwords immediately** after deployment.

---

## Project Structure

```
dti6-tms/
├── app/
│   ├── Http/Controllers/       # 11 controllers (+ 9 Auth)
│   ├── Models/                 # 10 Eloquent models
│   ├── Services/               # NotificationService, QrCodeService
│   ├── Observers/              # TransmittalObserver, DocumentLogObserver
│   └── Policies/               # TransmittalPolicy, DocumentLogPolicy
├── database/
│   ├── migrations/             # 16 migrations
│   └── seeders/                # Offices, Roles, Permissions, Divisions
├── resources/views/            # 61 Blade templates
├── routes/web.php              # ~73 routes
├── docs/                       # 8 standard documentation files
└── public/                     # Front controller & compiled assets
```

---

## Documentation

All documentation lives in the [`docs/`](docs/) directory:

| # | Document | Description |
|---|---|---|
| 1 | [Project Overview](docs/1_Project_Overview.md) | Background, objectives, tech stack, organizational structure |
| 2 | [Process Workflow](docs/2_Process_Workflow.md) | Step-by-step workflows with Mermaid diagrams |
| 3 | [Functional Requirements](docs/3_Functional_Requirements.md) | 60+ requirements with source code traceability |
| 4 | [System Architecture](docs/4_System_Architecture.md) | MVC breakdown, middleware, services, observers, policies |
| 5 | [Database Documentation](docs/5_Database_Documentation.md) | ER diagrams, all table schemas, constraints, migration history |
| 6 | [Deployment Guide](docs/6_Deployment_Guide.md) | Installation, configuration, Apache setup, troubleshooting |
| 7 | [User Manual](docs/7_User_Manual.md) | End-user guide for all roles |
| 8 | [VAPT Report](docs/8_VAPT_Report.md) | Security assessment, OWASP Top 10 coverage, remediation log |

---

## Useful Commands

```bash
# Cache management
php artisan config:cache        # Cache config (production)
php artisan route:cache         # Cache routes (production)
php artisan cache:clear         # Clear all cache
php artisan permission:cache-reset  # Reset permission cache

# Development
php artisan migrate:status      # Check migration status
php artisan route:list          # List all routes
php artisan tinker              # Interactive REPL

# Database
php artisan db:seed             # Seed default data
php artisan migrate:fresh --seed  # Reset & reseed (⚠️ destroys data)
```

---

## License

This project is licensed under the [MIT License](LICENSE).

---

<p align="center">
  <sub>Built for the Department of Trade and Industry — Region VI (Western Visayas)</sub>
</p>

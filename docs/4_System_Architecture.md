# DTI6-TMS — System Architecture

**System:** DTI Region VI — Transmittal Management System  
**Date:** February 26, 2026

---

## Table of Contents

1. [High-Level Architecture](#1-high-level-architecture)
2. [MVC Layer Breakdown](#2-mvc-layer-breakdown)
3. [Directory Structure](#3-directory-structure)
4. [Route Architecture](#4-route-architecture)
5. [Middleware Pipeline](#5-middleware-pipeline)
6. [Service Layer](#6-service-layer)
7. [Observer Pattern (Event-Driven)](#7-observer-pattern-event-driven)
8. [Policy Layer (Authorization)](#8-policy-layer-authorization)
9. [Frontend Architecture](#9-frontend-architecture)
10. [External Integrations](#10-external-integrations)

---

## 1. High-Level Architecture

```mermaid
graph TB
    subgraph "Client Layer"
        Browser["Browser<br/>(Desktop / Mobile)"]
        QRScanner["QR Scanner App"]
    end

    subgraph "Web Server Layer"
        Apache["Apache 2.4+<br/>(XAMPP)"]
    end

    subgraph "Application Layer"
        Middleware["Middleware Pipeline<br/>Auth, Admin, CSRF, Throttle"]
        Router["Route Handler<br/>web.php, auth.php"]
        Controllers["Controllers<br/>TransmittalController<br/>DocumentLogController<br/>DashboardController<br/>AuditLogController<br/>NotificationController<br/>Admin Controllers"]
        Services["Service Layer<br/>NotificationService<br/>QrCodeService"]
        Observers["Observer Layer<br/>TransmittalObserver<br/>DocumentLogObserver"]
        Policies["Policy Layer<br/>TransmittalPolicy<br/>DocumentLogPolicy"]
        Models["Eloquent Models<br/>User, Office, Division<br/>Transmittal, DocumentLog<br/>Notification"]
    end

    subgraph "View Layer"
        Blade["Blade Templates"]
        Alpine["Alpine.js Interactivity"]
        Tailwind["Tailwind CSS + Bootstrap 5"]
    end

    subgraph "External Services"
        DomPDF["DomPDF<br/>PDF Generation"]
        QRLib["chillerlan/php-qrcode<br/>SVG QR Codes"]
        Spatie["spatie/laravel-permission<br/>RBAC"]
    end

    subgraph "Data Layer"
        MySQL["MySQL 5.7+<br/>Database"]
    end

    Browser -->|HTTP Request| Apache
    QRScanner -->|"GET /track/{token}"| Apache
    Apache --> Middleware
    Middleware --> Router
    Router --> Controllers
    Controllers --> Policies
    Controllers --> Services
    Controllers --> Models
    Models --> MySQL
    Services --> Models
    Observers --> Models
    Controllers --> Blade
    Blade --> Alpine
    Blade --> Tailwind
    Controllers --> DomPDF
    Services --> QRLib
    Models --> Spatie
```

---

## 2. MVC Layer Breakdown

### Models (10)

| Model | Table | Purpose | Key Relationships |
|---|---|---|---|
| `User` | `users` | System accounts & authentication | belongsTo Office, Division; hasMany sent/received Transmittals |
| `Office` | `offices` | Organizational units | hasMany Users, Divisions, sent/received Transmittals; self-referencing hierarchy |
| `Division` | `divisions` | Sub-organizational units | belongsTo Office; hasMany Users, sent/received DocumentLogs |
| `Transmittal` | `transmittals` | Office-to-office document bundles | belongsTo User (sender/receiver), Office (sender/receiver); hasMany Items, Logs |
| `TransmittalItem` | `transmittal_items` | Line items in a transmittal | belongsTo Transmittal |
| `TransmittalLog` | `transmittal_logs` | Audit trail entries | belongsTo Transmittal, User |
| `DocumentLog` | `document_logs` | Division-to-division internal routing | belongsTo Division (sender/receiver), User (sender/receiver), Office; hasMany Items, Entries |
| `DocumentLogItem` | `document_log_items` | Line items in a document log | belongsTo DocumentLog |
| `DocumentLogEntry` | `document_log_entries` | Audit trail for document logs | belongsTo DocumentLog, User |
| `Notification` | `notifications` | In-app user alerts | belongsTo User, Office |

### Controllers (11)

| Controller | Namespace | Routes | Purpose |
|---|---|---|---|
| `TransmittalController` | `App\Http\Controllers` | `transmittals.*` | Full CRUD + receive, PDF, QR track, item update |
| `DocumentLogController` | `App\Http\Controllers` | `document-logs.*` | Full CRUD + receive for division routing |
| `DashboardController` | `App\Http\Controllers` | `dashboard`, `dashboard.stats` | Dashboard view & AJAX stats |
| `AuditLogController` | `App\Http\Controllers` | `audit.*` | Audit history listing & detail view |
| `NotificationController` | `App\Http\Controllers` | `notifications.*` | Inbox, read/unread, delete, count |
| `ProfileController` | `App\Http\Controllers` | `profile.*` | User profile edit, update, delete |
| `UserController` | `App\Http\Controllers\Admin` | `admin.users.*` | Admin user CRUD |
| `RoleController` | `App\Http\Controllers\Admin` | `admin.roles.*` | Admin role/permission CRUD |
| `OfficeController` | `App\Http\Controllers\Admin` | `admin.offices.*` | Admin office CRUD |
| `DivisionController` | `App\Http\Controllers\Admin` | `admin.divisions.*` | Admin division CRUD |
| Auth Controllers (9) | `App\Http\Controllers\Auth` | `login`, `register`, etc. | Authentication lifecycle |

### Views

```
resources/views/
├── layouts/              → app.blade.php, guest.blade.php, navigation.blade.php, public.blade.php
├── components/           → 15 reusable Blade components
├── dashboard.blade.php   → Main dashboard
├── welcome.blade.php     → Landing / login page
├── transmittals/         → index, create, edit, show, pdf, public-track (6 views)
├── document-logs/        → index, create, edit, show (4 views)
├── admin/                → users/, offices/, divisions/, roles/ (14 views)
├── audit/                → index, show (2 views)
├── auth/                 → login, register, password reset (6 views)
├── notifications/        → index (1 view)
├── profile/              → edit + partials (4 views)
└── pages/                → faqs, manual, support (3 views)
```

---

## 3. Directory Structure

```
dti6-tms/
├── app/
│   ├── Console/               → Artisan command kernel
│   ├── Exceptions/            → Exception handler
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         → UserController, RoleController, OfficeController, DivisionController
│   │   │   ├── Auth/          → 9 authentication controllers (Laravel Breeze)
│   │   │   ├── TransmittalController.php
│   │   │   ├── DocumentLogController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── AuditLogController.php
│   │   │   ├── NotificationController.php
│   │   │   └── ProfileController.php
│   │   ├── Middleware/        → AdminMiddleware, Authenticate, CSRF, etc. (9 files)
│   │   ├── Requests/         → StoreTransmittalRequest, UpdateTransmittalRequest, etc. (6 files)
│   │   └── Kernel.php        → Middleware registration
│   ├── Models/                → 10 Eloquent models
│   ├── Observers/             → TransmittalObserver, DocumentLogObserver
│   ├── Policies/              → TransmittalPolicy, DocumentLogPolicy
│   ├── Providers/             → AppServiceProvider, AuthServiceProvider, etc. (4 files)
│   ├── Services/              → NotificationService, QrCodeService
│   └── View/                  → 3 Blade components (View classes)
├── config/                    → 13 configuration files
├── database/
│   ├── factories/             → 3 model factories
│   ├── migrations/            → 16 migration files
│   └── seeders/               → 6 seeders (offices, roles, permissions, divisions, users)
├── public/                    → Front controller, compiled assets, images
├── resources/
│   ├── css/                   → app.css (Tailwind entry)
│   ├── js/                    → app.js, bootstrap.js
│   ├── lang/                  → Localization files
│   └── views/                 → 61 Blade template files
├── routes/
│   ├── web.php                → Primary routes (57 lines)
│   ├── auth.php               → Authentication routes
│   ├── api.php                → API routes (minimal)
│   └── console.php            → Console routes
├── storage/                   → Logs, cache, sessions
├── tests/                     → Feature & unit tests (15 files)
├── composer.json              → PHP dependencies
├── package.json               → Node.js dependencies
├── webpack.mix.js             → Laravel Mix asset config
└── tailwind.config.js         → Tailwind CSS configuration
```

---

## 4. Route Architecture

### Route Groups

```mermaid
graph TD
    A["All Routes"] --> B["Public Routes<br/>(No auth)"]
    A --> C["Authenticated Routes<br/>auth + verified middleware"]

    B --> D["GET / → Welcome page"]
    B --> E["GET /track/{qr_token}<br/>throttle:60,1"]

    C --> F["Dashboard Routes"]
    C --> G["Transmittal Routes<br/>resource + custom"]
    C --> H["Document Log Routes<br/>resource + custom"]
    C --> I["Profile Routes"]
    C --> J["Audit Routes"]
    C --> K["Notification Routes"]
    C --> L["Static Pages<br/>FAQs, Manual, Support"]
    C --> M["Admin Routes<br/>admin middleware"]

    M --> N["admin/users"]
    M --> O["admin/roles"]
    M --> P["admin/offices"]
    M --> Q["admin/divisions"]
```

### Route Count Summary

| Group | Route Count | Middleware |
|---|---|---|
| Public | 2 | none (+ throttle on tracking) |
| Dashboard | 2 | auth, verified |
| Transmittals | 8 | auth, verified |
| Document Logs | 8 | auth, verified |
| Profile | 3 | auth, verified |
| Audit | 2 | auth, verified |
| Notifications | 7 | auth, verified |
| Static Pages | 3 | auth, verified |
| Admin | 28 (4 resources × 7) | auth, verified, admin |
| Auth | ~10 | varies |
| **Total** | **~73** | |

---

## 5. Middleware Pipeline

```mermaid
flowchart LR
    A[HTTP Request] --> B[TrustProxies]
    B --> C[PreventRequestsDuringMaintenance]
    C --> D[TrimStrings]
    D --> E[ConvertEmptyStringsToNull]
    E --> F{Route Group?}
    F -->|Web| G[EncryptCookies]
    G --> H[VerifyCsrfToken]
    H --> I[Authenticate]
    I --> J{Has Admin Middleware?}
    J -->|Yes| K["AdminMiddleware<br/>Checks hasRole('Admin')"]
    J -->|No| L[Controller]
    K -->|Authorized| L
    K -->|Unauthorized| M[403 Forbidden]
```

### Custom Middleware

| Middleware | File | Purpose |
|---|---|---|
| `AdminMiddleware` | `app/Http/Middleware/AdminMiddleware.php` | Checks if user `hasRole('Admin')`, returns 403 if not |

---

## 6. Service Layer

### NotificationService

A static service class that centralizes all notification creation logic.

| Method | Trigger | Recipients |
|---|---|---|
| `notifyUser()` | Direct call | Single user |
| `notifyOffice()` | Internal | All users in an office |
| `notifyUsers()` | Internal | Multiple users by ID |
| `notifyTransmittalCreated()` | Transmittal submitted | All users in receiver office |
| `notifyTransmittalReceived()` | Transmittal received | Sender user |
| `notifyTransmittalStatusChanged()` | Status change | Sender user |
| `notifyDocumentLogCreated()` | Document log submitted | All users in receiver division |
| `notifyDocumentLogReceived()` | Document log received | Sender user |

### QrCodeService

Generates SVG QR codes using `chillerlan/php-qrcode`.

| Config | Value |
|---|---|
| Output Type | SVG (`OUTPUT_MARKUP_SVG`) |
| ECC Level | L (Low) |
| Scale | 5 |
| Transparent | No |

---

## 7. Observer Pattern (Event-Driven)

```mermaid
flowchart TD
    subgraph "TransmittalObserver"
        A1["created() → Log initial status"] 
        A2["updated() → Log status change or edit"]
    end

    subgraph "DocumentLogObserver"
        B1["created() → Entry with initial status"]
        B2["updated() → Entry for status change or edit"]
    end

    A1 --> C[(transmittal_logs)]
    A2 --> C
    B1 --> D[(document_log_entries)]
    B2 --> D
```

### Logged Actions

| Action | Trigger |
|---|---|
| `Draft` / `Submitted` | Model created with respective status |
| `Submitted` | Status changed from Draft → Submitted |
| `Received` | Status changed to Received |
| `Reverted to Draft` | Status changed from Submitted → Draft |
| `Edited` | Any field changed without status change |
| `Items Updated` | Manual log for transmittal item updates |

---

## 8. Policy Layer (Authorization)

### TransmittalPolicy

| Method | Admin | Creator | Office Member | Others |
|---|---|---|---|---|
| `viewAny` | ✅ (has permission) | ✅ | ✅ | ❌ |
| `view` | ✅ (all) | ✅ (own office) | ✅ (own office) | ❌ |
| `create` | ✅ | ✅ (has permission) | ✅ | ✅ |
| `update` | ✅ (all) | ✅ (not received) | ❌ | ❌ |
| `delete` | ✅ (all) | ✅ (not received) | ❌ | ❌ |
| `receive` | ✅ (submitted only) | ❌ | ✅ (receiver office, submitted only) | ❌ |

### DocumentLogPolicy

| Method | Admin | Creator | Division Member | Others |
|---|---|---|---|---|
| `viewAny` | ✅ | ✅ | ✅ | ❌ |
| `view` | ✅ | ✅ (own division) | ✅ (own division) | ❌ |
| `create` | ✅ | ✅ (needs division_id) | ✅ | ❌ |
| `update` | ✅ | ✅ (not received) | ❌ | ❌ |
| `delete` | ✅ | ✅ (not received) | ❌ | ❌ |
| `receive` | ✅ (submitted only) | ❌ | ✅ (receiver division, submitted only) | ❌ |

---

## 9. Frontend Architecture

```mermaid
graph TD
    A["Laravel Blade<br/>Server-Side Rendering"] --> B["Layout Templates"]
    B --> C["app.blade.php<br/>Authenticated layout"]
    B --> D["guest.blade.php<br/>Login/Registration layout"]
    B --> E["public.blade.php<br/>Public tracking layout"]
    
    A --> F["Alpine.js"]
    F --> G["Dropdown menus<br/>Notification polling<br/>Dynamic item tables<br/>Flash messages"]
    
    A --> H["Tailwind CSS + Bootstrap 5"]
    H --> I["Responsive grid<br/>Utility classes<br/>Dark color scheme<br/>Custom components"]
    
    A --> J["Laravel Mix Compilation"]
    J --> K["app.js → public/js/app.js"]
    J --> L["app.css → public/css/app.css"]
```

### Asset Compilation Pipeline

```
resources/css/app.css → PostCSS → Tailwind → public/css/app.css
resources/js/app.js → Mix → public/js/app.js
```

---

## 10. External Integrations

```mermaid
graph LR
    subgraph "DTI6-TMS"
        App["Application Core"]
    end

    subgraph "Laravel Packages"
        App --> Spatie["spatie/laravel-permission<br/>RBAC Engine"]
        App --> DomPDF["barryvdh/laravel-dompdf<br/>PDF Rendering"]
        App --> QR["chillerlan/php-qrcode<br/>SVG QR Generator"]
        App --> DBAL["doctrine/dbal<br/>Schema Introspection"]
    end

    subgraph "Infrastructure"
        App --> MySQL[(MySQL Database)]
        App --> Apache[Apache / XAMPP]
        App --> FileSystem["Storage<br/>Logs, Cache, Sessions"]
    end
```

---

_Document Version: 1.2 — Last Updated: February 26, 2026_

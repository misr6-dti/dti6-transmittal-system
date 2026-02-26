# DTI Region VI — Transmittal Management System (DTI6-TMS)

## Project Overview

**System Name:** DTI6-TMS — Transmittal Management System  
**Organization:** Department of Trade and Industry — Region VI (Western Visayas)  
**Version:** 1.2  
**Date:** February 26, 2026

---

## 1. Background

The **DTI6 Transmittal Management System (DTI6-TMS)** is a modern web-based platform designed to replace the legacy Microsoft Access-based transmittal tracking system. It serves as the central hub for the creation, routing, tracking, and archiving of official document transmittals across all DTI Region VI offices — spanning the Regional Office, six Provincial Offices, Negosyo Centers, and attached agencies.

By migrating to a web architecture, the system provides real-time accessibility, improved data integrity, and seamless collaboration between geographically distributed offices across the Western Visayas region.

---

## 2. Objectives

| # | Objective | Description |
|---|---|---|
| 1 | **Modernize Document Routing** | Replace offline/local tools with a cloud-ready web application accessible from any browser. |
| 2 | **Enhance Traceability** | Provide real-time status updates and QR code-based tracking for every document bundle. |
| 3 | **Improve Efficiency** | Simplify data entry with dynamic form interfaces for transmittal and document log items. |
| 4 | **Ensure Accountability** | Implement comprehensive, immutable audit logs recording every action (create, edit, receive). |
| 5 | **Secure Verification** | Utilize QR Code technology for public, no-login verification of printed transmittal sheets. |
| 6 | **Enable Intra-Office Routing** | Support division-to-division document routing within the same office via Document Logs. |
| 7 | **Data-Driven Monitoring** | Deliver insights via dashboards showing office/division performance and document throughput. |

---

## 3. Scope

### In-Scope

- **Transmittal Management**: Office-to-office document bundle routing with full lifecycle tracking (Draft → Submitted → Received).
- **Document Log Management**: Division-to-division internal document routing within a single office.
- **QR Code & PDF Generation**: Embedded QR codes in printable PDF transmittal sheets for public tracking.
- **Public Tracking Portal**: Anonymous transmittal status lookup via QR token URLs.
- **Role-Based Access Control (RBAC)**: Permission-based access using Spatie Laravel Permission.
- **Admin Module**: Management of users, roles, offices, and divisions.
- **Audit Trail**: Immutable logs of all transmittal and document actions.
- **In-App Notifications**: Real-time alerts for transmittal events delivered to affected offices/users.
- **Dashboard & Analytics**: Summary statistics and recent activity views.

### Out of Scope

- Email delivery of notifications (infrastructure prepared but not active).
- External API integrations with other government systems.
- Archival/disposal management of physical documents.

---

## 4. Technology Stack

### Backend

| Component | Technology | Version |
|---|---|---|
| Framework | Laravel | 8.x |
| Language | PHP | ≥ 7.4 |
| Database | MySQL | 5.7+ |
| Web Server | Apache (XAMPP) | 2.4+ |
| Package Manager | Composer | 2.x |

### Frontend

| Component | Technology | Version |
|---|---|---|
| Templating | Laravel Blade | (built-in) |
| CSS Framework | Tailwind CSS + Bootstrap 5 | 3.4.x + 5.x |
| JS Interactivity | Alpine.js | 3.x |
| Icons | Bootstrap Icons | (localized) |
| Asset Compilation | Laravel Mix | 6.x |
| Package Manager | NPM | (latest) |

### Key Libraries

| Library | Purpose |
|---|---|
| `spatie/laravel-permission` | Role-Based Access Control & permission management |
| `barryvdh/laravel-dompdf` | PDF generation for transmittal sheets |
| `chillerlan/php-qrcode` | SVG QR code generation for tracking tokens |
| `doctrine/dbal` | Database schema introspection for migrations |

---

## 5. Core Modules

### 5.1 Transmittal Management
Office-to-office document bundle routing. Supports creation, editing, submission, receiving, and PDF download with embedded QR codes. Reference numbers are auto-generated in the format `T-{OFFICE}-{YEAR}-{SEQ}`.

### 5.2 Document Log Management
Division-to-division internal document routing within a single office. Similar lifecycle to transmittals (Draft → Submitted → Received) with reference numbers `DL-{OFFICE}-{YEAR}-{SEQ}`.

### 5.3 Public Tracking
QR code-based public tracking portal at `/track/{qr_token}`. Displays transmittal status, dates, and office information without requiring authentication.

### 5.4 Dashboard & Analytics
Overview showing pending/received/outgoing transmittals and document log statistics. Real-time stats via AJAX endpoint with office-scoped and division-scoped data.

### 5.5 Audit Trail
Immutable log entries recorded via Model Observers for both transmittals (`TransmittalLog`) and document logs (`DocumentLogEntry`). Filterable by date, office, action type, and reference number.

### 5.6 Notifications
In-app notification system alerting users/offices of incoming transmittals and received confirmations. Supports mark-as-read, mark-all-read, and unread count polling.

### 5.7 Administration
Super Admin panel for managing users, roles & permissions, offices (with parent-child hierarchy), and divisions.

---

## 6. Organizational Structure

### Offices (Seeded)

| Code | Name | Type |
|---|---|---|
| RO6 | Regional Office VI (RO VI) | Regional |
| PO-ILO | DTI Iloilo Provincial Office | Provincial |
| PO-CAP | DTI Capiz Provincial Office | Provincial |
| PO-AKL | DTI Aklan Provincial Office | Provincial |
| PO-ANT | DTI Antique Provincial Office | Provincial |
| PO-GUI | DTI Guimaras Provincial Office | Provincial |
| PO-NEG | DTI Negros Occidental Provincial Office | Provincial |

### Divisions (RO6)

| Code | Division |
|---|---|
| ORD | Office of the Regional Director |
| BDD | Business Development Division |
| CPD | Consumer Protection Division |
| FAD | Finance and Admin Division |
| IDD | Industry Development Division |

---

## 7. User Roles

| Role | Capabilities |
|---|---|
| **Admin** | Full system access — user/role/office/division management, view all transmittals globally, manage audit logs |
| **User** | Create/edit/delete/receive transmittals with office-scoped visibility, create/receive document logs with division-scoped visibility, view audit history |

### Permissions

**Transmittal Permissions:** `view transmittals`, `create transmittals`, `edit transmittals`, `delete transmittals`, `receive transmittals`

**Document Log Permissions:** `view document-logs`, `create document-logs`, `edit document-logs`, `delete document-logs`, `receive document-logs`

**Admin Permissions:** `manage offices`, `manage users`, `view reports`

---

## 8. Default Accounts

| Account | Email | Role | Default Password |
|---|---|---|---|
| MIS Admin | `admin@dti6.gov.ph` | Admin | `password` |
| Default User | `user@dti6.gov.ph` | User | `password` |

> **Note:** Default passwords must be changed immediately upon first deployment.

---

_Document Version: 1.2 — Last Updated: February 26, 2026_

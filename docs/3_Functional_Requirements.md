# DTI6-TMS — Functional Requirements

**System:** DTI Region VI — Transmittal Management System  
**Date:** February 26, 2026

---

## Table of Contents

1. [FR-1: Authentication & Authorization](#fr-1-authentication--authorization)
2. [FR-2: Transmittal Management](#fr-2-transmittal-management)
3. [FR-3: Document Log Management](#fr-3-document-log-management)
4. [FR-4: Dashboard & Analytics](#fr-4-dashboard--analytics)
5. [FR-5: Notifications](#fr-5-notifications)
6. [FR-6: Audit Trail](#fr-6-audit-trail)
7. [FR-7: Administration](#fr-7-administration)
8. [FR-8: Public QR Tracking](#fr-8-public-qr-tracking)
9. [FR-9: PDF & QR Code Generation](#fr-9-pdf--qr-code-generation)
10. [FR-10: Profile Management](#fr-10-profile-management)
11. [Non-Functional Requirements](#non-functional-requirements)

---

## FR-1: Authentication & Authorization

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-1.1 | Users shall authenticate via email and password | Must | `Auth\LoginController` |
| FR-1.2 | New users shall register with name, email, and password | Must | `Auth\RegisteredUserController` |
| FR-1.3 | Email verification shall be supported for new accounts | Should | `Auth\VerifyEmailController` |
| FR-1.4 | Password reset via email link shall be supported | Must | `Auth\PasswordResetLinkController` |
| FR-1.5 | Login count and last login timestamp shall be tracked per user | Must | `User.login_count`, `User.last_login_at` |
| FR-1.6 | Role-Based Access Control (RBAC) shall restrict features by role | Must | `spatie/laravel-permission` |
| FR-1.7 | Admin middleware shall restrict admin routes to Admin role | Must | `AdminMiddleware` |
| FR-1.8 | CSRF protection shall be enforced on all POST/PUT/PATCH/DELETE requests | Must | `VerifyCsrfToken` |

### Permission Matrix

| Permission | Admin | User |
|---|---|---|
| `view transmittals` | ✅ | ✅ |
| `create transmittals` | ✅ | ✅ |
| `edit transmittals` | ✅ | ✅ |
| `delete transmittals` | ✅ | ✅ |
| `receive transmittals` | ✅ | ✅ |
| `view document-logs` | ✅ | ✅ |
| `create document-logs` | ✅ | ✅ |
| `edit document-logs` | ✅ | ✅ |
| `delete document-logs` | ✅ | ✅ |
| `receive document-logs` | ✅ | ✅ |
| `manage offices` | ✅ | ❌ |
| `manage users` | ✅ | ❌ |
| `view reports` | ✅ | ✅ |

---

## FR-2: Transmittal Management

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-2.1 | Users shall create transmittals with date, destination office, remarks, and line items | Must | `TransmittalController::store` |
| FR-2.2 | Reference numbers shall be auto-generated: `T-{OFFICE}-{YEAR}-{SEQ}` | Must | `TransmittalController::create` |
| FR-2.3 | Sender office shall be auto-populated from the logged-in user's office | Must | `TransmittalController::store` |
| FR-2.4 | Each transmittal shall support multiple line items (quantity, unit, description, remarks) | Must | `TransmittalItem` model |
| FR-2.5 | Transmittals shall follow status lifecycle: Draft → Submitted → Received | Must | `Transmittal.status` |
| FR-2.6 | Draft transmittals shall be editable by their creator | Must | `TransmittalPolicy::update` |
| FR-2.7 | Submitted transmittals shall be editable by Admin only | Must | `TransmittalController::edit` |
| FR-2.8 | Received transmittals shall not be editable (except by Admin) | Must | `TransmittalPolicy::update` |
| FR-2.9 | Transmittals shall be receivable only by users in the destination office | Must | `TransmittalPolicy::receive` |
| FR-2.10 | Only "Submitted" transmittals shall be eligible for receiving | Must | `TransmittalPolicy::receive` |
| FR-2.11 | The receiving action shall record receiver user ID and timestamp | Must | `TransmittalController::receive` |
| FR-2.12 | Non-admin users shall only see transmittals involving their office | Must | `TransmittalController::index` |
| FR-2.13 | Admin users shall see all transmittals across offices | Must | `TransmittalController::index` |
| FR-2.14 | Transmittals shall be filterable by reference number, status, office, and date range | Must | `TransmittalController::index` |
| FR-2.15 | Transmittals shall be sortable by reference number, date, status, and creation timestamp | Should | `TransmittalController::index` |
| FR-2.16 | Transmittal items shall be updatable independently via AJAX | Should | `TransmittalController::updateItems` |
| FR-2.17 | Submitted transmittals shall show "Pending Receipt" to sender and "To Receive" to receiver | Should | `Transmittal::getStatusDisplay` |
| FR-2.18 | Transmittal index shall default to today's date range when no filters are applied | Should | `TransmittalController::index` |
| FR-2.19 | A unique QR token (12-char uppercase) shall be auto-generated on transmittal creation | Must | `Transmittal::booted` |
| FR-2.20 | A verification token (32-char random) shall be auto-generated on transmittal creation | Must | `Transmittal::booted` |

---

## FR-3: Document Log Management

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-3.1 | Users with a division assignment shall create document logs for intra-office routing | Must | `DocumentLogController::create` |
| FR-3.2 | Reference numbers shall be auto-generated: `DL-{OFFICE}-{YEAR}-{SEQ}` | Must | `DocumentLogController::create` |
| FR-3.3 | Sender division shall be auto-populated from the user's division | Must | `DocumentLogController::store` |
| FR-3.4 | Only divisions within the same office shall be listed as receivers | Must | `DocumentLogController::create` |
| FR-3.5 | The sender's own division shall be excluded from the receiver list | Must | `DocumentLogController::create` |
| FR-3.6 | Document logs shall follow status lifecycle: Draft → Submitted → Received | Must | `DocumentLog.status` |
| FR-3.7 | Document logs shall be scoped to the user's office | Must | `DocumentLogController::index` |
| FR-3.8 | Non-admin users shall only see logs involving their division | Must | `DocumentLogController::index` |
| FR-3.9 | Users without a division assignment shall be redirected with an error | Must | `DocumentLogController::index` |
| FR-3.10 | Receiving shall be restricted to users in the receiver division | Must | `DocumentLogPolicy::receive` |
| FR-3.11 | Only the creator can edit non-received document logs | Must | `DocumentLogPolicy::update` |
| FR-3.12 | Admin shall have full CRUD access to all document logs | Must | `DocumentLogPolicy` |

---

## FR-4: Dashboard & Analytics

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-4.1 | Dashboard shall display summary statistics: total sent, total received, pending outgoing, pending incoming | Must | `DashboardController::getStats` |
| FR-4.2 | Dashboard shall display document log statistics when user has a division | Should | `DashboardController::getStats` |
| FR-4.3 | Dashboard shall show 5 most recent transmittals with pagination | Must | `DashboardController::index` |
| FR-4.4 | Real-time stats shall be available via AJAX endpoint `/dashboard/stats` | Should | `DashboardController::stats` |
| FR-4.5 | Dashboard statistics shall be scoped to the user's office (non-admin) | Must | `DashboardController::getStats` |
| FR-4.6 | Recent transmittals in AJAX response shall include context-aware status labels | Should | `DashboardController::stats` |

---

## FR-5: Notifications

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-5.1 | The system shall generate notifications when a transmittal is submitted | Must | `NotificationService::notifyTransmittalCreated` |
| FR-5.2 | The system shall generate notifications when a transmittal is received | Must | `NotificationService::notifyTransmittalReceived` |
| FR-5.3 | The system shall generate notifications when a document log is submitted | Must | `NotificationService::notifyDocumentLogCreated` |
| FR-5.4 | The system shall generate notifications when a document log is received | Must | `NotificationService::notifyDocumentLogReceived` |
| FR-5.5 | Users shall view notification inbox with pagination (10 per page) | Must | `NotificationController::index` |
| FR-5.6 | Users shall mark individual notifications as read or unread | Must | `NotificationController::markAsRead/markAsUnread` |
| FR-5.7 | Users shall mark all notifications as read in one action | Should | `NotificationController::markAllAsRead` |
| FR-5.8 | Users shall delete individual notifications | Must | `NotificationController::delete` |
| FR-5.9 | Unread notification count shall be available via AJAX endpoint | Must | `NotificationController::unreadCount` |
| FR-5.10 | Notifications shall be scoped by office_id or user_id | Must | `Notification::scopeForUser` |
| FR-5.11 | Notification actions shall be authorized — only office/user match allowed | Must | `NotificationController` |

---

## FR-6: Audit Trail

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-6.1 | All transmittal create/update events shall be automatically logged | Must | `TransmittalObserver` |
| FR-6.2 | All document log create/update events shall be automatically logged | Must | `DocumentLogObserver` |
| FR-6.3 | Audit log entries shall record: user, action, description, and timestamp | Must | `TransmittalLog`, `DocumentLogEntry` |
| FR-6.4 | Audit logs shall be immutable (created, never modified/deleted) | Must | Observer pattern |
| FR-6.5 | Audit history shall be viewable with filters: date, action, office, reference number | Must | `AuditLogController::index` |
| FR-6.6 | Non-admin users shall only view audit logs for transmittals involving their office | Must | `AuditLogController::index/show` |
| FR-6.7 | Audit history shall support sorting by date, action, reference, sender/receiver office | Should | `AuditLogController::index` |
| FR-6.8 | Sort parameters shall be validated against an allowlist to prevent injection | Must | `AuditLogController::index` |

---

## FR-7: Administration

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-7.1 | Admin shall manage users (CRUD): name, email, password, office, role | Must | `Admin\UserController` |
| FR-7.2 | Admin shall manage roles (CRUD): name and permission assignments | Must | `Admin\RoleController` |
| FR-7.3 | Admin shall manage offices (CRUD): name, code, type, parent office | Must | `Admin\OfficeController` |
| FR-7.4 | Admin shall manage divisions (CRUD): name, code, office | Must | `Admin\DivisionController` |
| FR-7.5 | Office codes shall be unique across the system | Must | `offices.code UNIQUE` |
| FR-7.6 | Offices shall support hierarchical structure via parent_id | Must | `Office.parent_id` |
| FR-7.7 | All admin routes shall be protected by the `admin` middleware | Must | `routes/web.php` |

---

## FR-8: Public QR Tracking

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-8.1 | The public tracking page shall display transmittal status without requiring login | Must | `TransmittalController::publicTrack` |
| FR-8.2 | Tracking shall use unique 12-char QR tokens as URL parameters | Must | `Transmittal.qr_token` |
| FR-8.3 | The public route shall be rate-limited to 60 requests per minute per IP | Must | `throttle:60,1` |
| FR-8.4 | Invalid tokens shall show a "not found" error message | Must | `TransmittalController::publicTrack` |
| FR-8.5 | Tracking page shall show: reference number, status, dates, origin/destination offices | Must | `public-track.blade.php` |

---

## FR-9: PDF & QR Code Generation

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-9.1 | Transmittals shall be downloadable as A4 portrait PDF documents | Must | `TransmittalController::downloadPdf` |
| FR-9.2 | PDFs shall include an embedded SVG QR code linking to the public tracking URL | Must | `QrCodeService::generate` |
| FR-9.3 | PDF generation shall use DomPDF engine | Must | `barryvdh/laravel-dompdf` |
| FR-9.4 | QR code shall use ECC Level L with scale 5 in SVG output format | Should | `QrCodeService` |
| FR-9.5 | QR tokens shall be auto-generated if missing when viewing/downloading | Must | `TransmittalController::show/downloadPdf` |

---

## FR-10: Profile Management

| ID | Requirement | Priority | Source |
|---|---|---|---|
| FR-10.1 | Users shall edit their own profile information (name, email) | Must | `ProfileController::update` |
| FR-10.2 | Users shall change their password | Must | `ProfileController::update` |
| FR-10.3 | Users shall delete their own account | Should | `ProfileController::destroy` |

---

## Non-Functional Requirements

| ID | Requirement | Category | Implementation |
|---|---|---|---|
| NFR-1 | All database queries shall use Eloquent ORM or parameter binding (no raw SQL injection risk) | Security | Eloquent ORM throughout |
| NFR-2 | All Blade output shall use `{{ }}` escape syntax (XSS prevention) | Security | Blade templating |
| NFR-3 | All model mass-assignment shall be protected via `$fillable` arrays | Security | Model definitions |
| NFR-4 | Sort parameters shall be validated against allowlists | Security | Controller validation |
| NFR-5 | All list views shall be paginated (5-15 items per page) | Performance | `paginate()` calls |
| NFR-6 | Key relationships shall be eager-loaded to prevent N+1 queries | Performance | `with()` clauses |
| NFR-7 | The UI shall be fully responsive for desktop, tablet, and mobile | Usability | Tailwind CSS responsive |
| NFR-8 | Database operations shall use transactions for multi-step writes | Reliability | `DB::beginTransaction()` |
| NFR-9 | All foreign key constraints shall be enforced at database level | Data Integrity | Migration constraints |
| NFR-10 | Cascading deletes shall clean up child records | Data Integrity | `cascadeOnDelete()` |

---

_Document Version: 1.2 — Last Updated: February 26, 2026_

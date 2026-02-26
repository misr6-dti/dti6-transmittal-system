# DTI6-TMS — Process Workflow Documentation

**System:** DTI Region VI — Transmittal Management System  
**Date:** February 26, 2026

---

## Table of Contents

1. [Transmittal Lifecycle Overview](#1-transmittal-lifecycle-overview)
2. [Transmittal Creation Workflow](#2-transmittal-creation-workflow)
3. [Transmittal Receiving Workflow](#3-transmittal-receiving-workflow)
4. [Document Log Workflow (Division-to-Division)](#4-document-log-workflow-division-to-division)
5. [Public QR Tracking Workflow](#5-public-qr-tracking-workflow)
6. [Notification Workflow](#6-notification-workflow)
7. [Audit Trail Workflow](#7-audit-trail-workflow)
8. [Admin Management Workflows](#8-admin-management-workflows)

---

## 1. Transmittal Lifecycle Overview

```mermaid
stateDiagram-v2
    [*] --> Draft : Create Transmittal
    Draft --> Draft : Edit / Update
    Draft --> Submitted : Submit
    Submitted --> Received : Receive (QR/Manual)
    Submitted --> Draft : Revert to Draft (Admin)
    Draft --> [*] : Delete

    note right of Draft
        - Creator can edit items & details
        - No notifications sent
        - Can be deleted by creator
    end note

    note right of Submitted
        - Notification sent to receiver office
        - Ready for physical dispatch & printing
        - PDF with QR code generated
        - Status shows "Pending Receipt" to sender
        - Status shows "To Receive" to receiver
    end note

    note right of Received
        - Receiver user & timestamp recorded
        - Notification sent to sender
        - Immutable — cannot be edited
        - Only Admin can delete
    end note
```

---

## 2. Transmittal Creation Workflow

### Flowchart

```mermaid
flowchart TD
    A([User Logs In]) --> B[Navigate to Create Transmittal]
    B --> C[System Auto-Fills Sender Office]
    C --> D["System Generates Reference Number<br/>T-{OFFICE}-{YEAR}-{SEQ}"]
    D --> E[Select Destination Office]
    E --> F[Set Transmittal Date]
    F --> G[Enter Remarks - Optional]
    G --> H[Add Line Items<br/>Quantity / Unit / Description / Remarks]
    H --> I{Save as Draft or Submit?}
    I -->|Draft| J[Save as Draft]
    I -->|Submit| K[Save as Submitted]
    J --> L[Audit Log: Created - Draft]
    K --> M[Audit Log: Created - Submitted]
    M --> N[Notification Sent to Receiver Office]
    L --> O([View Transmittal Details])
    N --> O
    O --> P{Print PDF?}
    P -->|Yes| Q[Generate PDF with QR Code]
    P -->|No| R([Done])
    Q --> R

    style J fill:#e2e8f0
    style K fill:#dcfce7
    style Q fill:#dbeafe
```

### Step-by-Step

1. **Login**: User authenticates with email and password.
2. **Navigate**: Click "Create Transmittal" from the navigation menu.
3. **Auto-population**: Sender office is auto-filled from the user's office. Reference number is auto-generated as `T-{OFFICE_CODE}-{YEAR}-{SEQUENCE}`.
4. **Select Destination**: Choose the receiving office from a hierarchical dropdown (sender's own office is excluded).
5. **Set Date**: Defaults to today; can be changed.
6. **Add Items**: Dynamically add line items with quantity, unit, description, and optional remarks.
7. **Save**: Choose "Save as Draft" (editable later) or "Submit" (dispatched immediately).
8. **Audit**: Observer automatically creates an audit log entry.
9. **Notification**: If submitted, `NotificationService::notifyTransmittalCreated()` sends an in-app alert to all users in the receiving office.
10. **Print**: Generate and download a PDF with an embedded QR code for physical dispatch.

---

## 3. Transmittal Receiving Workflow

### Flowchart

```mermaid
flowchart TD
    A([Physical Bundle Arrives]) --> B{Verification Method?}
    B -->|QR Code| C[Scan QR Code on Transmittal Sheet]
    B -->|Manual| D[Search by Reference Number in System]
    C --> E["Open Public Track URL<br/>/track/{qr_token}"]
    E --> F[Verify Transmittal Details]
    F --> G[Login to System]
    D --> H[Locate Transmittal in Index]
    G --> H
    H --> I{Status is Submitted?}
    I -->|Yes| J[Click Receive Button]
    I -->|No| K([Cannot Receive - Wrong Status])
    J --> L[Policy Check: User in Receiver Office?]
    L -->|Authorized| M[Status → Received]
    L -->|Unauthorized| N([403 Forbidden])
    M --> O[Record receiver_user_id & received_at]
    O --> P[Audit Log: Received]
    P --> Q[Notification to Sender: Received]
    Q --> R([Lifecycle Complete])

    style M fill:#dcfce7
    style N fill:#fce7e7
```

### Step-by-Step

1. **Physical Receipt**: The receiving office gets the physical document bundle.
2. **QR Scan** (Option A): Scan the QR code → opens `/track/{qr_token}` public page → verify details → log into system.
3. **Manual Lookup** (Option B): Navigate to transmittal index → search by reference number.
4. **Policy Check**: System verifies the user belongs to the receiver office and has `receive transmittals` permission.
5. **Mark Received**: Click "Receive" → status changes to **Received**, `receiver_user_id` and `received_at` are recorded.
6. **Observer Audit**: `TransmittalObserver::updated()` creates audit log with "Received" action.
7. **Notification**: `NotificationService::notifyTransmittalReceived()` alerts the original sender.

---

## 4. Document Log Workflow (Division-to-Division)

### Flowchart

```mermaid
flowchart TD
    A([User with Division Assignment]) --> B[Navigate to Document Logs]
    B --> C{Has Division ID?}
    C -->|No| D([Redirected: Must be assigned to a division])
    C -->|Yes| E[Click Create Document Log]
    E --> F["System Generates Reference<br/>DL-{OFFICE}-{YEAR}-{SEQ}"]
    F --> G[Select Receiver Division<br/>Same Office Only, Excludes Own]
    G --> H[Set Log Date & Remarks]
    H --> I[Add Line Items]
    I --> J{Save as Draft or Submit?}
    J -->|Draft| K[Status: Draft]
    J -->|Submit| L[Status: Submitted]
    K --> M[Observer: Entry Created - Draft]
    L --> N[Observer: Entry Created - Submitted]
    N --> O[Notify Receiver Division Users]
    M --> P([View Document Log])
    O --> P

    subgraph "Receiving"
        Q([Receiver Opens Document Log]) --> R[Click Receive]
        R --> S[Policy: User in Receiver Division?]
        S -->|Yes| T[Status → Received]
        T --> U[Observer: Entry - Received]
        U --> V[Notify Sender: Document Received]
    end

    style K fill:#e2e8f0
    style L fill:#dcfce7
    style T fill:#dbeafe
```

### Key Differences from Transmittal

| Aspect | Transmittal | Document Log |
|---|---|---|
| **Routing Level** | Office → Office | Division → Division (same office) |
| **Scope** | Cross-office (Regional ↔ Provincial) | Intra-office (ORD → BDD, etc.) |
| **Reference Format** | `T-{OFFICE}-{YEAR}-{SEQ}` | `DL-{OFFICE}-{YEAR}-{SEQ}` |
| **QR/PDF** | ✅ QR code + PDF generation | ❌ Not applicable |
| **Public Tracking** | ✅ `/track/{qr_token}` | ❌ Not applicable |
| **Audit Table** | `transmittal_logs` | `document_log_entries` |
| **Access Restriction** | Office-based | Division-based (within same office) |

---

## 5. Public QR Tracking Workflow

```mermaid
flowchart LR
    A[Printed Transmittal Sheet] --> B[QR Code Contains Token URL]
    B --> C["Scan QR Code<br/>/track/{qr_token}"]
    C --> D{Token Valid?}
    D -->|Yes| E[Display Tracking Information]
    D -->|No| F[Error: Transmittal Not Found]
    E --> G["Shown:<br/>• Reference Number<br/>• Status Badge<br/>• Execution Date<br/>• Received Date<br/>• Origin Office<br/>• Destination Office"]

    style E fill:#dcfce7
    style F fill:#fce7e7
```

- **No authentication required** — accessible to anyone with the URL.
- **Rate limited**: `throttle:60,1` — maximum 60 requests per minute per IP address.
- **QR Token**: 12-character uppercase alphanumeric string (36¹² possible combinations).
- **Minimal data exposure**: Only shows reference, status, dates, and office names.

---

## 6. Notification Workflow

```mermaid
flowchart TD
    A{Trigger Event} -->|Transmittal Submitted| B["notifyTransmittalCreated()<br/>→ All users in receiver office"]
    A -->|Transmittal Received| C["notifyTransmittalReceived()<br/>→ Sender user only"]
    A -->|Document Log Submitted| D["notifyDocumentLogCreated()<br/>→ All users in receiver division"]
    A -->|Document Log Received| E["notifyDocumentLogReceived()<br/>→ Sender user only"]

    B --> F[Notification Created in DB]
    C --> F
    D --> F
    E --> F

    F --> G[User Sees Unread Count in Nav Bar]
    G --> H[User Opens Notification Inbox]
    H --> I{Actions}
    I --> J[Mark as Read]
    I --> K[Mark as Unread]
    I --> L[Delete]
    I --> M[Mark All as Read]
    I --> N[Click Link → Navigate to Record]
```

### Notification Scoping

Notifications are scoped by `office_id` **or** `user_id`. The `scopeForUser` query matches notifications where:
- `office_id` matches the user's office, OR
- `user_id` matches the user's ID

---

## 7. Audit Trail Workflow

```mermaid
flowchart TD
    A[Model Event Fires] --> B{Which Model?}
    B -->|Transmittal| C[TransmittalObserver]
    B -->|DocumentLog| D[DocumentLogObserver]

    C --> E{Event Type}
    E -->|Created| F["Log: 'Draft' or 'Submitted'"]
    E -->|Updated - Status Changed| G["Log: 'Submitted' / 'Received' / 'Reverted to Draft'"]
    E -->|Updated - Other Fields| H["Log: 'Edited'"]
    E -->|Items Updated| I["Manual Log: 'Items Updated'"]

    D --> J{Event Type}
    J -->|Created| K["Entry: 'Draft' or 'Submitted'"]
    J -->|Updated - Status Changed| L["Entry: 'Submitted' / 'Received' / 'Reverted to Draft'"]
    J -->|Updated - Other Fields| M["Entry: 'Edited'"]

    F --> N[(transmittal_logs)]
    G --> N
    H --> N
    I --> N
    K --> O[(document_log_entries)]
    L --> O
    M --> O
```

### Key Properties
- **Immutable**: Log entries are created and never modified or deleted.
- **Automatic**: Observers are registered in `AppServiceProvider`, ensuring no event is missed.
- **Filterable**: Audit history can be filtered by date range, action type, office, and reference number.

---

## 8. Admin Management Workflows

### User Management

```mermaid
flowchart LR
    A[Admin Panel] --> B[User Management]
    B --> C[List Users<br/>with Office & Role]
    C --> D{Action}
    D --> E[Create User<br/>Name, Email, Password, Office, Role]
    D --> F[Edit User<br/>Update details & role]
    D --> G[Delete User]
    D --> H[View User Details<br/>Login count, last login]
```

### Office Management

```mermaid
flowchart LR
    A[Admin Panel] --> B[Office Management]
    B --> C[List Offices<br/>with Type & Parent]
    C --> D{Action}
    D --> E["Create Office<br/>Name, Code, Type, Parent"]
    D --> F[Edit Office]
    D --> G[Delete Office]
```

**Office Types**: Regional, Provincial, Negosyo Center, Attached  
**Hierarchy**: Offices support parent-child relationships via `parent_id` (e.g., Provincial → Regional).

### Division & Role Management

Similar CRUD workflows for divisions (Name, Code, Office) and roles (Name, Permissions).

---

_Document Version: 1.2 — Last Updated: February 26, 2026_

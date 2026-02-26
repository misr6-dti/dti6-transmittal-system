# DTI6-TMS — User Manual

**System:** DTI Region VI — Transmittal Management System  
**Date:** February 26, 2026

---

## Table of Contents

1. [Getting Started](#1-getting-started)
2. [Dashboard](#2-dashboard)
3. [Transmittal Management](#3-transmittal-management)
4. [Document Log Management](#4-document-log-management)
5. [Receiving Documents](#5-receiving-documents)
6. [Public QR Tracking](#6-public-qr-tracking)
7. [Notifications](#7-notifications)
8. [Audit History](#8-audit-history)
9. [Profile Management](#9-profile-management)
10. [Administration (Admin Only)](#10-administration-admin-only)
11. [Support & FAQs](#11-support--faqs)

---

## 1. Getting Started

### 1.1 Logging In

1. Open the system URL in your browser (e.g., `http://your-server/dti6-tms/public`).
2. You will see the welcome/login page.
3. Enter your **Email** and **Password**.
4. Click **Log In**.
5. You will be redirected to the **Dashboard**.

### 1.2 First-Time Login

If you are a new user, your account must be created by an Administrator. Contact your Regional MIS or Admin for account creation.

### 1.3 Forgot Password

1. Click **Forgot your password?** on the login page.
2. Enter your registered email address.
3. Check your email for the password reset link.
4. Follow the link to set a new password.

---

## 2. Dashboard

The Dashboard is your home screen after logging in. It displays key statistics and recent activity.

### 2.1 Transmittal Statistics

| Card | Description |
|---|---|
| **Total Sent** | Total transmittals sent from your office |
| **Total Received** | Total transmittals received by your office |
| **Pending Outgoing** | Submitted but not yet received (sent by your office) |
| **Pending Incoming** | Submitted but not yet received (sent to your office) |

### 2.2 Document Log Statistics

If you have a division assignment, you will also see:

| Card | Description |
|---|---|
| **Doc Logs Sent** | Total document logs sent from your division |
| **Doc Logs Received** | Total document logs received by your division |
| **Doc Logs Pending** | Submitted logs awaiting receipt by your division |

### 2.3 Recent Transmittals

A table showing the 5 most recent transmittals involving your office, with status badges:
- **Draft** — Gray
- **Submitted / Pending Receipt** — Blue
- **To Receive** — Orange/Yellow
- **Received** — Green

---

## 3. Transmittal Management

### 3.1 Viewing Transmittals

1. Click **Transmittals** in the navigation menu.
2. The index page shows transmittals involving your office (Admin sees all).
3. By default, only today's transmittals are shown.
4. Use the filters to search by:
   - **Reference Number** (text search)
   - **Status** (Draft / Submitted / Received)
   - **Office** (sender or receiver)
   - **Date Range** (From / To)
5. Click a column header to sort.
6. Click a transmittal row to view details.

### 3.2 Creating a Transmittal

1. Click **Create Transmittal** (or the "+" button).
2. The form auto-populates:
   - **Sender Office**: Your office (read-only)
   - **Reference Number**: Auto-generated as `T-{OFFICE}-{YEAR}-{SEQ}` (editable if needed)
3. Fill in:
   - **Destination Office**: Select the receiving office from the dropdown
   - **Transmittal Date**: Defaults to today
   - **Remarks**: Optional notes
4. **Add Line Items**:
   - Click **Add Item** to add a row
   - Enter **Quantity**, **Unit**, **Description**, and optional **Remarks** for each item
   - Click the **×** button to remove an item
5. **Save**:
   - Click **Save as Draft** to save without sending
   - Click **Submit** to send immediately (triggers notification to receiver office)

> **⚠️ Security Advisory**: Do not enter sensitive personal information (PII) in Description or Remarks fields, as these are visible on the public QR tracking page.

### 3.3 Editing a Transmittal

1. Navigate to the transmittal details page.
2. Click **Edit** (only available for Draft transmittals, or Admin for Submitted).
3. Modify fields and items as needed.
4. Click **Save** or **Submit**.

> **Note**: Once a transmittal is **Received**, it cannot be edited (except by Admin).

### 3.4 Submitting a Draft

1. Open a Draft transmittal.
2. Click **Edit**.
3. Change status to **Submit**.
4. This sends a notification to all users in the receiving office.

### 3.5 Printing a Transmittal (PDF)

1. Navigate to the transmittal details page.
2. Click **Download PDF**.
3. A PDF file downloads with:
   - All transmittal details
   - Line items table
   - Embedded QR code for tracking
4. Print the PDF and attach it to the physical document bundle.

### 3.6 Deleting a Transmittal

1. Navigate to the transmittal details page.
2. Click **Delete** (only available for Draft/Submitted by creator, or Admin).
3. Confirm the deletion.

> **Caution**: Deleting a transmittal also removes all associated items and logs.

---

## 4. Document Log Management

Document Logs are used for **division-to-division** document routing within your office.

### 4.1 Prerequisites

- You must be **assigned to a division** to access Document Logs. If you see a "must be assigned to a division" error, contact your Admin.

### 4.2 Viewing Document Logs

1. Click **Document Logs** in the navigation menu.
2. The list shows document logs involving your division (Admin sees all in the office).
3. Each row shows reference number, date, sender/receiver divisions, and status.

### 4.3 Creating a Document Log

1. Click **Create Document Log**.
2. Auto-populated fields:
   - **Sender Division**: Your division (read-only)
   - **Reference Number**: `DL-{OFFICE}-{YEAR}-{SEQ}` (auto-generated)
3. Fill in:
   - **Receiver Division**: Select from divisions in your office (your own division excluded)
   - **Log Date**: Defaults to today
   - **Remarks**: Optional
4. **Add Line Items**: Same as transmittals (Quantity, Unit, Description, Remarks).
5. **Save as Draft** or **Submit**.

### 4.4 Receiving a Document Log

1. Navigate to a submitted document log addressed to your division.
2. Click **Receive**.
3. Status changes to **Received** with your name and timestamp recorded.
4. Sender is notified.

---

## 5. Receiving Documents

### 5.1 Receiving a Transmittal

**Method A — Via QR Code Scan:**
1. Receive the physical document bundle with the printed transmittal sheet.
2. Scan the QR code using your phone's camera or a QR scanner app.
3. The public tracking page opens — verify the transmittal details.
4. Log into the system and locate the transmittal.
5. Click **Receive**.

**Method B — Manual Lookup:**
1. Navigate to **Transmittals** in the system.
2. Search for the reference number.
3. Open the transmittal.
4. Click **Receive**.

### 5.2 What Happens on Receive

- Status updates to **Received**
- Your user ID and the current timestamp are recorded
- An audit log entry is created
- The sender receives a notification: _"Your transmittal [REF] has been received by [OFFICE]"_

---

## 6. Public QR Tracking

### 6.1 How It Works

Each printed transmittal PDF contains a QR code. Scanning this code opens a public tracking page.

### 6.2 Information Displayed

- **Reference Number** with status badge
- **Status**: Draft (gray), Submitted (blue), Received (green)
- **Execution Date**: The transmittal date
- **Received Date/Time**: When it was received (if applicable)
- **Origin Office**: Sender office name and code
- **Destination Office**: Receiver office name and code

### 6.3 No Login Required

The public tracking page is accessible to anyone with the URL. No account is needed.

### 6.4 Security

- The QR token is a 12-character random code — extremely difficult to guess.
- The route is rate-limited to prevent abuse (60 requests per minute per IP).

---

## 7. Notifications

### 7.1 Viewing Notifications

1. The **bell icon** in the navigation bar shows your unread notification count.
2. Click the bell icon to see recent unread notifications in a dropdown.
3. Click **View All** to go to the full notification inbox.

### 7.2 Notification Types

| Event | Who Gets Notified | Message |
|---|---|---|
| Transmittal Submitted | All users in receiver office | "Incoming Transmittal: [REF] from [OFFICE]" |
| Transmittal Received | Sender user | "Your transmittal [REF] has been received by [OFFICE]" |
| Document Log Submitted | All users in receiver division | "New document log [REF] from [DIVISION]" |
| Document Log Received | Sender user | "Your document [REF] was received by [DIVISION]" |

### 7.3 Actions

| Action | How |
|---|---|
| **Mark as Read** | Click the checkmark icon on a notification |
| **Mark as Unread** | Click the envelope icon on a read notification |
| **Mark All as Read** | Click "Mark All as Read" button |
| **Delete** | Click the trash icon on a notification |
| **Navigate** | Click the notification text to go to the related record |

---

## 8. Audit History

### 8.1 Viewing Audit Logs

1. Navigate to **Audit History** from the menu.
2. The page lists all transmittal-related actions for your office.
3. Each entry shows:
   - **Timestamp**
   - **Reference Number**
   - **Action** (Created, Submitted, Received, Edited, Items Updated)
   - **User** who performed the action
   - **Description**

### 8.2 Filtering

- **Search**: By reference number or description text
- **Action**: Filter by specific action type
- **Office**: Filter by office (Admin only)
- **Sort**: Click column headers to sort

### 8.3 Detail View

Click a log entry to see full details including the associated transmittal information.

---

## 9. Profile Management

### 9.1 Editing Your Profile

1. Click your **name** in the top-right corner.
2. Select **Profile**.
3. Update your **Name** and **Email**.
4. Click **Save**.

### 9.2 Changing Your Password

1. Go to **Profile**.
2. In the password section, enter your current password.
3. Enter and confirm your new password.
4. Click **Save**.

### 9.3 Deleting Your Account

1. Go to **Profile**.
2. Scroll to **Delete Account**.
3. Enter your password to confirm.
4. Click **Delete Account**.

> **Warning**: This action is irreversible. All your data associations remain in the system for audit purposes, but your login will be disabled.

---

## 10. Administration (Admin Only)

The Admin panel is accessible only to users with the **Admin** role.

### 10.1 User Management

**Path**: Admin → Users

| Action | Steps |
|---|---|
| **View All** | Navigate to Admin → Users. See list with name, email, office, role, login count |
| **Create User** | Click "Create User". Enter name, email, password, office, and role |
| **Edit User** | Click "Edit" on a user row. Update details, change office or role |
| **Delete User** | Click "Delete" on a user row. Confirm the action |

### 10.2 Role & Permission Management

**Path**: Admin → Roles

| Action | Steps |
|---|---|
| **View Roles** | See all roles with their assigned permissions |
| **Create Role** | Enter role name and assign permissions |
| **Edit Role** | Modify permissions assigned to a role |
| **Delete Role** | Remove a role (ensure no users are assigned) |

**Available Permissions:**
`view transmittals`, `create transmittals`, `edit transmittals`, `delete transmittals`, `receive transmittals`, `view document-logs`, `create document-logs`, `edit document-logs`, `delete document-logs`, `receive document-logs`, `manage offices`, `manage users`, `view reports`

### 10.3 Office Management

**Path**: Admin → Offices

| Action | Steps |
|---|---|
| **View Offices** | See all offices with type, code, and parent |
| **Create Office** | Enter name, code, type (Regional/Provincial/Negosyo Center/Attached), and parent office |
| **Edit Office** | Modify office details |
| **Delete Office** | Remove an office (ensure no users or transmittals reference it) |

### 10.4 Division Management

**Path**: Admin → Divisions

| Action | Steps |
|---|---|
| **View Divisions** | See all divisions with code and parent office |
| **Create Division** | Enter name, code, and parent office |
| **Edit Division** | Modify division details |
| **Delete Division** | Remove a division |

---

## 11. Support & FAQs

### 11.1 Accessing Help

- **FAQs**: Available at the **FAQs** page (link in navigation or `/faqs`)
- **User Manual**: Available at the **User Manual** page (`/user-manual`)
- **Support**: Contact information at the **Support** page (`/support`)

### 11.2 Common Questions

| Question | Answer |
|---|---|
| I can't see any transmittals | Your view is scoped to your office. If no transmittals exist for your office, the list will be empty. Contact Admin if you believe your office assignment is wrong. |
| I can't access Document Logs | You need a division assignment. Contact your Admin to assign you to a division. |
| My reference number is wrong | Reference numbers are auto-generated. If the sequence seems off, contact Admin — it may be due to deleted transmittals. |
| I can't edit a transmittal | Only Draft transmittals can be edited by their creator. Submitted transmittals require Admin access. Received transmittals are locked. |
| I can't receive a transmittal | You must belong to the receiving office and the transmittal must be in "Submitted" status. |
| How do I print a transmittal? | Open the transmittal details page and click "Download PDF". |
| How secure is the QR tracking? | The QR token is randomly generated and practically impossible to guess. The public page shows only basic tracking info — no line item details. |

---

_Document Version: 1.2 — Last Updated: February 26, 2026_

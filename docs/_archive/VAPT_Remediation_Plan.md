# VAPT Remediation Plan
## DTI Region VI - Transmittal Management System (DTI6-TMS)

**Date:** February 12, 2026
**Reference:** [VAPT Assessment Report](./VAPT_Assessment_Report.md)

---

## Remediated Findings

### V-06: Missing Rate Limiting on Public Tracking Route

| Field | Value |
| :--- | :--- |
| **Original Risk** | Low |
| **Status** | ✅ Remediated |
| **File Changed** | `routes/web.php` |

**Problem:** The `/track/{qr_token}` route had no request throttling, allowing unlimited requests which could enable brute-force token enumeration.

**Fix Applied:** Added `throttle:60,1` middleware to limit public tracking requests to **60 per minute per IP address**. Requests exceeding this limit return HTTP `429 Too Many Requests`.

```php
// Before
Route::get('/track/{qr_token}', [...])->name('transmittals.public-track');

// After
Route::get('/track/{qr_token}', [...])->middleware('throttle:60,1')->name('transmittals.public-track');
```

---

### V-05: Sensitive Data Exposure via Public Tracking

| Field | Value |
| :--- | :--- |
| **Original Risk** | Low |
| **Status** | ✅ Remediated |
| **Files Changed** | `resources/views/transmittals/create.blade.php`, `resources/views/transmittals/public-track.blade.php` |

**Problem:** Users may unknowingly enter PII or confidential data in Description/Remarks fields, which are visible on the unauthenticated public QR tracking page.

**Fixes Applied:**
1. **Create Form Warning:** Added a prominent "Security Advisory" alert banner above the Enclosure Items table on the New Transmittal form, instructing users not to enter sensitive personal information.
2. **Public Tracking Footer:** Updated the footer notice to explicitly state the page is publicly accessible.

---

## Verification Checklist

- [ ] Visit `/track/INVALIDTOKEN` 60+ times within one minute → should receive `429` response after limit
- [ ] Open `/transmittals/create` → Security Advisory banner is visible above the items table
- [ ] Open any valid `/track/{qr_token}` → Footer reads "This page is publicly accessible..."

---

## Approval

| Role | Name | Signature | Date |
| :--- | :--- | :--- | :--- |
| Developer | | | |
| Reviewer | | | |
| Project Lead | | | |

# Notification System Implementation Guide

**Phase:** 3.5 - Notification System  
**Status:** ✅ COMPLETE  
**Date Completed:** January 29, 2026

---

## Overview

The DTI6-TMS Notification System is a comprehensive in-app notification framework that keeps users informed about important transmittal events and system activities. The system supports real-time notifications with a dropdown menu in the navbar and a dedicated notifications page.

## Architecture

### Components

1. **Database Layer**
   - `notifications` table for storing notifications
   - Relationships to `users` and `offices`
   - Timestamps for tracking notification creation

2. **Model Layer**
   - `Notification` model with utility methods
   - Methods for marking read/unread status
   - Relationship definitions

3. **Service Layer**
   - `NotificationService` for centralized notification creation
   - Utility methods for common notification types
   - Support for single user, multiple users, and office-wide notifications

4. **Controller Layer**
   - `NotificationController` for handling notification actions
   - JSON API endpoints for real-time operations
   - HTML views for notification management

5. **View Layer**
   - Navbar notification bell dropdown
   - Full notifications page with pagination
   - Real-time notification updates

---

## Database Schema

### Notifications Table

```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    office_id BIGINT UNSIGNED NULLABLE,
    user_id BIGINT UNSIGNED NULLABLE,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    link VARCHAR(255) NULLABLE,
    read_at TIMESTAMP NULLABLE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (office_id) REFERENCES offices(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

**Fields:**
- `id`: Primary key
- `office_id`: Office associated with the notification (for office-wide notifications)
- `user_id`: User who should receive the notification
- `title`: Brief notification title (e.g., "Transmittal Received")
- `message`: Detailed notification message
- `link`: Optional link to relevant resource (transmittal, audit log, etc.)
- `read_at`: Timestamp when notification was marked as read (NULL = unread)
- `created_at`: When notification was created
- `updated_at`: When notification was last updated

---

## Models

### Notification Model

**File:** `app/Models/Notification.php`

```php
class Notification extends Model
{
    protected $fillable = [
        'office_id',
        'user_id',
        'title',
        'message',
        'link',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function office() { ... }
    public function user() { ... }
    public function isRead() { ... }
    public function isUnread() { ... }
    public function markAsRead() { ... }
    public function markAsUnread() { ... }
}
```

**Methods:**
- `isRead()`: Check if notification has been read
- `isUnread()`: Check if notification is unread
- `markAsRead()`: Mark notification as read with timestamp
- `markAsUnread()`: Mark notification as unread (clears timestamp)

---

## Services

### NotificationService

**File:** `app/Services/NotificationService.php`

The `NotificationService` provides a clean, centralized API for creating notifications throughout the application.

#### Methods

##### `notifyUser(User $user, string $title, string $message, ?string $link = null): Notification`
Send notification to a specific user.

```php
NotificationService::notifyUser(
    $user,
    'Transmittal Received',
    'Your transmittal T-ORD-2026-001 has been received',
    route('transmittals.show', $transmittal)
);
```

##### `notifyOffice(Office $office, string $title, string $message, ?string $link = null): void`
Send notification to all users in an office.

```php
NotificationService::notifyOffice(
    $receiverOffice,
    'Incoming Transmittal',
    'New transmittal from Regional Office',
    route('transmittals.show', $transmittal)
);
```

##### `notifyUsers(array $userIds, string $title, string $message, ?string $link = null): void`
Send notification to multiple specific users.

```php
NotificationService::notifyUsers(
    [1, 2, 3],
    'System Maintenance',
    'System maintenance scheduled for 10 PM',
    null
);
```

##### Specialized Methods

**`notifyTransmittalCreated($transmittal)`**
- Triggered when transmittal is submitted
- Notifies receiver office about incoming transmittal
- Includes link to transmittal

**`notifyTransmittalReceived($transmittal)`**
- Triggered when transmittal is marked as received
- Notifies sender about successful receipt
- Includes link to transmittal

**`notifyTransmittalStatusChanged($transmittal, $previousStatus)`**
- Triggered when transmittal status changes
- Notifies sender of status update
- Includes link to transmittal

---

## Controller

### NotificationController

**File:** `app/Http/Controllers/NotificationController.php`

#### Routes

All routes require authentication.

**GET `/notifications`**
- Display notifications page with pagination
- Shows both read and unread notifications
- Returns HTML view

**GET `/notifications/unread`**
- Get last 5 unread notifications
- Returns JSON for dropdown display
- Used for real-time updates

**GET `/notifications/unread-count`**
- Get count of unread notifications
- Returns JSON with count
- Used to update badge in navbar

**POST `/notifications/{notification}/read`**
- Mark specific notification as read
- Returns JSON success response
- Performs authorization check

**POST `/notifications/{notification}/unread`**
- Mark specific notification as unread
- Returns JSON success response
- Performs authorization check

**DELETE `/notifications/{notification}`**
- Delete a notification
- Returns JSON success response
- Performs authorization check

**POST `/notifications/mark-all-read`**
- Mark all unread notifications as read
- Returns JSON success response
- Bulk operation

#### Access Control

- All routes require authentication
- Users can only see notifications intended for them or their office
- Authorization checks prevent unauthorized access

---

## Views

### Notifications Page

**File:** `resources/views/notifications/index.blade.php`

Full-page notifications inbox with the following features:

**Features:**
- Display all notifications (read and unread)
- Pagination (10 per page)
- Color-coded unread notifications (light blue background)
- Unread badge next to notification time
- Individual action buttons:
  - Mark as read/unread
  - Delete notification
- Mark all as read button in header
- Empty state message when no notifications
- Real-time action handling via AJAX

**Styling:**
- Modern card-based design
- Responsive for mobile devices
- Smooth transitions and hover effects
- Touch-friendly button sizing

---

## Navbar Integration

### Notification Bell Dropdown

**Location:** `resources/views/layouts/app.blade.php`

The navbar includes a notification bell icon with the following features:

**Features:**
- Bell icon with unread count badge
- Dropdown menu showing latest unread notifications
- Each notification displays:
  - Icon (inbox or check depending on type)
  - Title
  - Message preview
  - Timestamp (human-readable "X ago" format)
- Click notification to mark as read and navigate to link
- View all notifications link in dropdown

**JavaScript:**
- Polls for unread notifications every 30 seconds
- Updates badge count in real-time
- Loads dropdown content on bell click
- Handles notification marking as read

---

## Integration Points

### Transmittal Creation

**File:** `app/Http/Controllers/TransmittalController.php`

```php
public function store(Request $request)
{
    // ... create transmittal ...
    
    if ($status === 'Submitted') {
        NotificationService::notifyTransmittalCreated($transmittal);
    }
}
```

### Transmittal Reception

```php
public function receive(Transmittal $transmittal)
{
    // ... update status ...
    
    NotificationService::notifyTransmittalReceived($transmittal);
}
```

---

## Usage Examples

### Basic Notification

```php
use App\Services\NotificationService;

NotificationService::notifyUser(
    auth()->user(),
    'Welcome',
    'Welcome to the DTI6-TMS system!'
);
```

### Office-Wide Notification

```php
$office = Office::find(1);

NotificationService::notifyOffice(
    $office,
    'System Update',
    'System will be updated tonight at 10 PM',
    route('support')
);
```

### Transmittal-Related Notification

```php
// When transmittal is created
NotificationService::notifyTransmittalCreated($transmittal);

// When transmittal is received
NotificationService::notifyTransmittalReceived($transmittal);

// When transmittal status changes
NotificationService::notifyTransmittalStatusChanged(
    $transmittal,
    'Draft'  // previous status
);
```

---

## Real-Time Behavior

### Polling Strategy

- Navbar notification bell polls every 30 seconds
- Updates unread count badge
- Loads recent notifications on dropdown click
- No server push (simple polling approach)

### Client-Side Actions

All notification actions are handled via AJAX:
- Mark as read/unread
- Delete notification
- Mark all as read
- Updates page without refresh

---

## Notification Types

### System Notifications

- System maintenance announcements
- User account notifications
- General system information

### Transmittal Notifications

- Incoming transmittal alerts
- Receipt confirmations
- Status change updates

### Office Notifications

- Office-wide announcements
- Batch notifications
- Administrative alerts

---

## Future Enhancements

### Email Notifications

Support for email delivery:
- Queue jobs for email sending
- Email templates for different notification types
- User preferences for email notifications
- Daily digest option

### Push Notifications

Browser push notifications:
- Service worker setup
- Push notification API
- Mobile app support
- Notification preferences

### Advanced Filtering

- Notification categories/types
- User preferences for notification types
- Do not disturb settings
- Custom notification rules

### Notification History

- Archive old notifications
- Search notifications
- Export notification logs
- Audit trail integration

---

## Best Practices

### Creating Notifications

1. **Use NotificationService** - Always use the service for consistency
2. **Meaningful Titles** - Keep titles brief and descriptive
3. **Clear Messages** - Provide context and actionable information
4. **Include Links** - When possible, link to relevant resources
5. **Avoid Spam** - Only notify when truly necessary

### Example

```php
// ✅ Good
NotificationService::notifyUser(
    $user,
    'Transmittal Received',
    'Transmittal T-ORD-2026-001 from Regional Office has been received and acknowledged.',
    route('transmittals.show', $transmittal)
);

// ❌ Avoid
Notification::create([
    'user_id' => $user->id,
    'title' => 'Hi',
    'message' => 'Something happened'
]);
```

---

## Testing

### Manual Testing

1. **Create Transmittal** - Verify notification in receiver office notification bell
2. **Receive Transmittal** - Verify sender receives confirmation notification
3. **View Notifications** - Check full notifications page displays all items
4. **Mark as Read** - Verify badge updates and notification styling changes
5. **Delete Notification** - Verify removal from list

### Expected Results

- ✅ Notifications appear in dropdown within 30 seconds
- ✅ Unread count badge updates
- ✅ Clicking notification marks as read
- ✅ Notification links navigate to correct resources
- ✅ Deleted notifications removed from list
- ✅ Pagination works on full notifications page

---

## Troubleshooting

### Notifications Not Appearing

**Problem:** Notifications don't show in dropdown
**Solutions:**
1. Check browser console for JavaScript errors
2. Verify user office_id is set correctly
3. Check database for notification records
4. Clear browser cache

### Unread Count Not Updating

**Problem:** Badge count doesn't update
**Solutions:**
1. Wait 30 seconds for polling interval
2. Refresh page to reset polling
3. Check browser network requests
4. Verify CSRF token in page meta

### Notification Links Broken

**Problem:** Links in notifications don't work
**Solutions:**
1. Verify routes exist
2. Check named routes are correct
3. Verify resource IDs are valid
4. Check user permissions for linked resource

---

## Configuration

### Polling Interval

Edit `resources/views/layouts/app.blade.php`:
```javascript
setInterval(fetchNotifications, 30000); // Change 30000 to desired milliseconds
```

### Notification Retention

Add cleanup job to remove old notifications:
```php
// In Notification model or custom command
Notification::where('created_at', '<', now()->subDays(90))->delete();
```

### Maximum Dropdown Items

Edit the getUnread method in NotificationController:
```php
->limit(5)  // Change 5 to desired number
```

---

## Performance Considerations

- Notifications are paginated (10 per page)
- Dropdown shows only 5 latest unread
- Polling interval is 30 seconds (not too aggressive)
- Database queries use lazy loading where appropriate
- No N+1 queries through relationship loading

---

## Summary

The notification system provides a complete, production-ready solution for keeping users informed about important events in the DTI6-TMS system. It's easily extensible for future notification types and delivery methods.

**Key Features:**
✅ Real-time notification delivery  
✅ Read/unread status tracking  
✅ Office-wide and individual notifications  
✅ Centralized notification service  
✅ Responsive UI  
✅ AJAX-based interactions  
✅ Audit trail integration  

---

_Implementation Complete: January 29, 2026_  
_Next Steps: Phase 4 - Advanced Features & Analytics_

# Authorization Implementation Documentation

## Overview

This document describes the authorization system implemented for the BowlZone application, which fulfills assignment requirement #8: "Must Implement User authorization using gates or policies."

## Architecture

### 1. **is_admin Column**

- **Migration**: `2026_04_24_111350_add_is_admin_to_users_table`
- **Location**: `app/Models/User` model
- **Type**: Boolean (default: false)
- **Purpose**: Tracks which users have administrative access

### 2. **AdminPolicy Class**

- **Location**: `app/Policies/AdminPolicy.php`
- **Methods**:
    - `viewAdminDashboard()` - Check if user can access admin dashboard
    - `viewContactMessages()` - Check if user can view contact messages
    - `deleteContactMessage()` - Check if user can delete messages
    - `markAsRead()` - Check if user can mark messages as read

### 3. **Authorization Gates**

- **Location**: `app/Providers/AuthServiceProvider.php`
- **Gates Defined**:
    - `admin` - Basic admin check
    - `view-admin-dashboard` - Dashboard access
    - `view-contact-messages` - Message viewing
    - `delete-contact-message` - Message deletion

### 4. **AdminMiddleware**

- **Location**: `app/Http/Middleware/AdminMiddleware.php`
- **Registered in**: `app/Http/Kernel.php`
- **Function**: Middleware that checks if user is authenticated AND is an admin
- **Response**: Returns 403 Forbidden if unauthorized, redirects to login if not authenticated

### 5. **AdminController**

- **Location**: `app/Http/Controllers/AdminController.php`
- **Methods**:
    - `dashboard()` - Show admin dashboard with statistics
    - `contactMessages()` - List all contact messages with pagination
    - `showContactMessage()` - Display single message details
    - `deleteContactMessage()` - Delete a contact message
    - `bookings()` - List all bookings
    - `orders()` - List all orders
    - `users()` - List all users

### 6. **Protected Routes**

- **Location**: `routes/web.php`
- **Group**: `/admin` prefix with 'auth' and 'admin' middleware
- **Routes**:
    - GET `/admin/dashboard` → Admin dashboard
    - GET `/admin/contact-messages` → Contact messages list
    - GET `/admin/contact-messages/{id}` → Message details
    - DELETE `/admin/contact-messages/{id}` → Delete message
    - GET `/admin/bookings` → Bookings list
    - GET `/admin/orders` → Orders list
    - GET `/admin/users` → Users list

## Authorization Flow

```
User Request
    ↓
Route Middleware (auth)
    ↓ (User must be logged in)
Route Middleware (admin)
    ↓ (User must have is_admin = true)
AdminMiddleware checks is_admin field
    ↓
Gate::allows('view-admin-dashboard')
    ↓ (in Controller method)
Controller method executes
    ↓
View with authorization-protected data
```

## Usage

### Making a User an Admin

```bash
php artisan make:admin {email}
```

**Example**:

```bash
php artisan make:admin admin@bowlzone.com
```

### In Code - Using Gates

```php
// In routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Only accessible to authenticated admins
});

// In controllers
if (!Gate::allows('view-admin-dashboard')) {
    abort(403, 'Unauthorized');
}

// In views
@can('view-admin-dashboard')
    <!-- Admin content -->
@endcan
```

### In Code - Using Policies

```php
// Authorize via policy
$this->authorize('viewAdminDashboard');

// Or check directly
if (!auth()->user()->can('viewAdminDashboard')) {
    abort(403);
}
```

## Views

### Admin Templates

- `resources/views/admin/dashboard.blade.php` - Main admin dashboard
- `resources/views/admin/contact-messages.blade.php` - Messages list
- `resources/views/admin/contact-message-detail.blade.php` - Message details
- `resources/views/admin/bookings.blade.php` - Bookings list
- `resources/views/admin/orders.blade.php` - Orders list
- `resources/views/admin/users.blade.php` - Users list

### Styling

- `public/css/admin.css` - Admin pages stylesheet with red/black/white theme

## Security Features

1. **Middleware Protection**: All admin routes require both authentication AND admin status
2. **Gate Checks**: Additional authorization checks within controller methods
3. **Error Handling**: 403 Forbidden for unauthorized access
4. **Redirect**: Non-authenticated users redirected to login page
5. **Session Management**: Uses Laravel's built-in session handling for user authentication state

## Assignment Compliance

✅ **Requirement #8**: Must implement user authorization using gates or policies

- **Gates**: Defined in AuthServiceProvider
- **Policies**: AdminPolicy class with multiple authorization methods
- **Protected Routes**: All admin routes protected by middleware and gates
- **User Roles**: is_admin column determines authorization level

✅ **Requirement #7**: Must demonstrate sessions or cookies

- Uses Laravel's built-in session middleware
- Sessions track authenticated user state
- is_admin status persists across requests via session

✅ **Requirement #6**: User authentication

- Login/Register functionality implemented
- Admin routes require authentication
- Only authenticated users can access protected content

## Testing Authorization

### Test 1: Non-Admin User Access

```
1. Log in as regular user
2. Try to access /admin/dashboard
3. Expected: 403 Forbidden error
```

### Test 2: Admin User Access

```
1. Run: php artisan make:admin youremail@example.com
2. Log in as that user
3. Visit /admin/dashboard
4. Expected: Full admin dashboard access
```

### Test 3: Viewing Contact Messages

```
1. As admin, visit /admin/contact-messages
2. Click on a message
3. Expected: Full message details visible
4. Expected: Delete button available
```

## Database Schema

### Users Table (Relevant Fields)

```sql
- id (PK)
- email (string, unique)
- password (hashed)
- first_name (string)
- last_name (string)
- is_admin (boolean, default: false)  ← NEW FIELD
- created_at (timestamp)
- updated_at (timestamp)
```

## Files Modified/Created

### Created

- `app/Policies/AdminPolicy.php`
- `app/Http/Controllers/AdminController.php`
- `app/Http/Middleware/AdminMiddleware.php`
- `app/Console/Commands/MakeAdminCommand.php`
- `resources/views/admin/dashboard.blade.php`
- `resources/views/admin/contact-messages.blade.php`
- `resources/views/admin/contact-message-detail.blade.php`
- `resources/views/admin/bookings.blade.php`
- `resources/views/admin/orders.blade.php`
- `resources/views/admin/users.blade.php`
- `public/css/admin.css`
- `database/migrations/2026_04_24_111350_add_is_admin_to_users_table.php`

### Modified

- `app/Providers/AuthServiceProvider.php` - Added gates
- `app/Http/Kernel.php` - Registered AdminMiddleware
- `routes/web.php` - Added admin routes

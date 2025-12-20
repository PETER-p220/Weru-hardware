# Role-Based Access Control Guide

## Overview
This application uses role-based access control to ensure users can only access routes appropriate for their role.

## User Roles

### Regular Users (role: 'user')
**Routes they CAN access:**
- `/dashboard` - User dashboard
- `/products` - Browse products
- `/show` - View product details
- `/cart` - Shopping cart
- `/checkout` - Checkout and payment
- `/order` - View their own orders
- `/profile` - Profile management
- `/` - Welcome/home page

**Routes they CANNOT access (will be redirected):**
- `/adminDashboard` - Admin dashboard
- `/indexProduct` - Product management
- `/createProduct` - Create products
- `/editProduct` - Edit products
- `/deleteProduct` - Delete products
- `/indexCategory` - Category management
- `/createCategory` - Create categories
- `/editCategory` - Edit categories
- `/deleteCategory` - Delete categories
- `/OrderManagement` - Manage all orders
- `/user` - User management
- `/ads` - Advertisement management
- `/advertisement` - Create advertisements

### Admin Users (role: 'admin')
**Routes they CAN access:**
- All routes from Regular Users PLUS:
- `/adminDashboard` - Admin dashboard
- `/indexProduct` - Product management
- `/createProduct` - Create products
- `/editProduct` - Edit products
- `/deleteProduct` - Delete products
- `/indexCategory` - Category management
- `/createCategory` - Create categories
- `/editCategory` - Edit categories
- `/deleteCategory` - Delete categories
- `/OrderManagement` - Manage all orders
- `/user` - User management
- `/ads` - Advertisement management
- `/advertisement` - Create advertisements

**Routes they CANNOT access (will be redirected):**
- `/dashboard` - Regular user dashboard (admins are redirected to `/adminDashboard`)

## Testing Multiple Roles

### ⚠️ Important: Session Limitations
**You CANNOT be logged in as two different users in the same browser simultaneously.**

Laravel uses session-based authentication, which means:
- Sessions are **shared across all tabs** in the same browser
- Only **one user** can be authenticated at a time per browser

### How to Test Both Roles

To test both admin and regular user functionality, use one of these methods:

#### Method 1: Different Browsers
1. Open **Chrome** and login as regular user
2. Open **Firefox** (or Edge) and login as admin
3. Both sessions work independently

#### Method 2: Incognito/Private Browsing
1. Open **regular window** and login as regular user
2. Open **incognito/private window** (Ctrl+Shift+N in Chrome) and login as admin
3. Both sessions work independently

#### Method 3: Different Browser Profiles
1. Create separate browser profiles
2. Use Profile 1 for regular user
3. Use Profile 2 for admin
4. Both sessions work independently

## How Access Control Works

### Middleware Protection
1. **`EnsureUserIsAdmin`** middleware:
   - Checks if user has 'admin' role
   - Redirects non-admin users to `/dashboard` with error message
   - Applied to all admin-only routes

2. **`EnsureUserIsRegularUser`** middleware:
   - Checks if user does NOT have 'admin' role
   - Redirects admin users to `/adminDashboard`
   - Applied to `/dashboard` route only

3. **`auth`** middleware:
   - Ensures user is authenticated
   - Redirects unauthenticated users to login page
   - Applied to all protected routes

## Common Scenarios

### Scenario 1: Regular User Tries to Access Admin Route
**What happens:**
- User tries to access `/OrderManagement`
- `EnsureUserIsAdmin` middleware checks role
- User is NOT admin
- User is redirected to `/dashboard`
- Error message: "Access denied. This area is restricted to administrators only."

### Scenario 2: Admin User Tries to Access Regular Dashboard
**What happens:**
- Admin tries to access `/dashboard`
- `EnsureUserIsRegularUser` middleware checks role
- User IS admin
- Admin is redirected to `/adminDashboard`
- Info message: "Administrators should use the Admin Dashboard."

### Scenario 3: Unauthenticated User Tries to Access Protected Route
**What happens:**
- User tries to access `/cart`
- `auth` middleware checks authentication
- User is NOT logged in
- User is redirected to `/login`
- Error message: "Please login to access this page."

## Notes

- Admins can still shop! They have access to `/products`, `/cart`, `/checkout`, and `/order` routes
- Regular users are completely blocked from admin routes - they cannot access them even by typing URLs directly
- All redirects include appropriate error/info messages to inform users why access was denied


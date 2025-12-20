# User Roles Management Guide

## Database Tables for Roles

Your application uses **Spatie Laravel Permission** package. The roles are stored in these tables:

### 1. **`roles` Table**
   - Contains all available roles
   - Columns: `id`, `name`, `guard_name`, `created_at`, `updated_at`
   - Your roles: `admin` and `user`

### 2. **`model_has_roles` Table** (Pivot Table)
   - Links users to their roles
   - Columns: `role_id`, `model_type`, `model_id`
   - This is where user-role relationships are stored

### 3. **`users` Table**
   - Contains user information
   - Does NOT contain role information directly
   - Roles are linked via `model_has_roles` table

## How to Grant Admin Privileges

### Method 1: Via Admin Panel UI (Recommended)
1. Log in as an admin user
2. Go to `/user` (User Management page)
3. Find the user you want to make admin
4. Change the dropdown from "Customer" to "Administrator"
5. The role will update automatically

### Method 2: Using Laravel Tinker (Quick)
```bash
php artisan tinker
```

Then run:
```php
// Find user by email
$user = App\Models\User::where('email', 'user@example.com')->first();

// Assign admin role
$user->assignRole('admin');

// Or assign user role
$user->assignRole('user');

// To remove all roles and assign new one
$user->syncRoles(['admin']);
```

### Method 3: Direct Database Query (SQL)
```sql
-- Get the admin role ID
SELECT id FROM roles WHERE name = 'admin' AND guard_name = 'web';

-- Assuming admin role ID is 1, assign to user ID 5
INSERT INTO model_has_roles (role_id, model_type, model_id) 
VALUES (1, 'App\\Models\\User', 5);

-- To remove admin role from a user
DELETE FROM model_has_roles 
WHERE model_type = 'App\\Models\\User' 
AND model_id = 5 
AND role_id = 1;
```

### Method 4: Using Seeder (For Initial Setup)
The seeder already creates roles. You can modify `database/seeders/DatabaseSeeder.php` to assign roles to specific users.

## Checking User Roles

### In Code:
```php
$user->hasRole('admin');  // Returns true/false
$user->roles;             // Get all user roles
```

### In Database:
```sql
-- Check user's roles
SELECT r.name, r.guard_name 
FROM roles r
INNER JOIN model_has_roles mhr ON r.id = mhr.role_id
WHERE mhr.model_type = 'App\\Models\\User'
AND mhr.model_id = [USER_ID];
```

## Available Roles

Currently, your system has only 2 roles:
- **`user`** - Regular customer/user
- **`admin`** - Administrator with full access

## Security Notes

- Only admins can change user roles (via UI)
- Admins cannot change their own role
- You cannot delete the last admin user
- Regular users cannot assign roles


# Quick Database Fix

## The Problem
Access denied means either:
1. User doesn't exist
2. Password is wrong
3. User doesn't have permissions

## Quick Fix Steps

### Option 1: Create Everything Fresh

```bash
sudo mysql -u root -p
```

Then run this complete setup:
```sql
-- Create database
CREATE DATABASE IF NOT EXISTS oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user with password
CREATE USER IF NOT EXISTS 'oweru_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';

-- Grant all privileges
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';

-- Reload privileges
FLUSH PRIVILEGES;

-- Verify
SHOW DATABASES;
SELECT user, host FROM mysql.user WHERE user = 'oweru_user';

EXIT;
```

### Option 2: Test Connection
```bash
mysql -u oweru_user -p oweru_hardware
# Enter password: StrongPassword123!
```

If this works, your credentials are correct.

### Step 3: Update .env File
```bash
nano .env
```

Make sure these match:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oweru_hardware
DB_USERNAME=oweru_user
DB_PASSWORD=StrongPassword123!
```

**CRITICAL:** Password in .env must EXACTLY match the password in MySQL!

### Step 4: Clear Config Cache and Try Again
```bash
php artisan config:clear
php artisan migrate --force
```


# Fix Database Access Denied Error

## Problem
Database user can't connect - either user doesn't exist or password is wrong.

## Solution

### Step 1: Check if Database and User Exist
```bash
sudo mysql -u root -p
```

Then in MySQL:
```sql
-- Check if database exists
SHOW DATABASES LIKE 'oweru_hardware';

-- Check if user exists
SELECT user, host FROM mysql.user WHERE user = 'oweru_user';

-- Check user privileges
SHOW GRANTS FOR 'oweru_user'@'localhost';
```

### Step 2: Create Database and User (if they don't exist)

If database doesn't exist:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

If user doesn't exist:
```sql
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'YourStrongPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
```

### Step 3: Test Database Connection
```sql
-- Test connection as the user
mysql -u oweru_user -p oweru_hardware
-- Enter password when prompted
```

### Step 4: Verify .env File
Make sure your .env file has the correct credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oweru_hardware
DB_USERNAME=oweru_user
DB_PASSWORD=YourStrongPassword123!
```

**Important:** The password in .env must match the password you set when creating the user!

### Step 5: Reset Password (if needed)
If you need to change the user password:
```sql
ALTER USER 'oweru_user'@'localhost' IDENTIFIED BY 'NewPassword123!';
FLUSH PRIVILEGES;
```

Then update .env with the new password.


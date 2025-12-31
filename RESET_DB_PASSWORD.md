# Reset Database Password - Quick Fix

## Your Database Setup is Correct! ✅
- Database `oweru_hardware` exists ✅
- User `oweru_user` exists ✅
- User has ALL PRIVILEGES ✅

## The Problem
The password in your `.env` file doesn't match the MySQL password.

## Solution: Reset Password

### Step 1: Reset the MySQL Password

While still in MySQL (you're already there), run:

```sql
-- Reset password to: HardwareDB123!
ALTER USER 'oweru_user'@'localhost' IDENTIFIED BY 'HardwareDB123!';
FLUSH PRIVILEGES;
EXIT;
```

### Step 2: Update .env File

```bash
nano .env
```

Find the database section and update it to:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oweru_hardware
DB_USERNAME=oweru_user
DB_PASSWORD=HardwareDB123!
```

Save and exit (Ctrl+X, then Y, then Enter)

### Step 3: Test Connection

```bash
mysql -u oweru_user -p oweru_hardware
# Enter password: HardwareDB123!
```

If you can connect, type `EXIT;` and continue.

### Step 4: Clear Config Cache and Migrate

```bash
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
```

## Alternative: Use Root User (Quick Test)

If you want to test quickly, you can temporarily use root:

```env
DB_USERNAME=root
DB_PASSWORD=your_root_password
```

But using a dedicated user is more secure for production!


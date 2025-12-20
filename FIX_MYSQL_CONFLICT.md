# Fix MySQL/MariaDB Conflict on Hostinger VPS

## Problem
You already have Percona Server (MySQL) installed, which conflicts with MariaDB installation.

## Solution: Use Existing MySQL Server

You don't need to install MariaDB. Your existing Percona Server works perfectly fine with Laravel.

### Check MySQL Status
```bash
sudo systemctl status mysql
# or
sudo systemctl status percona-server
```

### If MySQL is running, continue with database setup:

```bash
# Connect to MySQL (use root password or skip if no password)
sudo mysql -u root -p
# OR if no password needed:
sudo mysql -u root
```

Then create your database:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'YourStrongPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Verify PHP MySQL Extension
Your system should already have the MySQL extension. Check:
```bash
php -m | grep mysql
```

If it shows `mysqli` or `pdo_mysql`, you're good!

### If you really want to remove Percona and use MariaDB
```bash
sudo apt remove --purge percona-server-* mysql-server
sudo apt autoremove
sudo apt install mariadb-server mariadb-client
```

But it's NOT necessary - Percona Server works fine with Laravel!


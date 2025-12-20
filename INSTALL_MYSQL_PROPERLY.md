# Install MySQL Properly on Hostinger VPS

## Problem
MySQL service doesn't exist. We need to install it properly.

## Solution: Install MariaDB (MySQL-compatible and easier)

### Step 1: Clean Up Any Broken MySQL Installation
```bash
# Remove any partial MySQL/Percona installations
sudo apt remove --purge percona-server-* mysql-server mysql-common -y
sudo apt autoremove -y
sudo apt autoclean
```

### Step 2: Install MariaDB (MySQL-compatible)
```bash
sudo apt update
sudo apt install -y mariadb-server mariadb-client
```

### Step 3: Start and Enable MariaDB
```bash
sudo systemctl start mariadb
sudo systemctl enable mariadb
sudo systemctl status mariadb
```

### Step 4: Secure MariaDB Installation
```bash
sudo mysql_secure_installation
```

Follow the prompts:
- Set root password? **Yes** and enter a strong password
- Remove anonymous users? **Yes**
- Disallow root login remotely? **Yes**
- Remove test database? **Yes**
- Reload privilege tables? **Yes**

### Step 5: Connect to MySQL
```bash
sudo mysql -u root -p
# Enter the password you just set
```

Then create your database:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'YourStrongPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## Alternative: Install MySQL 8.0 Instead
If you prefer MySQL over MariaDB:
```bash
sudo apt install -y mysql-server mysql-client
sudo systemctl start mysql
sudo systemctl enable mysql
sudo mysql_secure_installation
```


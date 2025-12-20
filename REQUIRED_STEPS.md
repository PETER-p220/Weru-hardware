# Required vs Optional Steps

## ✅ REQUIRED Steps (Must Do for App to Work)

### 1. Create Database (REQUIRED)
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
**Why:** Laravel needs a database to store data

### 2. Create Database User (REQUIRED)
```sql
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'YourPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
```
**Why:** Laravel needs credentials to connect to the database

### 3. Configure .env file with database credentials (REQUIRED)
**Why:** Laravel reads database settings from .env file

## ⚠️ RECOMMENDED Steps (Should Do for Security)

### mysql_secure_installation (RECOMMENDED)
- Set root password
- Remove anonymous users
- Disable remote root login
- Remove test databases

**Can skip if:** You're just testing, but **DO IT** before production!

## Summary
- **Database & User:** REQUIRED - App won't work without it
- **Security Setup:** OPTIONAL - But highly recommended before going live


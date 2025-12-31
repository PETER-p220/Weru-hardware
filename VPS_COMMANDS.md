# Commands to Run on Your VPS

## ✅ Already Done
- PHP 8.2 installed
- Composer installed
- MySQL/Percona Server running

## 🔄 Next Commands to Run

### 1. Reload System Daemon
```bash
sudo systemctl daemon-reload
```

### 2. Create Database
```bash
sudo mysql -u root
```

Then in MySQL:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Install Nginx
```bash
sudo apt install -y nginx
sudo systemctl start nginx
sudo systemctl enable nginx
```

### 4. Create Project Directory
```bash
sudo mkdir -p /var/www/oweru-hardware
sudo chown -R $USER:$USER /var/www/oweru-hardware
cd /var/www
```

### 5. Upload Your Project

**Option A: Using Git**
```bash
git clone YOUR_REPO_URL oweru-hardware
cd oweru-hardware
```

**Option B: Using SFTP**
- Upload all files to `/var/www/oweru-hardware`
- Don't upload: vendor/, node_modules/, .env, storage/logs/*

### 6. Install Laravel Dependencies
```bash
cd /var/www/oweru-hardware
composer install --optimize-autoloader --no-dev
```

### 7. Configure .env File
```bash
cp .env.example .env
nano .env
```

Update with:
- Database credentials
- APP_URL with your domain
- Selcom credentials

### 8. Setup Laravel
```bash
php artisan key:generate
sudo chown -R www-data:www-data /var/www/oweru-hardware
sudo chmod -R 755 /var/www/oweru-hardware
sudo chmod -R 775 storage bootstrap/cache
php artisan migrate --force
php artisan db:seed
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Continue with Nginx configuration after these steps!


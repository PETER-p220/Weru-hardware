# Deployment Guide for Hostinger VPS

## Prerequisites

1. **Hostinger VPS Access**
   - SSH credentials (IP, username, password/key)
   - Root or sudo access
   - Domain name pointing to your VPS IP

2. **Local Requirements**
   - Git repository (recommended)
   - All code committed
   - Database backup ready

## Step 1: Prepare Your Project Locally

### 1.1 Create .env.example (if not exists)
```bash
cp .env .env.example
```

### 1.2 Ensure these are in .gitignore:
- `.env`
- `vendor/`
- `node_modules/`
- `storage/logs/*`
- `.phpunit.result.cache`

### 1.3 Commit everything to Git
```bash
git add .
git commit -m "Prepare for deployment"
git push
```

## Step 2: Connect to Hostinger VPS

### 2.1 SSH into your VPS
```bash
ssh root@your-vps-ip
# or
ssh username@your-vps-ip
```

### 2.2 Update system packages
```bash
sudo apt update
sudo apt upgrade -y
```

## Step 3: Install Required Software

### 3.1 Install PHP 8.2+ and extensions
```bash
sudo apt install -y php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath php8.2-sqlite3
```

### 3.2 Install Composer
```bash
cd ~
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

### 3.3 Install MySQL/MariaDB
```bash
sudo apt install -y mariadb-server mariadb-client
sudo mysql_secure_installation
```

### 3.4 Install Nginx
```bash
sudo apt install -y nginx
```

### 3.5 Install Git
```bash
sudo apt install -y git
```

## Step 4: Setup Database

### 4.1 Create Database and User
```bash
sudo mysql -u root -p
```

Then in MySQL:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'your_strong_password_here';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## Step 5: Clone Your Project

### 5.1 Create project directory
```bash
sudo mkdir -p /var/www/oweru-hardware
sudo chown -R $USER:$USER /var/www/oweru-hardware
```

### 5.2 Clone repository
```bash
cd /var/www
git clone https://github.com/yourusername/oweru-hardware.git oweru-hardware
# OR upload files via SFTP if not using Git
```

## Step 6: Configure Laravel

### 6.1 Install dependencies
```bash
cd /var/www/oweru-hardware
composer install --optimize-autoloader --no-dev
```

### 6.2 Create .env file
```bash
cp .env.example .env
nano .env
```

Update these values:
```env
APP_NAME="Oweru Hardware"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oweru_hardware
DB_USERNAME=oweru_user
DB_PASSWORD=your_strong_password_here

SELCOM_BASE_URL=https://apigw.selcommobile.com/v1
SELCOM_VENDOR_ID=your_vendor_id
SELCOM_API_KEY=your_api_key
SELCOM_API_SECRET=your_api_secret
SELCOM_RETURN_URL=https://yourdomain.com/checkout/success
SELCOM_CANCEL_URL=https://yourdomain.com/checkout/cancel
```

### 6.3 Generate application key
```bash
php artisan key:generate
```

### 6.4 Set permissions
```bash
sudo chown -R www-data:www-data /var/www/oweru-hardware
sudo chmod -R 755 /var/www/oweru-hardware
sudo chmod -R 775 /var/www/oweru-hardware/storage
sudo chmod -R 775 /var/www/oweru-hardware/bootstrap/cache
```

### 6.5 Run migrations
```bash
php artisan migrate --force
php artisan db:seed
```

### 6.6 Create storage link
```bash
php artisan storage:link
```

### 6.7 Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Step 7: Configure Nginx

### 7.1 Create Nginx configuration
```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

Add this configuration:
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/oweru-hardware/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 7.2 Enable site
```bash
sudo ln -s /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## Step 8: Setup SSL Certificate (Let's Encrypt)

### 8.1 Install Certbot
```bash
sudo apt install -y certbot python3-certbot-nginx
```

### 8.2 Get SSL certificate
```bash
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

Follow the prompts. Certbot will automatically configure Nginx.

## Step 9: Setup Cron Job for Laravel Scheduler

### 9.1 Edit crontab
```bash
crontab -e
```

### 9.2 Add Laravel scheduler
```
* * * * * cd /var/www/oweru-hardware && php artisan schedule:run >> /dev/null 2>&1
```

## Step 10: Configure Firewall

### 10.1 Setup UFW
```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw enable
```

## Step 11: Final Checks

### 11.1 Test application
- Visit `https://yourdomain.com`
- Check all routes work
- Test login/registration
- Test checkout process

### 11.2 Monitor logs
```bash
tail -f /var/www/oweru-hardware/storage/logs/laravel.log
tail -f /var/log/nginx/error.log
```

## Troubleshooting

### Permission Issues
```bash
sudo chown -R www-data:www-data /var/www/oweru-hardware
sudo chmod -R 755 /var/www/oweru-hardware
sudo chmod -R 775 storage bootstrap/cache
```

### Clear all caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Check PHP-FPM status
```bash
sudo systemctl status php8.2-fpm
sudo systemctl restart php8.2-fpm
```

### Check Nginx status
```bash
sudo systemctl status nginx
sudo systemctl restart nginx
```

## Environment Variables Checklist

Make sure these are set in your `.env`:
- ✅ `APP_ENV=production`
- ✅ `APP_DEBUG=false`
- ✅ `APP_URL=https://yourdomain.com`
- ✅ Database credentials
- ✅ Selcom API credentials
- ✅ All required Laravel settings

## Post-Deployment

1. **Test everything**
   - User registration
   - Login
   - Product browsing
   - Cart functionality
   - Checkout process
   - Payment gateway

2. **Setup backups**
   - Database backups (daily)
   - File backups (weekly)

3. **Monitor performance**
   - Check server resources
   - Monitor error logs
   - Setup uptime monitoring

## Quick Commands Reference

```bash
# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
sudo systemctl restart mysql

# Check logs
tail -f storage/logs/laravel.log
tail -f /var/log/nginx/error.log

# Update application
cd /var/www/oweru-hardware
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```


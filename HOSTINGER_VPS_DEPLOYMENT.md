# Hostinger VPS Deployment Guide

## 🚀 Quick Deployment Steps

### Step 1: Prepare Project Locally

1. **Ensure your code is ready:**
   ```bash
   # Build assets
   npm run build
   
   # Clear caches
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Create .env.example template** (if needed)

### Step 2: Connect to Hostinger VPS

**Via SSH:**
```bash
ssh root@your-vps-ip
# or use your Hostinger SSH credentials
```

**Via Hostinger Panel:**
- Go to VPS → File Manager (or use SFTP)
- Upload your project files

### Step 3: Initial Server Setup

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2 and extensions
sudo apt install -y php8.2 php8.2-cli php8.2-fpm php8.2-mysql \
    php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip \
    php8.2-gd php8.2-bcmath

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Install MySQL
sudo apt install -y mariadb-server mariadb-client
sudo mysql_secure_installation

# Install Nginx
sudo apt install -y nginx

# Install Git
sudo apt install -y git
```

### Step 4: Create Database

```bash
sudo mysql -u root -p
```

In MySQL:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 5: Deploy Application

**Option A: Using Git (Recommended)**
```bash
cd /var/www
sudo mkdir -p oweru-hardware
sudo chown -R $USER:$USER oweru-hardware
git clone https://github.com/yourusername/oweru-hardware.git oweru-hardware
cd oweru-hardware
```

**Option B: Upload via SFTP**
- Use FileZilla or Hostinger File Manager
- Upload all files to `/var/www/oweru-hardware`

### Step 6: Configure Laravel

```bash
cd /var/www/oweru-hardware

# Install dependencies
composer install --optimize-autoloader --no-dev

# Create .env file
cp .env.example .env
nano .env
```

**Update .env with:**
```env
APP_NAME="Oweru Hardware"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oweru_hardware
DB_USERNAME=oweru_user
DB_PASSWORD=StrongPassword123!

SELCOM_BASE_URL=https://apigw.selcommobile.com/v1
SELCOM_VENDOR_ID=your_vendor_id
SELCOM_API_KEY=your_api_key
SELCOM_API_SECRET=your_api_secret
SELCOM_RETURN_URL=https://yourdomain.com/checkout/success
SELCOM_CANCEL_URL=https://yourdomain.com/checkout/cancel
```

```bash
# Generate key
php artisan key:generate

# Set permissions
sudo chown -R www-data:www-data /var/www/oweru-hardware
sudo chmod -R 755 /var/www/oweru-hardware
sudo chmod -R 775 storage bootstrap/cache

# Run migrations
php artisan migrate --force
php artisan db:seed

# Create storage link
php artisan storage:link

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 7: Configure Nginx

Create config file:
```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

Paste this configuration:
```nginx
server {
    listen 80;
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
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Step 8: Setup SSL (Let's Encrypt)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

### Step 9: Setup Cron Job

```bash
crontab -e
```

Add:
```
* * * * * cd /var/www/oweru-hardware && php artisan schedule:run >> /dev/null 2>&1
```

### Step 10: Configure Firewall

```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw enable
```

## 🔧 Troubleshooting

### Check Logs
```bash
tail -f /var/www/oweru-hardware/storage/logs/laravel.log
tail -f /var/log/nginx/error.log
```

### Fix Permissions
```bash
sudo chown -R www-data:www-data /var/www/oweru-hardware
sudo chmod -R 755 /var/www/oweru-hardware
sudo chmod -R 775 storage bootstrap/cache
```

### Restart Services
```bash
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
sudo systemctl restart mariadb
```

## 📝 Post-Deployment Checklist

- [ ] Test homepage loads
- [ ] Test user registration
- [ ] Test login/logout
- [ ] Test product browsing
- [ ] Test cart functionality
- [ ] Test checkout process
- [ ] Test Selcom payment integration
- [ ] Verify SSL certificate is active
- [ ] Check all routes work correctly
- [ ] Monitor error logs

## 🔄 Updating Application

```bash
cd /var/www/oweru-hardware
git pull  # or upload new files
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📞 Need Help?

Common issues:
1. **500 Error** - Check file permissions and .env configuration
2. **Database Connection Error** - Verify MySQL credentials
3. **Permission Denied** - Run chmod/chown commands
4. **Nginx 404** - Verify document root points to `/public` folder


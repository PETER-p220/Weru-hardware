# 🚀 Quick Hostinger VPS Deployment Guide

## Prerequisites Checklist

Before starting, ensure you have:
- ✅ Hostinger VPS credentials (IP address, SSH username/password)
- ✅ Domain name pointing to your VPS IP
- ✅ Selcom API credentials ready
- ✅ All code ready and tested locally

## Step-by-Step Deployment

### 1️⃣ Connect to Your VPS

**Option A: SSH (Command Line)**
```bash
ssh root@your-vps-ip
# Enter password when prompted
```

**Option B: Hostinger Panel**
- Login to Hostinger → VPS → File Manager
- Or use SFTP client (FileZilla, WinSCP)

### 2️⃣ Install Required Software

Run these commands on your VPS:

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
sudo mysql_secure_installation  # Follow prompts

# Install Nginx
sudo apt install -y nginx

# Install Git
sudo apt install -y git
```

### 3️⃣ Create Database

```bash
sudo mysql -u root -p
```

Then in MySQL prompt:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'YourStrongPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**⚠️ Remember these credentials for your .env file!**

### 4️⃣ Upload Your Project

**Option A: Using Git (Recommended)**
```bash
cd /var/www
sudo mkdir -p oweru-hardware
sudo chown -R $USER:$USER oweru-hardware
git clone YOUR_REPO_URL oweru-hardware
cd oweru-hardware
```

**Option B: Using SFTP/File Manager**
1. Upload all files to `/var/www/oweru-hardware`
2. Use FileZilla, WinSCP, or Hostinger File Manager
3. **Don't upload**: `vendor/`, `node_modules/`, `.env`, `storage/logs/*`

### 5️⃣ Install Dependencies

```bash
cd /var/www/oweru-hardware
composer install --optimize-autoloader --no-dev
```

### 6️⃣ Configure Environment

```bash
# Create .env file
cp .env.example .env
nano .env
```

**Update these values in .env:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_DATABASE=oweru_hardware
DB_USERNAME=oweru_user
DB_PASSWORD=YourStrongPassword123!

SELCOM_VENDOR_ID=your_vendor_id
SELCOM_API_KEY=your_api_key
SELCOM_API_SECRET=your_secret
SELCOM_RETURN_URL=https://yourdomain.com/checkout/success
SELCOM_CANCEL_URL=https://yourdomain.com/checkout/cancel
```

Save: `Ctrl+X`, then `Y`, then `Enter`

### 7️⃣ Setup Laravel

```bash
# Generate app key
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

### 8️⃣ Configure Nginx

```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

**Paste this configuration:**
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

**Important:** Replace `yourdomain.com` with your actual domain!

Save and enable:
```bash
sudo ln -s /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/
sudo nginx -t  # Test configuration
sudo systemctl restart nginx
```

### 9️⃣ Setup SSL (HTTPS)

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

Follow the prompts. This will automatically configure HTTPS.

### 🔟 Setup Cron Job

```bash
crontab -e
```

Add this line:
```
* * * * * cd /var/www/oweru-hardware && php artisan schedule:run >> /dev/null 2>&1
```

### 1️⃣1️⃣ Configure Firewall

```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw enable
```

## ✅ Test Your Deployment

1. Visit `https://yourdomain.com` in your browser
2. Test registration
3. Test login
4. Test product browsing
5. Test checkout
6. Test payment

## 🐛 Troubleshooting

**500 Error?**
```bash
tail -f /var/www/oweru-hardware/storage/logs/laravel.log
tail -f /var/log/nginx/error.log
```

**Permission Issues?**
```bash
sudo chown -R www-data:www-data /var/www/oweru-hardware
sudo chmod -R 775 storage bootstrap/cache
```

**Clear All Caches:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📝 Important Notes

1. **Replace `yourdomain.com`** with your actual domain name
2. **Update .env** with your actual database credentials
3. **Set strong passwords** for database and application
4. **Keep backups** of your database regularly
5. **Monitor logs** regularly: `tail -f storage/logs/laravel.log`

## 🔄 Updating Your Application

After making changes:
```bash
cd /var/www/oweru-hardware
git pull  # or upload new files
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

**Need help?** Check the detailed guides:
- `HOSTINGER_VPS_DEPLOYMENT.md` - Full detailed guide
- `DEPLOYMENT_CHECKLIST.md` - Step-by-step checklist


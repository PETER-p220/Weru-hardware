# 🚀 Hostinger VPS Deployment Checklist

## Pre-Deployment (Local Machine)

### ✅ Code Preparation
- [ ] All code is committed to Git (or ready to upload)
- [ ] Build assets: `npm run build`
- [ ] Test application locally works correctly
- [ ] Database migrations tested
- [ ] All features tested (registration, login, checkout, payment)

### ✅ Files to Upload
- [ ] All project files (except `vendor/`, `node_modules/`, `.env`)
- [ ] OR Git repository URL ready

## On Hostinger VPS

### ✅ Step 1: Server Setup
- [ ] SSH access configured
- [ ] System updated: `sudo apt update && sudo apt upgrade -y`
- [ ] PHP 8.2+ installed with required extensions
- [ ] Composer installed
- [ ] MySQL/MariaDB installed and configured
- [ ] Nginx installed
- [ ] Git installed (if using Git deployment)

### ✅ Step 2: Database Setup
- [ ] Database created: `oweru_hardware`
- [ ] Database user created with password
- [ ] User has all privileges on database
- [ ] Database credentials saved securely

### ✅ Step 3: Application Deployment
- [ ] Project files uploaded to `/var/www/oweru-hardware`
- [ ] OR Git repository cloned to `/var/www/oweru-hardware`
- [ ] Composer dependencies installed: `composer install --no-dev`
- [ ] `.env` file created and configured
- [ ] Application key generated: `php artisan key:generate`
- [ ] File permissions set correctly
- [ ] Storage symlink created: `php artisan storage:link`

### ✅ Step 4: Database Migration
- [ ] Migrations run: `php artisan migrate --force`
- [ ] Seeders run: `php artisan db:seed`
- [ ] Verify roles table has `admin` and `user` roles
- [ ] Test database connection

### ✅ Step 5: Nginx Configuration
- [ ] Nginx config file created at `/etc/nginx/sites-available/oweru-hardware`
- [ ] Document root set to `/var/www/oweru-hardware/public`
- [ ] PHP-FPM configured correctly
- [ ] Site enabled: `sudo ln -s /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/`
- [ ] Nginx config tested: `sudo nginx -t`
- [ ] Nginx restarted: `sudo systemctl restart nginx`

### ✅ Step 6: SSL Certificate
- [ ] Domain name points to VPS IP address
- [ ] Certbot installed
- [ ] SSL certificate obtained: `sudo certbot --nginx -d yourdomain.com`
- [ ] HTTPS working correctly

### ✅ Step 7: Optimization
- [ ] Config cached: `php artisan config:cache`
- [ ] Routes cached: `php artisan route:cache`
- [ ] Views cached: `php artisan view:cache`

### ✅ Step 8: Cron Job
- [ ] Cron job added for Laravel scheduler
- [ ] Cron job tested

### ✅ Step 9: Security
- [ ] Firewall configured (UFW)
- [ ] Only necessary ports open (80, 443, 22)
- [ ] `.env` file has secure passwords
- [ ] `APP_DEBUG=false` in production
- [ ] File permissions correct

## Testing After Deployment

### ✅ Functionality Tests
- [ ] Homepage loads correctly
- [ ] User registration works
- [ ] User login works
- [ ] Products page loads
- [ ] Cart functionality works
- [ ] Checkout process works
- [ ] Payment gateway integration works
- [ ] Admin dashboard accessible (for admin users)
- [ ] User dashboard accessible (for regular users)

### ✅ Performance Tests
- [ ] Pages load quickly
- [ ] Images load correctly
- [ ] No console errors
- [ ] Mobile responsive design works

## Post-Deployment

### ✅ Monitoring
- [ ] Error logs checked: `tail -f storage/logs/laravel.log`
- [ ] Nginx logs checked: `tail -f /var/log/nginx/error.log`
- [ ] Server resources monitored

### ✅ Backup Setup
- [ ] Database backup strategy in place
- [ ] File backup strategy in place
- [ ] Backup scripts tested

## Quick Commands Reference

```bash
# Connect to VPS
ssh root@your-vps-ip

# Navigate to project
cd /var/www/oweru-hardware

# Install dependencies
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Set permissions
sudo chown -R www-data:www-data /var/www/oweru-hardware
sudo chmod -R 775 storage bootstrap/cache

# Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

## Environment Variables Needed in .env

```env
APP_NAME="Oweru Hardware"
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oweru_hardware
DB_USERNAME=oweru_user
DB_PASSWORD=your_password

SELCOM_BASE_URL=https://apigw.selcommobile.com/v1
SELCOM_VENDOR_ID=your_vendor_id
SELCOM_API_KEY=your_api_key
SELCOM_API_SECRET=your_secret
SELCOM_RETURN_URL=https://yourdomain.com/checkout/success
SELCOM_CANCEL_URL=https://yourdomain.com/checkout/cancel
```


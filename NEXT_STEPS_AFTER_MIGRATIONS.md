# Next Steps After Migrations - Complete Guide

## ✅ What You've Completed
- ✅ Database created and configured
- ✅ Migrations run successfully
- ✅ All tables created

## 🔄 Next Steps (In Order)

### Step 1: Complete Laravel Setup

If you haven't done these yet, run them now:

```bash
cd /var/www/Weru-hardware

# 1. Seed database (creates roles and admin user)
php artisan db:seed

# 2. Create storage link (for file uploads)
php artisan storage:link

# 3. Set file permissions
sudo chown -R www-data:www-data /var/www/Weru-hardware
sudo chmod -R 755 /var/www/Weru-hardware
sudo chmod -R 775 storage bootstrap/cache

# 4. Update .env with your domain
nano .env
# Set: APP_URL=http://oweru.com

# 5. Optimize Laravel
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Default Admin Login (created by seeder):**
- Email: `admin@oweruhardware.com`
- Password: `admin123`

---

### Step 2: Install Nginx (if not installed)

```bash
sudo apt update
sudo apt install -y nginx
sudo systemctl start nginx
sudo systemctl enable nginx
```

---

### Step 3: Configure Nginx for Your Laravel App

Create Nginx configuration file:

```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

**Paste this configuration:**

```nginx
server {
    listen 80;
    server_name oweru.com www.oweru.com;
    root /var/www/Weru-hardware/public;

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

**Save:** `Ctrl+X`, then `Y`, then `Enter`

Enable the site:

```bash
# Remove default site (optional)
sudo rm /etc/nginx/sites-enabled/default

# Enable your site
sudo ln -s /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/

# Test Nginx configuration
sudo nginx -t

# If test passes, restart Nginx
sudo systemctl restart nginx
```

---

### Step 4: Point Your Domain to Server

**In your domain registrar (where you bought oweru.com):**

1. Go to DNS settings
2. Add/Update A Record:
   - **Type:** A
   - **Name:** @ (or blank)
   - **Value:** Your server IP address
   - **TTL:** 3600 (or Auto)

3. Add/Update CNAME for www:
   - **Type:** CNAME
   - **Name:** www
   - **Value:** oweru.com
   - **TTL:** 3600 (or Auto)

**To find your server IP:**
```bash
curl ifconfig.me
```

**Wait 5-15 minutes** for DNS to propagate.

**Test DNS:**
```bash
ping oweru.com
# Should show your server IP
```

---

### Step 5: Set Up SSL Certificate (HTTPS)

After your domain is pointing to the server:

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Get SSL certificate (replace with your email)
sudo certbot --nginx -d oweru.com -d www.oweru.com

# Follow the prompts:
# - Enter your email
# - Agree to terms
# - Choose whether to redirect HTTP to HTTPS (recommended: Yes)
```

Certbot will automatically:
- Get SSL certificate
- Update Nginx configuration
- Set up auto-renewal

**Test auto-renewal:**
```bash
sudo certbot renew --dry-run
```

---

### Step 6: Update .env for HTTPS

After SSL is set up:

```bash
nano .env
```

Change:
```env
APP_URL=https://oweru.com
```

Then:
```bash
php artisan config:clear
php artisan config:cache
```

---

### Step 7: Test Your Application

1. **Visit your website:**
   - `http://oweru.com` (should redirect to HTTPS)
   - `https://oweru.com` (should work)

2. **Test admin login:**
   - Go to: `https://oweru.com/login`
   - Email: `admin@oweruhardware.com`
   - Password: `admin123`

3. **Check features:**
   - Browse products
   - Add to cart
   - Checkout process
   - Admin dashboard

---

### Step 8: Configure Selcom (Payment Gateway)

If you have Selcom credentials:

```bash
nano .env
```

Add/Update:
```env
SELCOM_BASE_URL=https://apigw.selcommobile.com/v1
SELCOM_VENDOR_ID=your_vendor_id
SELCOM_API_KEY=your_api_key
SELCOM_API_SECRET=your_api_secret
SELCOM_RETURN_URL=https://oweru.com/checkout/success
SELCOM_CANCEL_URL=https://oweru.com/checkout/cancel
```

Then:
```bash
php artisan config:clear
php artisan config:cache
```

---

## 🎯 Quick Checklist

- [ ] Run `php artisan db:seed`
- [ ] Run `php artisan storage:link`
- [ ] Set file permissions
- [ ] Update `.env` with `APP_URL=http://oweru.com`
- [ ] Install Nginx (if needed)
- [ ] Create Nginx configuration file
- [ ] Enable Nginx site
- [ ] Point domain DNS to server IP
- [ ] Set up SSL certificate
- [ ] Update `.env` to HTTPS
- [ ] Test website
- [ ] Configure Selcom (optional)

---

## 🆘 Troubleshooting

**If website doesn't load:**
```bash
# Check Nginx status
sudo systemctl status nginx

# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Check Nginx error logs
sudo tail -f /var/log/nginx/error.log

# Check Laravel logs
tail -f storage/logs/laravel.log
```

**If you get 502 Bad Gateway:**
```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Check PHP-FPM socket
ls -la /var/run/php/php8.2-fpm.sock
```

**If you get 500 Internal Server Error:**
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check file permissions
ls -la storage bootstrap/cache
```

---

## 📝 Summary

After migrations, you need to:
1. ✅ Complete Laravel setup (seed, storage, permissions)
2. ✅ Configure Nginx web server
3. ✅ Point domain DNS to server
4. ✅ Set up SSL/HTTPS
5. ✅ Test everything works
6. ✅ Configure Selcom payment gateway

Start with Step 1 and work through each step!


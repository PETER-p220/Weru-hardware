# Fix Nginx SSL Configuration Error

## ✅ Great News!
- DNS is now correct: `31.97.176.48` ✓
- SSL Certificate obtained successfully ✓
- Certificate saved to: `/etc/letsencrypt/live/oweru.com/` ✓

## ❌ Problem
Nginx can't restart because of configuration error:
- Error: `no "ssl_certificate" is defined for the "listen ... quic" directive`
- Certificate was deployed to wrong config file: `default.conf`
- Need to configure correct site file

---

## Step-by-Step Fix

### Step 1: Check Current Nginx Configuration

```bash
# Check what site is enabled
ls -la /etc/nginx/sites-enabled/

# Check Nginx error
sudo nginx -t
```

### Step 2: Check Your Site Configuration

```bash
# View your site config
sudo cat /etc/nginx/sites-available/oweru-hardware

# Check if it exists
ls -la /etc/nginx/sites-available/
```

### Step 3: Remove/Disable Default Site (If Problematic)

The certificate was installed to `default.conf`. Let's check:

```bash
# View default config
sudo cat /etc/nginx/sites-enabled/default.conf

# If it has errors, disable it temporarily
sudo mv /etc/nginx/sites-enabled/default.conf /etc/nginx/sites-enabled/default.conf.bak
```

### Step 4: Update Your Site Configuration

Let's update your `oweru-hardware` site configuration:

```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

Replace the entire content with this:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name oweru.com www.oweru.com;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name oweru.com www.oweru.com;
    root /var/www/Weru-hardware/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/oweru.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/oweru.com/privkey.pem;
    ssl_trusted_certificate /etc/letsencrypt/live/oweru.com/chain.pem;

    # SSL Settings
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES256-GCM-SHA384;

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

### Step 5: Enable Your Site

```bash
# Remove default if it exists
sudo rm -f /etc/nginx/sites-enabled/default
sudo rm -f /etc/nginx/sites-enabled/default.conf

# Enable your site
sudo ln -sf /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/

# Remove any duplicates
sudo ls -la /etc/nginx/sites-enabled/
```

### Step 6: Test Nginx Configuration

```bash
sudo nginx -t
```

**Should show:** `syntax is ok` and `test is successful`

### Step 7: Restart Nginx

```bash
sudo systemctl restart nginx
sudo systemctl status nginx
```

Should show: `active (running)`

---

## Alternative: Quick Fix (Remove QUIC/HTTP3)

If you want a simpler config without HTTP3, use this:

```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

Use the config above (it doesn't include QUIC, which is causing the error).

---

## Verify SSL is Working

After restarting Nginx:

1. **Check Nginx status:**
   ```bash
   sudo systemctl status nginx
   ```

2. **Test HTTPS:**
   ```bash
   curl -I https://oweru.com
   ```

3. **Visit in browser:**
   - `https://oweru.com`
   - Should show padlock icon 🔒

---

## Update .env for HTTPS

```bash
cd /var/www/Weru-hardware
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

## Quick Fix Commands (Copy-Paste)

```bash
# 1. Disable problematic default config
sudo mv /etc/nginx/sites-enabled/default.conf /etc/nginx/sites-enabled/default.conf.bak 2>/dev/null
sudo rm -f /etc/nginx/sites-enabled/default

# 2. Update your site config (see above for full config)
sudo nano /etc/nginx/sites-available/oweru-hardware

# 3. Enable your site
sudo ln -sf /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/

# 4. Test config
sudo nginx -t

# 5. Restart Nginx
sudo systemctl restart nginx

# 6. Check status
sudo systemctl status nginx

# 7. Update .env
cd /var/www/Weru-hardware
nano .env  # Change APP_URL to https://oweru.com
php artisan config:clear
php artisan config:cache
```

---

## The Main Issue

The error is about QUIC/HTTP3 listener without SSL certificate. The config above removes QUIC (which is optional) and uses standard HTTP2 with SSL, which is what you need.

**Run the steps above to fix it!**


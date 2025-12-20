# Complete Fix for Certbot SSL Error

## Problem: DNS Still Shows Wrong IP

The error shows your domain is still pointing to `84.32.84.32` instead of `31.97.176.48`.

---

## Step-by-Step Fix

### Step 1: Verify DNS from Your Server

First, let's check what DNS is actually showing:

```bash
# Check DNS resolution
nslookup oweru.com

# Or use dig (if installed)
dig oweru.com +short

# Check both domains
nslookup www.oweru.com
```

**Expected result:** Should show `31.97.176.48`

**If it still shows `84.32.84.32`:**
- DNS hasn't updated yet (wait longer, can take up to 48 hours)
- DNS record wasn't actually changed
- DNS cache needs to clear

---

### Step 2: Check DNS Update Status

**Test from multiple locations:**

```bash
# From your VPS
curl -I http://oweru.com

# Check what IP it resolves to
curl -v http://oweru.com 2>&1 | grep "Connected to"
```

**Or use online DNS checker:**
- Visit: https://dnschecker.org
- Enter: `oweru.com`
- Select: `A Record`
- Check if it shows `31.97.176.48` globally

---

### Step 3: Verify Nginx is Configured

While DNS is updating, let's make sure Nginx is properly set up:

```bash
# Check Nginx is running
sudo systemctl status nginx

# Check Nginx configuration
sudo nginx -t

# Check if site is enabled
ls -la /etc/nginx/sites-enabled/

# View Nginx config
sudo cat /etc/nginx/sites-available/oweru-hardware
```

---

### Step 4: Ensure Nginx Config is Correct

Make sure your Nginx config is correct:

```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

**Should look like this:**

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

**Important:**
- `server_name` must have both `oweru.com` and `www.oweru.com`
- `root` must point to `/var/www/Weru-hardware/public`
- Port 80 must be listening

Save and test:

```bash
sudo nginx -t
sudo systemctl restart nginx
```

---

### Step 5: Check File Permissions

```bash
cd /var/www/Weru-hardware

# Set correct ownership
sudo chown -R www-data:www-data .

# Set correct permissions
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache

# Verify Laravel can write
sudo -u www-data php artisan config:clear
```

---

### Step 6: Check Laravel Application

```bash
cd /var/www/Weru-hardware

# Check .env file
cat .env | grep APP_URL

# Test Laravel works locally
curl -I http://localhost

# Check Laravel logs
tail -f storage/logs/laravel.log
```

---

### Step 7: Test Direct IP Access

Test if your server responds via direct IP:

```bash
# From your VPS
curl -I http://31.97.176.48

# Should return HTTP 200 or similar
```

**From your computer:**
- Try: `http://31.97.176.48`
- Should show your Laravel application

---

### Step 8: Wait for DNS to Update

If DNS still shows wrong IP:

1. **Double-check DNS panel:**
   - Make sure A record for `@` points to `31.97.176.48`
   - Make sure old record pointing to `84.32.84.32` is deleted

2. **Wait longer:**
   - DNS can take 5 minutes to 48 hours
   - Usually takes 15-30 minutes

3. **Flush DNS cache (on your computer):**
   ```cmd
   # Windows
   ipconfig /flushdns
   
   # Then test
   nslookup oweru.com
   ```

---

### Step 9: Verify DNS Before Retrying Certbot

**Only retry Certbot after DNS shows correct IP:**

```bash
# Check DNS first
nslookup oweru.com
# Must show: 31.97.176.48

# Test domain is accessible
curl -I http://oweru.com
# Should return HTTP response

# Then retry Certbot
sudo certbot --nginx -d oweru.com -d www.oweru.com
```

---

## Quick Diagnostic Script

Run this to check everything:

```bash
echo "=== Checking DNS ==="
nslookup oweru.com
echo ""
echo "=== Checking Nginx ==="
sudo systemctl status nginx | head -5
echo ""
echo "=== Checking Nginx Config ==="
sudo nginx -t
echo ""
echo "=== Checking PHP-FPM ==="
sudo systemctl status php8.2-fpm | head -5
echo ""
echo "=== Checking Port 80 ==="
sudo netstat -tulpn | grep :80
echo ""
echo "=== Testing Localhost ==="
curl -I http://localhost 2>&1 | head -5
echo ""
echo "=== Checking Laravel ==="
cd /var/www/Weru-hardware && php artisan --version
```

---

## Immediate Actions

### Action 1: Check DNS Status

```bash
nslookup oweru.com
```

**If it shows `84.32.84.32`:**
- Go back to DNS panel
- Verify the A record is changed
- Wait 15-30 minutes
- Check again

**If it shows `31.97.176.48`:**
- DNS is correct!
- Continue to Action 2

### Action 2: Verify Nginx

```bash
sudo nginx -t
sudo systemctl restart nginx
```

### Action 3: Test Locally

```bash
curl -I http://localhost
```

Should return HTTP 200 or similar.

---

## Temporary Workaround: Use Direct IP

While waiting for DNS, you can test your server works:

```bash
# Test direct IP access
curl http://31.97.176.48
```

If this works, your server is fine - just waiting for DNS.

---

## Most Likely Issue

The DNS is still pointing to `84.32.84.32`. 

**Do this NOW:**

1. **Check DNS panel again** - Verify A record shows `31.97.176.48`
2. **Delete old record** - If there's still one pointing to `84.32.84.32`, delete it
3. **Wait 15-30 minutes** - DNS propagation takes time
4. **Verify:** `nslookup oweru.com` should show `31.97.176.48`
5. **Then retry Certbot**

---

## After DNS is Fixed

Once DNS shows `31.97.176.48`:

```bash
# Verify DNS first
nslookup oweru.com
# Should show: 31.97.176.48

# Then retry Certbot
sudo certbot --nginx -d oweru.com -d www.oweru.com
```

The error message clearly shows DNS is still pointing to wrong IP. Fix DNS first!


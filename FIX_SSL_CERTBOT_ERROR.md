# Fix Certbot SSL Certificate Error

## Problem Identified

Certbot failed because:
1. **DNS is still pointing to wrong IP:** `84.32.84.32` (should be `31.97.176.48`)
2. **Nginx returning 500 errors** - Domain not properly configured

---

## Fix Steps (In Order)

### Step 1: Fix DNS Records (CRITICAL - Do This First!)

Your domain DNS is still pointing to `84.32.84.32` instead of your server IP `31.97.176.48`.

**Go to your DNS management panel and:**

1. **Find the A record** for `oweru.com`
2. **Change "Points to"** from `84.32.84.32` to `31.97.176.48`
3. **Save the record**
4. **Add/Update www record:**
   - Type: `A`
   - Name: `www`
   - Points to: `31.97.176.48`
   - Save

5. **Wait 5-15 minutes** for DNS to propagate

6. **Verify DNS is fixed:**
   ```bash
   nslookup oweru.com
   # Should show: 31.97.176.48 (NOT 84.32.84.32)
   ```

---

### Step 2: Check Nginx Configuration

Before running Certbot, make sure Nginx is properly configured:

```bash
# Check if Nginx is running
sudo systemctl status nginx

# Check Nginx configuration
sudo nginx -t

# Check if site is enabled
ls -la /etc/nginx/sites-enabled/
```

---

### Step 3: Verify Nginx Site Configuration

Check your Nginx configuration:

```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

**Make sure it looks like this:**

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
- Make sure `server_name` has both `oweru.com` and `www.oweru.com`
- Make sure `root` points to `/var/www/Weru-hardware/public`

Save and test:

```bash
sudo nginx -t
sudo systemctl restart nginx
```

---

### Step 4: Check File Permissions

Make sure Laravel files have correct permissions:

```bash
cd /var/www/Weru-hardware
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache
```

---

### Step 5: Check Laravel Application

Make sure Laravel is set up correctly:

```bash
cd /var/www/Weru-hardware

# Check .env file
cat .env | grep APP_URL
# Should show: APP_URL=http://oweru.com

# Check if storage link exists
ls -la public/storage

# Check Laravel logs for errors
tail -f storage/logs/laravel.log
```

---

### Step 6: Test Direct IP Access

Before trying Certbot again, test if your server responds:

```bash
# From your VPS, test localhost
curl -I http://localhost

# Should return HTTP 200 or similar
```

**From your computer, test direct IP:**
```
http://31.97.176.48
```

This should show your Laravel application (even if it shows HTTP, that's OK).

---

### Step 7: Verify Domain is Accessible

After DNS propagates (wait 5-15 minutes after fixing DNS):

**Test from your computer:**
```cmd
nslookup oweru.com
# Should show: 31.97.176.48

curl http://oweru.com
# Should return HTML content
```

**Or use online tool:**
- Visit: https://dnschecker.org
- Enter: `oweru.com`
- Should show: `31.97.176.48` in multiple locations

---

### Step 8: Retry Certbot (After DNS is Fixed)

**Only after DNS shows correct IP (`31.97.176.48`), try again:**

```bash
sudo certbot --nginx -d oweru.com -d www.oweru.com
```

---

## Quick Diagnostic Commands

Run these to check everything:

```bash
# 1. Check DNS from server
nslookup oweru.com

# 2. Check Nginx status
sudo systemctl status nginx

# 3. Check PHP-FPM status
sudo systemctl status php8.2-fpm

# 4. Test Nginx config
sudo nginx -t

# 5. Check if port 80 is listening
sudo netstat -tulpn | grep :80

# 6. Test localhost response
curl -I http://localhost

# 7. Check Laravel logs
tail -n 50 storage/logs/laravel.log
```

---

## Common Issues & Solutions

### Issue 1: DNS Still Shows Wrong IP

**Solution:** 
- Go to DNS panel
- Update A record to `31.97.176.48`
- Wait 15 minutes
- Verify with `nslookup oweru.com`

### Issue 2: Nginx Not Running

**Solution:**
```bash
sudo systemctl start nginx
sudo systemctl enable nginx
```

### Issue 3: PHP-FPM Not Running

**Solution:**
```bash
sudo systemctl start php8.2-fpm
sudo systemctl enable php8.2-fpm
```

### Issue 4: File Permissions Wrong

**Solution:**
```bash
cd /var/www/Weru-hardware
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache
```

### Issue 5: Nginx Site Not Enabled

**Solution:**
```bash
sudo ln -s /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

## Priority Actions (Do These First!)

1. ✅ **Fix DNS** - Change IP from `84.32.84.32` to `31.97.176.48`
2. ✅ **Wait 15 minutes** for DNS propagation
3. ✅ **Verify DNS** - `nslookup oweru.com` should show `31.97.176.48`
4. ✅ **Check Nginx** - Make sure it's running and configured
5. ✅ **Test domain** - `curl http://oweru.com` should work
6. ✅ **Retry Certbot** - Only after DNS is fixed

---

## Most Important Step

**FIX YOUR DNS FIRST!** 

The domain must point to `31.97.176.48` before Certbot can work.

Go to your DNS panel now and update the A record!


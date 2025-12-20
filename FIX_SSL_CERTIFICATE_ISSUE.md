# Fix SSL Certificate Issue - Self-Signed Certificate

## Problem

Nginx is using a self-signed certificate instead of the Let's Encrypt certificate we just obtained.

---

## Step 1: Check Current Nginx Configuration

Let's see what Nginx configuration is active:

```bash
# Check what sites are enabled
ls -la /etc/nginx/sites-enabled/

# Check your site configuration
sudo cat /etc/nginx/sites-available/oweru-hardware

# Check if default.conf exists
sudo cat /etc/nginx/sites-enabled/default.conf 2>/dev/null
```

---

## Step 2: Verify SSL Certificate Files Exist

```bash
# Check Let's Encrypt certificate files
sudo ls -la /etc/letsencrypt/live/oweru.com/

# Should show:
# - cert.pem
# - chain.pem
# - fullchain.pem
# - privkey.pem
```

---

## Step 3: Check Which Config is Serving oweru.com

The issue might be that a different config file is being used. Let's check:

```bash
# Check all enabled sites
sudo grep -r "server_name.*oweru.com" /etc/nginx/sites-enabled/

# Check which config has SSL
sudo grep -r "ssl_certificate" /etc/nginx/sites-enabled/
```

---

## Step 4: Update Your Site Configuration

Let's make sure your site config is correct:

```bash
sudo nano /etc/nginx/sites-available/oweru-hardware
```

**Make sure it has this exact SSL configuration:**

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name oweru.com www.oweru.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name oweru.com www.oweru.com;
    root /var/www/Weru-hardware/public;

    # SSL Configuration - MUST point to Let's Encrypt
    ssl_certificate /etc/letsencrypt/live/oweru.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/oweru.com/privkey.pem;

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

**Important:** Make sure the SSL certificate paths are:
- `ssl_certificate /etc/letsencrypt/live/oweru.com/fullchain.pem;`
- `ssl_certificate_key /etc/letsencrypt/live/oweru.com/privkey.pem;`

**NOT** any self-signed certificate paths!

---

## Step 5: Disable Any Conflicting Configs

If there's a default.conf that's interfering:

```bash
# Check if default.conf exists and has oweru.com
sudo grep -r "oweru.com" /etc/nginx/sites-enabled/

# If default.conf has oweru.com, disable it
sudo mv /etc/nginx/sites-enabled/default.conf /etc/nginx/sites-enabled/default.conf.bak 2>/dev/null
```

---

## Step 6: Make Sure Your Site is Enabled

```bash
# Check if symlink exists
ls -la /etc/nginx/sites-enabled/ | grep oweru

# If not, create it
sudo ln -sf /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/
```

---

## Step 7: Test and Restart

```bash
# Test configuration
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx

# Check status
sudo systemctl status nginx | head -10
```

---

## Step 8: Test SSL Certificate

```bash
# Test with curl (ignore self-signed warning for now)
curl -I -k https://oweru.com

# Check which certificate is being used
openssl s_client -connect oweru.com:443 -servername oweru.com </dev/null 2>/dev/null | openssl x509 -noout -subject -issuer
```

Should show Let's Encrypt issuer, not self-signed.

---

## Quick Diagnostic Commands

Run these to see what's happening:

```bash
echo "=== Checking enabled sites ==="
ls -la /etc/nginx/sites-enabled/

echo ""
echo "=== Checking for oweru.com in configs ==="
sudo grep -r "server_name.*oweru.com" /etc/nginx/sites-enabled/

echo ""
echo "=== Checking SSL certificate paths ==="
sudo grep -r "ssl_certificate" /etc/nginx/sites-enabled/

echo ""
echo "=== Checking Let's Encrypt certs ==="
sudo ls -la /etc/letsencrypt/live/oweru.com/
```

---

## Most Likely Issue

The problem is probably:
1. **default.conf** is still active and has a self-signed certificate
2. Or your site config is pointing to wrong certificate path
3. Or another config file is overriding your settings

**Let's check what's actually serving the site!**


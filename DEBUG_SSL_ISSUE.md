# Debug SSL Certificate Issue

## Problem

Nginx is still serving a self-signed certificate instead of Let's Encrypt certificate.

---

## Step 1: Check What Config is Actually Being Used

```bash
# Check what Nginx is actually using
sudo nginx -T | grep -A 15 "server_name.*oweru.com"

# This shows the ACTIVE configuration Nginx is using
```

---

## Step 2: Verify Your Config File Has SSL

```bash
# Check what's in your config file
sudo cat /etc/nginx/sites-available/oweru-hardware

# Or check SSL paths specifically
sudo grep -A 3 "ssl_certificate" /etc/nginx/sites-available/oweru-hardware
```

---

## Step 3: Check Certificate Files Exist

```bash
# Verify Let's Encrypt certificates exist and are readable
sudo ls -la /etc/letsencrypt/live/oweru.com/
sudo cat /etc/letsencrypt/live/oweru.com/fullchain.pem | head -5
```

---

## Step 4: Check Which Config is Handling Port 443

```bash
# See all SSL configurations
sudo nginx -T | grep -B 5 -A 10 "listen.*443"

# Check which one has oweru.com
sudo nginx -T | grep -B 10 "server_name.*oweru.com" | grep -A 10 "listen.*443"
```

---

## Most Likely Issue

Your config file might not have been saved correctly, or Nginx is using a different config. Let's check!


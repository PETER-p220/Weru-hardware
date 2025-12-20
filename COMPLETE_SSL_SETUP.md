# Complete SSL Setup - Final Steps

## ✅ Current Status

- DNS is correct: `31.97.176.48` ✓
- SSL Certificate obtained ✓
- Nginx configuration test passed ✓

The warnings about other SSL certificates are harmless - they're just for other sites.

---

## Step 1: Restart Nginx

```bash
sudo systemctl restart nginx
```

Check status:
```bash
sudo systemctl status nginx
```

Should show: `active (running)`

---

## Step 2: Test HTTPS Works

```bash
# Test HTTPS connection
curl -I https://oweru.com

# Should return HTTP 200 or similar
```

---

## Step 3: Update .env for HTTPS

```bash
cd /var/www/Weru-hardware
nano .env
```

Find this line:
```env
APP_URL=http://oweru.com
```

Change to:
```env
APP_URL=https://oweru.com
```

Save: `Ctrl+X`, then `Y`, then `Enter`

---

## Step 4: Clear and Rebuild Config Cache

```bash
cd /var/www/Weru-hardware
php artisan config:clear
php artisan config:cache
```

---

## Step 5: Verify Everything Works

### Test from Browser:
1. Visit: `https://oweru.com`
2. Should see padlock icon 🔒
3. Should load your Laravel application

### Test Admin Login:
1. Visit: `https://oweru.com/login`
2. Email: `admin@oweruhardware.com`
3. Password: `admin123`

---

## Quick Command Sequence

Copy and paste all at once:

```bash
# 1. Restart Nginx
sudo systemctl restart nginx

# 2. Check status
sudo systemctl status nginx | head -5

# 3. Test HTTPS
curl -I https://oweru.com

# 4. Update .env
cd /var/www/Weru-hardware
sed -i 's|APP_URL=http://oweru.com|APP_URL=https://oweru.com|g' .env

# 5. Verify .env change
grep APP_URL .env

# 6. Clear and rebuild cache
php artisan config:clear
php artisan config:cache

echo "✅ Setup complete! Visit https://oweru.com"
```

---

## What Those Warnings Mean

The warnings you saw:
- `ssl_stapling ignored, issuer certificate not found for certificate "/etc/nginx/ssl-certificates/oweruhardware.shop.crt"`
- `ssl_stapling ignored, no OCSP responder URL in the certificate "/etc/nginx/ssl-certificates/www.api.oweru.com.crt"`

These are just warnings about OTHER SSL certificates on your server (for other domains). They don't affect your `oweru.com` certificate. You can safely ignore them.

---

## After Everything Works

1. ✅ Visit `https://oweru.com` in your browser
2. ✅ Should show padlock 🔒 (SSL working)
3. ✅ Test admin login
4. ✅ Test all features of your application

---

## Troubleshooting

### If Nginx doesn't restart:

```bash
# Check error logs
sudo tail -f /var/log/nginx/error.log

# Check configuration again
sudo nginx -t
```

### If HTTPS doesn't work:

```bash
# Check certificate files exist
sudo ls -la /etc/letsencrypt/live/oweru.com/

# Check Nginx is listening on port 443
sudo netstat -tulpn | grep :443
```

### If you get SSL errors:

```bash
# Check certificate
sudo certbot certificates

# Renew if needed (should be automatic)
sudo certbot renew --dry-run
```

---

## Success Checklist

- [ ] Nginx restarted successfully
- [ ] HTTPS works: `curl -I https://oweru.com`
- [ ] .env updated to HTTPS
- [ ] Config cache cleared and rebuilt
- [ ] Website loads with padlock 🔒
- [ ] Admin login works

**You're almost done! Just restart Nginx and update .env!**


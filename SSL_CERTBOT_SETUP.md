# SSL Certificate Setup with Certbot

## Current Step: Enter Email Address

You're being prompted to enter an email address. This is required for:
- **Certificate renewal reminders** (Let's Encrypt certificates expire every 90 days)
- **Security notices** (if there are any issues)
- **Urgent renewal alerts**

---

## What to Do Now

### Step 1: Enter Your Email

At the prompt, type your email address and press Enter:

```
your-email@example.com
```

**Example:**
```
admin@oweru.com
```

**Press Enter after typing**

---

## What Happens Next

After you enter your email, Certbot will:

1. **Ask you to agree to terms of service:**
   ```
   (A)gree/(C)ancel: A
   ```
   Type `A` and press Enter

2. **Ask if you want to share email with EFF:**
   ```
   (Y)es/(N)o: N
   ```
   Type `Y` (yes) or `N` (no) - your choice

3. **Automatically:**
   - Verify your domain ownership
   - Get SSL certificate from Let's Encrypt
   - Configure Nginx for HTTPS
   - Set up auto-renewal

4. **Ask if you want to redirect HTTP to HTTPS:**
   ```
   1: No redirect
   2: Redirect HTTP to HTTPS
   ```
   **Choose option 2** (recommended for security)

---

## Complete Certbot Process

Here's what the full process looks like:

```bash
# You're here now:
Enter email address: your-email@example.com

# Next:
Please read the Terms of Service at...
(A)gree/(C)ancel: A

# Then:
Would you like to share your email address with the Electronic Frontier Foundation?
(Y)es/(N)o: N

# Then it will verify domain and get certificate...

# Finally:
Please choose whether or not to redirect HTTP traffic to HTTPS
1: No redirect
2: Redirect HTTP to HTTPS
Select the appropriate number [1-2] then [enter]: 2

# Success message:
Congratulations! You have successfully enabled https://oweru.com
```

---

## After SSL is Set Up

### Step 1: Update .env File

```bash
nano .env
```

Change:
```env
APP_URL=https://oweru.com
```

Save: `Ctrl+X`, then `Y`, then `Enter`

### Step 2: Clear and Rebuild Config

```bash
php artisan config:clear
php artisan config:cache
```

### Step 3: Test Your Website

1. Visit: `https://oweru.com`
2. You should see a padlock icon (🔒) in the browser
3. Test admin login: `https://oweru.com/login`

---

## Verify SSL Certificate

### Check certificate details:
```bash
sudo certbot certificates
```

### Test auto-renewal:
```bash
sudo certbot renew --dry-run
```

---

## Troubleshooting

### If you get "Failed to obtain certificate" error:

**Possible causes:**
1. **DNS not pointing to server** - Check DNS is showing `31.97.176.48`
2. **Port 80 blocked** - Certbot needs port 80 open for verification
3. **Nginx not configured** - Need Nginx site configured first

**Check DNS:**
```bash
nslookup oweru.com
# Should show: 31.97.176.48
```

**Check port 80:**
```bash
sudo netstat -tulpn | grep :80
```

**Check Nginx:**
```bash
sudo nginx -t
sudo systemctl status nginx
```

---

## Quick Checklist

- [ ] Enter email address in Certbot
- [ ] Agree to terms (type `A`)
- [ ] Choose email sharing preference (Y/N)
- [ ] Choose HTTP to HTTPS redirect (choose `2`)
- [ ] Wait for certificate to be issued
- [ ] Update `.env` to use HTTPS
- [ ] Clear and rebuild config cache
- [ ] Test website at `https://oweru.com`

---

## Next Steps After SSL

1. ✅ SSL certificate installed
2. ✅ HTTPS enabled
3. Update `.env` to use HTTPS
4. Test your Laravel application
5. Configure Selcom payment gateway (if needed)

Enter your email address now and continue with the process!


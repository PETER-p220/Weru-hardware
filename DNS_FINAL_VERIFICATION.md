# DNS Final Verification - Check Multiple Sources

## Current Status

Your DNS is still showing: `84.32.84.32` (WRONG)
Should be: `31.97.176.48` (CORRECT)

---

## Step 1: Check DNS from Different Sources

Let's verify from multiple places to see if DNS is propagating:

### A. Check from Your VPS (Current)
```bash
nslookup oweru.com
# Shows: 84.32.84.32 ❌
```

### B. Check Using Google DNS
```bash
nslookup oweru.com 8.8.8.8
```

### C. Check Using Cloudflare DNS
```bash
nslookup oweru.com 1.1.1.1
```

### D. Check Online (From Your Computer)
Visit: **https://dnschecker.org**
- Enter: `oweru.com`
- Select: `A Record`
- Click: `Search`
- Check results from different locations worldwide

---

## Step 2: Verify DNS Record Was Changed

**CRITICAL: Go back to your DNS management panel and verify:**

1. **Login to DNS panel**
2. **Find A record for `@`:**
   - What IP does "Points to" show?
   - Does it show `84.32.84.32` or `31.97.176.48`?

3. **If it shows `84.32.84.32`:**
   - **The DNS record was NOT changed!**
   - You need to EDIT it to `31.97.176.48`
   - Click SAVE
   - Wait 30 minutes

4. **If it shows `31.97.176.48`:**
   - DNS record is correct
   - But DNS hasn't propagated yet
   - Wait longer (can take up to 48 hours)
   - Check from different DNS servers

---

## Step 3: Check for Multiple A Records

**Look for ALL A records with Name = `@`:**

- If you see TWO A records:
  - One pointing to `84.32.84.32` ← DELETE THIS
  - One pointing to `31.97.176.48` ← KEEP THIS

- You should only have ONE A record for `@`

---

## Step 4: Test Server Directly (While DNS Updates)

While waiting for DNS, verify your server works:

```bash
# Test direct IP access
curl -I http://31.97.176.48

# Test localhost
curl -I http://localhost

# Check Nginx is working
sudo systemctl status nginx

# Check Laravel
cd /var/www/Weru-hardware
php artisan --version
```

If these work, your server is fine - just waiting for DNS!

---

## Step 5: Force DNS Refresh (Optional)

Try using different DNS servers:

```bash
# Use Google DNS
nslookup oweru.com 8.8.8.8

# Use Cloudflare DNS  
nslookup oweru.com 1.1.1.1

# Use OpenDNS
nslookup oweru.com 208.67.222.222
```

---

## What You Need to Do RIGHT NOW

### Action 1: Double-Check DNS Panel

**Go to your DNS management panel and:**

1. Look for A record with Name = `@`
2. Check what "Points to" shows
3. **If it shows `84.32.84.32`:**
   - Click "Edit"
   - Change to `31.97.176.48`
   - Click "Save"
   - **TAKE A SCREENSHOT** for proof

4. **If it shows `31.97.176.48`:**
   - Record is correct
   - DNS is just slow to propagate
   - Wait longer

### Action 2: Check Online DNS Checker

While on your computer, visit:
- **https://dnschecker.org**
- Enter: `oweru.com`
- Select: `A Record`
- Click: `Search`

**What do you see?**
- All locations show `84.32.84.32`? → DNS not changed
- Some show `31.97.176.48`? → DNS is propagating (wait)
- All show `31.97.176.48`? → DNS is correct!

### Action 3: Verify Nginx While Waiting

Check everything else is ready:

```bash
# Check Nginx config
sudo nginx -t

# Check site is enabled
ls -la /etc/nginx/sites-enabled/

# Test localhost
curl -I http://localhost

# Check Laravel
cd /var/www/Weru-hardware
cat .env | grep APP_URL
```

---

## Most Likely Issue

**The DNS record in your DNS panel is still showing `84.32.84.32`.**

This means:
1. The DNS record was never actually changed
2. OR the change wasn't saved
3. OR there's a duplicate record overriding it

**YOU MUST:**
1. Go to DNS panel
2. Find A record for `@`
3. Verify/Change it to `31.97.176.48`
4. Save it
5. Wait 30 minutes
6. Check again

---

## After DNS is Fixed

Once DNS shows `31.97.176.48`:

```bash
# Verify DNS first
nslookup oweru.com
# Must show: 31.97.176.48

# Test domain works
curl -I http://oweru.com
# Should return HTTP response

# Then retry Certbot
sudo certbot --nginx -d oweru.com -d www.oweru.com
```

---

## Quick Commands to Run Now

Run these on your VPS to get more info:

```bash
echo "=== Using Google DNS ==="
nslookup oweru.com 8.8.8.8

echo ""
echo "=== Using Cloudflare DNS ==="
nslookup oweru.com 1.1.1.1

echo ""
echo "=== Testing Direct IP ==="
curl -I http://31.97.176.48

echo ""
echo "=== Checking Nginx ==="
sudo nginx -t
```

---

**The DNS MUST show `31.97.176.48` before Certbot will work. Check your DNS panel now!**


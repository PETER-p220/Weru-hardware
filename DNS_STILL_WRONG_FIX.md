# DNS Still Shows Wrong IP - Complete Fix

## Current Status

Your DNS is still resolving to: `84.32.84.32`  
It should be: `31.97.176.48`

---

## Immediate Actions Required

### Step 1: Verify DNS Record Was Actually Changed

**Go back to your DNS management panel RIGHT NOW and check:**

1. **Look for the A record for `@`:**
   - Does it show `84.32.84.32`?
   - Or does it show `31.97.176.48`?

2. **If it still shows `84.32.84.32`:**
   - **EDIT** it to `31.97.176.48`
   - **SAVE** the changes
   - Wait 15-30 minutes

3. **If you see TWO A records for `@`:**
   - One pointing to `84.32.84.32`
   - One pointing to `31.97.176.48`
   - **DELETE** the one pointing to `84.32.84.32`
   - **KEEP** the one pointing to `31.97.176.48`

---

## Common DNS Issues

### Issue 1: DNS Record Wasn't Saved

**Symptoms:**
- Changed DNS but it's still showing old IP
- DNS panel shows correct IP but nslookup shows wrong IP

**Solution:**
- Go to DNS panel
- Make sure you clicked "Save" or "Update"
- Some panels require clicking "Save" button twice
- Check for confirmation message

### Issue 2: Multiple A Records

**Symptoms:**
- Have both old and new A records
- DNS is randomly using one or the other

**Solution:**
- Delete ALL A records for `@`
- Create ONE new A record:
  - Type: `A`
  - Name: `@`
  - Points to: `31.97.176.48`
  - TTL: `3600` or `14400`

### Issue 3: DNS Propagation Delay

**Symptoms:**
- Changed DNS correctly
- Still showing old IP after several minutes

**Solution:**
- DNS can take 5 minutes to 48 hours
- Usually takes 15-30 minutes
- Be patient and wait

---

## Verify DNS Change Was Made

### Check from DNS Panel:

1. **Login to your DNS management panel**
2. **Find A record for `@`**
3. **Check "Points to" field:**
   - Should show: `31.97.176.48`
   - NOT: `84.32.84.32`

### Check for Duplicate Records:

Look for ANY A record for `@` that shows:
- `84.32.84.32` → **DELETE THIS ONE**

---

## Wait for DNS Propagation

After changing DNS:

1. **Wait at least 15-30 minutes**
2. **Check DNS from multiple places:**

```bash
# From your VPS
nslookup oweru.com

# Or use dig
dig oweru.com +short

# Or use online tool
# Visit: https://dnschecker.org
# Enter: oweru.com
# Should show: 31.97.176.48 globally
```

---

## What to Do While Waiting

While DNS propagates, you can:

### 1. Verify Nginx Configuration

```bash
# Check Nginx is running
sudo systemctl status nginx

# Test Nginx config
sudo nginx -t

# View your site config
sudo cat /etc/nginx/sites-available/oweru-hardware
```

### 2. Verify Laravel Setup

```bash
cd /var/www/Weru-hardware

# Check .env
cat .env | grep APP_URL

# Test Laravel locally
curl -I http://localhost

# Check permissions
ls -la storage bootstrap/cache
```

### 3. Test Direct IP Access

```bash
# From your VPS
curl -I http://31.97.176.48

# Should return HTTP response
```

If direct IP works, your server is fine - just waiting for DNS!

---

## Quick DNS Fix Checklist

- [ ] Go to DNS management panel
- [ ] Find A record for `@` (root domain)
- [ ] Verify it shows `31.97.176.48` (NOT `84.32.84.32`)
- [ ] If wrong, EDIT it to `31.97.176.48`
- [ ] Click SAVE/UPDATE button
- [ ] Look for duplicate A records pointing to `84.32.84.32`
- [ ] DELETE any duplicate/old records
- [ ] Wait 15-30 minutes
- [ ] Check again: `nslookup oweru.com`
- [ ] Should show: `31.97.176.48`

---

## Verify DNS is Fixed

After waiting, check:

```bash
nslookup oweru.com
```

**Expected output:**
```
Name:   oweru.com
Address: 31.97.176.48  ← CORRECT!
```

**If still showing `84.32.84.32`:**
- DNS change wasn't saved properly
- Go back and check DNS panel again
- Make sure you clicked SAVE

---

## Once DNS Shows Correct IP

After `nslookup oweru.com` shows `31.97.176.48`:

1. **Test domain is accessible:**
   ```bash
   curl -I http://oweru.com
   ```

2. **Then retry Certbot:**
   ```bash
   sudo certbot --nginx -d oweru.com -d www.oweru.com
   ```

---

## Alternative: Check DNS Online

Use online DNS checker to see global DNS status:

1. Visit: **https://dnschecker.org**
2. Enter: `oweru.com`
3. Select: `A Record`
4. Click: `Search`
5. Check results from different locations

**If some locations show `31.97.176.48` and others show `84.32.84.32`:**
- DNS is propagating (wait longer)

**If all locations show `84.32.84.32`:**
- DNS record wasn't changed properly
- Go back to DNS panel and fix it

---

## Most Important: Check DNS Panel NOW

**The DNS record in your panel must show:**
- Type: `A`
- Name: `@`
- Points to: `31.97.176.48` ← MUST BE THIS!

**If it shows `84.32.84.32`, you need to:**
1. Click "Edit"
2. Change to `31.97.176.48`
3. Click "Save"
4. Wait 15-30 minutes

**Go check your DNS panel right now and verify the A record!**


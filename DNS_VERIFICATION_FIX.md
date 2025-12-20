# DNS Verification & Fix

## Problem Identified

Your domain `oweru.com` is currently pointing to: **84.32.84.32**

But your server IP is: **31.97.176.48**

This means either:
1. The DNS record hasn't been updated yet
2. The DNS record was added incorrectly
3. DNS hasn't propagated yet

---

## Solutions

### Option 1: Check Your DNS Records

Go back to your DNS management panel and verify:

1. **Check existing A record:**
   - Does it show `84.32.84.32`?
   - If yes, **edit** it to `31.97.176.48`
   - If no A record exists, **add** a new one

2. **Make sure the record is:**
   - **Type:** `A`
   - **Name:** `@` or blank
   - **Points to:** `31.97.176.48` (NOT 84.32.84.32)
   - **TTL:** `3600` or `14397`

### Option 2: Delete and Recreate

If you can't edit, delete the old record and create a new one:

1. **Delete** the A record pointing to `84.32.84.32`
2. **Add new** A record:
   - **Type:** `A`
   - **Name:** `@` (or blank)
   - **Points to:** `31.97.176.48`
   - **TTL:** `3600`

---

## Verify DNS Update

After updating your DNS record:

### Wait 5-15 minutes, then test:

**Windows:**
```cmd
nslookup oweru.com
```

**Should show:**
```
Name:    oweru.com
Address:  31.97.176.48
```

**Or use online tool:**
- Visit: https://dnschecker.org
- Enter: `oweru.com`
- Select: `A Record`
- Click: `Search`
- Should show: `31.97.176.48` in different locations

---

## Why Ping Times Out

The ping timeout could be because:

1. **Firewall blocking ICMP** (ping packets)
   - This is common on VPS servers
   - Doesn't mean your server is down
   - Try accessing via browser instead

2. **DNS pointing to wrong IP**
   - Currently pointing to `84.32.84.32`
   - Need to change to `31.97.176.48`

3. **DNS not propagated yet**
   - Can take 5-15 minutes (or up to 48 hours)
   - Different locations may show different IPs

---

## Test Server is Running

On your VPS, verify the server is accessible:

```bash
# Check if Nginx is running
sudo systemctl status nginx

# Check if PHP-FPM is running
sudo systemctl status php8.2-fpm

# Check if port 80 is open
sudo netstat -tulpn | grep :80
```

---

## After DNS is Fixed

Once DNS shows `31.97.176.48`, you should be able to:

1. **Access via browser:**
   - `http://oweru.com` (if Nginx is configured)
   - `http://31.97.176.48` (direct IP access)

2. **Test with curl:**
   ```bash
   curl -I http://oweru.com
   ```

3. **Check Nginx logs:**
   ```bash
   sudo tail -f /var/log/nginx/access.log
   ```

---

## Quick Action Items

1. ✅ **Go to DNS panel** - Check/edit A record
2. ✅ **Change IP** from `84.32.84.32` to `31.97.176.48`
3. ✅ **Save/Update** the record
4. ✅ **Wait 5-15 minutes** for propagation
5. ✅ **Test again:** `nslookup oweru.com`
6. ✅ **Verify** it shows `31.97.176.48`

---

## Important Notes

- **Ping timeout doesn't mean server is down** - Many servers block ping
- **DNS propagation takes time** - Be patient (5-15 minutes)
- **Check DNS records carefully** - Make sure IP is correct
- **Use nslookup instead of ping** - More reliable for DNS checking


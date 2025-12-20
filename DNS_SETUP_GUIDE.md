# DNS Setup Guide for oweru.com

## DNS Records You Need to Add

### 1. A Record (Points domain to your server)

**Type:** `A`

**Name:** `@` (or leave blank/empty - represents the root domain)

**Points to:** Your VPS server IP address

**TTL:** `3600` (or `14397` is fine - this is how long DNS caches the record)

**What this does:** Points `oweru.com` to your server

---

### 2. A Record for www (Optional but recommended)

**Type:** `A`

**Name:** `www`

**Points to:** Same server IP address as above

**TTL:** `3600` (or `14397`)

**What this does:** Points `www.oweru.com` to your server

**OR use CNAME instead (easier):**

**Type:** `CNAME`

**Name:** `www`

**Points to:** `oweru.com`

**TTL:** `3600`

**What this does:** Makes `www.oweru.com` automatically point to wherever `oweru.com` points

---

## How to Find Your Server IP Address

Run this command on your VPS:

```bash
curl ifconfig.me
```

Or:

```bash
hostname -I
```

This will show your server's IP address (something like `123.45.67.89`)

---

## Complete DNS Setup Example

### Record 1: Root Domain (A Record)
- **Type:** `A`
- **Name:** `@` (or blank/empty)
- **Points to:** `YOUR_SERVER_IP` (e.g., `123.45.67.89`)
- **TTL:** `3600` or `14397`

### Record 2: www Subdomain (CNAME - Recommended)
- **Type:** `CNAME`
- **Name:** `www`
- **Points to:** `oweru.com`
- **TTL:** `3600` or `14397`

**OR** use A Record for www:
- **Type:** `A`
- **Name:** `www`
- **Points to:** `YOUR_SERVER_IP` (same as Record 1)
- **TTL:** `3600` or `14397`

---

## Step-by-Step Instructions

### Step 1: Find Your Server IP

On your VPS, run:
```bash
curl ifconfig.me
```

Copy the IP address that appears (e.g., `123.45.67.89`)

### Step 2: Add A Record for Root Domain

In your DNS management interface:

1. Click **"Add Record"**
2. Select **Type:** `A`
3. Enter **Name:** `@` (or leave blank if the interface doesn't accept @)
4. Enter **Points to:** Your server IP (from Step 1)
5. Enter **TTL:** `3600` (or keep default)
6. Click **"Add Record"** or **"Save"**

### Step 3: Add www Subdomain (CNAME - Easier)

1. Click **"Add Record"** again
2. Select **Type:** `CNAME`
3. Enter **Name:** `www`
4. Enter **Points to:** `oweru.com`
5. Enter **TTL:** `3600`
6. Click **"Add Record"** or **"Save"**

**OR** use A Record for www (if CNAME not available):

1. Click **"Add Record"**
2. Select **Type:** `A`
3. Enter **Name:** `www`
4. Enter **Points to:** Same IP as Step 2
5. Enter **TTL:** `3600`
6. Click **"Add Record"**

---

## Verify DNS Setup

After adding records, wait 5-15 minutes, then test:

### Test from your computer:

**Windows (PowerShell or Command Prompt):**
```cmd
nslookup oweru.com
ping oweru.com
```

**Mac/Linux:**
```bash
nslookup oweru.com
ping oweru.com
```

**Or use online tools:**
- Visit: https://dnschecker.org
- Enter: `oweru.com`
- Select: `A Record`
- Click: `Search`

You should see your server IP address.

---

## Common Issues

### "Name field doesn't accept @ symbol"
- Some DNS interfaces use different notation
- Try leaving the Name field **blank/empty**
- Or use `*` if that's what they expect
- Check your DNS provider's documentation

### "Points to field format error"
- Make sure you enter just the IP address
- Format: `123.45.67.89` (4 numbers separated by dots)
- No `http://` or `https://`
- No trailing slashes or paths

### "TTL value"
- `3600` = 1 hour (recommended)
- `14397` = ~4 hours (also fine)
- Lower TTL = faster DNS updates but more queries
- Higher TTL = fewer queries but slower updates

---

## Quick Checklist

- [ ] Find server IP: `curl ifconfig.me` on VPS
- [ ] Add A Record: Name `@`, Points to `YOUR_IP`
- [ ] Add CNAME Record: Name `www`, Points to `oweru.com`
- [ ] Wait 5-15 minutes for DNS propagation
- [ ] Test: `ping oweru.com` (should show your IP)
- [ ] Test: `ping www.oweru.com` (should show same IP)

---

## What Happens After DNS is Set Up?

1. DNS propagates (5-15 minutes, up to 48 hours max)
2. You can then set up Nginx on your server
3. Your domain will start pointing to your Laravel app
4. You can get SSL certificate with Certbot

**Important:** Your server must have Nginx configured BEFORE visitors can see your website!


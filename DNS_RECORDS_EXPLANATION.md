# DNS Records Explanation

## What You Currently Have

### ✅ Good Records (Keep These):

1. **A Record for root domain:**
   - `A` | `@` | `31.97.176.48`
   - This points `oweru.com` to your server

2. **CNAME for www:**
   - `CNAME` | `www` | `oweru.com`
   - This is CORRECT! It automatically points `www.oweru.com` to wherever `oweru.com` points

### ❌ Problem Record (Fix This):

1. **Old A Record:**
   - `A` | `@` | `84.32.84.32` | `50`
   - This is WRONG! Delete or edit this one.

---

## How www Works

You have a **CNAME record** for www:
```
CNAME | www | oweru.com
```

This means:
- When someone visits `www.oweru.com`, DNS looks at `oweru.com`
- `oweru.com` points to wherever the `@` A record points
- So `www.oweru.com` automatically follows `oweru.com`

**This is PERFECT!** You don't need an A record for www if you have this CNAME.

---

## What You Need to Do

### Option 1: Edit the Old A Record (Recommended)

Find this record at the bottom:
```
A | @ | 84.32.84.32 | 50
```

**Click "Edit"** and change:
- **Points to:** Change from `84.32.84.32` to `31.97.176.48`
- **Save**

### Option 2: Delete Old and Keep New

1. **Delete** the old A record:
   - `A` | `@` | `84.32.84.32` | `50`
   - Click "Delete" next to it

2. **Keep** the new A record (if you already added it):
   - `A` | `@` | `31.97.176.48` | `14400`

---

## Final DNS Setup (What You Should Have)

### Required Records:

1. **A Record (Root Domain):**
   - Type: `A`
   - Name: `@` (or blank)
   - Points to: `31.97.176.48`
   - TTL: `14400`

2. **CNAME (www subdomain):**
   - Type: `CNAME`
   - Name: `www`
   - Points to: `oweru.com`
   - TTL: `300` or `3600`

### Optional Records (For Email - Keep These):

- MX records (for email)
- TXT records (SPF, DMARC)
- CNAME records (autodiscover, autoconfig)
- CAA records (SSL certificate authorities)
- DKIM records (email authentication)

**These are all fine - don't delete them!**

---

## Summary

### What to Keep:
- ✅ CNAME for `www` → `oweru.com` (already correct!)
- ✅ All email-related records (MX, TXT, CNAME, CAA)
- ✅ A record for `@` → `31.97.176.48` (the new/correct one)

### What to Fix:
- ❌ A record for `@` → `84.32.84.32` (the old/wrong one - DELETE or EDIT)

---

## Action Steps

1. **Edit** the A record pointing to `84.32.84.32`
   - Change it to point to `31.97.176.48`
   - OR **Delete** it if you already have a new A record

2. **Keep** the CNAME for www (it's perfect as is!)

3. **Keep** all email records (they're fine)

4. **Wait** 10-15 minutes for DNS to update

5. **Test:**
   ```bash
   nslookup oweru.com
   nslookup www.oweru.com
   ```
   Both should show `31.97.176.48`

---

## Important Notes

- **You only need ONE A record for `@`** - pointing to `31.97.176.48`
- **The CNAME for www is correct** - it automatically follows the root domain
- **Don't create duplicate A record for www** - the CNAME handles it
- **Keep all email records** - they don't interfere with web traffic

The www CNAME record you see is correct and needed! Just fix the A record for the root domain.


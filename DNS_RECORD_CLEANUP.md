# DNS Record Cleanup - What to Keep/Delete

## Current Domain: oweru.com

---

## Records You NEED (Keep These)

### 1. Root Domain A Record
- **Type:** `A`
- **Name:** `@` (or blank)
- **Points to:** `31.97.176.48`
- **Purpose:** Points `oweru.com` to your server
- **Action:** ✅ **KEEP** (or create if missing)

### 2. www CNAME Record
- **Type:** `CNAME`
- **Name:** `www`
- **Points to:** `oweru.com`
- **Purpose:** Points `www.oweru.com` to your server
- **Action:** ✅ **KEEP**

---

## Records You DON'T NEED (Delete These)

### ❌ www.oweruhardware A Record
- **Type:** `A`
- **Name:** `www.oweruhardware`
- **Points to:** `31.97.176.48`

**Why delete it:**
- This creates a subdomain: `www.oweruhardware.oweru.com`
- This is **NOT** your domain - your domain is `oweru.com`
- It's confusing and not needed
- **Action:** ❌ **DELETE**

---

## What Each Record Creates

### ✅ Correct Records:
- `A` | `@` → Creates: `oweru.com`
- `CNAME` | `www` → Creates: `www.oweru.com`

### ❌ Incorrect Record:
- `A` | `www.oweruhardware` → Creates: `www.oweruhardware.oweru.com`
  - This is a subdomain, not your main domain!
  - Visitors would need to type: `www.oweruhardware.oweru.com` (wrong!)

---

## Action Plan

### Step 1: Delete Unnecessary Records

Delete these (they're not needed for your domain):
- ❌ `A` | `www.oweruhardware` | `31.97.176.48`
- ❌ `A` | `www.api` | `31.97.176.48` (unless you need API subdomain)
- ❌ `A` | `api` | `31.97.176.48` (unless you need API subdomain)
- ❌ `A` | `www.oweruhardware` | `31.97.176.48`

**Only delete these if you don't need these subdomains!**

### Step 2: Keep Essential Records

✅ Keep these:
- `A` | `@` | `31.97.176.48` (or edit the one pointing to `84.32.84.32`)
- `CNAME` | `www` | `oweru.com`
- All email records (MX, TXT, DKIM, etc.)
- All CAA records (for SSL)

---

## Recommended DNS Records

### For Web Traffic:
1. **A Record (Root):**
   - Type: `A`
   - Name: `@`
   - Points to: `31.97.176.48`
   - TTL: `14400`

2. **CNAME (www):**
   - Type: `CNAME`
   - Name: `www`
   - Points to: `oweru.com`
   - TTL: `3600`

### Keep Email Records:
- All MX records
- All TXT records (SPF, DMARC)
- All DKIM CNAME records
- All CAA records

### Delete Unnecessary:
- `www.oweruhardware` A record (unless you need this subdomain)

---

## Decision: Do You Need These Subdomains?

### Question 1: Do you need `api.oweru.com`?
- If **YES**: Keep the `api` A record
- If **NO**: Delete it

### Question 2: Do you need `www.api.oweru.com`?
- If **YES**: Keep the `www.api` A record
- If **NO**: Delete it

### Question 3: Do you need `www.oweruhardware.oweru.com`?
- This seems like a mistake/typo
- If **NO** (which is likely): Delete it

---

## What to Do Right Now

### Priority 1: Fix Root Domain
1. Find A record: `A` | `@` | `84.32.84.32`
2. **Edit** it to point to `31.97.176.48`
   - OR **Delete** it if you already have a new one

### Priority 2: Clean Up (Optional)
1. **Delete** `www.oweruhardware` A record (not needed)
2. **Keep** `www` CNAME record (needed!)

### Priority 3: Keep Everything Else
- Keep all email records
- Keep all SSL/CAA records

---

## Summary

**Delete:**
- ❌ `www.oweruhardware` A record (unless you actually need this subdomain)

**Keep/Edit:**
- ✅ Edit: `A` | `@` | `84.32.84.32` → Change to `31.97.176.48`
- ✅ Keep: `CNAME` | `www` | `oweru.com`
- ✅ Keep: All email and SSL records

**Your main domain should be:**
- `oweru.com` (via A record for @)
- `www.oweru.com` (via CNAME www → oweru.com)

The `www.oweruhardware` record creates a subdomain you probably don't need - it's safe to delete!


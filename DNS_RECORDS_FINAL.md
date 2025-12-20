# DNS Records Setup - Final Configuration

## Your Server IP Addresses

- **IPv4 Address:** `31.97.176.48` ← Use this for A record
- **IPv6 Address:** `2a02:4780:28:a02b::1` ← Optional, for AAAA record

## DNS Records to Add

### Record 1: Root Domain (A Record - IPv4)

**Type:** `A`

**Name:** `@` (or blank/empty)

**Points to:** `31.97.176.48`

**TTL:** `3600` (or `14397`)

---

### Record 2: www Subdomain (A Record - IPv4)

**Type:** `A`

**Name:** `www`

**Points to:** `31.97.176.48`

**TTL:** `3600`

**OR use CNAME:**

**Type:** `CNAME`

**Name:** `www`

**Points to:** `oweru.com`

**TTL:** `3600`

---

### Record 3: Root Domain IPv6 (Optional - AAAA Record)

If your DNS provider supports IPv6:

**Type:** `AAAA`

**Name:** `@` (or blank/empty)

**Points to:** `2a02:4780:28:a02b::1`

**TTL:** `3600`

---

### Record 4: www Subdomain IPv6 (Optional - AAAA Record)

If your DNS provider supports IPv6:

**Type:** `AAAA`

**Name:** `www`

**Points to:** `2a02:4780:28:a02b::1`

**TTL:** `3600`

---

## Priority: What to Add First

### Required (Must Have):
1. ✅ **A Record** - Name: `@`, Points to: `31.97.176.48`
2. ✅ **A Record** - Name: `www`, Points to: `31.97.176.48` (or CNAME to `oweru.com`)

### Optional (Nice to Have):
3. **AAAA Record** - Name: `@`, Points to: `2a02:4780:28:a02b::1`
4. **AAAA Record** - Name: `www`, Points to: `2a02:4780:28:a02b::1`

**Start with the 2 A records first!** IPv6 can be added later.

---

## Quick Copy-Paste

### For Your Current DNS Form:

**Type:** `A`

**Name:** `@`

**Points to:** `31.97.176.48`

**TTL:** `3600` (or `14397`)

Click **"Add Record"**

---

## After Adding Records

1. Wait 5-15 minutes for DNS propagation
2. Test: `ping oweru.com` (should show `31.97.176.48`)
3. Test: `ping www.oweru.com` (should show same IP)
4. Continue with Nginx configuration on your server

---

## Verification

After adding DNS records, verify:

```bash
# From your computer or online tool
nslookup oweru.com
# Should show: 31.97.176.48

ping oweru.com
# Should ping: 31.97.176.48
```

**Or use online tool:**
- Visit: https://dnschecker.org
- Enter: `oweru.com`
- Should show: `31.97.176.48` in different locations worldwide


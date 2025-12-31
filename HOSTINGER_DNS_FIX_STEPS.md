# Fix DNS A Record in Hostinger - Step by Step

## What I Can See in Your DNS Panel

You're in Hostinger DNS management! I can see:

✅ **Add Record Form (at the top):**
- Type: `A` ✓
- Name: `oweru` (needs to be changed to `@`)
- Points to: `31.97.176.48` ✓ CORRECT!
- TTL: `14400` ✓
- **"Add Record" button**

✅ **DNS Records Table (below):**
- Shows existing records
- Has scrollbar (more records below)

---

## Step-by-Step Instructions

### Step 1: Find the Old A Record

1. **Scroll down** in the DNS records table
2. **Look for** a record with:
   - **Type:** `A`
   - **Name:** `@` (or blank/empty)
   - **Content/Points to:** `84.32.84.32`
3. **This is the record you need to fix!**

### Step 2: Edit or Delete the Old Record

**Option A: Edit the Old Record (Recommended)**

1. **Find** the A record showing `84.32.84.32`
2. **Click** the purple **"Edit"** button on that row
3. **Change** "Content" or "Points to" field:
   - From: `84.32.84.32`
   - To: `31.97.176.48`
4. **Click "Save"** or similar button
5. **Done!**

**Option B: Delete Old and Add New**

1. **Find** the A record showing `84.32.84.32`
2. **Click** the red **"Delete"** button
3. **Confirm deletion**
4. **Use the form at the top:**
   - Type: `A` (already selected)
   - Name: Change `oweru` to `@` (just the @ symbol)
   - Points to: `31.97.176.48` (already correct!)
   - TTL: `14400` (already correct!)
5. **Click "Add Record"** button

---

## Important: If Using the Form at Top

**Before clicking "Add Record", change:**
- **Name:** Change from `oweru` to `@` (just type `@`)

The form currently shows:
- Name: `oweru` ← Change this to `@`
- Points to: `31.97.176.48` ✓ (already correct!)

---

## Quick Action Steps

### Method 1: Edit Existing Record (Easiest)

1. **Scroll down** in the table
2. **Find** the A record with Content = `84.32.84.32`
3. **Click "Edit"** (purple button)
4. **Change** Content to `31.97.176.48`
5. **Save**

### Method 2: Delete and Add New

1. **Scroll down** in the table
2. **Find** the A record with Content = `84.32.84.32`
3. **Click "Delete"** (red button)
4. **Confirm deletion**
5. **In the form at top:**
   - Change Name: `oweru` → `@`
   - Points to: Already shows `31.97.176.48` ✓
6. **Click "Add Record"**

---

## What to Look For

When you scroll down, look for:

```
Type | Name | Priority | Content        | TTL  | Actions
A    | @    | 0        | 84.32.84.32    | 50   | [Delete] [Edit]
```

**Click "Edit"** and change Content to `31.97.176.48`

---

## After Making Changes

1. **Wait 15-30 minutes** for DNS to update
2. **Test from your VPS:**
   ```bash
   nslookup oweru.com
   ```
   Should show: `31.97.176.48`

3. **Then retry Certbot:**
   ```bash
   sudo certbot --nginx -d oweru.com -d www.oweru.com
   ```

---

## Summary

**Your form at the top is almost ready!** Just:
1. Scroll down to find the old A record (`84.32.84.32`)
2. Either **Edit** it or **Delete** it
3. If deleting, change Name in form from `oweru` to `@`
4. Click "Add Record" or "Save"

**The quickest way:** Scroll down, find the old A record, click "Edit", change IP to `31.97.176.48`, save!

Scroll down in that table and tell me what you see!


# How to Get a FREE Google Maps API Key

This guide will walk you through getting a free Google Maps API key for your Oweru Hardware checkout location picker.

---

## ✅ What You'll Get

- **FREE** $200/month in Google Maps Platform credits
- Interactive map on checkout page
- Location selection with drag & drop marker
- Automatic address filling from coordinates
- Reverse geocoding (coordinates → address)

**Note:** Google gives $200 in free credits per month. For a typical e-commerce site, this is more than enough and should stay within the free tier.

---

## Step 1: Create a Google Cloud Account

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Sign in with your Google account (or create one if needed)
3. Click **"Get Started for Free"** or **"Create Account"**

---

## Step 2: Create a New Project (or Use Existing)

1. Click the project dropdown at the top
2. Click **"New Project"**
3. Enter project name: `Oweru Hardware` (or any name you like)
4. Click **"Create"**
5. Wait a few seconds, then select your new project from the dropdown

---

## Step 3: Enable Billing (Don't Worry - It's Free!)

1. Go to [Billing](https://console.cloud.google.com/billing) in the left menu
2. Click **"Link a billing account"** or **"Create billing account"**
3. Enter your payment information (credit/debit card)
   - **Important:** Google requires a payment method BUT gives you $200 free credits/month
   - You'll only be charged if you exceed $200/month (very unlikely for a small e-commerce site)
   - Google will email you if you approach the limit
   - **Note:** Phone numbers (like Vodacom) are for account verification only, not billing
   - **For Tanzania users:** You need a Visa/Mastercard debit/credit card from your bank
     - See `GOOGLE_CLOUD_BILLING_TANZANIA.md` for detailed Tanzania-specific instructions

---

## Step 4: Enable Required APIs

You need to enable these two APIs:

### Enable Maps JavaScript API

1. Go to [APIs & Services > Library](https://console.cloud.google.com/apis/library)
2. Search for **"Maps JavaScript API"**
3. Click on it
4. Click **"Enable"** button

### Enable Geocoding API

1. Still in the Library, search for **"Geocoding API"**
2. Click on it
3. Click **"Enable"** button

---

## Step 5: Create API Key

1. Go to [APIs & Services > Credentials](https://console.cloud.google.com/apis/credentials)
2. Click **"+ CREATE CREDENTIALS"** at the top
3. Select **"API key"**
4. Your API key will be created! Copy it immediately

---

## Step 6: Restrict Your API Key (IMPORTANT for Security!)

1. Click on your newly created API key to edit it
2. Under **"API restrictions"**:
   - Select **"Restrict key"**
   - Check only these APIs:
     - ✅ Maps JavaScript API
     - ✅ Geocoding API
3. Under **"Website restrictions"** (for security):
   - Select **"HTTP referrers"**
   - Click **"Add an item"**
   - Add these (replace `yourdomain.com` with your actual domain):
     ```
     https://yourdomain.com/*
     http://localhost/*
     http://127.0.0.1/*
     ```
   - For production, also add:
     ```
     https://www.yourdomain.com/*
     ```
4. Click **"Save"**

---

## Step 7: Add API Key to Your Application

### Option A: Local Development (.env file)

1. Open your `.env` file in the project root
2. Add this line:
   ```env
   GOOGLE_MAPS_API_KEY=YOUR_API_KEY_HERE
   ```
3. Replace `YOUR_API_KEY_HERE` with your actual API key
4. Save the file

### Option B: Production (VPS Server)

1. SSH into your VPS:
   ```bash
   ssh root@your-server-ip
   ```

2. Navigate to your project:
   ```bash
   cd /var/www/Weru-hardware
   ```

3. Edit `.env` file:
   ```bash
   nano .env
   ```

4. Add or update this line:
   ```env
   GOOGLE_MAPS_API_KEY=YOUR_API_KEY_HERE
   ```

5. Save: `Ctrl+X`, then `Y`, then `Enter`

6. Clear Laravel config cache:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

---

## Step 8: Test Your Setup

1. Visit your checkout page: `https://yourdomain.com/checkout`
2. You should see:
   - ✅ Interactive Google Map
   - ✅ Ability to click on map to select location
   - ✅ Draggable marker
   - ✅ "Use My Location" button works
   - ✅ Address auto-fills from selected location

If you see a message saying "Google Maps API key not configured", double-check:
- The API key is in your `.env` file
- You ran `php artisan config:clear` and `php artisan config:cache`
- The API key is correct (no extra spaces)

---

## Pricing & Free Credits

### Google Maps Platform Pricing (as of 2024)

- **Maps JavaScript API**: $7 per 1,000 requests (after free tier)
- **Geocoding API**: $5 per 1,000 requests (after free tier)

### Free Credits

- **$200 FREE credits per month** (every month, not just first month!)
- This equals approximately:
  - **~28,500 map loads** per month
  - **~40,000 geocoding requests** per month

### Typical Usage for E-commerce

- Small site: 100-500 checkouts/month = **Well within free tier**
- Medium site: 1,000-5,000 checkouts/month = **Still within free tier**
- Large site: 10,000+ checkouts/month = **Might use $5-20/month**

**You'll receive an email if you exceed 50% of your free credits.**

---

## Troubleshooting

### Map Not Showing

**Problem:** Map container is empty or shows error

**Solutions:**
1. Check browser console (F12) for errors
2. Verify API key is correct in `.env`
3. Check API restrictions - make sure domain is allowed
4. Verify APIs are enabled in Google Cloud Console
5. Clear browser cache and try again

### "API key not valid" Error

**Solutions:**
1. Copy API key again from Google Cloud Console
2. Make sure no extra spaces in `.env` file
3. Check if API key restrictions allow your domain
4. Verify billing is enabled

### "RefererNotAllowedMapError"

**Problem:** Your domain is not allowed

**Solution:**
1. Go to Google Cloud Console > Credentials
2. Click on your API key
3. Under "Website restrictions", add your domain:
   ```
   https://yourdomain.com/*
   ```

### Address Not Auto-Filling

**Problem:** Map works but address doesn't fill automatically

**Solutions:**
1. Check browser console for errors
2. Verify Geocoding API is enabled
3. Check if API key has Geocoding API permission

---

## Security Best Practices

1. **Always restrict your API key** by:
   - Limiting to specific APIs (Maps JavaScript + Geocoding only)
   - Restricting to your domain(s)
   
2. **Monitor usage:**
   - Go to [APIs & Services > Dashboard](https://console.cloud.google.com/apis/dashboard)
   - Check usage regularly

3. **Set up billing alerts:**
   - Go to [Billing > Budgets & Alerts](https://console.cloud.google.com/billing/budgets)
   - Set alert at $10/month (just in case)

---

## Quick Commands Summary

```bash
# Add to .env file
echo "GOOGLE_MAPS_API_KEY=your_api_key_here" >> .env

# Clear and cache config (on VPS)
php artisan config:clear
php artisan config:cache

# Restart PHP-FPM (if needed on VPS)
sudo systemctl restart php8.2-fpm
```

---

## Need Help?

- [Google Maps Platform Documentation](https://developers.google.com/maps/documentation)
- [Maps JavaScript API Guide](https://developers.google.com/maps/documentation/javascript)
- [Geocoding API Guide](https://developers.google.com/maps/documentation/geocoding)
- [Google Cloud Support](https://cloud.google.com/support)

---

**You're all set! Your checkout page now has an interactive map for location selection! 🗺️**


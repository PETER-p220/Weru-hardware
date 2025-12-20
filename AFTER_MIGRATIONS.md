# Next Steps After Migrations ✅

## ✅ Already Completed
- Database created
- User created with permissions
- Migrations run successfully
- All tables created

## 🔄 Next Steps (Run These Commands)

### Step 1: Seed Database (Create Roles & Admin User)
This creates the 'admin' and 'user' roles, and a default admin account:
```bash
php artisan db:seed
```

**Default Admin Login:**
- Email: `admin@oweruhardware.com`
- Password: `admin123`

### Step 2: Create Storage Link
This links storage for file uploads (product images, etc.):
```bash
php artisan storage:link
```

### Step 3: Set File Permissions
```bash
sudo chown -R www-data:www-data /var/www/Weru-hardware
sudo chmod -R 755 /var/www/Weru-hardware
sudo chmod -R 775 storage bootstrap/cache
```

### Step 4: Optimize Laravel (Cache for Production)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 5: Verify .env Settings
Make sure your `.env` has production settings:
```bash
nano .env
```

Check these:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-server-ip  # or your domain
```

### Step 6: Configure Nginx (Next)
After these steps, we'll set up Nginx web server configuration.

---

## Quick Command Sequence

Copy and paste all at once:

```bash
# 1. Seed database
php artisan db:seed

# 2. Create storage link
php artisan storage:link

# 3. Set permissions
sudo chown -R www-data:www-data /var/www/Weru-hardware
sudo chmod -R 755 /var/www/Weru-hardware
sudo chmod -R 775 storage bootstrap/cache

# 4. Optimize Laravel (cache for production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Run these commands now!



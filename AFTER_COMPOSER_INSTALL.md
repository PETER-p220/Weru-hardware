# Next Steps After Composer Install

## ✅ Already Done
- Composer dependencies installed
- Packages discovered

## 🔄 Next Steps (In Order)

### Step 1: Create .env File
```bash
cp .env.example .env
nano .env
```

**Update these values in .env:**
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://yourdomain.com` (your actual domain)
- Database credentials:
  - `DB_DATABASE=oweru_hardware`
  - `DB_USERNAME=oweru_user`
  - `DB_PASSWORD=YourPassword123!` (the one you created)
- Selcom credentials (if you have them)

**Save:** `Ctrl+X`, then `Y`, then `Enter`

### Step 2: Generate Application Key
```bash
php artisan key:generate
```

### Step 3: Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/Weru-hardware
sudo chmod -R 755 /var/www/Weru-hardware
sudo chmod -R 775 storage bootstrap/cache
```

### Step 4: Create Database (if not done yet)
```bash
sudo mysql -u root -p
```

Then:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'YourPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 5: Run Migrations
```bash
php artisan migrate --force
```

### Step 6: Seed Database (Create Roles)
```bash
php artisan db:seed
```

### Step 7: Create Storage Link
```bash
php artisan storage:link
```

### Step 8: Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 9: Configure Nginx (Next Step)

---

## Quick Command Sequence

```bash
# 1. Create .env
cp .env.example .env
nano .env  # Edit and save

# 2. Generate key
php artisan key:generate

# 3. Set permissions
sudo chown -R www-data:www-data /var/www/Weru-hardware
sudo chmod -R 755 /var/www/Weru-hardware
sudo chmod -R 775 storage bootstrap/cache

# 4. Run migrations
php artisan migrate --force

# 5. Seed database
php artisan db:seed

# 6. Create storage link
php artisan storage:link

# 7. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```


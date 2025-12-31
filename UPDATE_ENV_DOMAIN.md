# Update .env with Your Domain (oweru.com)

## Update APP_URL in .env

Open your `.env` file:
```bash
nano .env
```

Find the `APP_URL` line and update it:

### If you DON'T have SSL/HTTPS yet (use HTTP for now):
```env
APP_URL=http://oweru.com
```

### If you HAVE SSL/HTTPS (recommended for production):
```env
APP_URL=https://oweru.com
```

**For now, start with HTTP:**
```env
APP_URL=http://oweru.com
```

You can change it to HTTPS later after setting up SSL certificate.

---

## Other Settings to Check

While you're in the `.env` file, also verify:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=http://oweru.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oweru_hardware
DB_USERNAME=oweru_user
DB_PASSWORD=HardwareDB123!
```

---

## Save and Exit

After editing:
- Press `Ctrl+X`
- Press `Y` to confirm
- Press `Enter` to save

Then clear config cache:
```bash
php artisan config:clear
php artisan config:cache
```


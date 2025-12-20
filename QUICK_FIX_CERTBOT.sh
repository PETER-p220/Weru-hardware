#!/bin/bash

echo "=== Step 1: Checking DNS ==="
echo "Checking oweru.com..."
nslookup oweru.com
echo ""
echo "Checking www.oweru.com..."
nslookup www.oweru.com
echo ""

echo "=== Step 2: Checking Nginx ==="
sudo systemctl status nginx | head -10
echo ""

echo "=== Step 3: Testing Nginx Config ==="
sudo nginx -t
echo ""

echo "=== Step 4: Checking PHP-FPM ==="
sudo systemctl status php8.2-fpm | head -5
echo ""

echo "=== Step 5: Testing Localhost ==="
curl -I http://localhost 2>&1 | head -10
echo ""

echo "=== Step 6: Checking Laravel ==="
cd /var/www/Weru-hardware
php artisan --version
echo ""

echo "=== Step 7: Checking .env ==="
cat .env | grep APP_URL
echo ""

echo "=== Step 8: Testing Direct IP ==="
curl -I http://31.97.176.48 2>&1 | head -5


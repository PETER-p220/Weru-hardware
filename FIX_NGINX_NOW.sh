#!/bin/bash

echo "=== Step 1: Disabling problematic default config ==="
sudo mv /etc/nginx/sites-enabled/default.conf /etc/nginx/sites-enabled/default.conf.bak 2>/dev/null
sudo rm -f /etc/nginx/sites-enabled/default
echo "Done!"

echo ""
echo "=== Step 2: Checking current site config ==="
ls -la /etc/nginx/sites-available/oweru-hardware

echo ""
echo "=== Step 3: Enabling your site ==="
sudo ln -sf /etc/nginx/sites-available/oweru-hardware /etc/nginx/sites-enabled/
echo "Done!"

echo ""
echo "=== Step 4: Testing Nginx configuration ==="
sudo nginx -t

echo ""
echo "=== Step 5: Restarting Nginx ==="
sudo systemctl restart nginx
sudo systemctl status nginx | head -10

echo ""
echo "=== Step 6: Testing HTTPS ==="
curl -I https://oweru.com 2>&1 | head -10


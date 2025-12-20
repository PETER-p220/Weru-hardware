#!/bin/bash

echo "=== Step 1: Check what config Nginx is actually using ==="
sudo nginx -T | grep -B 5 -A 15 "server_name.*oweru.com" | head -30

echo ""
echo "=== Step 2: Check SSL certificate paths in active config ==="
sudo nginx -T | grep -B 10 "server_name.*oweru.com" | grep "ssl_certificate"

echo ""
echo "=== Step 3: Check what's in your config file ==="
sudo cat /etc/nginx/sites-available/oweru-hardware | grep -A 3 "ssl_certificate"

echo ""
echo "=== Step 4: Verify Let's Encrypt certs exist ==="
sudo ls -la /etc/letsencrypt/live/oweru.com/

echo ""
echo "=== Step 5: Check all configs listening on port 443 ==="
sudo nginx -T | grep -B 5 "listen.*443" | grep -E "(server_name|ssl_certificate|listen)"


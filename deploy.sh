#!/bin/bash

# Hostinger VPS Deployment Script
# Run this script on your VPS after uploading files

set -e

echo "🚀 Starting Laravel Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if .env exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚠ .env file not found. Creating from .env.example...${NC}"
    if [ -f .env.example ]; then
        cp .env.example .env
        echo -e "${GREEN}✓ Created .env file${NC}"
        echo -e "${YELLOW}⚠ Please edit .env file with your configuration before continuing!${NC}"
        exit 1
    else
        echo -e "${RED}✗ .env.example not found. Please create .env manually.${NC}"
        exit 1
    fi
fi

echo -e "${GREEN}✓ .env file found${NC}"

# Install/Update dependencies
echo -e "${YELLOW}📦 Installing dependencies...${NC}"
composer install --optimize-autoloader --no-dev --no-interaction

# Generate application key if not set
echo -e "${YELLOW}🔑 Checking application key...${NC}"
php artisan key:generate --force

# Set permissions
echo -e "${YELLOW}🔒 Setting permissions...${NC}"
sudo chown -R www-data:www-data /var/www/oweru-hardware
sudo chmod -R 755 /var/www/oweru-hardware
sudo chmod -R 775 storage bootstrap/cache

# Run migrations
echo -e "${YELLOW}🗄️ Running database migrations...${NC}"
php artisan migrate --force

# Create storage link
echo -e "${YELLOW}🔗 Creating storage symlink...${NC}"
php artisan storage:link

# Clear and cache config
echo -e "${YELLOW}⚡ Optimizing Laravel...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo -e "${GREEN}✅ Deployment completed successfully!${NC}"
echo -e "${GREEN}🔍 Don't forget to:${NC}"
echo -e "  - Configure Nginx"
echo -e "  - Setup SSL certificate"
echo -e "  - Configure firewall"
echo -e "  - Setup cron job"


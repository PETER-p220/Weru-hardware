# Fix Git Clone Error on VPS

## Problem
Directory already exists, so Git can't clone.

## Solutions

### Option 1: Remove Existing Directory and Clone Fresh (Recommended)
```bash
cd /var/www
sudo rm -rf Weru-hardware
git clone https://github.com/PETER-p220/Weru-hardware.git
cd Weru-hardware
```

### Option 2: Clone to Different Directory Name
```bash
cd /var/www
git clone https://github.com/PETER-p220/Weru-hardware.git oweru-hardware
cd oweru-hardware
```

### Option 3: Check What's in Existing Directory First
```bash
cd /var/www
ls -la Weru-hardware
# If it's empty or has old files, remove it:
sudo rm -rf Weru-hardware
git clone https://github.com/PETER-p220/Weru-hardware.git
```

## After Cloning, Continue Setup

```bash
cd Weru-hardware
# Install dependencies
composer install --optimize-autoloader --no-dev
```


# Fix MySQL Connection Error

## Problem
MySQL service is not running, so you can't connect.

## Solution: Start MySQL Service

### Step 1: Check MySQL Service Status
```bash
sudo systemctl status mysql
```

### Step 2: Start MySQL Service
```bash
sudo systemctl start mysql
```

### Step 3: Enable MySQL to Start on Boot
```bash
sudo systemctl enable mysql
```

### Step 4: Verify MySQL is Running
```bash
sudo systemctl status mysql
```

You should see "active (running)" in green.

### Step 5: Try Connecting Again
```bash
sudo mysql -u root
```

If it still doesn't work, try:
```bash
sudo mysql -u root -p
# Press Enter if no password, or enter your MySQL root password
```

## Alternative: Check if it's Percona Server
```bash
sudo systemctl status percona-server
sudo systemctl start percona-server
```

## If MySQL Won't Start

Check logs:
```bash
sudo journalctl -u mysql -n 50
# OR for Percona
sudo journalctl -u percona-server -n 50
```


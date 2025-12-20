# Find and Start MySQL Service

## Your MySQL service name might be different

### Step 1: Check All MySQL/Percona Services
```bash
# Check for Percona Server
sudo systemctl status percona-server

# OR check for mysqld
sudo systemctl status mysqld

# List all services containing "sql" or "mysql"
sudo systemctl list-units --type=service | grep -i sql
sudo systemctl list-units --type=service | grep -i mysql
```

### Step 2: Check Running Processes
```bash
# See if MySQL is actually running
ps aux | grep mysql
ps aux | grep mysqld
```

### Step 3: Try Starting Different Service Names
```bash
# Try Percona Server
sudo systemctl start percona-server
sudo systemctl status percona-server

# OR try mysqld
sudo systemctl start mysqld
sudo systemctl status mysqld

# OR check what MySQL packages are installed
dpkg -l | grep -i mysql
dpkg -l | grep -i percona
```

### Step 4: If MySQL is Not Installed Properly

You might need to properly configure or reinstall MySQL. But first, let's see what's actually installed.


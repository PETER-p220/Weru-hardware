# Next Steps After MySQL Setup

## Your MySQL Status
✅ Percona Server is installed and running!

## Step 1: Reload System Daemon
```bash
sudo systemctl daemon-reload
sudo systemctl status mysql
```

## Step 2: Create Database

Connect to MySQL:
```bash
sudo mysql -u root
```

If that doesn't work, try:
```bash
sudo mysql -u root -p
# Enter your MySQL root password when prompted
```

Once connected, create your database:
```sql
CREATE DATABASE oweru_hardware CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'oweru_user'@'localhost' IDENTIFIED BY 'YourStrongPassword123!';
GRANT ALL PRIVILEGES ON oweru_hardware.* TO 'oweru_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**Remember to save the password you used for the database user!**

## Step 3: Continue with Deployment

Now continue with these steps:

1. **Install Nginx** (if not already installed):
   ```bash
   sudo apt install -y nginx
   ```

2. **Create project directory**:
   ```bash
   sudo mkdir -p /var/www/oweru-hardware
   sudo chown -R $USER:$USER /var/www/oweru-hardware
   ```

3. **Upload your project files** or clone from Git:
   - Option A: Use SFTP/File Manager to upload files
   - Option B: Clone from Git repository

4. **Continue with Laravel setup** as in the deployment guide.


# Emergency Troubleshooting Guide for Dedazen Store

## Common Issues and Solutions

### 1. Path/File Not Found Errors

**Error Message**: 
```
Warning: require_once(system/a_func.php): Failed to open stream: No such file or directory
```

**Solution**:
1. Check that the file exists in the correct location
2. Verify relative paths in require_once statements
3. For files in `/page/` directory, use `../system/` prefix
4. For files in `/system/` directory, use `../system/` prefix when referencing a_func.php

### 2. Database Connection Issues

**Error Message**:
```
Connection failed: SQLSTATE[HY000] [2002] No such file or directory
```

**Solution**:
1. Check database credentials in `system/a_func.php`
2. Verify MySQL service is running
3. Check if database exists
4. Verify database user permissions

### 3. Session Start Errors

**Error Message**:
```
Warning: session_start(): Cannot start session when headers already sent
```

**Solution**:
1. Ensure no output (echo, print, whitespace) before session_start()
2. Check for BOM in UTF-8 files
3. Remove any content before `<?php` tag
4. Check included files for early output

### 4. Permission Denied Errors

**Error Message**:
```
Warning: fopen(/path/to/file): failed to open stream: Permission denied
```

**Solution**:
1. Set correct file permissions:
   ```bash
   chmod -R 755 /path/to/website
   chmod -R 777 /path/to/website/system
   chmod -R 777 /path/to/website/page
   ```
2. Check directory ownership
3. Verify web server user has write access

### 5. Fatal Error: Class Not Found

**Error Message**:
```
Fatal error: Uncaught Error: Class 'ClassName' not found
```

**Solution**:
1. Check that the class file is included
2. Verify class file path
3. Check class name spelling
4. Ensure file is properly included with require_once

## Database Troubleshooting

### Checking Database Connection

Create a test file `db_test.php`:
```php
<?php
require_once 'system/a_func.php';

try {
    $conn->query("SELECT 1");
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
```

### Checking Table Existence

```sql
SHOW TABLES LIKE 'users';
SHOW TABLES LIKE 'box_product';
SHOW TABLES LIKE 'box_stock';
```

### Repairing Tables

```sql
REPAIR TABLE users;
REPAIR TABLE box_product;
REPAIR TABLE box_stock;
```

## Security Troubleshooting

### Resetting Admin Password

If you're locked out of admin account, create `reset_admin.php`:
```php
<?php
require_once 'system/a_func.php';

// Reset admin password to 'admin123'
$newPassword = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE rank = 1 LIMIT 1");
if ($stmt->execute([$newPassword])) {
    echo "Admin password reset to 'admin123'";
} else {
    echo "Failed to reset admin password";
}
?>
```

### Clearing Sessions

If users are experiencing login issues:
```bash
# Clear session files
rm -f /tmp/sess_*
# Or wherever your sessions are stored
```

## Discord Bot Troubleshooting

### Bot Not Responding

1. Check if bot is running:
```bash
pm2 status
```

2. Check bot logs:
```bash
pm2 logs dedazen-store-bot
```

3. Restart bot:
```bash
pm2 restart dedazen-store-bot
```

### Bot Offline

1. Check internet connection
2. Verify bot token in `.env` file
3. Check if bot has proper permissions in Discord server
4. Restart bot process

## Performance Issues

### Slow Page Loading

1. Enable OPcache:
```ini
; In php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
```

2. Check server resources:
```bash
free -h
top
df -h
```

3. Optimize database:
```sql
OPTIMIZE TABLE users;
OPTIMIZE TABLE box_product;
OPTIMIZE TABLE box_stock;
```

## Payment Gateway Issues

### Truemoney Wallet API Not Working

1. Check API credentials in admin panel
2. Verify webhook URL is accessible
3. Check API endpoint status
4. Verify SSL certificate is valid

### Payment Not Recording

1. Check webhook logs
2. Verify callback URL is correct
3. Check database for payment records
4. Ensure cron jobs are running

## Email Notification Issues

### Emails Not Sending

1. Check SMTP settings in admin panel
2. Verify email credentials
3. Check spam/junk folder
4. Test with different email provider

### Email Configuration Test

Create `email_test.php`:
```php
<?php
require_once 'system/a_func.php';

$to = "test@example.com";
$subject = "Test Email";
$message = "This is a test email from Dedazen Store";
$headers = "From: noreply@" . $_SERVER['HTTP_HOST'];

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
?>
```

## Backup and Recovery

### Restoring Database from Backup

```bash
mysql -u username -p database_name < backup_file.sql
```

### Creating Emergency Backup

```bash
mysqldump -u username -p database_name > emergency_backup_$(date +%Y%m%d_%H%M%S).sql
```

## Server Configuration Issues

### Increasing PHP Limits

In `php.ini`:
```ini
memory_limit = 256M
upload_max_filesize = 32M
post_max_size = 32M
max_execution_time = 300
max_input_vars = 3000
```

### Setting up Cron Jobs

```bash
# Edit crontab
crontab -e

# Add these lines:
# Daily backup at 2 AM
0 2 * * * cd /path/to/website && php system/daily_backup.php
# Hourly stock check
0 * * * * cd /path/to/website && php system/check_low_stock.php
```

## Monitoring and Logs

### Checking Error Logs

```bash
# Apache error log
tail -f /var/log/apache2/error.log

# PHP error log
tail -f /var/log/php_errors.log

# MySQL error log
tail -f /var/log/mysql/error.log
```

### Enabling Debug Mode

In `system/a_func.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Emergency Procedures

### 1. Site Completely Down

1. Check server status
2. Restart Apache/MySQL services
3. Check disk space
4. Check error logs
5. Restore from latest backup if needed

### 2. Database Corruption

1. Stop web services
2. Check database integrity
3. Repair corrupted tables
4. Restore from backup if needed
5. Restart services

### 3. Security Breach

1. Immediately disconnect server from network
2. Change all passwords
3. Check for malicious files
4. Review access logs
5. Restore from clean backup
6. Update all software
7. Reconnect to network with enhanced security

## Contact Support

If you're unable to resolve an issue:

1. Document the exact error message
2. Note the steps that led to the error
3. Check server logs for additional information
4. Contact support with:
   - Error message
   - System information (PHP version, MySQL version)
   - Recent changes made to the system
   - Steps already taken to troubleshoot

Support Email: support@dedazen.com
Discord: https://discord.gg/yourserver

## Prevention Tips

1. **Regular Backups**: Schedule daily backups
2. **Monitor Logs**: Check error logs regularly
3. **Update Software**: Keep PHP, MySQL, and extensions updated
4. **Security Audits**: Regularly review security settings
5. **Performance Monitoring**: Monitor server resources
6. **Test Changes**: Always test changes in a development environment first

---

**Remember**: Always backup your system before making major changes. When in doubt, consult the documentation or contact support.
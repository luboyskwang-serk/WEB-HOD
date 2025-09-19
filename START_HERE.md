# 🚀 GETTING STARTED WITH DEDAZEN STORE

## Welcome! Let's get you up and running with Dedazen Store

### 📋 First Things First - READ THESE ESSENTIAL DOCUMENTS

1. **[README_FIRST_TH.md](README_FIRST_TH.md)** *(Start Here)* - Critical information before you begin
2. **[INSTALLATION_GUIDE_TH.md](INSTALLATION_GUIDE_TH.md)** - Complete installation walkthrough
3. **[SYSTEM_REQUIREMENTS_TH.md](SYSTEM_REQUIREMENTS_TH.md)** - Server and software requirements

### 🔧 Technical Documentation

- **[technical_documentation_th.md](technical_documentation_th.md)** - In-depth technical specifications
- **[security_audit_th.md](security_audit_th.md)** - Security features and audit results
- **[created_files_summary.md](created_files_summary.md)** - Complete file structure overview

### 🎯 Key Features Overview

#### 🔒 Enhanced Security System
- Upgraded from MD5 to bcrypt password hashing
- Two-Factor Authentication (2FA) with Google Authenticator
- Brute force protection
- Secure session management

#### 📢 Advanced Notification System
- Line Notify integration
- Email notifications
- Discord Bot alerts
- Flexible notification channels

#### 📦 Inventory Management
- Real-time stock tracking
- Automatic low stock alerts
- CSV import/export functionality
- Stock movement history

#### 🎟️ Coupon/Discount System
- Percentage or fixed amount coupons
- Expiration dates and usage limits
- Conditional restrictions
- Usage analytics

#### 🤝 Affiliate/Referral Program
- Automatic referral code generation
- Commission calculation
- Affiliate dashboard
- Social sharing integration

#### 🤖 Discord Bot Integration
- Real-time alerts for orders, topups, low stock
- System management commands
- Daily/weekly/monthly reports
- Security monitoring

### 🚀 Quick Start Steps

#### Step 1: Environment Setup
```bash
# Check PHP version (requires PHP 8.0+)
php -v

# Check required extensions
php -m | grep -E "(PDO|cURL|GD|OpenSSL|Mbstring)"

# Install Node.js for Discord Bot (if needed)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
nvm install node
```

#### Step 2: Database Configuration
1. Create MySQL database
2. Import database structure
3. Update `system/a_func.php` with your database credentials

#### Step 3: File Permissions
```bash
# Set proper permissions (Linux/Mac)
chmod -R 755 /path/to/your/website
chmod -R 777 /path/to/your/website/system
chmod -R 777 /path/to/your/website/page
```

#### Step 4: Run Database Updates
```bash
# Navigate to your website directory
cd /path/to/your/website

# Run the database update script
php system/db_updates.php

# Or access via browser
# http://yourdomain.com/system/db_updates.php
```

#### Step 5: Discord Bot Setup (Optional but Recommended)
```bash
# Navigate to Discord bot directory
cd discord_bot

# Install dependencies
npm install

# Configure environment variables
cp .env.example .env
# Edit .env with your Discord bot token and settings

# Start the bot
npm start

# For production, use PM2
npm install -g pm2
pm2 start src/index.js --name "dedazen-store-bot"
```

### 🔍 Post-Installation Checklist

- [ ] Change default admin password immediately
- [ ] Configure reCAPTCHA settings
- [ ] Set up payment gateways
- [ ] Configure notification channels (Line, Email, Discord)
- [ ] Test user registration and login
- [ ] Test product ordering process
- [ ] Test topup/payment system
- [ ] Verify Discord Bot functionality
- [ ] Set up automated backups
- [ ] Configure SSL/HTTPS
- [ ] Set up monitoring and alerts

### ⚠️ Common Issues and Solutions

#### Database Connection Failed
**Solution**: Check `system/a_func.php` database credentials and ensure MySQL is running

#### Registration Shows "Please verify identity"
**Solution**: Verify reCAPTCHA configuration in `system/a_func.php`

#### Discord Bot Offline
**Solution**: Check bot token and internet connectivity

#### Slow Page Loading
**Solution**: Enable OPcache and consider using a CDN

### 📞 Support and Community

#### Need Help?
- **Documentation**: Start with the guides listed above
- **Issues**: [GitHub Issues](https://github.com/your-repo/issues)
- **Community**: Join our Discord server
- **Email**: support@dedazen.com

#### Reporting Problems
When reporting issues, please include:
1. Error messages or screenshots
2. Steps to reproduce the problem
3. System environment details
4. PHP and database versions
5. Any recent changes made to the system

### 🔄 Regular Maintenance Tasks

#### Daily
- Check system logs
- Monitor resource usage
- Verify backup completion

#### Weekly
- Update dependencies
- Check security vulnerabilities
- Review user activity

#### Monthly
- Full system backup
- Performance optimization
- Review and update documentation

### 📈 Next Steps After Installation

1. **Configure Payment Methods** - Set up your preferred payment gateways
2. **Add Products** - Populate your store with items
3. **Set Up Categories** - Organize your products
4. **Configure Notifications** - Set up alert channels
5. **Test All Features** - Ensure everything works as expected
6. **Train Your Team** - Familiarize staff with the new system
7. **Go Live!** - Launch your enhanced Dedazen Store

### 🎉 Congratulations!

You're now equipped with one of the most advanced and secure e-commerce platforms available. The Dedazen Store system provides enterprise-level features while remaining accessible and user-friendly.

Remember to regularly:
- Keep your system updated
- Monitor security reports
- Maintain regular backups
- Stay informed about new features

---

**Next Recommended Reading**: 
1. [INSTALLATION_GUIDE_TH.md](INSTALLATION_GUIDE_TH.md) - Complete installation walkthrough
2. [README_FIRST_TH.md](README_FIRST_TH.md) - Critical information before you begin

*Have questions? Join our community on Discord for real-time support!*
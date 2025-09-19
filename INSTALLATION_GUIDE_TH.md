# คู่มือการติดตั้ง Dedazen Store ฉบับสมบูรณ์

## ความต้องการของระบบ

### เซิร์ฟเวอร์เว็บ
- PHP 8.0 ขึ้นไป
- MySQL 5.7 หรือ MariaDB 10.3 ขึ้นไป
- Apache หรือ Nginx
- SSL Certificate (แนะนำให้ใช้ HTTPS)

### Extensions ของ PHP ที่จำเป็น
- PDO
- cURL
- GD
- OpenSSL
- Mbstring
- Zip
- JSON

### Node.js (สำหรับ Discord Bot)
- Node.js 16.9.0 ขึ้นไป
- npm หรือ yarn

## ขั้นตอนการติดตั้ง

### 1. การเตรียมสภาพแวดล้อม

#### 1.1 ติดตั้ง XAMPP (สำหรับ Windows)
1. ดาวน์โหลด XAMPP จาก https://www.apachefriends.org/
2. ติดตั้ง XAMPP ตามคำแนะนำ
3. เปิด XAMPP Control Panel
4. เริ่ม Apache และ MySQL

#### 1.2 ติดตั้ง LAMP (สำหรับ Linux)
```bash
# Ubuntu/Debian
sudo apt update
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql

# CentOS/RHEL
sudo yum install httpd mariadb-server php php-mysql
```

#### 1.3 ติดตั้ง Node.js
```bash
# ใช้ Node Version Manager (แนะนำ)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
nvm install node
nvm use node

# หรือติดตั้งโดยตรง
# Ubuntu/Debian
sudo apt install nodejs npm

# CentOS/RHEL
sudo yum install nodejs npm
```

### 2. การตั้งค่าฐานข้อมูล

#### 2.1 สร้างฐานข้อมูล
1. เปิด phpMyAdmin ที่ http://localhost/phpmyadmin
2. คลิก "New" หรือ "สร้างฐานข้อมูลใหม่"
3. ตั้งชื่อฐานข้อมูล เช่น `dedazen_store`
4. เลือก Collation เป็น `utf8mb4_unicode_ci`

#### 2.2 นำเข้าโครงสร้างฐานข้อมูล
1. ไปที่แท็บ "Import" หรือ "นำเข้า"
2. เลือกไฟล์ `kakarotc_demo.sql`
3. คลิก "Go" หรือ "ดำเนินการ"

### 3. การติดตั้งไฟล์เว็บไซต์

#### 3.1 คัดลอกไฟล์เว็บไซต์
1. คัดลอกโฟลเดอร์ `htdocs` ทั้งหมดไปยังไดเรกทอรีเว็บของคุณ
   - Windows (XAMPP): `C:\xampp\htdocs\`
   - Linux (Apache): `/var/www/html/`

#### 3.2 ตั้งค่าสิทธิ์การเข้าถึงไฟล์
```bash
# Linux/Mac
chmod -R 755 /path/to/your/website
chmod -R 777 /path/to/your/website/system
chmod -R 777 /path/to/your/website/page
chmod -R 777 /path/to/your/website/assets
```

### 4. การตั้งค่าการเชื่อมต่อฐานข้อมูล

#### 4.1 แก้ไขไฟล์ `system/a_func.php`
เปิดไฟล์ `system/a_func.php` ด้วยโปรแกรมแก้ไขข้อความ และแก้ไขค่าต่อไปนี้:

```php
$host = "localhost";        // โฮสต์ฐานข้อมูล
$db_user = "root";          // ชื่อผู้ใช้ฐานข้อมูล
$db_pass = "";              // รหัสผ่านฐานข้อมูล
$db = "dedazen_store";      // ชื่อฐานข้อมูล
```

### 5. การอัปเดตโครงสร้างฐานข้อมูล

#### 5.1 รันสคริปต์อัปเดตฐานข้อมูล
เปิดเบราว์เซอร์และไปที่:
```
http://yourdomain.com/system/db_updates.php
```

หรือรันผ่าน command line:
```bash
cd /path/to/your/website
php system/db_updates.php
```

### 6. การตั้งค่า Discord Bot

#### 6.1 สร้าง Discord Application
1. ไปที่ https://discord.com/developers/applications
2. คลิก "New Application"
3. ตั้งชื่อ Application
4. ไปที่แท็บ "Bot"
5. คลิก "Add Bot"
6. เปิดใช้งาน Privileged Gateway Intents

#### 6.2 ติดตั้ง Dependencies ของ Bot
```bash
cd discord_bot
npm install
```

#### 6.3 ตั้งค่า Environment Variables
คัดลอกไฟล์ `.env.example` เป็น `.env` และแก้ไขค่า:

```env
# Discord Bot Configuration
DISCORD_TOKEN=your_discord_bot_token_here
CLIENT_ID=your_application_client_id
GUILD_ID=your_server_id

# API Configuration
API_BASE_URL=https://yourwebsite.com/api/bot
API_TOKEN=your_api_authentication_token
```

#### 6.4 รัน Discord Bot
```bash
cd discord_bot
npm start
```

หรือใช้ PM2 (สำหรับ Production):
```bash
npm install -g pm2
pm2 start src/index.js --name "dedazen-store-bot"
```

### 7. การตั้งค่าระบบแจ้งเตือน

#### 7.1 ตั้งค่า Line Notify
1. ไปที่ https://notify-bot.line.me/
2. ล็อกอินด้วยบัญชี LINE ของคุณ
3. คลิก "Generate token"
4. ตั้งชื่อ token
5. เลือกกลุ่มหรือแชทที่ต้องการส่งแจ้งเตือน
6. คัดลอก token ที่สร้างขึ้นมา

#### 7.2 ตั้งค่า Webhook URL ในระบบ
1. เข้าสู่ระบบ Admin Panel
2. ไปที่การตั้งค่าเว็บไซต์
3. ใส่ Webhook URL ของ Discord
4. บันทึกการตั้งค่า

### 8. การตั้งค่า reCAPTCHA

#### 8.1 สร้าง reCAPTCHA Keys
1. ไปที่ https://www.google.com/recaptcha/admin
2. คลิก "Register a new site"
3. ตั้งชื่อเว็บไซต์
4. เลือก reCAPTCHA v2
5. เพิ่มโดเมนของเว็บไซต์
6. คัดลอก Site Key และ Secret Key

#### 8.2 ตั้งค่าใน `system/a_func.php`
```php
$conf['sitekey'] = "your_recaptcha_site_key";
$conf['secretkey'] = "your_recaptcha_secret_key";
```

### 9. การตั้งค่าโดเมนและ SSL

#### 9.1 ตั้งค่า Virtual Host (Apache)
เพิ่มในไฟล์ `httpd-vhosts.conf`:
```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs"
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
</VirtualHost>
```

#### 9.2 ติดตั้ง SSL Certificate (Let's Encrypt)
```bash
# ติดตั้ง Certbot
sudo apt install certbot python3-certbot-apache

# ขอ SSL Certificate
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
```

### 10. การทดสอบระบบ

#### 10.1 ทดสอบการลงทะเบียนผู้ใช้
1. เปิดเบราว์เซอร์ไปที่ `http://yourdomain.com`
2. คลิก "สมัครสมาชิก"
3. กรอกข้อมูลและลงทะเบียน
4. ตรวจสอบอีเมลสำหรับการยืนยัน

#### 10.2 ทดสอบการเข้าสู่ระบบ
1. เปิดหน้าล็อกอิน
2. กรอกชื่อผู้ใช้และรหัสผ่าน
3. ตรวจสอบว่าสามารถเข้าสู่ระบบได้

#### 10.3 ทดสอบ Discord Bot
1. เชิญ Bot เข้าเซิร์ฟเวอร์ Discord
2. ใช้คำสั่ง `/help` เพื่อดูคำสั่งที่ใช้งานได้
3. ทดสอบคำสั่งพื้นฐาน

#### 10.4 ทดสอบการแจ้งเตือน
1. สร้างคำสั่งซื้อใหม่
2. ตรวจสอบว่ามีการแจ้งเตือนใน Discord
3. ตรวจสอบว่ามีอีเมลแจ้งเตือนถูกส่ง

### 11. การตั้งค่า Cron Jobs

#### 11.1 ตั้งค่ารายงานประจำวัน
เพิ่มใน crontab:
```bash
# รายงานประจำวันเวลา 9:00 น.
0 9 * * * cd /path/to/your/website && php system/daily_report.php

# ตรวจสอบสต็อกต่ำทุกชั่วโมง
0 * * * * cd /path/to/your/website && php system/check_low_stock.php

# สำรองข้อมูลฐานข้อมูลทุกวันเวลา 2:00 น.
0 2 * * * mysqldump -u username -p database_name > /backup/database_backup_$(date +%Y%m%d).sql
```

### 12. การตั้งค่าความปลอดภัย

#### 12.1 ป้องกันการเข้าถึงไฟล์โดยตรง
เพิ่มใน `.htaccess`:
```apache
# ป้องกันการเข้าถึงไฟล์ .env
<Files ".env">
    Require all denied
</Files>

# ป้องกันการเข้าถึงไฟล์ config
<FilesMatch "\.(config|conf)$">
    Require all denied
</FilesMatch>
```

#### 12.2 ตั้งค่า Firewall
```bash
# Ubuntu/Debian (ufw)
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 3306/tcp
sudo ufw enable

# CentOS/RHEL (firewalld)
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --permanent --add-port=3306/tcp
sudo firewall-cmd --reload
```

### 13. การตั้งค่าการสำรองข้อมูล

#### 13.1 สำรองข้อมูลฐานข้อมูล
```bash
#!/bin/bash
# backup_db.sh
mysqldump -u username -p password database_name > /backup/database_$(date +%Y%m%d_%H%M%S).sql
```

#### 13.2 สำรองข้อมูลไฟล์เว็บไซต์
```bash
#!/bin/bash
# backup_files.sh
tar -czf /backup/files_$(date +%Y%m%d_%H%M%S).tar.gz /path/to/your/website
```

### 14. การตรวจสอบและดูแลระบบ

#### 14.1 ตรวจสอบ Logs
```bash
# ตรวจสอบ Apache logs
tail -f /var/log/apache2/error.log

# ตรวจสอบ MySQL logs
tail -f /var/log/mysql/error.log

# ตรวจสอบ Discord Bot logs
pm2 logs dedazen-store-bot
```

#### 14.2 ตรวจสอบประสิทธิภาพ
```bash
# ตรวจสอบการใช้หน่วยความจำ
free -h

# ตรวจสอบการใช้ CPU
top

# ตรวจสอบขนาดของฐานข้อมูล
mysql -u username -p -e "SELECT table_schema AS 'Database', ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)' FROM information_schema.tables GROUP BY table_schema;"
```

## การแก้ปัญหาทั่วไป

### ปัญหาการเชื่อมต่อฐานข้อมูล
**อาการ**: แสดงข้อความ "Connection failed"
**วิธีแก้ไข**:
1. ตรวจสอบการตั้งค่าใน `system/a_func.php`
2. ตรวจสอบว่า MySQL ทำงานอยู่
3. ตรวจสอบว่าฐานข้อมูลมีอยู่จริง

### ปัญหาการลงทะเบียนผู้ใช้
**อาการ**: แสดงข้อความ "กรุณายืนยันตัวตน"
**วิธีแก้ไข**:
1. ตรวจสอบการตั้งค่า reCAPTCHA
2. ตรวจสอบการเชื่อมต่ออินเทอร์เน็ต
3. ตรวจสอบว่า JavaScript เปิดใช้งานในเบราว์เซอร์

### ปัญหา Discord Bot
**อาการ**: Bot ไม่ออนไลน์ใน Discord
**วิธีแก้ไข**:
1. ตรวจสอบ Token ของ Bot
2. ตรวจสอบการเชื่อมต่ออินเทอร์เน็ต
3. ตรวจสอบ Logs ของ Bot

## ข้อแนะนำเพิ่มเติม

### 1. การปรับปรุงความปลอดภัย
- เปลี่ยนรหัสผ่านฐานข้อมูลเป็นรหัสที่ซับซ้อน
- ใช้ Firewall เพื่อจำกัดการเข้าถึงพอร์ต
- อัปเดต PHP และ Extensions เป็นเวอร์ชันล่าสุด
- ใช้ HTTPS เสมอ

### 2. การปรับปรุงประสิทธิภาพ
- เปิดใช้งาน OPcache ของ PHP
- ใช้ CDN สำหรับไฟล์ Static
- ปรับแต่ง MySQL สำหรับการใช้งานเว็บ
- ใช้ Redis หรือ Memcached สำหรับ Cache

### 3. การดูแลรักษา
- สำรองข้อมูลประจำวัน
- ตรวจสอบ Logs อย่างสม่ำเสมอ
- อัปเดตระบบปฏิบัติการและ Software
- ทดสอบระบบอย่างสม่ำเสมอ

## ข้อมูลการติดต่อ

หากพบปัญหาหรือมีข้อสงสัยในการติดตั้ง กรุณาติดต่อ:
- อีเมล: support@dedazen.com
- Discord: https://discord.gg/yourserver
- เว็บไซต์: https://dedazen.com

## ลิขสิทธิ์

ระบบ Dedazen Store เป็นผลงานที่ได้รับลิขสิทธิ์ © 2024 Dedazen Store. สงวนลิขสิทธิ์ทั้งหมด.

---

**หมายเหตุ**: คู่มือการติดตั้งนี้เป็นแนวทางเบื้องต้น คุณอาจต้องปรับแต่งตามสภาพแวดล้อมของคุณเอง ขอแนะนำให้ทดสอบทุกอย่างในสภาพแวดล้อมทดสอบก่อนนำไปใช้งานจริง
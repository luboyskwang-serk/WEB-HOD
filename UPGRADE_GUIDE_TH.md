# คู่มือการอัปเกรด Dedazen Store จากเวอร์ชันเดิม

## บทนำ

เอกสารนี้เป็นคู่มือสำหรับการอัปเกรดระบบ Dedazen Store จากเวอร์ชันเดิมไปเป็นเวอร์ชันที่ได้รับการปรับปรุงใหม่ ซึ่งรวมถึงระบบความปลอดภัยที่เข้มงวดขึ้น การแจ้งเตือนที่ทันสมัย และฟีเจอร์ใหม่ๆ เช่น Discord Bot และระบบ Affiliate

## ก่อนการอัปเกรด

### 1. การสำรองข้อมูล

#### 1.1 สำรองฐานข้อมูล
```bash
# สำรองฐานข้อมูลทั้งหมด
mysqldump -u username -p database_name > backup_before_upgrade.sql

# หรือสำรองเฉพาะตารางที่สำคัญ
mysqldump -u username -p database_name users box_product box_stock topup_his boxlog > backup_essential_tables.sql
```

#### 1.2 สำรองไฟล์เว็บไซต์
```bash
# สร้าง archive ของไฟล์เว็บไซต์ทั้งหมด
tar -czf website_backup_$(date +%Y%m%d_%H%M%S).tar.gz /path/to/htdocs/

# หรือคัดลอกเฉพาะไฟล์ที่สำคัญ
cp -r /path/to/htdocs/system /path/to/backup/system_$(date +%Y%m%d_%H%M%S)/
cp -r /path/to/htdocs/page /path/to/backup/page_$(date +%Y%m%d_%H%M%S)/
cp -r /path/to/htdocs/assets /path/to/backup/assets_$(date +%Y%m%d_%H%M%S)/
```

#### 1.3 จดบันทึกการตั้งค่าปัจจุบัน
- จดบันทึกการตั้งค่าในไฟล์ `system/a_func.php`
- จดบันทึกการตั้งค่าของโดเมนและ SSL
- จดบันทึกการตั้งค่าของ Payment Gateway
- จดบันทึกการตั้งค่าของ Discord Bot (ถ้ามี)

### 2. การตรวจสอบสภาพแวดล้อม

#### 2.1 ตรวจสอบเวอร์ชันของ PHP
```bash
php -v
```
**ข้อกำหนดขั้นต่ำ**: PHP 8.0 ขึ้นไป

#### 2.2 ตรวจสอบ Extensions ของ PHP
```bash
php -m
```
**Extensions ที่จำเป็น**:
- PDO
- cURL
- GD
- OpenSSL
- Mbstring
- Zip
- JSON

#### 2.3 ตรวจสอบเวอร์ชันของ MySQL/MariaDB
```bash
mysql -V
```
**ข้อกำหนดขั้นต่ำ**: MySQL 5.7 หรือ MariaDB 10.3 ขึ้นไป

#### 2.4 ตรวจสอบ Node.js (สำหรับ Discord Bot)
```bash
node -v
npm -v
```
**ข้อกำหนดขั้นต่ำ**: Node.js 16.9.0 ขึ้นไป

## ขั้นตอนการอัปเกรด

### 1. การสำรองเวอร์ชันเดิม (สำหรับ Rollback)

#### 1.1 ย้ายไฟล์เว็บไซต์เดิม
```bash
# สร้างไดเรกทอรีสำรอง
mkdir /path/to/old_website_backup_$(date +%Y%m%d_%H%M%S)

# ย้ายไฟล์เว็บไซต์เดิม
mv /path/to/htdocs/* /path/to/old_website_backup_$(date +%Y%m%d_%H%M%S)/
```

#### 1.2 สำรองข้อมูลฐานข้อมูลเดิม
```bash
# สร้าง dump ของฐานข้อมูลเดิม
mysqldump -u username -p old_database_name > old_database_backup_$(date +%Y%m%d_%H%M%S).sql
```

### 2. การติดตั้งเวอร์ชันใหม่

#### 2.1 คัดลอกไฟล์เว็บไซต์ใหม่
```bash
# คัดลอกไฟล์เว็บไซต์ใหม่ไปยังไดเรกทอรี htdocs
cp -r /path/to/new_files/* /path/to/htdocs/
```

#### 2.2 ตั้งค่าสิทธิ์การเข้าถึงไฟล์
```bash
# ตั้งค่าสิทธิ์สำหรับ Unix/Linux
chmod -R 755 /path/to/htdocs/
chmod -R 777 /path/to/htdocs/system
chmod -R 777 /path/to/htdocs/page
chmod -R 777 /path/to/htdocs/assets
```

#### 2.3 ตั้งค่าการเชื่อมต่อฐานข้อมูล
เปิดไฟล์ `system/a_func.php` และตรวจสอบการตั้งค่า:

```php
$host = "localhost";        // ตรวจสอบให้แน่ใจว่าถูกต้อง
$db_user = "your_db_user";  // ตรวจสอบให้แน่ใจว่าถูกต้อง
$db_pass = "your_db_pass";  // ตรวจสอบให้แน่ใจว่าถูกต้อง
$db = "your_database";      // ตรวจสอบให้แน่ใจว่าถูกต้อง
```

### 3. การอัปเดตโครงสร้างฐานข้อมูล

#### 3.1 รันสคริปต์อัปเดตฐานข้อมูล
```bash
cd /path/to/htdocs/
php system/db_updates.php
```

หรือเปิดเบราว์เซอร์ไปที่:
```
http://yourdomain.com/system/db_updates.php
```

#### 3.2 ตรวจสอบผลการอัปเดต
- ตรวจสอบ Logs ว่าไม่มีข้อผิดพลาด
- ตรวจสอบว่าตารางใหม่ถูกสร้างขึ้นเรียบร้อย
- ตรวจสอบว่าตารางเดิมได้รับการอัปเดตเรียบร้อย

### 4. การย้ายข้อมูลผู้ใช้และสินค้า

#### 4.1 แปลง Password Hashing ของผู้ใช้
ระบบจะแปลง Password Hashing แบบ MD5 เป็น bcrypt อัตโนมัติเมื่อผู้ใช้เข้าสู่ระบบครั้งแรก ไม่จำเป็นต้องทำอะไรเพิ่มเติม

#### 4.2 ย้ายข้อมูลสินค้าคงคลัง
ถ้าคุณมีระบบสต็อกเดิม ให้สร้างสคริปต์สำหรับย้ายข้อมูล:

```php
// migrate_inventory.php
<?php
require_once 'system/a_func.php';

// ดึงสต็อกเดิม
$stmt = $conn->prepare("SELECT * FROM box_stock_old");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // เพิ่มลงในระบบสต็อกใหม่
    $insertStmt = $conn->prepare("INSERT INTO box_stock (username, password, p_id) VALUES (?, ?, ?)");
    $insertStmt->execute([$row['username'], $row['password'], $row['p_id']]);
}

echo "Inventory migration completed.";
?>
```

### 5. การตั้งค่า Discord Bot

#### 5.1 ติดตั้ง Dependencies
```bash
cd /path/to/htdocs/discord_bot
npm install
```

#### 5.2 ตั้งค่า Environment Variables
คัดลอกไฟล์ `.env.example` เป็น `.env` และแก้ไขค่า:

```env
DISCORD_TOKEN=your_discord_bot_token
CLIENT_ID=your_application_client_id
GUILD_ID=your_guild_id
API_BASE_URL=https://yourwebsite.com/api/bot
API_TOKEN=your_api_token
```

#### 5.3 รัน Discord Bot
```bash
# รันในโหมด development
npm start

# หรือรันด้วย PM2 สำหรับ production
npm install -g pm2
pm2 start src/index.js --name "dedazen-store-bot"
```

### 6. การตั้งค่าระบบแจ้งเตือน

#### 6.1 ตั้งค่า Line Notify (ถ้าใช้)
1. ไปที่ https://notify-bot.line.me/
2. สร้าง Token ใหม่
3. บันทึก Token ไว้ในระบบ

#### 6.2 ตั้งค่า Webhook URL
เข้าสู่ระบบ Admin Panel และตั้งค่า Webhook URL สำหรับ Discord:

1. ไปที่การตั้งค่าเว็บไซต์
2. กรอก Discord Webhook URL
3. เปิดใช้งานการแจ้งเตือนที่ต้องการ

### 7. การตั้งค่าระบบ Affiliate

#### 7.1 สร้าง Referral Codes สำหรับผู้ใช้เดิม
```php
// generate_referral_codes.php
<?php
require_once 'system/a_func.php';
require_once 'system/affiliate.php';

// ดึงผู้ใช้ทั้งหมดที่ยังไม่มี Referral Code
$stmt = $conn->prepare("SELECT id FROM users WHERE referral_code IS NULL OR referral_code = ''");
$stmt->execute();

while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // สร้าง Referral Code ใหม่
    $referralCode = AffiliateManager::generateReferralCode($user['id']);
    echo "Generated referral code for user ID " . $user['id'] . ": " . $referralCode . "\n";
}

echo "All referral codes generated.";
?>
```

### 8. การตั้งค่าระบบคูปอง

#### 8.1 นำเข้าคูปองเดิม (ถ้ามี)
ถ้าคุณมีระบบคูปองเดิม ให้สร้างสคริปต์สำหรับย้ายข้อมูล:

```php
// migrate_coupons.php
<?php
require_once 'system/a_func.php';

// ดึงคูปองเดิม
$stmt = $conn->prepare("SELECT * FROM old_coupons_table");
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // เพิ่มคูปองใหม่
    $insertStmt = $conn->prepare("INSERT INTO coupons (code, discount_type, discount_value, minimum_amount, expiry_date, usage_limit, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $insertStmt->execute([
        $row['code'],
        $row['type'] == 'percent' ? 'percentage' : 'fixed',
        $row['value'],
        $row['min_amount'],
        $row['expire_date'],
        $row['usage_limit'],
        'active'
    ]);
}

echo "Coupons migration completed.";
?>
```

## หลังการอัปเกรด

### 1. การทดสอบระบบ

#### 1.1 ทดสอบการลงทะเบียนผู้ใช้ใหม่
1. เปิดเบราว์เซอร์ไปที่หน้าลงทะเบียน
2. สร้างบัญชีใหม่
3. ตรวจสอบว่าสามารถเข้าสู่ระบบได้

#### 1.2 ทดสอบการเข้าสู่ระบบผู้ใช้เดิม
1. ใช้บัญชีเดิมเข้าสู่ระบบ
2. ตรวจสอบว่าระบบจะอัปเกรด Password Hashing อัตโนมัติ
3. ตรวจสอบว่าสามารถใช้งานฟีเจอร์ใหม่ได้

#### 1.3 ทดสอบระบบสั่งซื้อ
1. สั่งซื้อสินค้าทดสอบ
2. ตรวจสอบการลดสต็อก
3. ตรวจสอบการแจ้งเตือน

#### 1.4 ทดสอบ Discord Bot
1. เชิญ Bot เข้าเซิร์ฟเวอร์ (ถ้ายังไม่ได้เชิญ)
2. ใช้คำสั่ง `/help` เพื่อดูคำสั่งที่ใช้งานได้
3. ทดสอบคำสั่งพื้นฐาน

### 2. การตรวจสอบความปลอดภัย

#### 2.1 ตรวจสอบ Password Hashing
```sql
-- ตรวจสอบว่าผู้ใช้ใหม่ใช้ bcrypt
SELECT id, username, password FROM users WHERE LENGTH(password) > 32 LIMIT 5;
```

#### 2.2 ตรวจสอบการตั้งค่า 2FA
- ทดสอบการเปิดใช้งาน 2FA
- ทดสอบการ login ด้วย 2FA
- ทดสอบการปิดใช้งาน 2FA

#### 2.3 ตรวจสอบระบบป้องกัน Brute Force
- ทดสอบการ login หลายครั้งด้วยรหัสผ่านผิด
- ตรวจสอบว่าระบบจะบล็อก IP หรือไม่

### 3. การปรับปรุงประสิทธิภาพ

#### 3.1 เปิดใช้งาน OPcache (ถ้ายังไม่ได้เปิด)
ในไฟล์ `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

#### 3.2 ปรับแต่ง MySQL
ในไฟล์ `my.cnf`:
```ini
[mysqld]
innodb_buffer_pool_size = 1G
query_cache_size = 64M
tmp_table_size = 64M
max_heap_table_size = 64M
```

## การแก้ปัญหาทั่วไป

### ปัญหาการเชื่อมต่อฐานข้อมูล
**อาการ**: แสดงข้อความ "Connection failed"
**วิธีแก้ไข**:
1. ตรวจสอบการตั้งค่าใน `system/a_func.php`
2. ตรวจสอบว่า MySQL ทำงานอยู่
3. ตรวจสอบ Firewall ว่าเปิดพอร์ต 3306 หรือไม่

### ปัญหาการลงทะเบียนผู้ใช้
**อาการ**: แสดงข้อความ "กรุณายืนยันตัวตน"
**วิธีแก้ไข**:
1. ตรวจสอบการตั้งค่า reCAPTCHA
2. ตรวจสอบการเชื่อมต่ออินเทอร์เน็ต
3. ตรวจสอบว่า JavaScript เปิดใช้งานในเบราว์เซอร์

### ปัญหา Password Hashing
**อาการ**: ผู้ใช้เก่าไม่สามารถเข้าสู่ระบบได้
**วิธีแก้ไข**:
1. ตรวจสอบว่าผู้ใช้สามารถ login ได้ (ระบบจะอัปเกรด hash อัตโนมัติ)
2. หากยังไม่ได้ ให้ให้ผู้ใช้รีเซ็ตรหัสผ่าน

### ปัญหา Discord Bot
**อาการ**: Bot ไม่ออนไลน์ใน Discord
**วิธีแก้ไข**:
1. ตรวจสอบ Token ของ Bot
2. ตรวจสอบการเชื่อมต่ออินเทอร์เน็ต
3. ตรวจสอบ Logs ของ Bot

## การ Rollback (หากเกิดปัญหา)

### 1. คืนค่าไฟล์เว็บไซต์
```bash
# ลบไฟล์เว็บไซต์ใหม่
rm -rf /path/to/htdocs/*

# คืนค่าไฟล์เว็บไซต์เดิม
cp -r /path/to/old_website_backup_*/* /path/to/htdocs/
```

### 2. คืนค่าฐานข้อมูล
```bash
# ลบฐานข้อมูลใหม่
mysql -u username -p -e "DROP DATABASE your_database; CREATE DATABASE your_database;"

# คืนค่าฐานข้อมูลเดิม
mysql -u username -p your_database < old_database_backup.sql
```

### 3. คืนค่าการตั้งค่า
- คืนค่าการตั้งค่าใน `system/a_func.php`
- คืนค่าการตั้งค่าโดเมนและ SSL
- คืนค่าการตั้งค่า Payment Gateway

## การดูแลรักษาระบบ

### 1. การสำรองข้อมูลประจำวัน
```bash
#!/bin/bash
# daily_backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/dedazen_store"

# สำรองฐานข้อมูล
mysqldump -u username -p database_name > "$BACKUP_DIR/database_$DATE.sql"

# สำรองไฟล์เว็บไซต์สำคัญ
tar -czf "$BACKUP_DIR/files_$DATE.tar.gz" /path/to/htdocs/system /path/to/htdocs/page

# ลบไฟล์เก่าที่เกิน 30 วัน
find $BACKUP_DIR -name "*.sql" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete
```

### 2. การตรวจสอบระบบ
```bash
#!/bin/bash
# system_check.sh

# ตรวจสอบสถานะของ Discord Bot
BOT_STATUS=$(pm2 status | grep dedazen-store-bot | awk '{print $10}')
if [ "$BOT_STATUS" != "online" ]; then
    echo "Discord Bot is offline!"
    # ส่งแจ้งเตือนทาง Line หรือ Email
fi

# ตรวจสอบพื้นที่ว่างในดิสก์
DISK_USAGE=$(df / | tail -1 | awk '{print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 90 ]; then
    echo "Disk usage is above 90%!"
fi

# ตรวจสอบการใช้หน่วยความจำ
MEMORY_USAGE=$(free | grep Mem | awk '{printf("%.2f"), $3/$2 * 100.0}')
if (( $(echo "$MEMORY_USAGE > 90" | bc -l) )); then
    echo "Memory usage is above 90%!"
fi
```

## สรุป

การอัปเกรดระบบ Dedazen Store เป็นกระบวนการที่สำคัญที่จะช่วยให้เว็บไซต์ของคุณมีความปลอดภัยมากขึ้น ฟีเจอร์ใหม่ๆ มากขึ้น และสามารถจัดการได้ง่ายขึ้น โดยเฉพาะด้วยการเพิ่ม Discord Bot ที่จะช่วยให้คุณสามารถติดตามและจัดการระบบได้จาก Discord

**สิ่งสำคัญที่ต้องจำ**:
1. สำรองข้อมูลก่อนอัปเกรดเสมอ
2. ทดสอบในสภาพแวดล้อมทดสอบก่อนนำไปใช้งานจริง
3. ตรวจสอบระบบอย่างละเอียดหลังการอัปเกรด
4. ตั้งค่าการสำรองข้อมูลอัตโนมัติ
5. ติดตามระบบอย่างสม่ำเสมอ

หากคุณมีคำถามเพิ่มเติมหรือพบปัญหาในการอัปเกรด กรุณาติดต่อทีมสนับสนุนของเรา
# คู่มือการดูแลรักษา Dedazen Store

## บทนำ

เอกสารนี้เป็นคู่มือสำหรับการดูแลรักษาระบบ Dedazen Store อย่างมีประสิทธิภาพ เพื่อให้ระบบสามารถทำงานได้อย่างต่อเนื่อง มีความปลอดภัย และให้บริการแก่ผู้ใช้ได้อย่างดีเยี่ยม

## แผนการดูแลรักษา

### แผนการรายวัน
| เวลา | งาน | ความรับผิดชอบ |
|------|-----|----------------|
| 06:00 | ตรวจสอบสถานะเซิร์ฟเวอร์ | ระบบอัตโนมัติ |
| 09:00 | ตรวจสอบการแจ้งเตือน | ผู้ดูแลระบบ |
| 12:00 | ตรวจสอบประสิทธิภาพ | ระบบอัตโนมัติ |
| 18:00 | ตรวจสอบ Logs | ระบบอัตโนมัติ |
| 22:00 | สำรองข้อมูล | ระบบอัตโนมัติ |

### แผนการรายสัปดาห์
| วัน | งาน | ความรับผิดชอบ |
|-----|-----|----------------|
| จันทร์ | ตรวจสอบความปลอดภัย | ผู้ดูแลระบบ |
| อังคาร | ตรวจสอบประสิทธิภาพเว็บไซต์ | ผู้ดูแลระบบ |
| พุธ | ตรวจสอบอัปเดตระบบ | ผู้ดูแลระบบ |
| พฤหัสบดี | ตรวจสอบการใช้งานฐานข้อมูล | ผู้ดูแลระบบ |
| ศุกร์ | ตรวจสอบการใช้งาน Disk | ระบบอัตโนมัติ |
| เสาร์ | ตรวจสอบระบบแจ้งเตือน | ผู้ดูแลระบบ |
| อาทิตย์ | สรุปรายงานประจำสัปดาห์ | ผู้ดูแลระบบ |

### แผนการรายเดือน
| วัน | งาน | ความรับผิดชอบ |
|-----|-----|----------------|
| 1 | สำรองข้อมูลเต็มระบบ | ระบบอัตโนมัติ |
| 7 | ตรวจสอบความปลอดภัย | ผู้ดูแลระบบ |
| 15 | ตรวจสอบประสิทธิภาพ | ผู้ดูแลระบบ |
| 22 | ตรวจสอบ Logs | ผู้ดูแลระบบ |
| 30 | สรุปรายงานประจำเดือน | ผู้ดูแลระบบ |

## การตรวจสอบสถานะระบบ

### 1. การตรวจสอบเซิร์ฟเวอร์

#### 1.1 ตรวจสอบการใช้งาน CPU
```bash
#!/bin/bash
# check_cpu.sh
CPU_USAGE=$(top -bn1 | grep "Cpu(s)" | awk '{print $2}' | cut -d'%' -f1)
if (( $(echo "$CPU_USAGE > 80" | bc -l) )); then
    echo "CPU Usage is high: ${CPU_USAGE}%"
    # ส่งแจ้งเตือน
fi
```

#### 1.2 ตรวจสอบการใช้งานหน่วยความจำ
```bash
#!/bin/bash
# check_memory.sh
MEMORY_USAGE=$(free | grep Mem | awk '{printf("%.2f"), $3/$2 * 100.0}')
if (( $(echo "$MEMORY_USAGE > 85" | bc -l) )); then
    echo "Memory Usage is high: ${MEMORY_USAGE}%"
    # ส่งแจ้งเตือน
fi
```

#### 1.3 ตรวจสอบการใช้งาน Disk
```bash
#!/bin/bash
# check_disk.sh
DISK_USAGE=$(df / | tail -1 | awk '{print $5}' | sed 's/%//')
if [ $DISK_USAGE -gt 80 ]; then
    echo "Disk Usage is high: ${DISK_USAGE}%"
    # ส่งแจ้งเตือน
fi
```

### 2. การตรวจสอบบริการเว็บ

#### 2.1 ตรวจสอบสถานะ Apache/Nginx
```bash
#!/bin/bash
# check_web_server.sh
if systemctl is-active --quiet apache2; then
    echo "Apache is running"
elif systemctl is-active --quiet nginx; then
    echo "Nginx is running"
else
    echo "Web server is not running"
    # ส่งแจ้งเตือน
fi
```

#### 2.2 ตรวจสอบสถานะ MySQL/MariaDB
```bash
#!/bin/bash
# check_database.sh
if systemctl is-active --quiet mysql; then
    echo "MySQL is running"
elif systemctl is-active --quiet mariadb; then
    echo "MariaDB is running"
else
    echo "Database server is not running"
    # ส่งแจ้งเตือน
fi
```

#### 2.3 ตรวจสอบการเชื่อมต่อฐานข้อมูล
```php
// check_db_connection.php
<?php
require_once 'system/a_func.php';

try {
    $conn->query("SELECT 1");
    echo "Database connection is OK";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    // ส่งแจ้งเตือน
}
?>
```

### 3. การตรวจสอบ Discord Bot

#### 3.1 ตรวจสอบสถานะ Discord Bot
```bash
#!/bin/bash
# check_discord_bot.sh
BOT_STATUS=$(pm2 status | grep dedazen-store-bot | awk '{print $10}')
if [ "$BOT_STATUS" != "online" ]; then
    echo "Discord Bot is offline"
    # ส่งแจ้งเตือน
    # รีสตาร์ท Bot
    pm2 restart dedazen-store-bot
fi
```

## การสำรองข้อมูล

### 1. การสำรองข้อมูลฐานข้อมูล

#### 1.1 สคริปต์สำรองข้อมูลรายวัน
```bash
#!/bin/bash
# daily_backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/dedazen_store"
DB_USER="your_db_user"
DB_PASS="your_db_pass"
DB_NAME="dedazen_store"

# สร้างไดเรกทอรีสำรองข้อมูล
mkdir -p $BACKUP_DIR

# สำรองฐานข้อมูล
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > "$BACKUP_DIR/database_$DATE.sql"

# Compress ไฟล์
gzip "$BACKUP_DIR/database_$DATE.sql"

# ลบไฟล์เก่าที่เกิน 30 วัน
find $BACKUP_DIR -name "*.sql.gz" -mtime +30 -delete

echo "Daily database backup completed"
```

#### 1.2 สคริปต์สำรองข้อมูลรายสัปดาห์
```bash
#!/bin/bash
# weekly_backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/dedazen_store/weekly"
WEB_DIR="/var/www/html"

# สร้างไดเรกทอรีสำรองข้อมูล
mkdir -p $BACKUP_DIR

# สำรองไฟล์เว็บไซต์
tar -czf "$BACKUP_DIR/files_$DATE.tar.gz" $WEB_DIR

# สำรองฐานข้อมูล
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > "$BACKUP_DIR/database_$DATE.sql.gz"

# ลบไฟล์เก่าที่เกิน 90 วัน
find $BACKUP_DIR -name "*.tar.gz" -mtime +90 -delete
find $BACKUP_DIR -name "*.sql.gz" -mtime +90 -delete

echo "Weekly full backup completed"
```

### 2. การกู้คืนข้อมูล

#### 2.1 กู้คืนฐานข้อมูล
```bash
#!/bin/bash
# restore_database.sh
BACKUP_FILE="$1"

if [ -z "$BACKUP_FILE" ]; then
    echo "Usage: $0 <backup_file.sql.gz>"
    exit 1
fi

# หยุดบริการเว็บชั่วคราว
systemctl stop apache2

# กู้คืนฐานข้อมูล
gunzip -c $BACKUP_FILE | mysql -u $DB_USER -p$DB_PASS $DB_NAME

# เริ่มบริการเว็บ
systemctl start apache2

echo "Database restored from $BACKUP_FILE"
```

#### 2.2 กู้คืนไฟล์เว็บไซต์
```bash
#!/bin/bash
# restore_files.sh
BACKUP_FILE="$1"
RESTORE_DIR="$2"

if [ -z "$BACKUP_FILE" ] || [ -z "$RESTORE_DIR" ]; then
    echo "Usage: $0 <backup_file.tar.gz> <restore_directory>"
    exit 1
fi

# สำรองไฟล์เดิมก่อน
tar -czf "/tmp/files_backup_$(date +%Y%m%d_%H%M%S).tar.gz" $RESTORE_DIR

# กู้คืนไฟล์
tar -xzf $BACKUP_FILE -C $RESTORE_DIR

echo "Files restored from $BACKUP_FILE to $RESTORE_DIR"
```

## การตรวจสอบความปลอดภัย

### 1. การสแกน Malware

#### 1.1 สแกนด้วย ClamAV
```bash
#!/bin/bash
# scan_malware.sh
WEB_DIR="/var/www/html"
LOG_FILE="/var/log/clamav_scan.log"

clamscan -r $WEB_DIR --log=$LOG_FILE

if [ $? -eq 0 ]; then
    echo "No malware found"
else
    echo "Malware detected! Check $LOG_FILE"
    # ส่งแจ้งเตือน
fi
```

#### 1.2 ตรวจสอบไฟล์ที่เปลี่ยนแปลง
```bash
#!/bin/bash
# check_file_changes.sh
WEB_DIR="/var/www/html"
HASH_FILE="/var/lib/file_hashes.txt"
TEMP_HASH_FILE="/tmp/current_hashes.txt"

# สร้าง hash ของไฟล์ปัจจุบัน
find $WEB_DIR -type f -exec md5sum {} \; > $TEMP_HASH_FILE

# เปรียบเทียบกับ hash ที่บันทึกไว้
if [ -f $HASH_FILE ]; then
    diff $HASH_FILE $TEMP_HASH_FILE > /dev/null
    if [ $? -ne 0 ]; then
        echo "Files have been modified!"
        # ส่งแจ้งเตือน
        # อัปเดต hash file
        cp $TEMP_HASH_FILE $HASH_FILE
    fi
else
    # สร้าง hash file ครั้งแรก
    cp $TEMP_HASH_FILE $HASH_FILE
fi
```

### 2. การตรวจสอบการเข้าถึง

#### 2.1 ตรวจสอบ Failed Login Attempts
```bash
#!/bin/bash
# check_failed_logins.sh
LOG_FILE="/var/log/apache2/access.log"
THRESHOLD=10

# ตรวจสอบ IP ที่มีการเข้าถึงผิดพลาดมากเกินไป
awk '{print $1}' $LOG_FILE | sort | uniq -c | sort -nr | head -20 > /tmp/failed_logins.txt

while read count ip; do
    if [ $count -gt $THRESHOLD ]; then
        echo "Suspicious activity from IP: $ip ($count attempts)"
        # เพิ่ม IP ลงใน blacklist
        echo "$ip" >> /etc/apache2/blacklist.conf
    fi
done < /tmp/failed_logins.txt
```

#### 2.2 ตรวจสอบ SQL Injection Attempts
```bash
#!/bin/bash
# check_sql_injection.sh
LOG_FILE="/var/log/apache2/access.log"

# ตรวจสอบรูปแบบที่น่าสงสัย
grep -i "union.*select\|concat.*\(|information_schema\|--\|'" $LOG_FILE > /tmp/suspicious_requests.txt

if [ -s /tmp/suspicious_requests.txt ]; then
    echo "Potential SQL injection attempts detected:"
    cat /tmp/suspicious_requests.txt
    # ส่งแจ้งเตือน
fi
```

## การตรวจสอบประสิทธิภาพ

### 1. การตรวจสอบเวลาในการโหลดหน้าเว็บ

#### 1.1 ทดสอบเวลาในการโหลด
```bash
#!/bin/bash
# check_page_load_time.sh
DOMAIN="https://yourdomain.com"
EXPECTED_TIME=3.0

LOAD_TIME=$(curl -o /dev/null -s -w "%{time_total}\n" $DOMAIN)

if (( $(echo "$LOAD_TIME > $EXPECTED_TIME" | bc -l) )); then
    echo "Page load time is slow: ${LOAD_TIME}s"
    # ส่งแจ้งเตือน
else
    echo "Page load time is acceptable: ${LOAD_TIME}s"
fi
```

### 2. การตรวจสอบการใช้งานฐานข้อมูล

#### 2.1 ตรวจสอบ Slow Queries
```bash
#!/bin/bash
# check_slow_queries.sh
MYSQL_LOG="/var/log/mysql/slow.log"
THRESHOLD=2

# ตรวจสอบ slow queries
slow_queries=$(grep -c "Query_time" $MYSQL_LOG)

if [ $slow_queries -gt $THRESHOLD ]; then
    echo "Too many slow queries detected: $slow_queries"
    # ส่งแจ้งเตือน
fi
```

## การอัปเดตระบบ

### 1. การอัปเดต PHP และ Extensions

#### 1.1 ตรวจสอบเวอร์ชันปัจจุบัน
```bash
#!/bin/bash
# check_php_version.sh
CURRENT_VERSION=$(php -v | head -n 1 | cut -d " " -f 2)
REQUIRED_VERSION="8.1"

if [[ "$CURRENT_VERSION" < "$REQUIRED_VERSION" ]]; then
    echo "PHP version $CURRENT_VERSION is outdated. Please upgrade to $REQUIRED_VERSION or later."
    # ส่งแจ้งเตือน
fi
```

### 2. การอัปเดต Dependencies

#### 2.1 อัปเดต Composer Packages
```bash
#!/bin/bash
# update_composer_packages.sh
cd /var/www/html
composer update --no-dev

if [ $? -eq 0 ]; then
    echo "Composer packages updated successfully"
else
    echo "Failed to update composer packages"
    # ส่งแจ้งเตือน
fi
```

#### 2.2 อัปเดต Node.js Packages (สำหรับ Discord Bot)
```bash
#!/bin/bash
# update_node_packages.sh
cd /var/www/html/discord_bot
npm update

if [ $? -eq 0 ]; then
    echo "Node.js packages updated successfully"
    # รีสตาร์ท Discord Bot
    pm2 restart dedazen-store-bot
else
    echo "Failed to update Node.js packages"
    # ส่งแจ้งเตือน
fi
```

## การรายงานและการแจ้งเตือน

### 1. รายงานประจำวัน

#### 1.1 สคริปต์สร้างรายงาน
```php
// daily_report.php
<?php
require_once 'system/a_func.php';

// ดึงข้อมูลสำหรับรายงาน
$today = date('Y-m-d');

// ผู้ใช้ใหม่
$newUsersStmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE DATE(date) = ?");
$newUsersStmt->execute([$today]);
$newUsers = $newUsersStmt->fetch(PDO::FETCH_ASSOC)['count'];

// คำสั่งซื้อใหม่
$newOrdersStmt = $conn->prepare("SELECT COUNT(*) as count FROM boxlog WHERE DATE(date) = ?");
$newOrdersStmt->execute([$today]);
$newOrders = $newOrdersStmt->fetch(PDO::FETCH_ASSOC)['count'];

// การเติมเงินใหม่
$newTopupsStmt = $conn->prepare("SELECT COUNT(*) as count FROM topup_his WHERE DATE(date) = ?");
$newTopupsStmt->execute([$today]);
$newTopups = $newTopupsStmt->fetch(PDO::FETCH_ASSOC)['count'];

// รายได้รวม
$totalRevenueStmt = $conn->prepare("SELECT SUM(amount) as total FROM topup_his WHERE DATE(date) = ?");
$totalRevenueStmt->execute([$today]);
$totalRevenue = $totalRevenueStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// สร้างรายงาน
$report = [
    'date' => $today,
    'new_users' => $newUsers,
    'new_orders' => $newOrders,
    'new_topups' => $newTopups,
    'total_revenue' => $totalRevenue
];

// ส่งรายงานไปยัง Discord
sendDailyReportToDiscord($report);

// ส่งรายงานไปยัง Line Notify
sendDailyReportToLine($report);

// ส่งรายงานไปยัง Email
sendDailyReportToEmail($report);

function sendDailyReportToDiscord($report) {
    // โค้ดสำหรับส่งรายงานไปยัง Discord
}

function sendDailyReportToLine($report) {
    // โค้ดสำหรับส่งรายงานไปยัง Line Notify
}

function sendDailyReportToEmail($report) {
    // โค้ดสำหรับส่งรายงานไปยัง Email
}

echo "Daily report generated and sent successfully\n";
?>
```

### 2. รายงานการใช้งาน

#### 2.1 รายงานการใช้งานผู้ใช้
```php
// user_activity_report.php
<?php
require_once 'system/a_func.php';

// ดึงข้อมูลการใช้งานผู้ใช้
$stmt = $conn->prepare("SELECT u.username, COUNT(bl.id) as orders, COUNT(th.id) as topups, u.point as balance 
                       FROM users u 
                       LEFT JOIN boxlog bl ON u.id = bl.uid 
                       LEFT JOIN topup_his th ON u.id = th.uid 
                       GROUP BY u.id 
                       ORDER BY orders DESC, topups DESC 
                       LIMIT 20");
$stmt->execute();

$topUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// สร้างรายงาน
$reportContent = "รายงานการใช้งานผู้ใช้ 20 อันดับแรก\n";
$reportContent .= "=====================================\n";

foreach ($topUsers as $index => $user) {
    $reportContent .= ($index + 1) . ". " . $user['username'] . "\n";
    $reportContent .= "   คำสั่งซื้อ: " . $user['orders'] . " ครั้ง\n";
    $reportContent .= "   การเติมเงิน: " . $user['topups'] . " ครั้ง\n";
    $reportContent .= "   ยอดเงินคงเหลือ: " . number_format($user['balance']) . " บาท\n\n";
}

// ส่งรายงาน
echo $reportContent;
?>
```

## การจัดการ Incidents

### 1. แผนการจัดการปัญหา

#### 1.1 Incident Response Plan
```markdown
# แผนการจัดการ Incident

## ระดับความรุนแรง
1. **Critical**: ระบบหยุดทำงาน ผลกระทบต่อผู้ใช้ทั้งหมด
2. **High**: ฟีเจอร์หลักไม่ทำงาน ผลกระทบต่อผู้ใช้จำนวนมาก
3. **Medium**: ฟีเจอร์ย่อยไม่ทำงาน ผลกระทบต่อผู้ใช้บางส่วน
4. **Low**: ปัญหาเล็กน้อย ไม่มีผลกระทบต่อการใช้งาน

## ขั้นตอนการจัดการ

### Critical Incident
1. แจ้งทีมผู้ดูแลทันที
2. ตรวจสอบสถานะระบบ
3. ถอยกลับเป็นเวอร์ชันก่อนหน้า (ถ้าจำเป็น)
4. แก้ไขปัญหาและทดสอบ
5. นำระบบกลับมาออนไลน์
6. แจ้งผู้ใช้และรายงานเหตุการณ์

### High Incident
1. แจ้งทีมผู้ดูแลภายใน 15 นาที
2. วิเคราะห์ปัญหาและหาสาเหตุ
3. แก้ไขปัญหาและทดสอบ
4. ตรวจสอบความเสถียรของระบบ
5. รายงานและบันทึก incident

### Medium/Low Incident
1. บันทึก incident ในระบบ
2. วิเคราะห์และแก้ไขในเวลาที่เหมาะสม
3. ทดสอบการแก้ไข
4. รายงานและปิด incident
```

## การวางแผนสำหรับอนาคต

### 1. แผนการขยายระบบ

#### 1.1 การ Scale Up
- เพิ่ม RAM และ CPU ให้เซิร์ฟเวอร์
- แยกฐานข้อมูลออกจากเซิร์ฟเวอร์เว็บ
- ใช้ CDN สำหรับไฟล์ Static

#### 1.2 การ Scale Out
- ใช้ Load Balancer
- สร้าง Cluster ของเซิร์ฟเวอร์
- ใช้ฐานข้อมูลแบบ Master-Slave

### 2. แผนการพัฒนาฟีเจอร์

#### 2.1 ฟีเจอร์ใหม่ที่แนะนำ
- ระบบ Ticket Support
- ระบบ Analytics ขั้นสูง
- ระบบ Multi-language
- ระบบ Mobile App
- ระบบ AI Recommendation

## สรุป

การดูแลรักษาระบบ Dedazen Store อย่างสม่ำเสมอจะช่วยให้ระบบสามารถทำงานได้อย่างมีประสิทธิภาพและปลอดภัย การปฏิบัติตามแผนการดูแลรักษาที่กำหนดไว้จะช่วยให้สามารถป้องกันปัญหาที่อาจเกิดขึ้นได้ล่วงหน้า และสามารถตอบสนองต่อเหตุการณ์ที่เกิดขึ้นได้อย่างรวดเร็วและมีประสิทธิภาพ

**ข้อแนะนำสำคัญ**:
1. ตั้งค่าการตรวจสอบระบบอัตโนมัติ
2. ตั้งค่าการสำรองข้อมูลประจำ
3. ตั้งค่าการแจ้งเตือนเมื่อเกิดปัญหา
4. ฝึกซ้อมแผนการจัดการ incident
5. ติดตามและอัปเดตระบบอย่างสม่ำเสมอ
6. บันทึกและวิเคราะห์ Logs อย่างละเอียด

การดูแลรักษาระบบที่ดีจะช่วยให้ Dedazen Store สามารถให้บริการแก่ผู้ใช้ได้อย่างต่อเนื่องและมีคุณภาพสูงสุด
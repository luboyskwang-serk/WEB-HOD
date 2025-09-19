<?php
require_once 'a_func.php';

// ฟังก์ชันสำหรับอัปเดตตารางฐานข้อมูล
function updateDatabaseSchema() {
    global $conn;
    
    try {
        // อัปเดตตาราง users
        updateUserTable();
        
        // สร้างตาราง coupons
        createCouponsTable();
        
        // สร้างตาราง coupon_usage_history
        createCouponUsageHistoryTable();
        
        // สร้างตาราง affiliates
        createAffiliatesTable();
        
        // สร้างตาราง referral_records
        createReferralRecordsTable();
        
        // สร้างตาราง affiliate_commission_history
        createCommissionHistoryTable();
        
        // สร้างตาราง notification_settings
        createNotificationSettingsTable();
        
        // สร้างตาราง inventory_movements
        createInventoryMovementsTable();
        
        // อัปเดตตาราง box_product
        updateBoxProductTable();
        
        // อัปเดตตาราง setting
        updateSettingTable();
        
        // สร้างตาราง discord_webhooks
        createDiscordWebhooksTable();
        
        echo "Database schema updated successfully.
";
        return true;
    } catch (PDOException $e) {
        echo "Error updating database schema: " . $e->getMessage() . "
";
        return false;
    }
}

// อัปเดตตาราง users
function updateUserTable() {
    global $conn;
    
    // เพิ่มคอลัมน์สำหรับ 2FA
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS twofa_secret VARCHAR(255) NULL");
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS twofa_enabled TINYINT(1) DEFAULT 0");
    
    // เพิ่มคอลัมน์สำหรับ Line Notify
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS line_token VARCHAR(255) NULL");
    
    // เพิ่มคอลัมน์สำหรับการตั้งค่าการแจ้งเตือน
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS notify_orders TINYINT(1) DEFAULT 1");
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS notify_topups TINYINT(1) DEFAULT 1");
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS notify_promotions TINYINT(1) DEFAULT 1");
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS notify_security TINYINT(1) DEFAULT 1");
    
    // เพิ่มคอลัมน์สำหรับ Affiliate
    $conn->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS referral_code VARCHAR(20) UNIQUE NULL");
    
    // เพิ่ม index สำหรับ referral_code
    $conn->exec("CREATE INDEX IF NOT EXISTS idx_users_referral_code ON users(referral_code)");
    
    echo "Users table updated successfully.
";
}

// สร้างตาราง coupons
function createCouponsTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS coupons (
        id INT AUTO_INCREMENT PRIMARY KEY,
        code VARCHAR(50) UNIQUE NOT NULL,
        discount_type ENUM('percentage', 'fixed') NOT NULL,
        discount_value DECIMAL(10,2) NOT NULL,
        minimum_amount DECIMAL(10,2) DEFAULT 0,
        max_discount DECIMAL(10,2) DEFAULT NULL,
        expiry_date DATETIME NOT NULL,
        usage_limit INT DEFAULT 0,
        used_count INT DEFAULT 0,
        status ENUM('active', 'inactive', 'expired') DEFAULT 'active',
        created_at DATETIME,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_code (code),
        INDEX idx_status (status),
        INDEX idx_expiry (expiry_date)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Coupons table created successfully.
";
}

// สร้างตาราง coupon_usage_history
function createCouponUsageHistoryTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS coupon_usage_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        coupon_id INT NOT NULL,
        user_id INT,
        used_at DATETIME,
        FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
        INDEX idx_coupon_id (coupon_id),
        INDEX idx_user_id (user_id),
        INDEX idx_used_at (used_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Coupon usage history table created successfully.
";
}

// สร้างตาราง affiliates
function createAffiliatesTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS affiliates (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        referral_code VARCHAR(20) UNIQUE,
        total_earnings DECIMAL(10,2) DEFAULT 0,
        total_commission DECIMAL(10,2) DEFAULT 0,
        total_referrals INT DEFAULT 0,
        created_at DATETIME,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_user_id (user_id),
        INDEX idx_referral_code (referral_code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Affiliates table created successfully.
";
}

// สร้างตาราง referral_records
function createReferralRecordsTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS referral_records (
        id INT AUTO_INCREMENT PRIMARY KEY,
        referrer_id INT NOT NULL,
        referred_user_id INT NOT NULL,
        referral_code VARCHAR(20) NOT NULL,
        status ENUM('pending', 'confirmed', 'rejected') DEFAULT 'pending',
        commission_amount DECIMAL(10,2) DEFAULT 0,
        created_at DATETIME,
        confirmed_at DATETIME NULL,
        FOREIGN KEY (referrer_id) REFERENCES affiliates(id) ON DELETE CASCADE,
        FOREIGN KEY (referred_user_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_referrer_id (referrer_id),
        INDEX idx_referred_user_id (referred_user_id),
        INDEX idx_status (status),
        INDEX idx_referral_code (referral_code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Referral records table created successfully.
";
}

// สร้างตาราง affiliate_commission_history
function createCommissionHistoryTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS affiliate_commission_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        affiliate_id INT NOT NULL,
        referred_user_id INT NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        commission_type VARCHAR(20) DEFAULT 'referral',
        created_at DATETIME,
        FOREIGN KEY (affiliate_id) REFERENCES affiliates(id) ON DELETE CASCADE,
        FOREIGN KEY (referred_user_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_affiliate_id (affiliate_id),
        INDEX idx_referred_user_id (referred_user_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Affiliate commission history table created successfully.
";
}

// สร้างตาราง notification_settings
function createNotificationSettingsTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS notification_settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        notification_type VARCHAR(50) NOT NULL,
        channel VARCHAR(20) NOT NULL,
        enabled TINYINT(1) DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        UNIQUE KEY unique_user_notification (user_id, notification_type, channel),
        INDEX idx_user_id (user_id),
        INDEX idx_notification_type (notification_type),
        INDEX idx_channel (channel)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Notification settings table created successfully.
";
}

// สร้างตาราง inventory_movements
function createInventoryMovementsTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS inventory_movements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        type ENUM('import', 'export', 'adjustment', 'sale', 'return') NOT NULL,
        admin_id INT NOT NULL,
        notes TEXT,
        created_at DATETIME,
        FOREIGN KEY (product_id) REFERENCES box_product(id) ON DELETE CASCADE,
        FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_product_id (product_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Inventory movements table created successfully.
";
}

// อัปเดตตาราง box_product
function updateBoxProductTable() {
    global $conn;
    
    // เพิ่มคอลัมน์ stock_quantity
    $conn->exec("ALTER TABLE box_product ADD COLUMN IF NOT EXISTS stock_quantity INT DEFAULT 0");
    
    // เพิ่มคอลัมน์ low_stock_threshold
    $conn->exec("ALTER TABLE box_product ADD COLUMN IF NOT EXISTS low_stock_threshold INT DEFAULT 5");
    
    // เพิ่มคอลัมน์ notes ในตาราง box_stock
    $conn->exec("ALTER TABLE box_stock ADD COLUMN IF NOT EXISTS notes TEXT");
    
    // เพิ่มคอลัมน์ created_at ในตาราง box_stock
    $conn->exec("ALTER TABLE box_stock ADD COLUMN IF NOT EXISTS created_at DATETIME");
    
    echo "Box product table updated successfully.
";
}

// อัปเดตตาราง setting
function updateSettingTable() {
    global $conn;
    
    // เพิ่มคอลัมน์ affiliate_commission_rate
    $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS affiliate_commission_rate DECIMAL(5,2) DEFAULT 10.00");
    
    // เพิ่มคอลัมน์ affiliate_commission_type
    $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS affiliate_commission_type VARCHAR(20) DEFAULT 'percentage'");
    
    // เพิ่มคอลัมน์ discord_webhook_url
    $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS discord_webhook_url VARCHAR(255)");
    
    // เพิ่มคอลัมน์ notify_new_order
    $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS notify_new_order TINYINT(1) DEFAULT 1");
    
    // เพิ่มคอลัมน์ notify_new_topup
    $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS notify_new_topup TINYINT(1) DEFAULT 1");
    
    // เพิ่มคอลัมน์ notify_low_stock
    $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS notify_low_stock TINYINT(1) DEFAULT 1");
    
    // เพิ่มคอลัมน์ notify_security_alert
    $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS notify_security_alert TINYINT(1) DEFAULT 1");
    
    // เพิ่มคอลัมน์ notify_new_user
    $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS notify_new_user TINYINT(1) DEFAULT 0");
    
    echo "Setting table updated successfully.
";
}

// สร้างตาราง discord_webhooks
function createDiscordWebhooksTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS discord_webhooks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        url VARCHAR(500) NOT NULL,
        event_types JSON,
        enabled TINYINT(1) DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_name (name),
        INDEX idx_enabled (enabled)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "Discord webhooks table created successfully.
";
}

// ฟังก์ชันสำหรับอัปเดต password hashing ของผู้ใช้ที่มีอยู่
function upgradeExistingPasswords() {
    global $conn;
    
    echo "Starting password upgrade process...
";
    
    // ดึงผู้ใช้ทั้งหมดที่มี password แบบ MD5 (32 ตัวอักษร hexadecimal)
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE LENGTH(password) = 32 AND password REGEXP '^[a-f0-9]+$'");
    $stmt->execute();
    
    $count = 0;
    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // ตรวจสอบว่า password เป็น MD5 จริง ๆ
        if (strlen($user['password']) == 32 && ctype_xdigit($user['password'])) {
            echo "Found user ID: " . $user['id'] . " with MD5 password
";
            $count++;
        }
    }
    
    echo "Found $count users with MD5 passwords. They will be upgraded when they log in.
";
    echo "Note: Passwords will be automatically upgraded to bcrypt when users log in.
";
}

// ฟังก์ชันสำหรับเพิ่มผู้ใช้ admin เริ่มต้น (ถ้ายังไม่มี)
function createDefaultAdminUser() {
    global $conn;
    
    // ตรวจสอบว่ามีผู้ใช้ admin หรือยัง
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE rank = 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // สร้างผู้ใช้ admin เริ่มต้น
        $username = 'admin';
        $password = password_hash('admin123', PASSWORD_DEFAULT); // ควรเปลี่ยน password นี้
        $email = 'admin@' . $_SERVER['HTTP_HOST'];
        
        $insertStmt = $conn->prepare("INSERT INTO users (username, password, email, date, point, total, rank, accept) VALUES (?, ?, ?, NOW(), 0, 0, 1, 1)");
        if ($insertStmt->execute([$username, $password, $email])) {
            echo "Default admin user created:
";
            echo "Username: admin
";
            echo "Password: admin123 (PLEASE CHANGE THIS IMMEDIATELY)
";
            echo "Email: $email
";
        } else {
            echo "Failed to create default admin user.
";
        }
    } else {
        echo "Admin user already exists.
";
    }
}

// ฟังก์ชันสำหรับเพิ่มการตั้งค่าเริ่มต้น
function createDefaultSettings() {
    global $conn;
    
    // ตรวจสอบว่ามีการตั้งค่าอยู่แล้วหรือยัง
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM setting");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // เพิ่มการตั้งค่าเริ่มต้น
        $insertStmt = $conn->prepare("INSERT INTO setting (name, des, logo, bg, main_color, sec_color, wallet, discord, fb, lined, oaccept, apipeamsub) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->execute([
            'Dedazen Store',
            'ร้านค้าออนไลน์ที่ดีที่สุด',
            '/dz/logo.png',
            '/dz/bg.png',
            '#ff6b35',
            '#2a9d8f',
            '08xxxxxxxx',
            'https://discord.gg/example',
            'https://facebook.com/example',
            '@example',
            1,
            '#'
        ]);
        
        echo "Default settings created.
";
    } else {
        echo "Settings already exist.
";
    }
}

// ฟังก์ชันหลักสำหรับรันการอัปเดตฐานข้อมูล
function runDatabaseUpdates() {
    echo "=== Dedazen Store Database Update Script ===

";
    
    echo "1. Updating database schema...
";
    if (!updateDatabaseSchema()) {
        echo "Failed to update database schema. Aborting.
";
        return false;
    }
    
    echo "
2. Upgrading existing passwords...
";
    upgradeExistingPasswords();
    
    echo "
3. Creating default admin user...
";
    createDefaultAdminUser();
    
    echo "
4. Creating default settings...
";
    createDefaultSettings();
    
    echo "
=== Database update completed successfully ===
";
    echo "Please remember to:
";
    echo "1. Change the default admin password immediately
";
    echo "2. Update the website configuration in the settings table
";
    echo "3. Set up your Discord webhook URLs if using Discord notifications
";
    echo "4. Configure your payment gateways
";
    echo "5. Test all new features thoroughly
";
    
    return true;
}

// ถ้ารันไฟล์นี้โดยตรง ให้รันการอัปเดตฐานข้อมูล
if (basename($_SERVER['PHP_SELF']) == 'db_updates.php') {
    runDatabaseUpdates();
}
?>
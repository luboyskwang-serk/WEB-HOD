<?php
require_once 'a_func.php';

// คลาสสำหรับจัดการระบบ Affiliate/Referral
class AffiliateManager {
    
    // สร้างรหัส Referral สำหรับผู้ใช้
    public static function generateReferralCode($userId) {
        global $conn;
        
        // สร้างรหัส Referral แบบสุ่ม
        $referralCode = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        
        // ตรวจสอบว่ารหัสซ้ำหรือไม่
        $checkStmt = $conn->prepare("SELECT id FROM affiliates WHERE referral_code = ?");
        $checkStmt->execute([$referralCode]);
        
        if ($checkStmt->rowCount() > 0) {
            // ถ้าซ้ำ ลองใหม่
            return self::generateReferralCode($userId);
        }
        
        // ตรวจสอบว่าผู้ใช้มี Affiliate record หรือยัง
        $stmt = $conn->prepare("SELECT id FROM affiliates WHERE user_id = ?");
        $stmt->execute([$userId]);
        
        if ($stmt->rowCount() == 0) {
            // สร้าง Affiliate record ใหม่
            $insertStmt = $conn->prepare("INSERT INTO affiliates 
                                         (user_id, referral_code, total_earnings, total_referrals, created_at) 
                                         VALUES (?, ?, 0, 0, NOW())");
            $insertStmt->execute([$userId, $referralCode]);
        } else {
            // อัปเดตรหัส Referral
            $updateStmt = $conn->prepare("UPDATE affiliates SET referral_code = ? WHERE user_id = ?");
            $updateStmt->execute([$referralCode, $userId]);
        }
        
        return $referralCode;
    }
    
    // ลงทะเบียน Referral
    public static function registerReferral($referralCode, $newUserId) {
        global $conn;
        
        // ตรวจสอบรหัส Referral
        $stmt = $conn->prepare("SELECT id, user_id FROM affiliates WHERE referral_code = ?");
        $stmt->execute([$referralCode]);
        $affiliate = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$affiliate) {
            return ['status' => 'error', 'message' => 'ไม่พบรหัส Referral นี้'];
        }
        
        $referrerId = $affiliate['user_id'];
        
        // ตรวจสอบว่าผู้ใช้ใหม่ลงทะเบียนแล้วหรือยัง
        $checkStmt = $conn->prepare("SELECT id FROM referral_records WHERE referred_user_id = ?");
        $checkStmt->execute([$newUserId]);
        
        if ($checkStmt->rowCount() > 0) {
            return ['status' => 'error', 'message' => 'ผู้ใช้นี้ได้รับการแนะนำไปแล้ว'];
        }
        
        // บันทึกการแนะนำ
        $insertStmt = $conn->prepare("INSERT INTO referral_records 
                                     (referrer_id, referred_user_id, referral_code, status, created_at) 
                                     VALUES (?, ?, ?, 'pending', NOW())");
        $result = $insertStmt->execute([$referrerId, $newUserId, $referralCode]);
        
        if ($result) {
            // เพิ่มจำนวน referrals ของ referrer
            $updateStmt = $conn->prepare("UPDATE affiliates SET total_referrals = total_referrals + 1 WHERE user_id = ?");
            $updateStmt->execute([$referrerId]);
            
            return ['status' => 'success', 'message' => 'ลงทะเบียน Referral สำเร็จ'];
        }
        
        return ['status' => 'error', 'message' => 'ไม่สามารถลงทะเบียน Referral ได้'];
    }
    
    // ยืนยัน Referral (หลังจากผู้ใช้เติมเงินครั้งแรก)
    public static function confirmReferral($referredUserId) {
        global $conn;
        
        // ดึงข้อมูล Referral
        $stmt = $conn->prepare("SELECT rr.*, a.user_id as referrer_id 
                               FROM referral_records rr 
                               JOIN affiliates a ON rr.referrer_id = a.id 
                               WHERE rr.referred_user_id = ? AND rr.status = 'pending'");
        $stmt->execute([$referredUserId]);
        $referral = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$referral) {
            return ['status' => 'error', 'message' => 'ไม่พบ Referral ที่ต้องยืนยัน'];
        }
        
        // คำนวณค่าคอมมิชชั่น (ตั้งค่าใน config)
        $commission = self::calculateCommission($referral['referrer_id'], $referredUserId);
        
        // อัปเดตสถานะ Referral
        $updateStmt = $conn->prepare("UPDATE referral_records SET 
                                     status = 'confirmed', 
                                     commission_amount = ?, 
                                     confirmed_at = NOW() 
                                     WHERE id = ?");
        $updateStmt->execute([$commission, $referral['id']]);
        
        // เพิ่มค่าคอมมิชชั่นให้ referrer
        $commissionStmt = $conn->prepare("UPDATE affiliates SET 
                                         total_earnings = total_earnings + ?, 
                                         total_commission = COALESCE(total_commission, 0) + ? 
                                         WHERE user_id = ?");
        $commissionStmt->execute([$commission, $commission, $referral['referrer_id']]);
        
        // เพิ่มเงินให้ referrer
        $pointsStmt = $conn->prepare("UPDATE users SET point = point + ? WHERE id = ?");
        $pointsStmt->execute([$commission, $referral['referrer_id']]);
        
        // บันทึกประวัติค่าคอมมิชชั่น
        $historyStmt = $conn->prepare("INSERT INTO affiliate_commission_history 
                                      (affiliate_id, referred_user_id, amount, commission_type, created_at) 
                                      VALUES (?, ?, ?, 'referral', NOW())");
        $historyStmt->execute([$referral['referrer_id'], $referredUserId, $commission]);
        
        return ['status' => 'success', 'message' => 'ยืนยัน Referral สำเร็จ', 'commission' => $commission];
    }
    
    // คำนวณค่าคอมมิชชั่น
    public static function calculateCommission($referrerId, $referredUserId) {
        global $conn, $config;
        
        // ดึงการตั้งค่าค่าคอมมิชชั่น
        $commissionRate = $config['affiliate_commission_rate'] ?? 10; // 10% เป็นค่าเริ่มต้น
        $commissionType = $config['affiliate_commission_type'] ?? 'percentage'; // percentage หรือ fixed
        
        // ดึงยอดการเติมเงินของผู้ใช้ที่ถูกแนะนำ
        $stmt = $conn->prepare("SELECT SUM(amount) as total_topup FROM topup_his WHERE uid = ?");
        $stmt->execute([$referredUserId]);
        $topupData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $totalTopup = $topupData['total_topup'] ?? 0;
        
        if ($commissionType === 'percentage') {
            $commission = ($totalTopup * $commissionRate) / 100;
        } else {
            $commission = $commissionRate; // ค่าคงที่
        }
        
        return $commission;
    }
    
    // ดึงข้อมูล Affiliate ของผู้ใช้
    public static function getUserAffiliateData($userId) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT a.*, u.username, u.profile 
                               FROM affiliates a 
                               JOIN users u ON a.user_id = u.id 
                               WHERE a.user_id = ?");
        $stmt->execute([$userId]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // ดึงรายการ Referral ของผู้ใช้
    public static function getUserReferrals($userId, $limit = 50, $offset = 0) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT rr.*, u.username, u.profile, u.date as join_date
                               FROM referral_records rr 
                               JOIN users u ON rr.referred_user_id = u.id 
                               WHERE rr.referrer_id = ?
                               ORDER BY rr.created_at DESC 
                               LIMIT ? OFFSET ?");
        $stmt->execute([$userId, $limit, $offset]);
        
        $referrals = [];
        while ($referral = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $referrals[] = $referral;
        }
        
        return $referrals;
    }
    
    // ดึงประวัติค่าคอมมิชชั่น
    public static function getCommissionHistory($userId, $limit = 50) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT ach.*, u.username 
                               FROM affiliate_commission_history ach 
                               JOIN users u ON ach.referred_user_id = u.id 
                               WHERE ach.affiliate_id = ?
                               ORDER BY ach.created_at DESC 
                               LIMIT ?");
        $stmt->execute([$userId, $limit]);
        
        $history = [];
        while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $history[] = $record;
        }
        
        return $history;
    }
    
    // ดึงสถิติ Affiliate
    public static function getAffiliateStats($userId) {
        global $conn;
        
        // จำนวน referrals ทั้งหมด
        $totalStmt = $conn->prepare("SELECT COUNT(*) as total_referrals FROM referral_records WHERE referrer_id = ?");
        $totalStmt->execute([$userId]);
        $totalData = $totalStmt->fetch(PDO::FETCH_ASSOC);
        
        // จำนวน referrals ที่ยืนยันแล้ว
        $confirmedStmt = $conn->prepare("SELECT COUNT(*) as confirmed_referrals FROM referral_records WHERE referrer_id = ? AND status = 'confirmed'");
        $confirmedStmt->execute([$userId]);
        $confirmedData = $confirmedStmt->fetch(PDO::FETCH_ASSOC);
        
        // ยอดค่าคอมมิชชั่นทั้งหมด
        $commissionStmt = $conn->prepare("SELECT SUM(commission_amount) as total_commission FROM referral_records WHERE referrer_id = ? AND status = 'confirmed'");
        $commissionStmt->execute([$userId]);
        $commissionData = $commissionStmt->fetch(PDO::FETCH_ASSOC);
        
        return [
            'total_referrals' => $totalData['total_referrals'] ?? 0,
            'confirmed_referrals' => $confirmedData['confirmed_referrals'] ?? 0,
            'total_commission' => $commissionData['total_commission'] ?? 0
        ];
    }
    
    // สร้างลิงก์ Referral
    public static function generateReferralLink($userId) {
        global $config;
        
        $affiliateData = self::getUserAffiliateData($userId);
        if (!$affiliateData) {
            return null;
        }
        
        $baseUrl = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
        return $baseUrl . '?ref=' . $affiliateData['referral_code'];
    }
}

// สร้างตาราง affiliates ถ้ายังไม่มี
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
    
    try {
        $conn->exec($sql);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// สร้างตาราง referral_records ถ้ายังไม่มี
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
    
    try {
        $conn->exec($sql);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// สร้างตาราง affiliate_commission_history ถ้ายังไม่มี
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
    
    try {
        $conn->exec($sql);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// เพิ่มคอลัมน์ในตาราง setting สำหรับการตั้งค่า Affiliate
function updateSettingTableForAffiliate() {
    global $conn;
    
    try {
        // เพิ่มคอลัมน์ affiliate_commission_rate
        $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS affiliate_commission_rate DECIMAL(5,2) DEFAULT 10.00");
        
        // เพิ่มคอลัมน์ affiliate_commission_type
        $conn->exec("ALTER TABLE setting ADD COLUMN IF NOT EXISTS affiliate_commission_type VARCHAR(20) DEFAULT 'percentage'");
        
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// เรียกใช้ฟังก์ชันสร้างตาราง
createAffiliatesTable();
createReferralRecordsTable();
createCommissionHistoryTable();
updateSettingTableForAffiliate();
?>
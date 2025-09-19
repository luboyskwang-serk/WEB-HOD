<?php
require_once 'a_func.php';

// คลาสสำหรับจัดการคูปอง
class CouponManager {
    
    // สร้างคูปองใหม่
    public static function createCoupon($data) {
        global $conn;
        
        $required_fields = ['code', 'discount_type', 'discount_value', 'expiry_date'];
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                return ['status' => 'error', 'message' => "กรุณากรอกข้อมูลให้ครบ: $field"];
            }
        }
        
        // ตรวจสอบว่ารหัสคูปองซ้ำหรือไม่
        $checkStmt = $conn->prepare("SELECT id FROM coupons WHERE code = ?");
        $checkStmt->execute([$data['code']]);
        
        if ($checkStmt->rowCount() > 0) {
            return ['status' => 'error', 'message' => 'รหัสคูปองนี้มีอยู่แล้ว'];
        }
        
        // สร้างคูปองใหม่
        $stmt = $conn->prepare("INSERT INTO coupons 
                               (code, discount_type, discount_value, minimum_amount, 
                                expiry_date, usage_limit, used_count, status, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, 0, ?, NOW())");
        
        $result = $stmt->execute([
            $data['code'],
            $data['discount_type'],
            $data['discount_value'],
            $data['minimum_amount'] ?? 0,
            $data['expiry_date'],
            $data['usage_limit'] ?? 0,
            $data['status'] ?? 'active'
        ]);
        
        if ($result) {
            return ['status' => 'success', 'message' => 'สร้างคูปองสำเร็จ', 'id' => $conn->lastInsertId()];
        } else {
            return ['status' => 'error', 'message' => 'ไม่สามารถสร้างคูปองได้'];
        }
    }
    
    // แก้ไขคูปอง
    public static function updateCoupon($couponId, $data) {
        global $conn;
        
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $couponId;
        
        $sql = "UPDATE coupons SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute($values)) {
            return ['status' => 'success', 'message' => 'อัปเดตคูปองสำเร็จ'];
        } else {
            return ['status' => 'error', 'message' => 'ไม่สามารถอัปเดตคูปองได้'];
        }
    }
    
    // ลบคูปอง
    public static function deleteCoupon($couponId) {
        global $conn;
        
        $stmt = $conn->prepare("DELETE FROM coupons WHERE id = ?");
        if ($stmt->execute([$couponId])) {
            return ['status' => 'success', 'message' => 'ลบคูปองสำเร็จ'];
        } else {
            return ['status' => 'error', 'message' => 'ไม่สามารถลบคูปองได้'];
        }
    }
    
    // ตรวจสอบคูปอง
    public static function validateCoupon($code, $cartTotal = 0) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code = ? AND status = 'active'");
        $stmt->execute([$code]);
        $coupon = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$coupon) {
            return ['status' => 'error', 'message' => 'ไม่พบคูปองนี้หรือคูปองไม่สามารถใช้งานได้'];
        }
        
        // ตรวจสอบวันหมดอายุ
        if (strtotime($coupon['expiry_date']) < time()) {
            return ['status' => 'error', 'message' => 'คูปองหมดอายุแล้ว'];
        }
        
        // ตรวจสอบจำนวนการใช้งาน
        if ($coupon['usage_limit'] > 0 && $coupon['used_count'] >= $coupon['usage_limit']) {
            return ['status' => 'error', 'message' => 'คูปองถูกใช้งานครบจำนวนแล้ว'];
        }
        
        // ตรวจสอบจำนวนเงินขั้นต่ำ
        if ($coupon['minimum_amount'] > 0 && $cartTotal < $coupon['minimum_amount']) {
            return ['status' => 'error', 'message' => 'จำนวนเงินในตะกร้าต้องไม่น้อยกว่า ' . number_format($coupon['minimum_amount']) . ' บาท'];
        }
        
        return ['status' => 'success', 'message' => 'คูปองสามารถใช้งานได้', 'coupon' => $coupon];
    }
    
    // ใช้งานคูปอง
    public static function useCoupon($code, $userId = null) {
        global $conn;
        
        // ตรวจสอบคูปอง
        $validation = self::validateCoupon($code);
        if ($validation['status'] !== 'success') {
            return $validation;
        }
        
        $coupon = $validation['coupon'];
        
        // เพิ่มจำนวนการใช้งาน
        $stmt = $conn->prepare("UPDATE coupons SET used_count = used_count + 1 WHERE id = ?");
        if ($stmt->execute([$coupon['id']])) {
            // บันทึกประวัติการใช้งาน
            $historyStmt = $conn->prepare("INSERT INTO coupon_usage_history 
                                          (coupon_id, user_id, used_at) 
                                          VALUES (?, ?, NOW())");
            $historyStmt->execute([$coupon['id'], $userId]);
            
            return ['status' => 'success', 'message' => 'ใช้งานคูปองสำเร็จ', 'coupon' => $coupon];
        } else {
            return ['status' => 'error', 'message' => 'ไม่สามารถใช้งานคูปองได้'];
        }
    }
    
    // คำนวณส่วนลด
    public static function calculateDiscount($coupon, $amount) {
        if ($coupon['discount_type'] === 'percentage') {
            $discount = ($amount * $coupon['discount_value']) / 100;
            return min($discount, $coupon['max_discount'] ?? $discount); // จำกัดส่วนลดสูงสุดถ้ามี
        } else if ($coupon['discount_type'] === 'fixed') {
            return min($coupon['discount_value'], $amount); // ห้ามส่วนลดมากกว่าจำนวนเงิน
        }
        
        return 0;
    }
    
    // ดึงรายการคูปองทั้งหมด
    public static function getAllCoupons($limit = 50, $offset = 0) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM coupons ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
        
        $coupons = [];
        while ($coupon = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coupons[] = $coupon;
        }
        
        return $coupons;
    }
    
    // ดึงคูปองตาม ID
    public static function getCouponById($couponId) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE id = ?");
        $stmt->execute([$couponId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // ดึงคูปองตามรหัส
    public static function getCouponByCode($code) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // ค้นหาคูปอง
    public static function searchCoupons($keyword, $limit = 50) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code LIKE ? ORDER BY created_at DESC LIMIT ?");
        $stmt->execute(["%$keyword%", $limit]);
        
        $coupons = [];
        while ($coupon = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $coupons[] = $coupon;
        }
        
        return $coupons;
    }
}

// สร้างตาราง coupons ถ้ายังไม่มี
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
    
    try {
        $conn->exec($sql);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// สร้างตาราง coupon_usage_history ถ้ายังไม่มี
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
    
    try {
        $conn->exec($sql);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// เรียกใช้ฟังก์ชันสร้างตาราง
createCouponsTable();
createCouponUsageHistoryTable();
?>
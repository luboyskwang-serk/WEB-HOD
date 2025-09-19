<?php
require_once 'a_func.php';

// คลาสสำหรับจัดการ 2FA
class TwoFactorAuth {
    
    // สร้าง secret key สำหรับผู้ใช้
    public static function generateSecret() {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < 16; $i++) {
            $secret .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $secret;
    }
    
    // สร้าง QR Code URL สำหรับ Google Authenticator
    public static function getQRCodeUrl($name, $secret) {
        $url = 'otpauth://totp/' . urlencode($name) . '?secret=' . $secret;
        return $url;
    }
    
    // สร้าง QR Code Image (ใช้ Google Charts API)
    public static function getQRCodeImage($name, $secret, $size = 200) {
        $url = urlencode(self::getQRCodeUrl($name, $secret));
        return "https://chart.googleapis.com/chart?chs={$size}x{$size}&chld=M|0&cht=qr&chl={$url}";
    }
    
    // ตรวจสอบโค้ด 2FA
    public static function verifyCode($secret, $code, $discrepancy = 1, $time = null) {
        if (!$time) {
            $time = floor(time() / 30);
        }
        
        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $calculatedCode = self::getCode($secret, $time + $i);
            if (hash_equals($calculatedCode, $code)) {
                return true;
            }
        }
        
        return false;
    }
    
    // สร้างโค้ด 2FA
    private static function getCode($secret, $time = null) {
        if (!$time) {
            $time = floor(time() / 30);
        }
        
        $secretKey = self::base32Decode($secret);
        $timePacked = pack('N*', 0) . pack('N*', $time);
        $hash = hash_hmac('sha1', $timePacked, $secretKey, true);
        $offset = ord($hash[19]) & 0x0f;
        $code = (
                ((ord($hash[$offset + 0]) & 0x7f) << 24) |
                ((ord($hash[$offset + 1]) & 0xff) << 16) |
                ((ord($hash[$offset + 2]) & 0xff) << 8) |
                (ord($hash[$offset + 3]) & 0xff)
            ) % pow(10, 6);
            
        return str_pad($code, 6, '0', STR_PAD_LEFT);
    }
    
    // แปลง Base32 เป็น binary
    private static function base32Decode($secret) {
        $base32Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = strtoupper($secret);
        $buffer = 0;
        $bufferBits = 0;
        $result = '';
        
        for ($i = 0; $i < strlen($secret); $i++) {
            $char = $secret[$i];
            $value = strpos($base32Chars, $char);
            if ($value === false) {
                continue;
            }
            
            $buffer = ($buffer << 5) | $value;
            $bufferBits += 5;
            
            if ($bufferBits >= 8) {
                $bufferBits -= 8;
                $result .= chr(($buffer >> $bufferBits) & 0xFF);
            }
        }
        
        return $result;
    }
}

// ฟังก์ชันสำหรับเปิดใช้งาน 2FA สำหรับผู้ใช้
function enable2FA($userId) {
    global $conn;
    
    // สร้าง secret key ใหม่
    $secret = TwoFactorAuth::generateSecret();
    
    // บันทึก secret key ลงในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE users SET twofa_secret = ? WHERE id = ?");
    if ($stmt->execute([$secret, $userId])) {
        return $secret;
    }
    
    return false;
}

// ฟังก์ชันสำหรับปิดใช้งาน 2FA
function disable2FA($userId) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE users SET twofa_secret = NULL, twofa_enabled = 0 WHERE id = ?");
    return $stmt->execute([$userId]);
}

// ฟังก์ชันสำหรับตรวจสอบ 2FA
function verify2FA($userId, $code) {
    global $conn;
    
    // ดึง secret key ของผู้ใช้
    $stmt = $conn->prepare("SELECT twofa_secret FROM users WHERE id = ? AND twofa_enabled = 1");
    $stmt->execute([$userId]);
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $secret = $user['twofa_secret'];
        
        // ตรวจสอบโค้ด
        return TwoFactorAuth::verifyCode($secret, $code);
    }
    
    return false;
}

// ฟังก์ชันสำหรับเปิดใช้งาน 2FA หลังจากตรวจสอบโค้ด
function activate2FA($userId, $code) {
    global $conn;
    
    // ดึง secret key ของผู้ใช้
    $stmt = $conn->prepare("SELECT twofa_secret FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $secret = $user['twofa_secret'];
        
        // ตรวจสอบโค้ด
        if (TwoFactorAuth::verifyCode($secret, $code)) {
            // เปิดใช้งาน 2FA
            $updateStmt = $conn->prepare("UPDATE users SET twofa_enabled = 1 WHERE id = ?");
            if ($updateStmt->execute([$userId])) {
                return true;
            }
        }
    }
    
    return false;
}

// ฟังก์ชันสำหรับตรวจสอบว่าผู้ใช้มี 2FA หรือไม่
function has2FA($userId) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT twofa_enabled FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user['twofa_enabled'] == 1;
    }
    
    return false;
}

// ฟังก์ชันสำหรับดึงข้อมูล 2FA ของผู้ใช้
function get2FAInfo($userId) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT twofa_secret, twofa_enabled FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    
    if ($stmt->rowCount() == 1) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    return false;
}
?>
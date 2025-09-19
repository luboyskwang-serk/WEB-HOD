<?php
// ไฟล์สำหรับอัปเกรด password hashing จากระบบเดิมเป็น bcrypt

require_once 'a_func.php';

function hashPassword($password) {
    // ใช้ bcrypt สำหรับ password ใหม่
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    // ตรวจสอบ password ด้วย bcrypt
    return password_verify($password, $hash);
}

function needsRehash($hash) {
    // ตรวจสอบว่า password ต้อง rehash หรือไม่
    return password_needs_rehash($hash, PASSWORD_DEFAULT);
}

// ฟังก์ชันสำหรับ login ที่รองรับทั้ง MD5 และ bcrypt
function checkUserPassword($username, $password) {
    global $conn;
    
    // ค้นหาผู้ใช้
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // ตรวจสอบด้วย bcrypt ก่อน
        if (password_verify($password, $user['password'])) {
            // ถ้า password ต้อง rehash ให้อัปเดต
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $updateStmt->execute([$newHash, $user['id']]);
            }
            return $user;
        }
        
        // ตรวจสอบด้วย MD5 (ระบบเดิม) - สำหรับผู้ใช้ที่ยังไม่ได้อัปเกรด
        if (md5($password) === $user['password']) {
            // อัปเกรด password เป็น bcrypt
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $updateStmt->execute([$newHash, $user['id']]);
            return $user;
        }
    }
    
    return false;
}

// ฟังก์ชันสำหรับเปลี่ยนรหัสผ่านใหม่
function changePassword($userId, $oldPassword, $newPassword) {
    global $conn;
    
    // ตรวจสอบรหัสผ่านเก่า
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        return ['status' => 'error', 'message' => 'ไม่พบผู้ใช้'];
    }
    
    // ตรวจสอบรหัสผ่านเก่า
    if (!password_verify($oldPassword, $user['password']) && md5($oldPassword) !== $user['password']) {
        return ['status' => 'error', 'message' => 'รหัสผ่านเก่าไม่ถูกต้อง'];
    }
    
    // แฮชรหัสผ่านใหม่ด้วย bcrypt
    $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // อัปเดตรหัสผ่าน
    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    if ($updateStmt->execute([$newHash, $userId])) {
        return ['status' => 'success', 'message' => 'เปลี่ยนรหัสผ่านสำเร็จ'];
    } else {
        return ['status' => 'error', 'message' => 'ไม่สามารถเปลี่ยนรหัสผ่านได้'];
    }
}

// ฟังก์ชันสำหรับลงทะเบียนผู้ใช้ใหม่
function registerUser($username, $password, $email) {
    global $conn;
    
    // ตรวจสอบว่า username ซ้ำหรือไม่
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    if ($stmt->rowCount() > 0) {
        return ['status' => 'error', 'message' => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว'];
    }
    
    // แฮชรหัสผ่านด้วย bcrypt
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // เพิ่มผู้ใช้ใหม่
    $insertStmt = $conn->prepare("INSERT INTO users (username, password, email, date, point, total, accept) VALUES (?, ?, ?, NOW(), 0, 0, 1)");
    
    if ($insertStmt->execute([$username, $hashedPassword, $email])) {
        return ['status' => 'success', 'message' => 'ลงทะเบียนสำเร็จ', 'user_id' => $conn->lastInsertId()];
    } else {
        return ['status' => 'error', 'message' => 'ไม่สามารถลงทะเบียนได้'];
    }
}

// ฟังก์ชันสำหรับอัปเกรด password ทั้งหมดในระบบ (ควรรันครั้งเดียว)
function upgradeAllPasswords() {
    global $conn;
    
    echo "กำลังอัปเกรด password ทั้งหมด...
";
    
    $stmt = $conn->prepare("SELECT id, password FROM users");
    $stmt->execute();
    
    $count = 0;
    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // ตรวจสอบว่า password เป็น MD5 หรือไม่
        if (strlen($user['password']) == 32 && ctype_xdigit($user['password'])) {
            // สมมติว่าเป็น MD5, ต้องมีวิธีตรวจสอบเพิ่มเติม
            // สำหรับการอัปเกรดจริง ควรให้ผู้ใช้ login แล้วค่อยอัปเกรด password
            
            echo "ผู้ใช้ ID: " . $user['id'] . " ใช้ระบบ password เดิม
";
            $count++;
        }
    }
    
    echo "พบผู้ใช้ที่ต้องอัปเกรด: " . $count . " คน
";
    echo "หมายเหตุ: การอัปเกรด password จะเกิดขึ้นเมื่อผู้ใช้ login ครั้งต่อไป
";
}

// ถ้ารันไฟล์นี้โดยตรง ให้แสดงผลการอัปเกรด
if (basename($_SERVER['PHP_SELF']) == 'password_hash_upgrade.php') {
    upgradeAllPasswords();
}
?>
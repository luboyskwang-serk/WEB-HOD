<?php
require_once 'a_func.php';

// คลาสสำหรับจัดการการแจ้งเตือน
class NotificationSystem {
    
    // ส่งแจ้งเตือนผ่าน Line Notify
    public static function sendLineNotify($message, $token = null) {
        global $config;
        
        // ใช้ token จาก config ถ้าไม่ได้ระบุ
        if (!$token) {
            $token = $config['line_notify_token']; // ต้องเพิ่มในตาราง setting
        }
        
        if (!$token) {
            return ['status' => 'error', 'message' => 'ไม่พบ Line Notify Token'];
        }
        
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/x-www-form-urlencoded'
        ];
        
        $data = [
            'message' => $message
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://notify-api.line.me/api/notify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            return ['status' => 'success', 'message' => 'ส่งแจ้งเตือน Line สำเร็จ'];
        } else {
            return ['status' => 'error', 'message' => 'ไม่สามารถส่งแจ้งเตือน Line ได้'];
        }
    }
    
    // ส่งแจ้งเตือนผ่าน Email
    public static function sendEmail($to, $subject, $message, $html = false) {
        // ตรวจสอบว่ามี PHPMailer หรือไม่
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            // ใช้ mail() ของ PHP แทน
            $headers = "MIME-Version: 1.0" . "\r\n";
            if ($html) {
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            } else {
                $headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
            }
            $headers .= "From: noreply@" . $_SERVER['HTTP_HOST'] . "\r\n";
            
            if (mail($to, $subject, $message, $headers)) {
                return ['status' => 'success', 'message' => 'ส่งอีเมลสำเร็จ'];
            } else {
                return ['status' => 'error', 'message' => 'ไม่สามารถส่งอีเมลได้'];
            }
        } else {
            // ใช้ PHPMailer
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->CharSet = 'UTF-8';
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // ปรับตามผู้ให้บริการ
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@gmail.com'; // ต้องกำหนด
                $mail->Password = 'your-password'; // ต้องกำหนด
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                
                $mail->setFrom('noreply@' . $_SERVER['HTTP_HOST'], $config['name']);
                $mail->addAddress($to);
                $mail->isHTML($html);
                $mail->Subject = $subject;
                $mail->Body = $message;
                
                if ($mail->send()) {
                    return ['status' => 'success', 'message' => 'ส่งอีเมลสำเร็จ'];
                } else {
                    return ['status' => 'error', 'message' => 'ไม่สามารถส่งอีเมลได้: ' . $mail->ErrorInfo];
                }
            } catch (Exception $e) {
                return ['status' => 'error', 'message' => 'ไม่สามารถส่งอีเมลได้: ' . $e->getMessage()];
            }
        }
    }
    
    // ส่งแจ้งเตือนไปยัง admin
    public static function notifyAdmin($type, $data) {
        global $config;
        
        $message = "";
        $subject = "";
        
        switch ($type) {
            case 'new_order':
                $message = "มีคำสั่งซื้อใหม่\n";
                $message .= "สินค้า: " . $data['product_name'] . "\n";
                $message .= "จำนวน: " . $data['quantity'] . "\n";
                $message .= "ราคา: " . number_format($data['price']) . " บาท\n";
                $message .= "ผู้ใช้: " . $data['username'] . "\n";
                $message .= "เวลา: " . date('Y-m-d H:i:s');
                $subject = "แจ้งเตือนคำสั่งซื้อใหม่ - " . $config['name'];
                break;
                
            case 'new_topup':
                $message = "มีการเติมเงินใหม่\n";
                $message .= "จำนวน: " . number_format($data['amount']) . " บาท\n";
                $message .= "ผู้ใช้: " . $data['username'] . "\n";
                $message .= "เวลา: " . date('Y-m-d H:i:s');
                $subject = "แจ้งเตือนการเติมเงิน - " . $config['name'];
                break;
                
            case 'low_stock':
                $message = "สินค้าใกล้หมดสต็อก\n";
                $message .= "สินค้า: " . $data['product_name'] . "\n";
                $message .= "จำนวนคงเหลือ: " . $data['stock'] . "\n";
                $message .= "เวลา: " . date('Y-m-d H:i:s');
                $subject = "แจ้งเตือนสต็อกสินค้า - " . $config['name'];
                break;
                
            case 'security_alert':
                $message = "แจ้งเตือนความปลอดภัย\n";
                $message .= "เหตุการณ์: " . $data['event'] . "\n";
                $message .= "ผู้ใช้: " . ($data['username'] ?? 'ไม่ระบุ') . "\n";
                $message .= "IP: " . ($data['ip'] ?? 'ไม่ระบุ') . "\n";
                $message .= "เวลา: " . date('Y-m-d H:i:s');
                $subject = "แจ้งเตือนความปลอดภัย - " . $config['name'];
                break;
                
            default:
                $message = "แจ้งเตือนระบบ\n" . print_r($data, true);
                $subject = "แจ้งเตือนระบบ - " . $config['name'];
        }
        
        // ส่งไปยัง Line Notify ของ admin
        if (!empty($config['admin_line_token'])) {
            self::sendLineNotify($message, $config['admin_line_token']);
        }
        
        // ส่งไปยังอีเมลของ admin
        if (!empty($config['admin_email'])) {
            self::sendEmail($config['admin_email'], $subject, $message);
        }
        
        return ['status' => 'success', 'message' => 'ส่งแจ้งเตือนสำเร็จ'];
    }
    
    // ส่งแจ้งเตือนไปยังผู้ใช้
    public static function notifyUser($userId, $type, $data) {
        global $conn, $config;
        
        // ดึงข้อมูลผู้ใช้
        $stmt = $conn->prepare("SELECT username, email, line_token FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return ['status' => 'error', 'message' => 'ไม่พบผู้ใช้'];
        }
        
        $message = "";
        $subject = "";
        
        switch ($type) {
            case 'order_success':
                $message = "การสั่งซื้อของคุณสำเร็จแล้ว\n";
                $message .= "สินค้า: " . $data['product_name'] . "\n";
                $message .= "จำนวน: " . $data['quantity'] . "\n";
                $message .= "ราคา: " . number_format($data['price']) . " บาท\n";
                $message .= "รายละเอียด: " . $data['details'] . "\n";
                $message .= "เวลา: " . date('Y-m-d H:i:s');
                $subject = "การสั่งซื้อสำเร็จ - " . $config['name'];
                break;
                
            case 'topup_success':
                $message = "การเติมเงินของคุณสำเร็จแล้ว\n";
                $message .= "จำนวน: " . number_format($data['amount']) . " บาท\n";
                $message .= "ยอดเงินคงเหลือ: " . number_format($data['balance']) . " บาท\n";
                $message .= "เวลา: " . date('Y-m-d H:i:s');
                $subject = "การเติมเงินสำเร็จ - " . $config['name'];
                break;
                
            case 'account_update':
                $message = "ข้อมูลบัญชีของคุณมีการเปลี่ยนแปลง\n";
                $message .= "การเปลี่ยนแปลง: " . $data['change'] . "\n";
                $message .= "เวลา: " . date('Y-m-d H:i:s');
                $subject = "การเปลี่ยนแปลงบัญชี - " . $config['name'];
                break;
                
            default:
                $message = "แจ้งเตือนจากระบบ\n" . print_r($data, true);
                $subject = "แจ้งเตือนระบบ - " . $config['name'];
        }
        
        // ส่งไปยัง Line ของผู้ใช้ (ถ้ามี)
        if (!empty($user['line_token'])) {
            self::sendLineNotify($message, $user['line_token']);
        }
        
        // ส่งไปยังอีเมลของผู้ใช้
        if (!empty($user['email'])) {
            self::sendEmail($user['email'], $subject, $message);
        }
        
        return ['status' => 'success', 'message' => 'ส่งแจ้งเตือนผู้ใช้สำเร็จ'];
    }
    
    // บันทึกประวัติการแจ้งเตือน
    public static function logNotification($userId, $type, $message, $channel) {
        global $conn;
        
        $stmt = $conn->prepare("INSERT INTO notification_logs (user_id, type, message, channel, created_at) VALUES (?, ?, ?, ?, NOW())");
        return $stmt->execute([$userId, $type, $message, $channel]);
    }
}

// สร้างตาราง notification_logs ถ้ายังไม่มี
function createNotificationTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS notification_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        type VARCHAR(50),
        message TEXT,
        channel VARCHAR(20),
        created_at DATETIME,
        INDEX idx_user_id (user_id),
        INDEX idx_type (type),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    try {
        $conn->exec($sql);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// เรียกใช้ฟังก์ชันสร้างตาราง
createNotificationTable();
?>
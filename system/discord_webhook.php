<?php
// ระบบส่งแจ้งเตือนไปยัง Discord Webhook
require_once 'a_func.php';

class DiscordWebhook {
    
    // ส่งแจ้งเตือนคำสั่งซื้อใหม่
    public static function sendNewOrderNotification($orderId, $productName, $quantity, $price, $userId, $userName) {
        global $config;
        
        // ตรวจสอบว่าเปิดใช้งานการแจ้งเตือนหรือไม่
        if (empty($config['discord_webhook_url']) || !$config['notify_new_order']) {
            return ['status' => 'success', 'message' => 'Notification disabled'];
        }
        
        $webhookUrl = $config['discord_webhook_url'];
        
        // สร้าง payload สำหรับ Discord
        $payload = [
            'username' => 'Dedazen Store',
            'avatar_url' => 'https://yourwebsite.com/logo.png',
            'embeds' => [
                [
                    'title' => '🛒 คำสั่งซื้อใหม่',
                    'description' => 'มีคำสั่งซื้อใหม่ในระบบ',
                    'color' => 0x2ecc71, // สีเขียว
                    'fields' => [
                        [
                            'name' => 'ไอดีคำสั่งซื้อ',
                            'value' => $orderId,
                            'inline' => true
                        ],
                        [
                            'name' => 'สินค้า',
                            'value' => $productName,
                            'inline' => true
                        ],
                        [
                            'name' => 'จำนวน',
                            'value' => $quantity,
                            'inline' => true
                        ],
                        [
                            'name' => 'ราคา',
                            'value' => number_format($price) . ' บาท',
                            'inline' => true
                        ],
                        [
                            'name' => 'ผู้สั่งซื้อ',
                            'value' => $userName . ' (ID: ' . $userId . ')',
                            'inline' => true
                        ]
                    ],
                    'timestamp' => date('c'),
                    'footer' => [
                        'text' => 'Dedazen Store Notification',
                        'icon_url' => 'https://yourwebsite.com/logo.png'
                    ]
                ]
            ]
        ];
        
        return self::sendWebhook($webhookUrl, $payload);
    }
    
    // ส่งแจ้งเตือนการเติมเงินใหม่
    public static function sendNewTopupNotification($topupId, $amount, $userId, $userName, $paymentMethod) {
        global $config;
        
        // ตรวจสอบว่าเปิดใช้งานการแจ้งเตือนหรือไม่
        if (empty($config['discord_webhook_url']) || !$config['notify_new_topup']) {
            return ['status' => 'success', 'message' => 'Notification disabled'];
        }
        
        $webhookUrl = $config['discord_webhook_url'];
        
        // สร้าง payload สำหรับ Discord
        $payload = [
            'username' => 'Dedazen Store',
            'avatar_url' => 'https://yourwebsite.com/logo.png',
            'embeds' => [
                [
                    'title' => '💰 การเติมเงินใหม่',
                    'description' => 'มีการเติมเงินใหม่ในระบบ',
                    'color' => 0xf1c40f, // สีเหลือง
                    'fields' => [
                        [
                            'name' => 'ไอดีการเติมเงิน',
                            'value' => $topupId,
                            'inline' => true
                        ],
                        [
                            'name' => 'จำนวนเงิน',
                            'value' => number_format($amount) . ' บาท',
                            'inline' => true
                        ],
                        [
                            'name' => 'ผู้เติมเงิน',
                            'value' => $userName . ' (ID: ' . $userId . ')',
                            'inline' => true
                        ],
                        [
                            'name' => 'วิธีการชำระเงิน',
                            'value' => $paymentMethod,
                            'inline' => true
                        ]
                    ],
                    'timestamp' => date('c'),
                    'footer' => [
                        'text' => 'Dedazen Store Notification',
                        'icon_url' => 'https://yourwebsite.com/logo.png'
                    ]
                ]
            ]
        ];
        
        return self::sendWebhook($webhookUrl, $payload);
    }
    
    // ส่งแจ้งเตือนสต็อกสินค้าต่ำ
    public static function sendLowStockNotification($productId, $productName, $currentStock, $threshold) {
        global $config;
        
        // ตรวจสอบว่าเปิดใช้งานการแจ้งเตือนหรือไม่
        if (empty($config['discord_webhook_url']) || !$config['notify_low_stock']) {
            return ['status' => 'success', 'message' => 'Notification disabled'];
        }
        
        $webhookUrl = $config['discord_webhook_url'];
        
        // สร้าง payload สำหรับ Discord
        $payload = [
            'username' => 'Dedazen Store',
            'avatar_url' => 'https://yourwebsite.com/logo.png',
            'embeds' => [
                [
                    'title' => '⚠️ สต็อกสินค้าต่ำ',
                    'description' => 'สินค้าใกล้หมดสต็อก',
                    'color' => 0xe74c3c, // สีแดง
                    'fields' => [
                        [
                            'name' => 'ไอดีสินค้า',
                            'value' => $productId,
                            'inline' => true
                        ],
                        [
                            'name' => 'ชื่อสินค้า',
                            'value' => $productName,
                            'inline' => true
                        ],
                        [
                            'name' => 'สต็อกปัจจุบัน',
                            'value' => $currentStock,
                            'inline' => true
                        ],
                        [
                            'name' => 'ขั้นต่ำที่กำหนด',
                            'value' => $threshold,
                            'inline' => true
                        ]
                    ],
                    'timestamp' => date('c'),
                    'footer' => [
                        'text' => 'Dedazen Store Notification',
                        'icon_url' => 'https://yourwebsite.com/logo.png'
                    ]
                ]
            ]
        ];
        
        return self::sendWebhook($webhookUrl, $payload);
    }
    
    // ส่งแจ้งเตือนความปลอดภัย
    public static function sendSecurityAlert($eventId, $eventType, $userId = null, $ipAddress = null, $details = null) {
        global $config;
        
        // ตรวจสอบว่าเปิดใช้งานการแจ้งเตือนหรือไม่
        if (empty($config['discord_webhook_url']) || !$config['notify_security_alert']) {
            return ['status' => 'success', 'message' => 'Notification disabled'];
        }
        
        $webhookUrl = $config['discord_webhook_url'];
        
        // สร้าง payload สำหรับ Discord
        $payload = [
            'username' => 'Dedazen Store Security',
            'avatar_url' => 'https://yourwebsite.com/logo.png',
            'embeds' => [
                [
                    'title' => '🔒 แจ้งเตือนความปลอดภัย',
                    'description' => 'ตรวจพบกิจกรรมที่น่าสงสัย',
                    'color' => 0xe74c3c, // สีแดง
                    'fields' => [
                        [
                            'name' => 'ประเภทเหตุการณ์',
                            'value' => $eventType,
                            'inline' => true
                        ],
                        [
                            'name' => 'ไอดีเหตุการณ์',
                            'value' => $eventId,
                            'inline' => true
                        ],
                        [
                            'name' => 'ผู้ใช้',
                            'value' => $userId ? 'ID: ' . $userId : 'ไม่ระบุ',
                            'inline' => true
                        ],
                        [
                            'name' => 'ที่อยู่ IP',
                            'value' => $ipAddress ?: 'ไม่ระบุ',
                            'inline' => true
                        ],
                        [
                            'name' => 'รายละเอียด',
                            'value' => $details ?: 'ไม่มีข้อมูลเพิ่มเติม',
                            'inline' => false
                        ]
                    ],
                    'timestamp' => date('c'),
                    'footer' => [
                        'text' => 'Dedazen Store Security',
                        'icon_url' => 'https://yourwebsite.com/logo.png'
                    ]
                ]
            ]
        ];
        
        return self::sendWebhook($webhookUrl, $payload);
    }
    
    // ส่งแจ้งเตือนผู้ใช้ใหม่
    public static function sendNewUserNotification($userId, $username, $email, $registrationDate) {
        global $config;
        
        // ตรวจสอบว่าเปิดใช้งานการแจ้งเตือนหรือไม่
        if (empty($config['discord_webhook_url']) || !$config['notify_new_user']) {
            return ['status' => 'success', 'message' => 'Notification disabled'];
        }
        
        $webhookUrl = $config['discord_webhook_url'];
        
        // สร้าง payload สำหรับ Discord
        $payload = [
            'username' => 'Dedazen Store',
            'avatar_url' => 'https://yourwebsite.com/logo.png',
            'embeds' => [
                [
                    'title' => '👥 ผู้ใช้ใหม่',
                    'description' => 'มีผู้ใช้ใหม่ลงทะเบียนในระบบ',
                    'color' => 0x3498db, // สีน้ำเงิน
                    'fields' => [
                        [
                            'name' => 'ไอดีผู้ใช้',
                            'value' => $userId,
                            'inline' => true
                        ],
                        [
                            'name' => 'ชื่อผู้ใช้',
                            'value' => $username,
                            'inline' => true
                        ],
                        [
                            'name' => 'อีเมล',
                            'value' => $email ?: 'ไม่ระบุ',
                            'inline' => true
                        ],
                        [
                            'name' => 'วันที่ลงทะเบียน',
                            'value' => $registrationDate,
                            'inline' => true
                        ]
                    ],
                    'timestamp' => date('c'),
                    'footer' => [
                        'text' => 'Dedazen Store Notification',
                        'icon_url' => 'https://yourwebsite.com/logo.png'
                    ]
                ]
            ]
        ];
        
        return self::sendWebhook($webhookUrl, $payload);
    }
    
    // ส่ง webhook ไปยัง Discord
    private static function sendWebhook($webhookUrl, $payload) {
        $jsonPayload = json_encode($payload);
        
        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return ['status' => 'success', 'message' => 'Notification sent successfully'];
        } else {
            return ['status' => 'error', 'message' => 'Failed to send notification: ' . $error];
        }
    }
}

// เพิ่มคอลัมน์ในตาราง setting สำหรับการตั้งค่า Discord Webhook
function updateSettingTableForDiscord() {
    global $conn;
    
    try {
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
        
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// เรียกใช้ฟังก์ชันเพื่ออัปเดตตาราง
updateSettingTableForDiscord();
?>
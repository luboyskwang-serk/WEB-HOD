<?php
require_once '../system/a_func.php';

// ฟังก์ชันสร้าง state สำหรับ OAuth
function generateState() {
    return bin2hex(random_bytes(16));
}

// ฟังก์ชันสำหรับจัดการการเชื่อมต่อ Line Notify
function handleLineConnect() {
    global $config;
    
    // ตรวจสอบว่าผู้ใช้ login แล้วหรือยัง
    if (!isset($_SESSION['id'])) {
        header('Location: ?page=login');
        exit;
    }
    
    // ถ้าเป็นการ callback จาก Line
    if (isset($_GET['code'])) {
        // ประมวลผล callback
        processLineCallback($_GET['code']);
    } else {
        // เปลี่ยนเส้นทางไปยัง Line OAuth
        redirectToLineOAuth();
    }
}

// เปลี่ยนเส้นทางไปยัง Line OAuth
function redirectToLineOAuth() {
    global $config;
    
    $state = generateState();
    $_SESSION['line_state'] = $state;
    
    $clientId = $config['line_client_id']; // ต้องเพิ่มในตาราง setting
    $redirectUri = urlencode('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    $stateParam = urlencode($state);
    
    $url = "https://access.line.me/oauth2/v2.1/authorize?" .
           "response_type=code&" .
           "client_id={$clientId}&" .
           "redirect_uri={$redirectUri}&" .
           "scope=notify&" .
           "state={$stateParam}";
           
    header("Location: {$url}");
    exit;
}

// ประมวลผล callback จาก Line
function processLineCallback($code) {
    global $conn, $config;
    
    // ตรวจสอบ state
    if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['line_state']) {
        die('Invalid state parameter');
    }
    
    // ลบ state ออกจาก session
    unset($_SESSION['line_state']);
    
    // ขอ access token
    $clientId = $config['line_client_id'];
    $clientSecret = $config['line_client_secret'];
    $redirectUri = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    
    $postData = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirectUri,
        'client_id' => $clientId,
        'client_secret' => $clientSecret
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/oauth2/v2.1/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200) {
        $tokenData = json_decode($response, true);
        $accessToken = $tokenData['access_token'];
        
        // บันทึก access token ลงในฐานข้อมูล
        $stmt = $conn->prepare("UPDATE users SET line_token = ? WHERE id = ?");
        if ($stmt->execute([$accessToken, $_SESSION['id']])) {
            // ส่งแจ้งเตือนทดสอบ
            sendTestNotification($accessToken);
            
            // เปลี่ยนเส้นทางกลับไปยังหน้าการตั้งค่า
            header('Location: ?page=notification_settings&success=1');
            exit;
        }
    }
    
    // ถ้ามีข้อผิดพลาด
    header('Location: ?page=notification_settings&error=1');
    exit;
}

// ส่งแจ้งเตือนทดสอบ
function sendTestNotification($token) {
    $message = "เชื่อมต่อกับระบบแจ้งเตือนของ " . $GLOBALS['config']['name'] . " สำเร็จแล้ว!";
    
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
    
    curl_exec($ch);
    curl_close($ch);
}

// เรียกใช้ฟังก์ชัน
handleLineConnect();
?>
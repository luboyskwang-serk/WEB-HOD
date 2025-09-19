<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';
require_once 'coupon.php';

function dd_return($status, $message) {
    if ($status) {
        $json = ['status'=> 'success','message' => $message];
        http_response_code(200);
        die(json_encode($json));
    }else{
        $json = ['status'=> 'fail','message' => $message];
        http_response_code(200);
        die(json_encode($json));
    }
}

//////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        // ตรวจสอบสิทธิ์ admin
        $q1 = dd_q("SELECT rank FROM users WHERE id = ? LIMIT 1", [$_SESSION['id']]);
        $user = $q1->fetch(PDO::FETCH_ASSOC);
        
        if ($user['rank'] != 1) {
            dd_return(false, "คุณไม่มีสิทธิ์เข้าถึงฟังก์ชันนี้");
        }
        
        // ตรวจสอบข้อมูล
        $required_fields = ['code', 'discount_type', 'discount_value', 'expiry_date'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                dd_return(false, "กรุณากรอกข้อมูลให้ครบ: $field");
            }
        }
        
        // ตรวจสอบประเภทส่วนลด
        if (!in_array($_POST['discount_type'], ['percentage', 'fixed'])) {
            dd_return(false, "ประเภทส่วนลดไม่ถูกต้อง");
        }
        
        // ตรวจสอบค่าส่วนลด
        $discount_value = floatval($_POST['discount_value']);
        if ($discount_value <= 0) {
            dd_return(false, "มูลค่าส่วนลดต้องมากกว่า 0");
        }
        
        // ตรวจสอบวันหมดอายุ
        $expiry_date = $_POST['expiry_date'];
        if (strtotime($expiry_date) === false) {
            dd_return(false, "รูปแบบวันหมดอายุไม่ถูกต้อง");
        }
        
        // ตรวจสอบวันหมดอายุต้องเป็นวันในอนาคต
        if (strtotime($expiry_date) < time()) {
            dd_return(false, "วันหมดอายุต้องเป็นวันในอนาคต");
        }
        
        // จัดเตรียมข้อมูล
        $data = [
            'code' => $_POST['code'],
            'discount_type' => $_POST['discount_type'],
            'discount_value' => $discount_value,
            'minimum_amount' => floatval($_POST['minimum_amount'] ?? 0),
            'expiry_date' => $expiry_date,
            'usage_limit' => intval($_POST['usage_limit'] ?? 0),
            'status' => $_POST['status'] ?? 'active'
        ];
        
        // สร้างคูปอง
        $result = CouponManager::createCoupon($data);
        dd_return($result['status'] === 'success', $result['message']);
    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
}

dd_return(false, "Method not allowed");
?>
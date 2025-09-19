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
        
        // ตรวจสอบ ID คูปอง
        $coupon_id = $_POST['id'] ?? 0;
        if (!$coupon_id) {
            dd_return(false, "ไม่พบ ID คูปอง");
        }
        
        // ลบคูปอง
        $result = CouponManager::deleteCoupon($coupon_id);
        dd_return($result['status'] === 'success', $result['message']);
    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
}

dd_return(false, "Method not allowed");
?>
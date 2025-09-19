<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../system/a_func.php';
require_once '../system/coupon.php';

function dd_return($status, $message, $extra = []) {
    if ($status) {
        $json = ['status'=> 'success','message' => $message];
        if (!empty($extra)) {
            $json = array_merge($json, $extra);
        }
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
        // ตรวจสอบรหัสคูปอง
        $code = $_POST['code'] ?? '';
        if (empty($code)) {
            dd_return(false, "กรุณาใส่รหัสคูปอง");
        }
        
        // ตรวจสอบคูปอง
        $validation = CouponManager::validateCoupon($code);
        if ($validation['status'] !== 'success') {
            dd_return(false, $validation['message']);
        }
        
        $coupon = $validation['coupon'];
        
        // คืนค่าข้อมูลคูปอง
        dd_return(true, "คูปองสามารถใช้งานได้", ['coupon' => $coupon]);
    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
}

dd_return(false, "Method not allowed");
?>
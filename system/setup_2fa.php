<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../system/a_func.php';
require_once '../system/2fa.php';

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
        $code = $_POST['code'];
        $secret = $_POST['secret'];
        
        if (!empty($code) && !empty($secret)) {
            // ตรวจสอบโค้ด 2FA
            if (TwoFactorAuth::verifyCode($secret, $code)) {
                // บันทึก secret key ลงในฐานข้อมูล
                $stmt = $conn->prepare("UPDATE users SET twofa_secret = ?, twofa_enabled = 1 WHERE id = ?");
                if ($stmt->execute([$secret, $_SESSION['id']])) {
                    dd_return(true, "เปิดใช้งาน 2FA สำเร็จ");
                } else {
                    dd_return(false, "ไม่สามารถบันทึกข้อมูลได้");
                }
            } else {
                dd_return(false, "โค้ดไม่ถูกต้อง");
            }
        } else {
            dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
        }
    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
}

dd_return(false, "Method not allowed");
?>
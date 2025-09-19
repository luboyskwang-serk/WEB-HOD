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
        // ปิดใช้งาน 2FA
        $stmt = $conn->prepare("UPDATE users SET twofa_secret = NULL, twofa_enabled = 0 WHERE id = ?");
        if ($stmt->execute([$_SESSION['id']])) {
            dd_return(true, "ปิดใช้งาน 2FA สำเร็จ");
        } else {
            dd_return(false, "ไม่สามารถปิดใช้งาน 2FA ได้");
        }
    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
}

dd_return(false, "Method not allowed");
?>
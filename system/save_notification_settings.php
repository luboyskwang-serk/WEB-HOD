<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../system/a_func.php';

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
        $orders = isset($_POST['orders']) ? (int)$_POST['orders'] : 0;
        $topups = isset($_POST['topups']) ? (int)$_POST['topups'] : 0;
        $promotions = isset($_POST['promotions']) ? (int)$_POST['promotions'] : 0;
        $security = isset($_POST['security']) ? (int)$_POST['security'] : 0;
        
        // อัปเดตการตั้งค่าการแจ้งเตือน
        $stmt = $conn->prepare("UPDATE users SET 
            notify_orders = ?, 
            notify_topups = ?, 
            notify_promotions = ?, 
            notify_security = ? 
            WHERE id = ?");
            
        if ($stmt->execute([$orders, $topups, $promotions, $security, $_SESSION['id']])) {
            dd_return(true, "บันทึกการตั้งค่าการแจ้งเตือนสำเร็จ");
        } else {
            dd_return(false, "ไม่สามารถบันทึกการตั้งค่าได้");
        }
    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
}

dd_return(false, "Method not allowed");
?>
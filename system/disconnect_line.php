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
        // ลบ line token ออกจากฐานข้อมูล
        $stmt = $conn->prepare("UPDATE users SET line_token = NULL WHERE id = ?");
        
        if ($stmt->execute([$_SESSION['id']])) {
            dd_return(true, "ยกเลิกการเชื่อมต่อกับ Line Notify สำเร็จ");
        } else {
            dd_return(false, "ไม่สามารถยกเลิกการเชื่อมต่อได้");
        }
    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
}

dd_return(false, "Method not allowed");
?>
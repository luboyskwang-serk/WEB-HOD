<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';
require_once 'password_hash_upgrade.php';

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
  if (!isset($_SESSION['id'])) {
    $user_login = $_POST['user'];
    $pwd_login = $_POST['pass'];

    if ($user_login != "" AND $pwd_login != "") {
        // ใช้ระบบตรวจสอบ password ที่อัปเกรดแล้ว
        $user = checkUserPassword($user_login, $pwd_login);
        
        if ($user) {
            $_SESSION['id'] = $user['id'];
            dd_return(true, "เข้าสู่ระบบสำเร็จ");
        } else {
            dd_return(false, "ไม่พบผู้ใช้นี้ / รหัสผ่านไม่ถูกต้อง");
        }
    }
    dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
  } else {
    dd_return(false, "ไม่สามารถใช้งานได้");
  }
}
dd_return(false, "ออกจากระบบก่อน");
?>
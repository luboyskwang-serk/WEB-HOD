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
  if (isset($_SESSION['id'])) {
    $o_pass = $_POST['o_pass'];
    $pass   = $_POST['pass'];
    $pass2  = $_POST['pass2'];
    
    if ($o_pass != "" AND $pass != "" AND $pass2 != "") {
        if($pass == $pass2){
            // ใช้ระบบเปลี่ยนรหัสผ่านที่อัปเกรดแล้ว
            $result = changePassword($_SESSION['id'], $o_pass, $pass);
            if($result['status'] == 'success'){
                dd_return(true, $result['message']);
            }else{
                dd_return(false, $result['message']);
            }
        }else{
            dd_return(false, "กรุณากรอกรหัสผ่านให้ตรงกัน");
        }
    }else{
        dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
    }
  }
  dd_return(false, "เข้าสู่ระบบก่อนดำเนินการครับ ");
}
dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
?>
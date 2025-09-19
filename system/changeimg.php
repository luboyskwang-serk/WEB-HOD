<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';

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
        $img = filter_input(INPUT_POST, 'img', FILTER_VALIDATE_URL);

        if ($img !== false) {
            $user = dd_q("SELECT * FROM users WHERE id = ?", [$_SESSION['id']])->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                if ($user['profile'] != $img) {
                    $q = dd_q("UPDATE users SET profile = ? WHERE id = ?", [$img, $_SESSION['id']]);
                    
                    if ($q) {
                        dd_return(true, "เปลี่ยนรูปภาพสำเร็จ");
                    } else {
                        dd_return(false, "SQL ผิดพลาด");
                    }
                } else {
                    dd_return(false, "รูปภาพเดิม !");
                }
            } else {
                dd_return(false, "เข้าสู่ระบบก่อนดำเนินการ");
            }
        } else {
            dd_return(false, "รูปแบบรูปภาพไม่ถูกต้อง");
        }
    }

    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
?>

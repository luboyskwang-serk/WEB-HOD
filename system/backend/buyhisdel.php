<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once '../a_func.php';

    function dd_return($status, $message) {
        $json = ['message' => $message];
        if ($status) {
            http_response_code(200);
            die(json_encode($json));
        } else {
            http_response_code(400);
            die(json_encode($json));
        }
    }

    //////////////////////////////////////////////////////////////////////////

    header('Content-Type: application/json; charset=utf-8;');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_SESSION['id'])) {
            if (!empty($_POST['id'])) {
                $q_1 = dd_q('SELECT * FROM users WHERE id = ? AND rank = 1', [$_SESSION['id']]);
                if ($q_1->rowCount() >= 1) {
                    $ids = $_POST['id'];
                    $delete_success = true;
                    foreach ($ids as $id) {
                        $insert = dd_q("DELETE FROM boxlog WHERE id = ?", [$id]);
                        if (!$insert) {
                            $delete_success = false;
                            break;
                        }
                    }
                    if ($delete_success) {
                        dd_return(true, "ลบสำเร็จ");
                    } else {
                        dd_return(false, "ไม่สามารถลบข้อมูลบางรายการได้");
                    }
                } else {
                    dd_return(false, "เซสชั่นผิดพลาด โปรดล็อกอินใหม่");
                    session_destroy();
                }
            } else {
                dd_return(false, "กรุณาเลือกรายการที่ต้องการลบ");
            }
        } else {
            dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
        }
    } else {
        dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
    }
?>

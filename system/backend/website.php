<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once '../a_func.php';

    function dd_return($status, $message) {
        $json = ['message' => $message];
        if ($status) {
            http_response_code(200);
            die(json_encode($json));
        }else{
            http_response_code(400);
            die(json_encode($json));
        }
    }

    //////////////////////////////////////////////////////////////////////////

    header('Content-Type: application/json; charset=utf-8;');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {

        if ($_POST['name'] != "" AND $_POST['logo'] != ""  AND $_POST['bg'] != "" AND $_POST['phone'] != "" AND $_POST['main_color'] != "" AND $_POST['sec_color'] != ""  AND $_POST['discord'] != "" AND $_POST['bg_premium'] != "" AND $_POST['premium_img'] != "" AND $_POST['c1_dedazen'] != "" AND $_POST['c2_dedazen'] != "" AND $_POST['c3_dedazen'] != "" AND $_POST['c4_dedazen'] != "" AND $_POST['bg_ann'] != ""  AND $_POST['tx_ann'] != ""  AND $_POST['help'] != "" AND $_POST['fb'] != "" AND $_POST['lined'] != "" AND $_POST['des'] != "") {
            $q_1 = dd_q('SELECT * FROM users WHERE id = ? AND rank = 1 ', [$_SESSION['id']]);
            if ($q_1->rowCount() >= 1) {
                $des = preg_replace('~\R~u', "\n", $_POST['des']);
                $insert = dd_q("UPDATE setting SET 
                    name = ? , bg = ? , wallet = ? , main_color  = ? ,
                    sec_color = ? , discord = ? , des = ? , logo = ? , c1_dedazen = ? , c2_dedazen = ? , c3_dedazen = ? , c4_dedazen = ? , bg_premium = ? , premium_img = ? , ann = ? , fee = ? , bg_ann = ? , tx_ann = ? , help = ? , fb = ? , lined = ? , webhook_dc = ? , oaccept = ? , apipeamsub = ?
                ", [
                    $_POST['name'],
                    $_POST['bg'],
                    $_POST['phone'],
                    $_POST['main_color'],
                    $_POST['sec_color'],
                    $_POST['discord'],
                    $des,
                    $_POST['logo'],
                    $_POST['c1_dedazen'],
                    $_POST['c2_dedazen'],
                    $_POST['c3_dedazen'],
                    $_POST['c4_dedazen'],
                    $_POST['bg_premium'],
                    $_POST['premium_img'],
                    $_POST['ann'],
                    $_POST['fee'],
                    $_POST['bg_ann'],
                    $_POST['tx_ann'],
                    $_POST['help'],
                    $_POST['fb'],
                    $_POST['lined'],
                    $_POST['webhook_dc'],
                    $_POST['oaccept'], 
                    $_POST['apipeamsub']                 
                ]);
                if($insert){
                    dd_return(true, "บันทึกสำเร็จ");
                }else{
                    dd_return(false, "SQL ผิดพลาด");
                }
            }else{
                dd_return(false, "เซสชั่นผิดพลาด โปรดล็อกอินใหม่");
                session_destroy();
            }
        }else{
            dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
        }
        }else{
        dd_return(false, "เข้าสู่ระบบก่อน");
        }
    }else{
        dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
    }
?>

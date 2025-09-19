<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';

function dd_return($status, $message) {
    if ($status) {
        $json = ['status' => 'success', 'message' => $message];
        http_response_code(200);
        die(json_encode($json));
    } else {
        $json = ['status' => 'fail', 'message' => $message];
        http_response_code(400);
        die(json_encode($json));
    }
}

function connect_api($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; th; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

header('Content-Type: application/json; charset=utf-8;');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    

    $req_amount = isset($_POST['req_amount']) ? $_POST['req_amount'] : "";

    if (isset($_SESSION['id'])) {
        if ($req_amount != "") {
                $urlapi_step2 = "https://aekshop.pokel.online/genqr.php?phone=.........&amount=$req_amount";
                $data_step2 = json_decode(connect_api(urldecode($urlapi_step2)), true);
            
                    echo json_encode([
                        'status' => "success",
                        'img' => $data_step2['img'],
                        'amount' => $data_step2['amount'],
                        'time_out' => 899,
                    ]);
               
        } else {
            dd_return(false, "กรุณาระบุจำนวนเงิน");
        }
    } else {
        dd_return(false, "เข้าสู่ระบบก่อนดำเนินการ");
    }
} else {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}

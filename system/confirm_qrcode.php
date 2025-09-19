<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';

function dd_return($status, $message) {
    $json = ['status' => $status ? 'success' : 'fail', 'message' => $message];
    http_response_code(200);
    die(json_encode($json));
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

function notifyDiscord($webhookUrl, $username, $point, $transRef, $url) {
    $embed = [
        "title" => "แจ้งเตือนเว็ปไซต์",
        "description" => "แจ้งเตือนการเติมเงิน Promptpay",
        "color" => 65280,
        "fields" => [
            ["name" => "ชื่อผู้ใช้", "value" => $username, "inline" => true],
            ["name" => "จำนวนเงิน", "value" => $point, "inline" => true],
            ["name" => "เลขอ้างอิง", "value" => $transRef, "inline" => true],
        ],
        "footer" => ["text" => "Developer : ธเนศ"],
        "thumbnail" => [
            "url" => $url
        ]
    ];

    $data = ["embeds" => [$embed]];
    $json_data = json_encode($data);

    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);
}


header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$plr = dd_q("SELECT * FROM users WHERE id = ?", [$_SESSION['id']])->fetch(PDO::FETCH_ASSOC);
    
    $urlapi_step1 = "https://aekshop.pokel.online/test1.php?user=.........&pass==.........&bank=.........&amount=".$_POST['amount']."";
    $data_step1 = json_decode(connect_api(urldecode($urlapi_step1)), true);
    $status_step1 = $data_step1['status'];
    

    if ($status_step1 == 1) {

        $amount_req = $data_step1['Amount'];
        
        $update_user = dd_q("UPDATE users SET point = ?, total = ? WHERE id = ?", [$plr["point"] + $amount_req, $plr["total"] + $amount_req, $_SESSION["id"]]);
        $insert = dd_q("INSERT INTO topup_his (id, link, amount, date, uid, uname) VALUES (NULL, ? ,  ? , NOW() , ? , ? )", [
            'TOPUP QR',
            $amount_req,
            $_SESSION['id'],
            $plr["username"]
        ]);
        
        dd_return(true, "เติมเครดิตสำเร็จ คุณได้รับ $amount_req เครดิต");

        
    } else {
        
        dd_return(false, '');
    }
} else {
    dd_return(false, "เข้าสู่ระบบก่อนดำเนินการ");
}
?>

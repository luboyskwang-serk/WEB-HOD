<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';

function dd_return($status, $message)
{
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

//////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $link = $_POST['link'];
        if ($link != "") {
            $f = dd_q("SELECT * FROM setting")->fetch(PDO::FETCH_ASSOC);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://apibot.xzrn.xyz/wallet/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'lnk=' . $link . '&phone=' . $f["wallet"],
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $res = json_decode($response);
            if (isset($res)) {
                if ($res->status ==  400) {
                    dd_return(false, $res->message);
                } elseif ($res->status ==  200) {
                    $plr = dd_q("SELECT * FROM users WHERE id = ?", [$_SESSION["id"]])->fetch(PDO::FETCH_ASSOC);
                    $update = dd_q("UPDATE users SET point = ?, total = ? WHERE id = ?", [$plr["point"] + $res->amount, $res->amount, $_SESSION["id"]]);
                    $insert = dd_q("INSERT INTO topup_his (id, link, amount, date, uid, uname) VALUES (NULL, ? ,  ? , NOW() , ? , ? )",[
                        $link,
                        $res->amount,
                        $_SESSION['id'],
                        $plr["username"]
                    ]);
                    
                    if ($update && $insert) {


////////////////// ทำแจ้งเตือนส่วนนี้ได้เลย//////////////

                        $f = dd_q("SELECT * FROM setting");
                        $dt = $f->fetch(PDO::FETCH_ASSOC);
                        $sToken = $dt['webhook_dc'];
                        $sMessage = "MUCITY แจ้งเตือนมีรายการเติมเงินเข้าด้วยซองอั่งเปา : ".$dt['name']. "\n";
                        $sMessage .= "ผู้ใช้ : " .$plr["username"]. " \n";
                        $sMessage .= "จำนวน : ".$res->amount. " บาท \n"; 
                        $chOne = curl_init(); 
                        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
                        curl_setopt( $chOne, CURLOPT_POST, 1); 
                        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
                        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
                        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
                        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
                        $result = curl_exec( $chOne );

//////////////////////////////////////////////


                    dd_return(true, "คุณได้รับเงินจำนวน " . $res->amount . " บาท");

                    } else {
                        dd_return(false, "SQL ERR");
                    }
                }
            } else {
                dd_return(false, "API ERR");
            }
        } else {
            dd_return(false, "กรุณาใส่ลิ้ง");
        }
    } else {
        dd_return(false, "เข้าสู่ระบบก่อนดำเนินการครับ ");
    }
} else {
    dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}
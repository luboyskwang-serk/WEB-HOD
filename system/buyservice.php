<?php
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

// //////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        $p = dd_q("SELECT * FROM users WHERE id = ? ", [$_SESSION['id']]);
        $plr = $p->fetch(PDO::FETCH_ASSOC);

        $pdx = dd_q('SELECT * FROM service_prod WHERE id = ?', [$_POST['id']]);
        $pd = $pdx->fetch(PDO::FETCH_ASSOC);

        $price =  $pd["price"];
        if (
            $_POST['user'] != "" AND $_POST['pass'] != ""
        ) {
        if ($plr["point"] >= $price) {
            $insert = dd_q("INSERT INTO service_order (cosid , prod , user , pass , status , del)
                        VALUES ( ? , ? , ? , ? , ? , ?  ) 
                        ", [
                            $_SESSION['id'],
                            $pd["name"],
                            $_POST["user"],
                            $_POST["pass"],
                            "no",
                            "no"
                        ]);
                        $upt = dd_q("UPDATE users SET point = point  - ? WHERE id = ? ",[$price , $_SESSION['id']]);
                        if ($insert AND $upt) {
                            $f = dd_q("SELECT * FROM setting");
                        $dt = $f->fetch(PDO::FETCH_ASSOC);
                        $sToken = $dt['webhook_dc'];
                        $sMessage = "มีการเติมเกมส์เข้ามาใหม่ครับ : ".$dt['name']. "\n";
                        $sMessage .= "สินค้า : " .$pd["name"]. " \n";
                        $sMessage .= "UID : " .$_POST["user"]. " \n";
                        /* $sMessage .= "ชื่อในเกม : " .$_POST["pass"]. " \n"; */
                        /* $sMessage .= "ผู้ใช้ : " .$profile['username']. " \n"; */

                        $sMessage .= "จำนวน : ".$price. " บาท \n";
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
                            dd_return(true, "Order ซื้อสินค้าสำเร็จ !");
                        } else {
                            dd_return(false, "[ERROR API BUY] โปรดติดต่อเจ้าของเว็บ!");
                        }
        } else {
            dd_return(false,  "เงินไม่เพียงพอ");
        }
        }else{
            dd_return(false, "กรุณากรอกไอดีและพาสเวิร์ดให้ครบ");
        }
    } else {
        dd_return(false,  "เข้าสู่ระบบก่อนทำรายการ");
    }
} else {
    dd_return(false,  "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}

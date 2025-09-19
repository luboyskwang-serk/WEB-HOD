<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';

function Config_Topup(){
    $ary = array();
    $ary = [
        'api_url' => 'http://tmwallet.thaighost.net/apipp.php',
        'tmweasy_user' => 'Karan2002',
        'tmweasy_password' => 'Karan2002',
        'con_id' => '104522',
        'prommpay_type' => '03',
        'prommpay_no' => '004999159272011',
        'bbl_accode' => 'tmpwoktXABBQMDi[pl]FTaDTwuvkLUAjF5HgIhNF13ph9wg1cLA2Fwt6YqF4DfM0c[pl]11c1qykWgUm[pl]h0zdBYvODyux2eruA[tr][tr]',
        'bbl_account_no' => '1483640087',
    ];
    return $ary;
}
header('Content-Type: application/json; charset=utf-8;');

if(isset($_POST['method'])){
    if($_POST['method'] == 'qr_set'){
        $price = preg_replace("/[^0-9]/", "", $_POST['amount']);
        if(!$price){
            echo json_encode(array('status'=>'error', 'msg'=>'จำนวนเงินไม่ถูกต้อง!'));
            return;
        }
        if($price < 10){
            echo json_encode(array('status'=>'error', 'msg'=>'กรุณาเติมเงินไม่ต่ำกว่า 50 บาท'));
            return;
        }
        
        $config = Config_Topup();
        $connect_api =  ConnectApi($config['api_url'].'?username='.$config['tmweasy_user'].'&password='.$config['tmweasy_password'].'&amount='.$price.'&ref1='.$_SESSION['id'].'&con_id='.$config['con_id'].'&method=create_pay');
        $connect_api=json_decode($connect_api,true);
        
        if($connect_api['status'] != 1){
            echo json_encode(array('status'=>"error",'msg'=>$connect_api['msg']));
            return;
        }else{
            $_SESSION["id_pay"]=$connect_api['id_pay'];
            $connect_api1 =  ConnectApi($config['api_url'].'?username='.$config['tmweasy_user'].'&password='.$config['tmweasy_password'].'&con_id='.$config['con_id'].'&id_pay='.$_SESSION["id_pay"].'&type='.$config['prommpay_type'].'&promptpay_id='.$config['prommpay_no'].'&method=detail_pay');
            $connect_api1=json_decode($connect_api1,true);
            if($connect_api1["status"]!= 1){
                $_SESSION['id_pay'] = "";
                echo json_encode(array('status'=>"error",'msg'=>$connect_api1['msg']));
                return;
            }
            $_SESSION["pricee"]=$price;
            echo json_encode(array('status'=>'success', 'base64'=>$connect_api1['qr_image_base64'], 'price'=>number_format($price, 2), 'timeout'=>$connect_api1['time_out']));
        }
    }else if($_POST['method'] == 'cancle'){
        $config = Config_Topup();
        $connect_api=ConnectApi($config['api_url']."?username=".$config['tmweasy_user']."&password=".$config['tmweasy_password']."&con_id=".$config['con_id']."&method=cancel&id_pay=".$_SESSION["id_pay"]);
        $_SESSION['id_pay'] = "";
        echo json_encode(array('status'=>"success"));
        return;
    }else if($_POST['method'] == 'submit_qr'){
        
        $config = Config_Topup();
        $connect_api=ConnectApi($config['api_url']."?username=".$config['tmweasy_user']."&password=".$config['tmweasy_password']."&con_id=".$config['con_id']."&method=confirm&id_pay=".$_SESSION["id_pay"]."&accode=".$config['bbl_accode']."&account_no=".$config['bbl_account_no']."&ip=".GettingIP());
	    
        $connect_api=json_decode($connect_api,true);
        
        if($connect_api["status"]!= 1){
            echo json_encode(array('status'=>"error",'msg'=>$connect_api["msg"]));
            return;
        }
        
        $amount = $connect_api["amount"];
        $amount = round(str_replace(',','', $amount));
        $_SESSION["id_pay"]="";
        $plr = dd_q("SELECT * FROM users WHERE id = ?", [$_SESSION["id"]])->fetch(PDO::FETCH_ASSOC);
        $update = dd_q("UPDATE users SET point = ?, total = ? WHERE id = ?", [$plr["point"] + $amount, $plr["total"] + $amount, $_SESSION["id"]]);
        $insert = dd_q("INSERT INTO topup_his (`link`, `amount`, `date`, `uid`, `uname`) VALUES (?, ?, NOW(), ?, ?)", ['QRCODE',$amount, $plr["id"], $plr["username"]]);
        echo json_encode(array('status'=>"success",'msg'=>'เติมเงินสำเร็จจำนวน '.$amount. ' บาท'));
            return;

    }
}

function ConnectApi($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; th; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    @curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    return curl_exec($ch);
}
function GettingIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $IP = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $IP = $_SERVER['REMOTE_ADDR'];
    }
    return $IP;
}
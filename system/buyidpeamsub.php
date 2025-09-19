<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once 'a_func.php';


function dd_return($status, $message) {
    $json = ['msg' => $message];
    if ($status) {
        http_response_code(200);
        die(json_encode($json));
    }else{
        http_response_code(400);
        die(json_encode($json));
    }
}

// //////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');
		$get_data=file_get_contents('https://peamsub24hr.online/api/api_product');
		$getpack=json_decode($get_data);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
		$f = dd_q("SELECT * FROM setting");
		$dt = $f->fetch(PDO::FETCH_ASSOC);
		$keyapi = $dt['apipeamsub'];
        $p = dd_q("SELECT * FROM users WHERE id = ? ", [$_SESSION['id']]);
        $plr = $p->fetch(PDO::FETCH_ASSOC);
          $q_1 = dd_q('SELECT * FROM users WHERE id = ?', [$_SESSION['id']]);
          if ($q_1->rowCount() >= 1) {
                $row_1 = $q_1->fetch(PDO::FETCH_ASSOC);
                $p = dd_q("SELECT * FROM apipeam_product WHERE id = ?",[$_POST['id']]);
                if($p->rowCount() >= 1){
                    $pd = $p->fetch(PDO::FETCH_ASSOC);
                    $point = (int) $row_1['point'];
                    $price = (int) $pd['price'];
                    if($point >= $price){
						 if($response['status'] != 'error'){
                        if($pd['stock'] != "0"){
                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://peamsub24hr.online/api/apibuy_product',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                    CURLOPT_HTTPHEADER => array(
                                        'Content-Type: application/json',
                                        'apikey: ' . $keyapi,
                                        'customer: ' . $plr['username'],
                                        'pid: ' . $_POST['id']
                                    ),
                                ));
                                
                                $result = curl_exec($curl);
                                curl_close($curl);
                                $response = json_decode($result, true);                   
                                
                                $product = dd_q("INSERT INTO boxlogapp (date, username, name, details, image, price, product_id , uid) VALUES ( NOW() , ? , ? , ? , ? , ? , ?  , ? )", [
                                    $plr['username'],
                                    $pd['name'],
                                    $response['result'],
                                    $pd['img'],
                                    $price,
                                    $response['p_id'],
                                    $_SESSION['id'],
                                ]);
                                
                                if ($product){
                                    $sToken = $config['webhook_dc'];
                                    $sMessage = "(PEAMSUB24HR) มีรายการสั่งซื้อ \n";
                                    $sMessage .= "ชื่อสินค้า : " .$pd['product']. " \n";
                                    $sMessage .= "รายละเอียดสินค้า : " .str_replace('\n', '\n', $response['result']). " \n";
                                    $sMessage .= "ผู้ใช้ : " .$plr['username']. " \n";
                                    $sMessage .= "ราคา : ".$price. " บาท \n";
                                    $sMessage .= "IP : " .$ip. " \n";
                                    
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
                                    
                                    $upt = dd_q("UPDATE users SET point = point  - ? WHERE id = ? ",[$price , $_SESSION['id']]);
                                    
                                    echo json_encode(array('status'=>"success",'msg'=>'สั่งซื้อสินค้าสำเร็จ'));
                                }else{
                                    echo json_encode(array('status'=>"error",'msg'=>'โปรดติดต่อแอดมินเว็บไซต์ของคุณเพื่อเติมเงินเข้าสู่ระบบหรืออาจะพบปัญหาอื่นๆกรุณาแจ้งแอดมิน !'));
                                }
                            }else{
                                echo json_encode(array('status'=>"error",'msg'=>'สินค้าหมดแล้ว'));
                            }
                    }else{
                        echo json_encode(array('status'=>"error",'msg'=>$response['msg']));
                    }
                }else{
                        echo json_encode(array('status'=>"error",'msg'=>"คุณมียอดเงินไม่เพียงพอ"));
                    }
                }else{
                  echo json_encode(array('msg'=>"ไม่พบสินค้า"));
                }
          }else{
            echo json_encode(array('msg'=>"ไม่พบชื่อผู้ใช้งาน"));
          }
    }else{
    echo json_encode(array('msg'=>"เข้าสู่ระบบก่อนทำรายการ"));
    }
}else{
dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
}



?>

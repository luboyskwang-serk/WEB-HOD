<?php
require_once "a_func.php";

function getStatusDescriptionTH($status)
{
    switch ($status) {
        case 0:
            return "รายการสำเร็จ";
        case 10001:
            return "Internal Error (ไม่สามารถเชื่อมต่อระบบฐานข้อมูลได้)";
        case 10002:
            return "Internal Error (รายการไม่สมบูรณ์)";
        case 10003:
            return "Internal Error (Too Many Requests)";
        case 10004:
            return "Internal Error (เกิดข้อผิดพลาดในการสร้างรายการใหม่)";
        case 20001:
            return "Username หรือ Password มีรูปแบบไม่ถูกต้อง";
        case 20003:
            return "Username หรือ Password มีรูปแบบไม่ถูกต้อง";
        case 20004:
            return "Username ไม่สามารถเรียกใช้ API ได้";
        case 20005:
            return "ไม่อนุญาตให้เข้าถึงระบบ (IP address นี้ไม่ได้รับอนุญาต)";
        case 30001:
            return "ไม่พบ Company ที่ระบุ";
        case 30002:
            return "Transaction ID ไม่ถูกต้อง";
        case 30003:
            return "ไม่พบ Transaction ID ที่ระบุ";
        case 30004:
            return "Transaction ID ที่ระบุอยู่ในระหว่างการทำรายการ";
        case 30005:
            return "Callback URL ไม่ถูกต้อง";
        case 30006:
            return "Callback Reference ID ไม่ถูกต้อง";
        case 30007:
            return "ระบุจำนวนเงินไม่ถูกต้อง";
        case 30008:
            return "ระบุบริษัทไม่ถูกต้อง";
        case 30009:
            return "ระบุ Ref.1 ไม่ถูกต้อง";
        case 30010:
            return "ระบุ Ref.2 ไม่ถูกต้อง";
        case 30011:
            return "ระบุ Ref.3 ไม่ถูกต้อง";
        case 30012:
            return "ระบุ Ref.4 ไม่ถูกต้อง";
        case 30013:
            return "บาร์โค้ดไม่ถูกต้อง";
        case 30016:
            return "มีข้อผิดพลาดในการทำรายการ (พบ Callback Reference ID ซ้ำ)";
        case 30017:
            return "ตรวจพบการเลือกบริษัทผิดพลาด (เช่น กรณีที่บัตรเครดิตเป็นของธนาคารอื่น)";
        case 30018:
            return "ตรวจพบความไม่ถูกต้องของยอดหนี้ (เช่น กรณีที่กำหนดชำระเงินหรือระบุยอดหนี้ไม่ถูกต้อง)";
        case 30019:
            return "ยอดเงินในระบบไม่เพียงพอ";
        case 30020:
            return "ไม่อนุญาตให้ใช้ชำระเงินให้กับบริษัทที่ระบุ";
        default:
            return "รหัสสถานะไม่ถูกต้อง";
    }
}

function dd_return($status, $message)
{
    if ($status) {
        $json = ["status" => "success", "message" => $message];
        http_response_code(200);
        die(json_encode($json));
    } else {
        $json = ["status" => "fail", "message" => $message];
        http_response_code(200);
        die(json_encode($json));
    }
}

function callWePayAPI($username, $password, $resp_url, $pay_to_amount, $pay_to_company, $pay_to_ref1, $dest_ref)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.wepay.in.th/client_api.json.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query(array(
            'username' => $username,
            'password' => $password,
            'resp_url' => $resp_url,
            'type' => "cashcard",
            'pay_to_amount' => $pay_to_amount,
            'pay_to_company' => $pay_to_company,
            'pay_to_ref1' => $pay_to_ref1,
            'dest_ref' => $dest_ref
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}


function generateRandomString($length = 12) {
    $characters = '0123456789ABC';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}


header("Content-Type: application/json; charset=utf-8;");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["id"])) {
        $f = dd_q("SELECT * FROM setting")->fetch(PDO::FETCH_ASSOC);
        $pay_to_amount = $_POST["price"];
        $pay_to_company = $_POST["product"];




        if ($apistatus == "2") {
            if (
                empty($pay_to_amount) ||
                empty($pay_to_company) 
            ) {
                // หยุดทำงานหากมีค่าว่าง
                dd_return(false, "กรุณากรอกข้อมูลให้ครบถ้วน");
            }

            $pay_to_ref1 = "0000000000";
            $q_1 = dd_q("SELECT * FROM users WHERE id = ?", [$_SESSION["id"]]);
            if ($q_1->rowCount() >= 1) {
                
                        $cost_price = $pay_to_amount;

                        $free = $cost_price + $cost_price * ($apiprice / 100);
                        $free = round($free, 2);

                        $p = dd_q("SELECT * FROM users WHERE id = ? ", [
                            $_SESSION["id"],
                        ]);
                        $plr = $p->fetch(PDO::FETCH_ASSOC);
                        if ($plr["point"] < $free) {
                            dd_return(false, "ยอดเงินของคุณไม่เพียงพอ");
                        }
                        $randomString = generateRandomString();
                        $host = $_SERVER['HTTP_HOST'];
                        $current_url = "https://" . $host;
                        $response = callWePayAPI($apipubkey, $apisecrets, "$current_url/wepaywebhook.php", $pay_to_amount, $pay_to_company, $pay_to_ref1, $randomString);


                        $TermGame = $response;

                        if (isset($TermGame["code"])) {
                            
                            if ($TermGame["code"] === "00000") {
                                $log = dd_q(
                                    "INSERT INTO his_purchase (ref, description, product, price, uid, dest_ref,type) VALUES (?,?,?,?,?,?,?)",
                                    [
                                        $pay_to_ref1,
                                        "ซื้อบัตรเงินสด",
                                        $pay_to_company,
                                        $free,
                                        $_SESSION["id"],
                                        $randomString,
                                        "cashcard"
                                    ]
                                );

                                $upt = dd_q(
                                    "UPDATE users SET point = point  - ? WHERE id = ? ",
                                    [$free, $_SESSION["id"]]
                                );

                                
                                if($upt && $log){
                                    dd_return(true, "ดำเนินการเรียบร้อยแล้ว");
                                    http_response_code(200);
                                    exit();
                                } else {
                                    dd_return(false, "SQL ERROR");
                                }
                            } else {
                                dd_return(
                                    false,
                                    getStatusDescriptionTH(
                                        $TermGame["code"]
                                    ) . " ($randomString) #2"
                                );
                                http_response_code(400);
                                exit();
                            }
                        } else {
                            dd_return(
                                false,
                                getStatusDescriptionTH(
                                    $TermGame["code"]
                                ) . " #1"
                            );
                            http_response_code(400);
                            exit();
                        }
                    
            } else {
                dd_return(false, "ไม่พบชื่อผู้ใช้งาน");
            }
        } else {
            dd_return(false, "ปิดใช้งานระบบชั่วคราว !!");
        }
    } else {
        dd_return(false, "เข้าสู่ระบบก่อนทำรายการ");
    }
} else {
    dd_return(false, "Method '{$_SERVER["REQUEST_METHOD"]}' not allowed!");
}

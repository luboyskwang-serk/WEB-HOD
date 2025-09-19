<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';
require_once 'password_hash_upgrade.php';

function dd_return($status, $message) {
    if ($status) {
        $json = ['status' => 'success', 'message' => $message];
        http_response_code(200);
        die(json_encode($json));
    } else {
        $json = ['status' => 'fail', 'message' => $message];
        http_response_code(200);
        die(json_encode($json));
    }
}

//////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['id'])) {
        $user_login = $_POST['user'];
        $pwd_login = $_POST['pass'];
        $pwd2_login = $_POST['pass2'];
        $accept = $_POST['accept'];
        $secret = $conf['secretkey'];
        $response = $_POST["captcha"];
        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
        $captcha_success = json_decode($verify);
        
        if ($captcha_success->success == false) {
            dd_return(false, "กรุณายืนยันตัวตน");
        } else if ($captcha_success->success == true) {
            //================================================================
            if ($config['oaccept'] == 1) {
                if ($accept == 1) {
                    if ($user_login != "" && $pwd_login != "" && $pwd2_login != "" && $_POST['email'] != "") {
                        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                            if ($pwd_login == $pwd2_login) {
                                // ใช้ระบบลงทะเบียนที่อัปเกรดแล้ว
                                $result = registerUser($user_login, $pwd_login, $_POST['email']);
                                if ($result['status'] == 'success') {
                                    // Login อัตโนมัติหลังลงทะเบียน
                                    $user = checkUserPassword($user_login, $pwd_login);
                                    if ($user) {
                                        $_SESSION['id'] = $user['id'];
                                        dd_return(true, "สมัครสมาชิกสำเร็จ");
                                    } else {
                                        dd_return(false, "ลงทะเบียนสำเร็จแต่เข้าสู่ระบบไม่ได้");
                                    }
                                } else {
                                    dd_return(false, $result['message']);
                                }
                            } else {
                                dd_return(false, "โปรดป้อนรหัสผ่านทั้งสองให้ตรงกัน");
                            }
                        } else {
                            dd_return(false, "กรุณากรอกรูปแบบอีเมล์ให้ถูกต้อง");
                        }
                    } else {
                        dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
                    }
                } else {
                    dd_return(false, "กรุณาอ่านเงื่อนไขและยอมรับเงื่อนไขก่อน");
                }
            } elseif ($config['oaccept'] == 0) {
                if ($user_login != "" && $pwd_login != "" && $pwd2_login != "") {
                    if ($pwd_login == $pwd2_login) {
                        // ใช้ระบบลงทะเบียนที่อัปเกรดแล้ว (ไม่มี email)
                        $result = registerUser($user_login, $pwd_login, null);
                        if ($result['status'] == 'success') {
                            // Login อัตโนมัติหลังลงทะเบียน
                            $user = checkUserPassword($user_login, $pwd_login);
                            if ($user) {
                                $_SESSION['id'] = $user['id'];
                                dd_return(true, "สมัครสมาชิกสำเร็จ");
                            } else {
                                dd_return(false, "ลงทะเบียนสำเร็จแต่เข้าสู่ระบบไม่ได้");
                            }
                        } else {
                            dd_return(false, $result['message']);
                        }
                    } else {
                        dd_return(false, "โปรดป้อนรหัสผ่านทั้งสองให้ตรงกัน");
                    }
                } else {
                    dd_return(false, "กรุณากรอกข้อมูลให้ครบ");
                }
            }
            //================================================================
        } else {
            dd_return(false, "ไม่สามารถใช้งานได้");
        }
    } else {
        dd_return(false, "ออกจากระบบก่อน");
    }
}
dd_return(false, "Method '{$_SERVER['REQUEST_METHOD']}' not allowed!");
?>
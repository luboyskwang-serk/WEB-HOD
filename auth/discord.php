<?php
 session_start();
 error_reporting(0);
 require_once '../system/a_func.php';
// กำหนดค่า Client ID และ Client Secret ของแอปพลิเคชัน Discord ของคุณ
$clientID = '1242821012018434149';
$clientSecret = 'tyW0H_oO-TGJfa8rOh-V_TLfOkwf54gQ';

// กำหนด URL สำหรับรีเดิร์กซ์เป็น callback หลังจากที่ผู้ใช้เข้าสู่ระบบ Discord
$redirectURI = 'https://khunbaimai.in.th/auth/discord.php';

// ตรวจสอบว่ามีการส่งค่า code กลับมาหลังจากการรับอนุญาตจากผู้ใช้หรือไม่
if (isset($_GET['code'])) {
    // ส่งคำขอ Token ไปยัง Discord API
    $token = getToken($_GET['code'], $clientID, $clientSecret, $redirectURI);

    // ใช้ Token เพื่อขอข้อมูลผู้ใช้จาก Discord API
    $user = getUser($token);
    $avatarURL = getAvatarURL($user->id, $user->avatar);

    // echo("-------<br/>");
    // echo("DIS ID: ". $user->id . "<br/>");
    // echo("-------<br/>");
    // echo("DIS Username: ". $user->username . "<br/>");
    // echo("-------<br/>");
    // echo("DIS Global Name: ". $user->global_name . "<br/>");
    // echo("-------<br/>");
    // echo("DIS IMG: ". "<img src=".$avatarURL." /><br/>");
    // echo("-------<br/>");

    $q = dd_q("SELECT * FROM users WHERE social_id = ? ", [$user->id]);
    if ($q->rowCount() == 1) {
        // dd_return(false, "ชื่อนี้ผู้ใช้แล้ว");
        $dt = $q->fetch(PDO::FETCH_ASSOC);
        $_SESSION['id'] = $dt['id'];
        header('Location: /?page=home&true=discord#login');
        exit();
    } else {
        $in = dd_q("INSERT INTO users (username,password,date,point,total,social_id, social_type, profile) VALUES ( ? , ? , NOW() , 0 , 0, ?, 'discord', ?)", [
            $user->global_name,
            md5($user->id),
            $user->id,
            $avatarURL
        ]);            
        // print_r($in);
        // exit;
        if ($in == true) {
            $q = dd_q("SELECT * FROM users WHERE social_id = ? ", [
                $user->id
            ]);
            $dt = $q->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $dt['id'];
            header('Location: /?page=home&true=discord#reg');
            exit();
        } else {
            header('Location: /?page=home&error=discord#reg');
            exit();
        }
    }
} else {
    // ถ้าไม่มี code ส่งกลับมา ให้ส่งผู้ใช้ไปยังหน้ารับอนุญาต
    header('Location: https://discord.com/api/oauth2/authorize?client_id=' . $clientID . '&redirect_uri=' . urlencode($redirectURI) . '&response_type=code&scope=identify');
    exit();
}

// ฟังก์ชันสำหรับการรับ Token จาก Discord API
function getToken($code, $clientID, $clientSecret, $redirectURI) {
    $data = array(
        'client_id' => $clientID,
        'client_secret' => $clientSecret,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirectURI,
        'scope' => 'identify'
    );

    $ch = curl_init('https://discord.com/api/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $token = json_decode($response)->access_token;
    return $token;
}

// ฟังก์ชันสำหรับการรับข้อมูลผู้ใช้จาก Discord API
function getUser($token) {
    $ch = curl_init('https://discord.com/api/users/@me');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $token
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    $user = json_decode($response);
    return $user;
}

// ฟังก์ชันสำหรับการรับ URL ของรูปโปรไฟล์จาก Discord API
function getAvatarURL($userID, $avatarHash, $size = 128) {
    // ตรวจสอบว่ามีการกำหนดรูปแบบไซส์หรือไม่
    $avatarSize = $size != null ? '?size=' . $size : '';
    // สร้าง URL สำหรับรูปโปรไฟล์โดยใช้ userID และ hash ของ avatar
    return 'https://cdn.discordapp.com/avatars/' . $userID . '/' . $avatarHash . '.png' . $avatarSize;
}
?>

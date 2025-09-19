 <?php
 session_start();
 error_reporting(0);
 require_once '../system/a_func.php';
    // ตรวจสอบว่ามีรหัสอนุญาตจาก Line หรือไม่
    if(isset($_GET['code'])) {
        // รับรหัสอนุญาตจาก Line
        $code = $_GET['code'];
        
        // สร้างข้อมูลที่จำเป็นสำหรับการร้องขอ Access Token
        $data = array(
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => "https://khunbaimai.in.th/auth/line.php",
            'client_id' => "2005554516",
            'client_secret' => '131b669af38ccef37b2074085dc2b435' // ใส่ Client Secret ของคุณที่นี่
        );

        // สร้าง URL สำหรับการร้องขอ Access Token
        $token_url = 'https://api.line.me/oauth2/v2.1/token';

        // สร้าง Context สำหรับการส่งคำขอ POST ไปยัง Line API
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            )
        ));

        // ส่งคำขอร้องขอ Access Token ไปยัง Line API
        $response = file_get_contents($token_url, false, $context);

        // แปลงข้อมูลที่ได้รับกลับมาเป็นรูปแบบของ JSON
        $token_data = json_decode($response, true);

        // ตรวจสอบว่ามี Access Token ที่ได้หรือไม่
        if(isset($token_data['access_token'])) {
            // สามารถใช้ Access Token นี้ได้
            $access_token = $token_data['access_token'];

            // ใช้ Access Token เพื่อร้องขอข้อมูลผู้ใช้จาก Line
            $profile_url = 'https://api.line.me/v2/profile';
            $profile_response = file_get_contents($profile_url, false, stream_context_create([
                'http' => [
                    'header' => "Authorization: Bearer $access_token"
                ]
            ]));
            
            // แปลงข้อมูลที่ได้รับกลับมาเป็นรูปแบบของ JSON
            $profile_data = json_decode($profile_response, true);

            // แสดงข้อมูลผู้ใช้
            // echo "<h2>User Profile:</h2>";
            // echo "<p>User ID: " . $profile_data['userId'] . "</p>";
            // echo "<p>Display Name: " . $profile_data['displayName'] . "</p>";
            // echo "<p>Picture URL: " . $profile_data['pictureUrl'] . "</p>";
            // echo "<p>Status Message: " . $profile_data['statusMessage'] . "</p>";

            $q = dd_q("SELECT * FROM users WHERE social_id = ? ", [$profile_data['userId']]);
        if ($q->rowCount() == 1) {
            // dd_return(false, "ชื่อนี้ผู้ใช้แล้ว");
            $dt = $q->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $dt['id'];
            header('Location: /?page=home&true=line#login');
            exit();
        } else {
            $in = dd_q("INSERT INTO users (username,password,date,point,total,social_id, social_type, profile) VALUES ( ? , ? , NOW() , 0 , 0, ?, 'line', ?)", [
                $profile_data['displayName'],
                md5($profile_data['userId']),
                $profile_data['userId'],
                $profile_data['pictureUrl']
            ]);            
            // print_r($in);
            // exit;
            if ($in == true) {
                $q = dd_q("SELECT * FROM users WHERE social_id = ? ", [
                    $profile_data['userId']
                ]);
                $dt = $q->fetch(PDO::FETCH_ASSOC);
                $_SESSION['id'] = $dt['id'];
                header('Location: /?page=home&true=line#reg');
                exit();
            } else {
                header('Location: /?page=home&error=line#reg');
                exit();
            }
        }
        } else {
            header('Location: /?page=home&error=line#reg');
            exit();
        }
    }
    ?>
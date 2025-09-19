<?php 
//---------------- config ---------------
// ใส่ keyapi ท่าน
$keyapi = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

//---------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // URL สำหรับ API ที่จะส่งข้อมูลไป
    $api_url = "https://byshop.me/api/report_fix";

    // รับค่าจาก AJAX
    $orderid = isset($_POST["orderid"]) ? $_POST["orderid"] : '';
    $report_id = isset($_POST["report_id"]) ? $_POST["report_id"] : '';

    // ตรวจสอบว่ามีการส่งค่าทั้ง orderid และ report_id มาหรือไม่
    if (empty($orderid) || empty($report_id)) {
        echo json_encode(['status' => 'error', 'message' => 'กรุณาใส่ข้อมูลให้ครบถ้วน ']);
        exit();
    }

    // ข้อมูลที่ต้องการส่งไปยัง API
    $data = array(
        "keyapi" => $keyapi,
        "orderid" => $orderid,
        "report_id" => $report_id
    );

    // ตั้งค่า cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // แปลง array เป็น query string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded"
    ));

    // ส่ง request และรับ response
    $response = curl_exec($ch);

    // ตรวจสอบข้อผิดพลาดจาก cURL
    if (curl_errno($ch)) {
        echo json_encode(['status' => 'error', 'message' => 'cURL Error: ' . curl_error($ch)]);
    } else {
        // หากไม่มีข้อผิดพลาดให้ส่ง response กลับ
        echo $response;
    }

    // ปิด cURL
    curl_close($ch);
    exit();
}

// รับค่า OrderId จาก URL
$orderid = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';


$curl = curl_init();

// ข้อมูลที่ต้องการส่งไปในคำขอ POST
$postData = array(
    'keyapi' => $keyapi,
    'orderid' => $orderid
);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://byshop.me/api/history',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => http_build_query($postData), // แปลง array เป็น query string
  CURLOPT_HTTPHEADER => array(
    'Cookie: PHPSESSID=ca9984t7npko2vl8svqg0pdvsj',
    'Content-Type: application/x-www-form-urlencoded' // กำหนด Content-Type ให้เหมาะสมกับข้อมูลที่ส่ง
  ),
));

$response = curl_exec($curl);
curl_close($curl);

// ตรวจสอบว่า response ไม่เป็นค่าว่าง
if (!$response) {
    echo $response;
    exit();
}

// แปลงข้อมูล JSON ที่ได้รับมาเป็น array
$data = json_decode($response, true);

// ตรวจสอบว่าแปลง JSON สำเร็จ และตรวจสอบว่าได้รับข้อมูลหรือไม่
if ($data && is_array($data)) {
    foreach ($data as $item) {
        // ตรวจสอบคีย์ใน array ว่ามีข้อมูลที่ต้องการหรือไม่
        $id = isset($item['id']) ? $item['id'] : '';
        $name = isset($item['name']) ? $item['name'] : '';
        $img = isset($item['img']) ? $item['img'] : '';
        $report = isset($item['report']) ? $item['report'] : '';
        $status_fix = isset($item['status_fix']) ? $item['status_fix'] : '';
    }
} else {
    echo $response;
    exit();
}

$report_idstatus = array(
    2 => "รอแก้ไข...",
    3 => "แก้ไขสำเร็จ",
    4 => "หมดอายุแล้ว!",
    5 => "ติดต่อแอดมิน",
    6 => "กดเข้าร่วม Youtube Family ให้สำเร็จ!",
    7 => "ยืนยันตัวตนที่ Gmail",
    8 => "เข้าร่วม Youtube Family สำเร็จแล้ว!!",
    9 => "อัพเดท (รหัสใหม่)",
    10 => "OTP เกินเวลา (ติดต่อแอดมิน)",
    11 => "คืนยอดเงินในระบบ สำเร็จ! (คืนยอดเงินตามจำนวนวันที่คงเหลือ) *คืนยอดผ่าน API BYShop*",
    12 => "กดรับสิทธ์ Youtube Premium ใหม่!!",
    13 => "แพคเกจ : จอแชร์",
    14 => "อัพเดท (PINใหม่)",
);

?>




<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งปัญหา (Report)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Add SweetAlert2 -->
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
     <center>
    <?php if (isset($img) && !empty($img)) { ?>
        <img src="<?php echo $img; ?>" class="card-img-top mt-2" style="width:15%;">
    <?php } ?>
</center>

<div class="card-body">
    <h5 class="card-title text-center" id="productName">
        <?php if (isset($name) && !empty($name)) { echo $name; } ?>
    </h5>

    <h5 class="card-title text-center" id="productName">
        <?php if (isset($report) && !empty($report)) { echo "ปัญหา : " . $report; } ?>
    </h5>

    <h5 class="card-title text-center" id="productName">
	<?php
if (isset($status_fix) && isset($report_idstatus[$status_fix]) && !empty($report_idstatus[$status_fix])) {
    echo "สถานะ : " . $report_idstatus[$status_fix];
}
?></h5>


<?php 
// สำหรับออเดอร์ Netflix ติดยืนยันอุปกรณ์

// ตรวจสอบว่า $name มีคำว่า "Netflix"
if (strpos($name, "Netflix") !== false) {

    // แพคเกจ TV
    if( strpos( $name, "TV" ) !== false ) {
        echo '<a class="btn text-white bg-dark w-100" target="_blank" href="https://byshop.me/api/netflix_update/api/tv?orderid=' . $id . '">
                <img class="byshop1" src="https://byshop.me/api/img/app/netflix.png" height="25">&nbsp;อัพเดทครัวเรือน TV<br>
                <small><u>(กรณีติดยืนยัน E-mail)</u></small>
              </a>';
    }

    // แพคเกจไม่ TV
    else {
        echo '<a class="btn text-white bg-dark w-100" target="_blank" href="https://byshop.me/api/netflix_update/api/mp?orderid=' . $id . '">
                <img class="byshop1" src="https://byshop.me/api/img/app/netflix.png" height="25">&nbsp;รับรหัสยืนยัน<br>
                <small><u>(กรณีติดยืนยัน E-mail)</u></small>
              </a>';
    }

}
?>


					<form id="reportForm">
                        <div class="mb-3">
                            <label for="orderId" class="form-label">เลขออเดอร์</label>
                            <input class="form-control" id="orderId" name="orderid" value="<?= $orderid ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="reportId" class="form-label">แจ้งปัญหา</label>
                            <select class="form-select" id="reportId" name="report_id">
								<option value="" disabled selected>-------- แจ้งปัญหา --------</option>
                                <option value="1">รหัสผิดเข้าสู่ระบบไม่ได้</option>
                                <option value="2">จอหาย / PIN ผิด</option>
                                <option value="3">Netflix โดนมั่วจอ</option>
                                <option value="4">OTP เกินเวลา</option>
                                <option value="5">แก้จอเต็มอัตโนมัติ (Netflix)</option>
                                <option value="6">จอเต็มรับชมไม่ได้ (แอปอื่นๆ)</option>
                                <option value="7">Youtube Premium หลุด</option>
                                <option value="8">Youtube Premium ครอบครัวถูกปิดการใช้งาน</option>
                                <option value="9">Spotify Premium หลุด</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-danger" id="submitReport">ส่งเรื่องแจ้งปัญหา</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#submitReport").click(function() {
        var formData = $("#reportForm").serialize(); // ใช้ serialize เพื่อส่งข้อมูลจากฟอร์มทั้งหมด
        $.ajax({
            url: "report.php",  // ใช้ URL ของไฟล์เดียวกัน
            method: "POST",
            data: formData,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === "error") {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: result.message
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'ส่งเรื่องแจ้งปัญหาสำเร็จ',
                        text: 'การแจ้งปัญหาของคุณได้รับการส่งเรียบร้อยแล้ว'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'เกิดข้อผิดพลาดในการส่งข้อมูล'
                });
            }
        });
    });
</script>

</body>
</html>

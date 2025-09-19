<?php
require_once '../system/a_func.php';
require_once '../system/2fa.php';

// ตรวจสอบการ login
if (!isset($_SESSION['id'])) {
    header('Location: ?page=login');
    exit;
}

// ดึงข้อมูลผู้ใช้
$q1 = dd_q("SELECT * FROM users WHERE id = ? LIMIT 1", [$_SESSION['id']]);
$user = $q1->fetch(PDO::FETCH_ASSOC);

// ตรวจสอบว่าผู้ใช้มี secret key หรือยัง
if (empty($user['twofa_secret'])) {
    // สร้าง secret key ใหม่
    $secret = TwoFactorAuth::generateSecret();
    
    // บันทึก secret key ชั่วคราวใน session
    $_SESSION['twofa_secret'] = $secret;
    
    // สร้าง QR Code
    $qrCodeUrl = TwoFactorAuth::getQRCodeUrl($config['name'] . ' (' . $user['username'] . ')', $secret);
    $qrCodeImage = TwoFactorAuth::getQRCodeImage($config['name'] . ' (' . $user['username'] . ')', $secret);
} else {
    // ใช้ secret key ที่มีอยู่
    $secret = $user['twofa_secret'];
    $qrCodeUrl = TwoFactorAuth::getQRCodeUrl($config['name'] . ' (' . $user['username'] . ')', $secret);
    $qrCodeImage = TwoFactorAuth::getQRCodeImage($config['name'] . ' (' . $user['username'] . ')', $secret);
}
?>

<style>
    .form-control {
        border: none;
        border-bottom: 3px solid var(--main);
        border-radius: 0px;
    }

    .tc {
        font-weight: 500;
        text-transform: uppercase;
        background: linear-gradient(to right, #d51f1f 0%, #ff9f00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none
    }

    .fsh {
        font-size: 16px;
        color: #dfdfdf;
    }

    .bb {
        background-color: #0e0e0f;
        border: solid 1px #232326;
    }

    .card-dz {
        background-color: #0f0f0f;
        border-radius: 1vh;
        border: solid 1px #232326;
    }

    .btn-dz {
        background-color: #141416;
        border: solid 1px #232326;
    }
    
    .qr-container {
        text-align: center;
        margin: 20px 0;
    }
    
    .qr-code {
        max-width: 200px;
        border: 1px solid #ddd;
        padding: 10px;
        background: white;
    }
    
    .secret-key {
        font-family: monospace;
        font-size: 18px;
        letter-spacing: 2px;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        color: #333;
    }
</style>

<div class="container-fluid p-0 mt-4">
    <div class="container-sm m-cent ps-4 pe-4" style="margin-bottom: 4em!important;">
        <div class="container-fluid p-4 shadow-sm card-dz">
            <div class="col-lg-8 m-cent pt-4" style="margin-bottom: 4em!important;">
                <div>
                    <h1 class="tc" style="font-size: 26px;">Two-Factor Authentication</h1>
                    <h1 class="fsh"><?php echo $config['name']; ?></h1>
                </div>
                
                <br>
                
                <?php if ($user['twofa_enabled'] == 1): ?>
                    <div class="alert alert-success">
                        <h4><i class="fa fa-check-circle"></i> 2FA ถูกเปิดใช้งานแล้ว</h4>
                        <p>ระบบ Two-Factor Authentication ของคุณทำงานอยู่แล้ว</p>
                        <a href="?page=disable_2fa" class="btn btn-danger">ปิดการใช้งาน 2FA</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <h4><i class="fa fa-shield-alt"></i> ตั้งค่า Two-Factor Authentication</h4>
                        <p>เพิ่มความปลอดภัยให้กับบัญชีของคุณด้วย 2FA</p>
                    </div>
                    
                    <div class="qr-container">
                        <h5>สแกน QR Code ด้วยแอป Google Authenticator</h5>
                        <img src="<?php echo $qrCodeImage; ?>" alt="QR Code" class="qr-code img-fluid">
                        <p class="mt-2">หรือใส่ Secret Key ด้วยตนเอง:</p>
                        <div class="secret-key"><?php echo $secret; ?></div>
                    </div>
                    
                    <form id="setup2FAForm">
                        <div class="mb-3">
                            <label class="form-label">ใส่โค้ด 6 หลักจากแอป Google Authenticator</label>
                            <input type="text" class="form-control bb" id="twofa_code" maxlength="6" placeholder="123456">
                        </div>
                        
                        <button type="submit" class="btn btn-dz text-white ps-4 pe-4 pt-2 pb-2 w-100" id="btn_setup_2fa">
                            <i class="fa fa-check"></i> ยืนยันและเปิดใช้งาน 2FA
                        </button>
                    </form>
                <?php endif; ?>
                
                <div class="mt-4">
                    <h5>วิธีการตั้งค่า:</h5>
                    <ol>
                        <li>ดาวน์โหลดแอป Google Authenticator บนสมาร์ทโฟนของคุณ</li>
                        <li>สแกน QR Code หรือใส่ Secret Key ด้วยตนเอง</li>
                        <li>ใส่โค้ด 6 หลักที่ได้จากแอปเพื่อยืนยัน</li>
                        <li>คลิกปุ่ม "ยืนยันและเปิดใช้งาน 2FA"</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#setup2FAForm").submit(function(e) {
        e.preventDefault();
        
        var code = $("#twofa_code").val();
        
        if (code.length != 6 || !/^\d+$/.test(code)) {
            Swal.fire({
                icon: 'error',
                title: 'ข้อผิดพลาด',
                text: 'กรุณาใส่โค้ด 6 หลักให้ถูกต้อง'
            });
            return;
        }
        
        var formData = new FormData();
        formData.append('code', code);
        formData.append('secret', '<?php echo $secret; ?>');
        
        $.ajax({
            type: 'POST',
            url: 'system/setup_2fa.php',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#btn_setup_2fa').attr('disabled', 'disabled');
                $('#btn_setup_2fa').html('<i class="fa fa-spinner fa-spin"></i> กำลังตรวจสอบ...');
            }
        }).done(function(res) {
            if (res.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: res.message
                }).then(function() {
                    window.location = "?page=setup_2fa";
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: res.message
                });
                $('#btn_setup_2fa').removeAttr('disabled');
                $('#btn_setup_2fa').html('<i class="fa fa-check"></i> ยืนยันและเปิดใช้งาน 2FA');
            }
        }).fail(function(jqXHR) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้'
            });
            $('#btn_setup_2fa').removeAttr('disabled');
            $('#btn_setup_2fa').html('<i class="fa fa-check"></i> ยืนยันและเปิดใช้งาน 2FA');
        });
    });
});
</script>
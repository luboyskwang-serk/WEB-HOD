<?php
require_once '../system/a_func.php';

// ตรวจสอบการ login
if (!isset($_SESSION['id'])) {
    header('Location: ?page=login');
    exit;
}

// ดึงข้อมูลผู้ใช้
$q1 = dd_q("SELECT * FROM users WHERE id = ? LIMIT 1", [$_SESSION['id']]);
$user = $q1->fetch(PDO::FETCH_ASSOC);
?>

<style>
    .notification-card {
        background: linear-gradient(145deg, #1a1a1a, #0d0d0d);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .notification-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .notification-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .notification-toggle:last-child {
        border-bottom: none;
    }
    
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .slider {
        background-color: #ff6b35;
    }
    
    input:checked + .slider:before {
        transform: translateX(30px);
    }
    
    .channel-icon {
        font-size: 24px;
        margin-right: 10px;
    }
    
    .channel-email { color: #4285f4; }
    .channel-line { color: #00c300; }
    .channel-sms { color: #ff6b35; }
    .channel-push { color: #ffbb00; }
</style>

<div class="container-fluid p-0 mt-4">
    <div class="container-sm m-cent ps-4 pe-4">
        <div class="container-fluid p-4 shadow-sm" style="background: linear-gradient(145deg, #1a1a1a, #0d0d0d); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="col-lg-10 m-cent">
                <div class="text-center mb-4">
                    <h1 class="gradient-text" style="font-size: 28px; font-weight: 700;">การตั้งค่าการแจ้งเตือน</h1>
                    <p class="text-muted">จัดการวิธีการและประเภทการแจ้งเตือนที่คุณต้องการรับ</p>
                </div>
                
                <!-- การตั้งค่า Line Notify -->
                <div class="notification-card">
                    <h4><i class="fab fa-line channel-line"></i> การเชื่อมต่อกับ Line Notify</h4>
                    <p class="text-muted">เชื่อมต่อบัญชี Line ของคุณเพื่อรับการแจ้งเตือนแบบเรียลไทม์</p>
                    
                    <?php if (!empty($user['line_token'])): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> เชื่อมต่อกับ Line Notify แล้ว
                            <button class="btn btn-danger btn-sm float-end" id="disconnectLine">
                                <i class="fas fa-times"></i> ยกเลิกการเชื่อมต่อ
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="text-center">
                            <p>ยังไม่ได้เชื่อมต่อกับ Line Notify</p>
                            <a href="system/line_connect.php" class="btn btn-success">
                                <i class="fab fa-line"></i> เชื่อมต่อกับ Line Notify
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- ตั้งค่าการแจ้งเตือน -->
                <div class="notification-card">
                    <h4><i class="fas fa-bell"></i> ประเภทการแจ้งเตือน</h4>
                    <p class="text-muted">เลือกประเภทการแจ้งเตือนที่คุณต้องการรับ</p>
                    
                    <form id="notificationSettingsForm">
                        <!-- การสั่งซื้อ -->
                        <div class="notification-toggle">
                            <div>
                                <h5><i class="fas fa-shopping-cart"></i> การสั่งซื้อ</h5>
                                <p class="text-muted mb-0">แจ้งเตือนเมื่อมีการสั่งซื้อสินค้า</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="order_notifications" <?php echo ($user['notify_orders'] == 1) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <!-- การเติมเงิน -->
                        <div class="notification-toggle">
                            <div>
                                <h5><i class="fas fa-wallet"></i> การเติมเงิน</h5>
                                <p class="text-muted mb-0">แจ้งเตือนเมื่อมีการเติมเงินเข้าระบบ</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="topup_notifications" <?php echo ($user['notify_topups'] == 1) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <!-- โปรโมชั่น -->
                        <div class="notification-toggle">
                            <div>
                                <h5><i class="fas fa-tags"></i> โปรโมชั่น</h5>
                                <p class="text-muted mb-0">แจ้งเตือนโปรโมชั่นและข่าวสาร</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="promotion_notifications" <?php echo ($user['notify_promotions'] == 1) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <!-- ความปลอดภัย -->
                        <div class="notification-toggle">
                            <div>
                                <h5><i class="fas fa-shield-alt"></i> ความปลอดภัย</h5>
                                <p class="text-muted mb-0">แจ้งเตือนกิจกรรมความปลอดภัยในบัญชี</p>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" id="security_notifications" <?php echo ($user['notify_security'] == 1) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary-modern" id="saveNotificationSettings">
                                <i class="fas fa-save"></i> บันทึกการตั้งค่า
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- ช่องทางการแจ้งเตือน -->
                <div class="notification-card">
                    <h4><i class="fas fa-broadcast-tower"></i> ช่องทางการแจ้งเตือน</h4>
                    <p class="text-muted">เลือกช่องทางที่คุณต้องการรับการแจ้งเตือน</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="notification-toggle">
                                <div>
                                    <h5><i class="fas fa-envelope channel-email"></i> อีเมล</h5>
                                    <p class="text-muted mb-0">ส่งผ่านอีเมลของคุณ</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="email_channel" <?php echo (!empty($user['email'])) ? 'checked' : ''; ?> <?php echo (empty($user['email'])) ? 'disabled' : ''; ?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="notification-toggle">
                                <div>
                                    <h5><i class="fab fa-line channel-line"></i> Line</h5>
                                    <p class="text-muted mb-0">ส่งผ่าน Line Notify</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="line_channel" <?php echo (!empty($user['line_token'])) ? 'checked' : ''; ?> <?php echo (empty($user['line_token'])) ? 'disabled' : ''; ?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // บันทึกการตั้งค่าการแจ้งเตือน
    $("#notificationSettingsForm").submit(function(e) {
        e.preventDefault();
        
        var settings = {
            orders: $('#order_notifications').is(':checked') ? 1 : 0,
            topups: $('#topup_notifications').is(':checked') ? 1 : 0,
            promotions: $('#promotion_notifications').is(':checked') ? 1 : 0,
            security: $('#security_notifications').is(':checked') ? 1 : 0
        };
        
        $.ajax({
            type: 'POST',
            url: 'system/save_notification_settings.php',
            data: settings,
            beforeSend: function() {
                $('#saveNotificationSettings').attr('disabled', 'disabled');
                $('#saveNotificationSettings').html('<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...');
            }
        }).done(function(res) {
            if (res.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: res.message
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: res.message
                });
            }
            $('#saveNotificationSettings').removeAttr('disabled');
            $('#saveNotificationSettings').html('<i class="fas fa-save"></i> บันทึกการตั้งค่า');
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'ผิดพลาด',
                text: 'ไม่สามารถบันทึกการตั้งค่าได้'
            });
            $('#saveNotificationSettings').removeAttr('disabled');
            $('#saveNotificationSettings').html('<i class="fas fa-save"></i> บันทึกการตั้งค่า');
        });
    });
    
    // ยกเลิกการเชื่อมต่อ Line
    $("#disconnectLine").click(function() {
        Swal.fire({
            title: 'ยืนยันการยกเลิกการเชื่อมต่อ',
            text: "คุณแน่ใจหรือไม่ที่ต้องการยกเลิกการเชื่อมต่อกับ Line Notify?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'system/disconnect_line.php',
                    data: {},
                    beforeSend: function() {
                        $('#disconnectLine').attr('disabled', 'disabled');
                        $('#disconnectLine').html('<i class="fas fa-spinner fa-spin"></i>');
                    }
                }).done(function(res) {
                    if (res.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: res.message
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด',
                            text: res.message
                        });
                        $('#disconnectLine').removeAttr('disabled');
                        $('#disconnectLine').html('<i class="fas fa-times"></i> ยกเลิกการเชื่อมต่อ');
                    }
                }).fail(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'ไม่สามารถยกเลิกการเชื่อมต่อได้'
                    });
                    $('#disconnectLine').removeAttr('disabled');
                    $('#disconnectLine').html('<i class="fas fa-times"></i> ยกเลิกการเชื่อมต่อ');
                });
            }
        });
    });
});
</script>
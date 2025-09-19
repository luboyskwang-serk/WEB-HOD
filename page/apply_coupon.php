<?php
require_once '../system/a_func.php';
require_once '../system/coupon.php';

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
    .coupon-section {
        background: linear-gradient(145deg, #1a1a1a, #0d0d0d);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .coupon-input-group {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .coupon-input {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        background: rgba(30, 30, 30, 0.8);
        color: #f0f0f0;
        font-family: 'Courier New', monospace;
        font-size: 1.1rem;
    }
    
    .coupon-input:focus {
        outline: none;
        border-color: #ff6b35;
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
    }
    
    .coupon-applied {
        background: rgba(42, 157, 143, 0.1);
        border: 1px solid rgba(42, 157, 143, 0.3);
        border-radius: 12px;
        padding: 15px;
        margin-top: 15px;
    }
    
    .discount-badge-large {
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .badge-percentage-large {
        background: rgba(42, 157, 143, 0.2);
        color: #2a9d8f;
    }
    
    .badge-fixed-large {
        background: rgba(233, 196, 106, 0.2);
        color: #e9c46a;
    }
</style>

<div class="container-fluid p-0 mt-4">
    <div class="container-sm m-cent ps-4 pe-4">
        <div class="container-fluid p-4 shadow-sm coupon-section">
            <div class="col-lg-8 m-cent">
                <div class="text-center mb-4">
                    <h1 class="gradient-text" style="font-size: 28px; font-weight: 700;">ใช้งานคูปองส่วนลด</h1>
                    <p class="text-muted">ใส่รหัสคูปองเพื่อรับส่วนลดในการสั่งซื้อ</p>
                </div>
                
                <div class="coupon-input-group">
                    <input type="text" class="coupon-input" id="couponCode" placeholder="ใส่รหัสคูปองของคุณที่นี่">
                    <button class="btn btn-primary-modern" id="applyCouponBtn">
                        <i class="fas fa-tag"></i> ใช้งาน
                    </button>
                </div>
                
                <div id="couponResult"></div>
                
                <div class="mt-4">
                    <h5><i class="fas fa-info-circle"></i> วิธีใช้งานคูปอง</h5>
                    <ul class="text-muted">
                        <li>ใส่รหัสคูปองในช่องด้านบนแล้วคลิก "ใช้งาน"</li>
                        <li>ตรวจสอบเงื่อนไขการใช้งานของคูปองแต่ละใบ</li>
                        <li>คูปองสามารถใช้งานได้ครั้งเดียวเท่านั้น</li>
                        <li>คูปองมีอายุการใช้งานตามที่ระบุ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // ใช้งานคูปอง
    $('#applyCouponBtn').click(function() {
        var code = $('#couponCode').val().trim();
        
        if (!code) {
            Swal.fire('ผิดพลาด', 'กรุณาใส่รหัสคูปอง', 'error');
            return;
        }
        
        $.ajax({
            url: 'system/apply_coupon.php',
            type: 'POST',
            data: {code: code},
            beforeSend: function() {
                $('#applyCouponBtn').attr('disabled', 'disabled');
                $('#applyCouponBtn').html('<i class="fas fa-spinner fa-spin"></i> กำลังตรวจสอบ...');
            }
        }).done(function(res) {
            if (res.status === 'success') {
                // แสดงผลคูปองที่ใช้งาน
                var coupon = res.coupon;
                var discountText = '';
                var discountClass = '';
                
                if (coupon.discount_type === 'percentage') {
                    discountText = coupon.discount_value + '%';
                    discountClass = 'badge-percentage-large';
                } else {
                    discountText = Number(coupon.discount_value).toLocaleString() + ' บาท';
                    discountClass = 'badge-fixed-large';
                }
                
                var html = `
                    <div class="coupon-applied">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5><i class="fas fa-check-circle text-success"></i> ใช้งานคูปองสำเร็จ</h5>
                                <p class="mb-1">รหัสคูปอง: <strong>${coupon.code}</strong></p>
                                <p class="mb-0 text-muted">ส่วนลด: ${coupon.minimum_amount > 0 ? 'ขั้นต่ำ ' + Number(coupon.minimum_amount).toLocaleString() + ' บาท, ' : ''} ${discountText}</p>
                            </div>
                            <div>
                                <span class="discount-badge-large ${discountClass}">${discountText}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                หมดอายุ: ${new Date(coupon.expiry_date).toLocaleDateString('th-TH')}
                                ${coupon.usage_limit > 0 ? ' | ใช้งานได้อีก ' + (coupon.usage_limit - coupon.used_count) + ' ครั้ง' : ''}
                            </small>
                        </div>
                    </div>
                `;
                
                $('#couponResult').html(html);
                
                // เก็บคูปองใน sessionStorage
                sessionStorage.setItem('appliedCoupon', JSON.stringify(coupon));
                
                Swal.fire('สำเร็จ', res.message, 'success');
            } else {
                $('#couponResult').html('');
                Swal.fire('ผิดพลาด', res.message, 'error');
            }
            
            $('#applyCouponBtn').removeAttr('disabled');
            $('#applyCouponBtn').html('<i class="fas fa-tag"></i> ใช้งาน');
        }).fail(function() {
            Swal.fire('ผิดพลาด', 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้', 'error');
            $('#applyCouponBtn').removeAttr('disabled');
            $('#applyCouponBtn').html('<i class="fas fa-tag"></i> ใช้งาน');
        });
    });
    
    // ตรวจสอบว่ามีคูปองที่ใช้งานอยู่หรือไม่
    var appliedCoupon = sessionStorage.getItem('appliedCoupon');
    if (appliedCoupon) {
        var coupon = JSON.parse(appliedCoupon);
        var now = new Date();
        var expiry = new Date(coupon.expiry_date);
        
        if (expiry > now) {
            // แสดงคูปองที่ใช้งานอยู่
            var discountText = '';
            var discountClass = '';
            
            if (coupon.discount_type === 'percentage') {
                discountText = coupon.discount_value + '%';
                discountClass = 'badge-percentage-large';
            } else {
                discountText = Number(coupon.discount_value).toLocaleString() + ' บาท';
                discountClass = 'badge-fixed-large';
            }
            
            var html = `
                <div class="coupon-applied">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5><i class="fas fa-check-circle text-success"></i> ใช้งานคูปองแล้ว</h5>
                            <p class="mb-1">รหัสคูปอง: <strong>${coupon.code}</strong></p>
                        </div>
                        <div>
                            <span class="discount-badge-large ${discountClass}">${discountText}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-danger" id="removeCouponBtn">
                            <i class="fas fa-times"></i> ลบคูปอง
                        </button>
                    </div>
                </div>
            `;
            
            $('#couponResult').html(html);
        } else {
            // คูปองหมดอายุแล้ว
            sessionStorage.removeItem('appliedCoupon');
        }
    }
    
    // ลบคูปองที่ใช้งานอยู่
    $(document).on('click', '#removeCouponBtn', function() {
        sessionStorage.removeItem('appliedCoupon');
        $('#couponResult').html('');
        $('#couponCode').val('');
        Swal.fire('สำเร็จ', 'ลบคูปองเรียบร้อยแล้ว', 'success');
    });
});
</script>
<?php
require_once 'system/a_func.php';
require_once 'system/coupon.php';

// ตรวจสอบการ login และสิทธิ์ admin
if (!isset($_SESSION['id'])) {
    header('Location: ?page=login');
    exit;
}

$q1 = dd_q("SELECT * FROM users WHERE id = ? LIMIT 1", [$_SESSION['id']]);
$user = $q1->fetch(PDO::FETCH_ASSOC);

if ($user['rank'] != 1) {
    header('Location: ?page=home');
    exit;
}

// ดึงรายการคูปองทั้งหมด
$coupons = CouponManager::getAllCoupons(100);
?>

<style>
    .coupon-card {
        background: linear-gradient(145deg, #1a1a1a, #0d0d0d);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .coupon-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .coupon-code {
        font-family: 'Courier New', monospace;
        font-size: 1.2rem;
        font-weight: bold;
        background: rgba(255, 107, 53, 0.1);
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px dashed #ff6b35;
    }
    
    .discount-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .badge-percentage {
        background: rgba(42, 157, 143, 0.2);
        color: #2a9d8f;
    }
    
    .badge-fixed {
        background: rgba(233, 196, 106, 0.2);
        color: #e9c46a;
    }
    
    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .status-active {
        background: rgba(42, 157, 143, 0.2);
        color: #2a9d8f;
    }
    
    .status-inactive {
        background: rgba(231, 111, 81, 0.2);
        color: #e76f51;
    }
    
    .status-expired {
        background: rgba(108, 117, 125, 0.2);
        color: #6c757d;
    }
    
    .table-coupons {
        background: rgba(30, 30, 30, 0.5);
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .table-coupons thead th {
        background: rgba(40, 40, 40, 0.8);
        border: none;
        font-weight: 600;
        padding: 15px;
    }
    
    .table-coupons tbody td {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding: 15px;
    }
    
    .action-btn {
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
        margin: 2px;
    }
    
    .btn-success-light {
        background: rgba(42, 157, 143, 0.2);
        color: #2a9d8f;
        border: 1px solid rgba(42, 157, 143, 0.3);
    }
    
    .btn-warning-light {
        background: rgba(233, 196, 106, 0.2);
        color: #e9c46a;
        border: 1px solid rgba(233, 196, 106, 0.3);
    }
    
    .btn-danger-light {
        background: rgba(231, 111, 81, 0.2);
        color: #e76f51;
        border: 1px solid rgba(231, 111, 81, 0.3);
    }
</style>

<div class="container-fluid p-0 mt-4">
    <div class="container-sm m-cent ps-4 pe-4">
        <div class="container-fluid p-4 shadow-sm" style="background: linear-gradient(145deg, #1a1a1a, #0d0d0d); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="col-lg-12 m-cent">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="gradient-text" style="font-size: 28px; font-weight: 700;">จัดการคูปอง</h1>
                        <p class="text-muted">สร้างและจัดการคูปองส่วนลดสำหรับลูกค้า</p>
                    </div>
                    <div>
                        <button class="btn btn-primary-modern" data-bs-toggle="modal" data-bs-target="#createCouponModal">
                            <i class="fas fa-plus"></i> สร้างคูปองใหม่
                        </button>
                    </div>
                </div>
                
                <!-- สรุปคูปอง -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="coupon-card text-center">
                            <h3><?php echo count($coupons); ?></h3>
                            <p class="text-muted">จำนวนคูปองทั้งหมด</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="coupon-card text-center">
                            <?php
                            $activeCoupons = 0;
                            foreach ($coupons as $coupon) {
                                if ($coupon['status'] === 'active' && strtotime($coupon['expiry_date']) > time()) {
                                    $activeCoupons++;
                                }
                            }
                            ?>
                            <h3><?php echo $activeCoupons; ?></h3>
                            <p class="text-muted">คูปองที่ใช้งานอยู่</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="coupon-card text-center">
                            <?php
                            $usedCount = 0;
                            foreach ($coupons as $coupon) {
                                $usedCount += $coupon['used_count'];
                            }
                            ?>
                            <h3><?php echo $usedCount; ?></h3>
                            <p class="text-muted">จำนวนการใช้งานทั้งหมด</p>
                        </div>
                    </div>
                </div>
                
                <!-- ตารางคูปอง -->
                <div class="coupon-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><i class="fas fa-tags"></i> รายการคูปอง</h4>
                        <div class="d-flex">
                            <input type="text" class="search-box me-2" placeholder="ค้นหาคูปอง..." id="searchCoupon">
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table-coupons table table-hover">
                            <thead>
                                <tr>
                                    <th>รหัสคูปอง</th>
                                    <th>ประเภทส่วนลด</th>
                                    <th>มูลค่าส่วนลด</th>
                                    <th>จำนวนเงินขั้นต่ำ</th>
                                    <th>วันหมดอายุ</th>
                                    <th>การใช้งาน</th>
                                    <th>สถานะ</th>
                                    <th>การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($coupons as $coupon): ?>
                                <tr>
                                    <td>
                                        <div class="coupon-code"><?php echo htmlspecialchars($coupon['code']); ?></div>
                                    </td>
                                    <td>
                                        <span class="discount-badge <?php echo ($coupon['discount_type'] === 'percentage') ? 'badge-percentage' : 'badge-fixed'; ?>">
                                            <?php echo ($coupon['discount_type'] === 'percentage') ? 'เปอร์เซ็นต์' : 'จำนวนคงที่'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($coupon['discount_type'] === 'percentage'): ?>
                                            <?php echo $coupon['discount_value']; ?>%
                                        <?php else: ?>
                                            <?php echo number_format($coupon['discount_value']); ?> บาท
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo ($coupon['minimum_amount'] > 0) ? number_format($coupon['minimum_amount']) . ' บาท' : '-'; ?></td>
                                    <td>
                                        <?php echo date('d/m/Y', strtotime($coupon['expiry_date'])); ?>
                                        <?php if (strtotime($coupon['expiry_date']) < time()): ?>
                                            <br><small class="text-danger">หมดอายุแล้ว</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo $coupon['used_count']; ?> / 
                                        <?php echo ($coupon['usage_limit'] > 0) ? $coupon['usage_limit'] : 'ไม่จำกัด'; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php 
                                            if ($coupon['status'] === 'active' && strtotime($coupon['expiry_date']) > time()) {
                                                echo 'status-active';
                                            } elseif ($coupon['status'] === 'inactive') {
                                                echo 'status-inactive';
                                            } else {
                                                echo 'status-expired';
                                            }
                                        ?>">
                                            <?php 
                                            if ($coupon['status'] === 'active' && strtotime($coupon['expiry_date']) > time()) {
                                                echo 'ใช้งาน';
                                            } elseif ($coupon['status'] === 'inactive') {
                                                echo 'ปิดใช้งาน';
                                            } else {
                                                echo 'หมดอายุ';
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm action-btn btn-warning-light" onclick="editCoupon(<?php echo $coupon['id']; ?>)">
                                            <i class="fas fa-edit"></i> แก้ไข
                                        </button>
                                        <button class="btn btn-sm action-btn btn-danger-light" onclick="deleteCoupon(<?php echo $coupon['id']; ?>)">
                                            <i class="fas fa-trash"></i> ลบ
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal สร้างคูปองใหม่ -->
<div class="modal fade" id="createCouponModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-modern">
            <div class="modal-header">
                <h5 class="modal-title">สร้างคูปองใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createCouponForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">รหัสคูปอง *</label>
                                <input type="text" class="form-control-modern" id="couponCode" placeholder="ใส่รหัสคูปอง" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">ประเภทส่วนลด *</label>
                                <select class="form-control-modern" id="discountType" required>
                                    <option value="percentage">เปอร์เซ็นต์</option>
                                    <option value="fixed">จำนวนเงินคงที่</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">มูลค่าส่วนลด *</label>
                                <input type="number" class="form-control-modern" id="discountValue" placeholder="ใส่มูลค่าส่วนลด" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">จำนวนเงินขั้นต่ำ</label>
                                <input type="number" class="form-control-modern" id="minimumAmount" placeholder="ใส่จำนวนเงินขั้นต่ำ (ไม่บังคับ)" step="0.01">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">วันหมดอายุ *</label>
                                <input type="date" class="form-control-modern" id="expiryDate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">จำนวนการใช้งานสูงสุด</label>
                                <input type="number" class="form-control-modern" id="usageLimit" placeholder="ใส่จำนวนการใช้งานสูงสุด (0 = ไม่จำกัด)">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">สถานะ</label>
                        <select class="form-control-modern" id="couponStatus">
                            <option value="active">ใช้งาน</option>
                            <option value="inactive">ปิดใช้งาน</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary-modern" id="createCouponBtn">
                    <i class="fas fa-plus"></i> สร้างคูปอง
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // ตั้งค่าวันที่เริ่มต้นสำหรับวันหมดอายุ
    var today = new Date();
    var nextMonth = new Date();
    nextMonth.setMonth(today.getMonth() + 1);
    var dateString = nextMonth.toISOString().split('T')[0];
    $('#expiryDate').val(dateString);
    
    // สร้างคูปองใหม่
    $('#createCouponBtn').click(function() {
        var data = {
            code: $('#couponCode').val(),
            discount_type: $('#discountType').val(),
            discount_value: $('#discountValue').val(),
            minimum_amount: $('#minimumAmount').val(),
            expiry_date: $('#expiryDate').val(),
            usage_limit: $('#usageLimit').val(),
            status: $('#couponStatus').val()
        };
        
        // ตรวจสอบข้อมูล
        if (!data.code || !data.discount_type || !data.discount_value || !data.expiry_date) {
            Swal.fire('ผิดพลาด', 'กรุณากรอกข้อมูลให้ครบ', 'error');
            return;
        }
        
        $.ajax({
            url: 'system/create_coupon.php',
            type: 'POST',
            data: data,
            beforeSend: function() {
                $('#createCouponBtn').attr('disabled', 'disabled');
                $('#createCouponBtn').html('<i class="fas fa-spinner fa-spin"></i> กำลังสร้าง...');
            }
        }).done(function(res) {
            if (res.status === 'success') {
                Swal.fire('สำเร็จ', res.message, 'success').then(function() {
                    location.reload();
                });
            } else {
                Swal.fire('ผิดพลาด', res.message, 'error');
            }
            $('#createCouponBtn').removeAttr('disabled');
            $('#createCouponBtn').html('<i class="fas fa-plus"></i> สร้างคูปอง');
        });
    });
    
    // ค้นหาคูปอง
    $('#searchCoupon').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.table-coupons tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

// ฟังก์ชันแก้ไขคูปอง
function editCoupon(couponId) {
    Swal.fire({
        title: 'ฟีเจอร์นี้อยู่ในระหว่างการพัฒนา',
        text: 'ระบบแก้ไขคูปองจะถูกเพิ่มในเวอร์ชันถัดไป',
        icon: 'info'
    });
}

// ฟังก์ชันลบคูปอง
function deleteCoupon(couponId) {
    Swal.fire({
        title: 'ยืนยันการลบคูปอง',
        text: "คุณแน่ใจหรือไม่ที่ต้องการลบคูปองนี้? การกระทำนี้ไม่สามารถย้อนกลับได้",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'system/delete_coupon.php',
                type: 'POST',
                data: {id: couponId},
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังลบ...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            }).done(function(res) {
                if (res.status === 'success') {
                    Swal.fire('สำเร็จ', res.message, 'success').then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
            });
        }
    });
}
</script>
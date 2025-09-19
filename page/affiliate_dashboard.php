<?php
require_once '../system/a_func.php';
require_once '../system/affiliate.php';

// ตรวจสอบการ login
if (!isset($_SESSION['id'])) {
    header('Location: ?page=login');
    exit;
}

// ดึงข้อมูลผู้ใช้
$q1 = dd_q("SELECT * FROM users WHERE id = ? LIMIT 1", [$_SESSION['id']]);
$user = $q1->fetch(PDO::FETCH_ASSOC);

// ดึงข้อมูล Affiliate
$affiliateData = AffiliateManager::getUserAffiliateData($_SESSION['id']);

// ถ้ายังไม่มี Affiliate record ให้สร้างใหม่
if (!$affiliateData) {
    $referralCode = AffiliateManager::generateReferralCode($_SESSION['id']);
    $affiliateData = AffiliateManager::getUserAffiliateData($_SESSION['id']);
}

// ดึงสถิติ
$stats = AffiliateManager::getAffiliateStats($_SESSION['id']);

// ดึงรายการ Referral ล่าสุด
$recentReferrals = AffiliateManager::getUserReferrals($_SESSION['id'], 10);

// สร้างลิงก์ Referral
$referralLink = AffiliateManager::generateReferralLink($_SESSION['id']);
?>

<style>
    .affiliate-card {
        background: linear-gradient(145deg, #1a1a1a, #0d0d0d);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .affiliate-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .stat-card {
        text-align: center;
        padding: 20px;
        border-radius: 12px;
        background: rgba(30, 30, 30, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin: 10px 0;
    }
    
    .stat-label {
        color: #aaa;
        font-size: 0.9rem;
    }
    
    .referral-link-box {
        background: rgba(30, 30, 30, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 15px;
        margin: 20px 0;
        position: relative;
    }
    
    .referral-link {
        font-family: 'Courier New', monospace;
        background: rgba(0, 0, 0, 0.3);
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px dashed #ff6b35;
        word-break: break-all;
        color: #f0f0f0;
    }
    
    .copy-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 107, 53, 0.2);
        color: #ff6b35;
        border: 1px solid rgba(255, 107, 53, 0.3);
        border-radius: 8px;
        padding: 8px 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .copy-btn:hover {
        background: rgba(255, 107, 53, 0.3);
        color: #ff8c52;
    }
    
    .table-referrals {
        background: rgba(30, 30, 30, 0.5);
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .table-referrals thead th {
        background: rgba(40, 40, 40, 0.8);
        border: none;
        font-weight: 600;
        padding: 15px;
    }
    
    .table-referrals tbody td {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding: 15px;
    }
    
    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .status-pending {
        background: rgba(233, 196, 106, 0.2);
        color: #e9c46a;
    }
    
    .status-confirmed {
        background: rgba(42, 157, 143, 0.2);
        color: #2a9d8f;
    }
    
    .status-rejected {
        background: rgba(231, 111, 81, 0.2);
        color: #e76f51;
    }
    
    .commission-amount {
        font-weight: 600;
        color: #2a9d8f;
    }
</style>

<div class="container-fluid p-0 mt-4">
    <div class="container-sm m-cent ps-4 pe-4">
        <div class="container-fluid p-4 shadow-sm" style="background: linear-gradient(145deg, #1a1a1a, #0d0d0d); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="col-lg-12 m-cent">
                <div class="text-center mb-4">
                    <h1 class="gradient-text" style="font-size: 28px; font-weight: 700;">ระบบพันธมิตร (Affiliate)</h1>
                    <p class="text-muted">เชิญเพื่อนมาใช้งานและรับค่าคอมมิชชั่น</p>
                </div>
                
                <!-- สรุป -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fas fa-users fa-2x" style="color: #ff6b35;"></i>
                            <div class="stat-number"><?php echo $stats['total_referrals']; ?></div>
                            <div class="stat-label">รวม Referrals</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fas fa-user-check fa-2x" style="color: #2a9d8f;"></i>
                            <div class="stat-number"><?php echo $stats['confirmed_referrals']; ?></div>
                            <div class="stat-label">ยืนยันแล้ว</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fas fa-wallet fa-2x" style="color: #e9c46a;"></i>
                            <div class="stat-number"><?php echo number_format($stats['total_commission']); ?></div>
                            <div class="stat-label">ค่าคอมมิชชั่น (บาท)</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fas fa-coins fa-2x" style="color: #ffbb00;"></i>
                            <div class="stat-number"><?php echo number_format($user['point']); ?></div>
                            <div class="stat-label">ยอดเงินคงเหลือ</div>
                        </div>
                    </div>
                </div>
                
                <!-- ลิงก์ Referral -->
                <div class="affiliate-card">
                    <h4><i class="fas fa-link"></i> ลิงก์แนะนำของคุณ</h4>
                    <p class="text-muted">แชร์ลิงก์นี้กับเพื่อนเพื่อรับค่าคอมมิชชั่น</p>
                    
                    <div class="referral-link-box">
                        <div class="referral-link" id="referralLink"><?php echo htmlspecialchars($referralLink); ?></div>
                        <button class="copy-btn" id="copyReferralLink">
                            <i class="fas fa-copy"></i> คัดลอก
                        </button>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <div class="btn-group">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($referralLink); ?>" target="_blank" class="btn btn-outline-primary">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($referralLink); ?>&text=มาใช้บริการที่นี่ดีมาก!" target="_blank" class="btn btn-outline-info">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://line.me/R/msg/text/?มาใช้บริการที่นี่ดีมาก! <?php echo urlencode($referralLink); ?>" target="_blank" class="btn btn-outline-success">
                                <i class="fab fa-line"></i> Line
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- ตาราง Referral ล่าสุด -->
                <div class="affiliate-card">
                    <h4><i class="fas fa-history"></i> Referral ล่าสุด</h4>
                    <p class="text-muted">ประวัติการแนะนำเพื่อนของคุณ</p>
                    
                    <?php if (empty($recentReferrals)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-user-friends fa-3x text-muted"></i>
                            <p class="mt-3">ยังไม่มีผู้ใช้ที่ถูกแนะนำ แชร์ลิงก์ของคุณเพื่อรับค่าคอมมิชชั่น</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table-referrals table table-hover">
                                <thead>
                                    <tr>
                                        <th>ผู้ใช้</th>
                                        <th>วันที่ลงทะเบียน</th>
                                        <th>สถานะ</th>
                                        <th>ค่าคอมมิชชั่น</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentReferrals as $referral): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $referral['profile'] ?: '/dz/user.png'; ?>" alt="Profile" width="40" class="rounded-circle me-3">
                                                <div>
                                                    <strong><?php echo htmlspecialchars($referral['username']); ?></strong>
                                                    <br><small class="text-muted">ID: <?php echo $referral['referred_user_id']; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y H:i', strtotime($referral['join_date'])); ?>
                                            <br><small class="text-muted"><?php echo date('H:i', strtotime($referral['created_at'])); ?></small>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo 'status-' . $referral['status']; ?>">
                                                <?php 
                                                switch ($referral['status']) {
                                                    case 'pending': echo 'รอการยืนยัน'; break;
                                                    case 'confirmed': echo 'ยืนยันแล้ว'; break;
                                                    case 'rejected': echo 'ถูกปฏิเสธ'; break;
                                                    default: echo $referral['status'];
                                                }
                                                ?>
                                            </span>
                                        </td>
                                        <td class="commission-amount">
                                            <?php if ($referral['status'] === 'confirmed' && $referral['commission_amount'] > 0): ?>
                                                <?php echo number_format($referral['commission_amount']); ?> บาท
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- คำอธิบายระบบ -->
                <div class="affiliate-card">
                    <h4><i class="fas fa-info-circle"></i> วิธีการทำงานของระบบพันธมิตร</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>วิธีรับค่าคอมมิชชั่น</h5>
                            <ol>
                                <li>แชร์ลิงก์แนะนำของคุณกับเพื่อน</li>
                                <li>เพื่อนของคุณคลิกลิงก์และลงทะเบียน</li>
                                <li>เพื่อนของคุณเติมเงินเข้าระบบครั้งแรก</li>
                                <li>คุณจะได้รับค่าคอมมิชชั่น <?php echo $config['affiliate_commission_rate'] ?? 10; ?>% จากยอดเติมเงิน</li>
                                <li>ค่าคอมมิชชั่นจะถูกเพิ่มเข้าสู่บัญชีของคุณทันที</li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h5>ข้อกำหนดและเงื่อนไข</h5>
                            <ul>
                                <li>ค่าคอมมิชชั่นคือ <?php echo $config['affiliate_commission_rate'] ?? 10; ?>% ของยอดเติมเงิน</li>
                                <li>ไม่มีขีดจำกัดของรายได้ที่จะได้รับ</li>
                                <li>สามารถถอนเงินได้เมื่อยอดเงินถึง 100 บาท</li>
                                <li>ระบบตรวจสอบการฉ้อโกงอย่างเข้มงวด</li>
                                <li>ผู้ดูแลระบบมีสิทธิ์ระงับบัญชีได้หากพบความผิดปกติ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // คัดลอกลิงก์ Referral
    $('#copyReferralLink').click(function() {
        var referralLink = $('#referralLink').text();
        
        // คัดลอกไปยังคลิปบอร์ด
        navigator.clipboard.writeText(referralLink).then(function() {
            // เปลี่ยนข้อความปุ่มชั่วคราว
            var originalText = $('#copyReferralLink').html();
            $('#copyReferralLink').html('<i class="fas fa-check"></i> คัดลอกแล้ว');
            
            // แสดงแจ้งเตือน
            Swal.fire({
                icon: 'success',
                title: 'คัดลอกแล้ว',
                text: 'ลิงก์แนะนำของคุณถูกคัดลอกไปยังคลิปบอร์ดแล้ว',
                timer: 1500,
                showConfirmButton: false
            });
            
            // กลับคืนข้อความเดิมหลัง 2 วินาที
            setTimeout(function() {
                $('#copyReferralLink').html(originalText);
            }, 2000);
        }).catch(function(err) {
            // ถ้าคัดลอกไม่สำเร็จ ให้ใช้วิธี fallback
            var tempInput = $('<input>');
            $('body').append(tempInput);
            tempInput.val(referralLink).select();
            document.execCommand('copy');
            tempInput.remove();
            
            Swal.fire({
                icon: 'success',
                title: 'คัดลอกแล้ว',
                text: 'ลิงก์แนะนำของคุณถูกคัดลอกไปยังคลิปบอร์ดแล้ว',
                timer: 1500,
                showConfirmButton: false
            });
        });
    });
});
</script>
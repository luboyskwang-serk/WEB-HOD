<?php
require_once 'a_func.php';
require_once 'affiliate.php';

// ฟังก์ชันสำหรับประมวลผล Referral
function processReferral() {
    // ตรวจสอบว่ามี ref parameter ใน URL หรือไม่
    if (isset($_GET['ref'])) {
        $referralCode = $_GET['ref'];
        
        // บันทึก Referral code ใน session
        $_SESSION['referral_code'] = $referralCode;
    }
    
    // ตรวจสอบว่าผู้ใช้ลงทะเบียนสำเร็จและมี Referral code ใน session หรือไม่
    if (isset($_SESSION['id']) && isset($_SESSION['referral_code'])) {
        // ลงทะเบียน Referral
        $result = AffiliateManager::registerReferral($_SESSION['referral_code'], $_SESSION['id']);
        
        // ลบ Referral code ออกจาก session
        unset($_SESSION['referral_code']);
        
        return $result;
    }
    
    return null;
}

// เรียกใช้ฟังก์ชันเมื่อโหลดหน้านี้
$result = processReferral();

// ถ้าต้องการ redirect หลังจากประมวลผล Referral
if (isset($_GET['redirect'])) {
    header('Location: ' . $_GET['redirect']);
    exit;
}
?>
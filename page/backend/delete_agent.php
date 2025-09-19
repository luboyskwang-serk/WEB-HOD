<?php
include '../../system/a_func.php';

if (!isset($_SESSION['id']) || $user['rank'] != 1) {
    die("คุณไม่มีสิทธิ์ลบข้อมูล");
}

if (!isset($_GET['id'])) {
    die("ไม่พบข้อมูลที่ต้องการลบ");
}

$id = $_GET['id'];

// ลบรูปภาพเก่า (ถ้ามี)
$agent = dd_q("SELECT image FROM agents WHERE id = ?", [$id])->fetch(PDO::FETCH_ASSOC);
if ($agent && $agent['image']) {
    $image_path = "../../assets/uploads/" . $agent['image'];
    if (file_exists($image_path)) {
        unlink($image_path); // ลบไฟล์รูปออกจากระบบ
    }
}

// ลบข้อมูลตัวแทนจากฐานข้อมูล
$del = dd_q("DELETE FROM agents WHERE id = ?", [$id]);

header("Location: list_agents.php");
exit;
?>

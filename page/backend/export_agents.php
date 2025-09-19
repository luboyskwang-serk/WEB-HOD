<?php
include '../../system/a_func.php';

if (!isset($_SESSION['id']) || $user['rank'] != 1) {
    die("คุณไม่มีสิทธิ์เข้าถึงข้อมูล");
}

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=agents_export.csv");

$output = fopen("php://output", "w");
fputcsv($output, ["รหัสตัวแทน", "ชื่อเต็ม", "ชื่อผู้ใช้", "วันที่เริ่ม", "วันที่หมดอายุ", "สถานะ"]);

$sql = "SELECT a.*, u.username 
        FROM agents a 
        JOIN users u ON a.user_id = u.id 
        ORDER BY a.created_at DESC";
$result = dd_q($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [
        $row['agent_code'],
        $row['full_name'],
        $row['username'],
        $row['start_date'],
        $row['end_date'],
        $row['status']
    ]);
}

fclose($output);
exit;
?>

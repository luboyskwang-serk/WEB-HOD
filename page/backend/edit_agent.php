<?php
include '../../system/a_func.php';
if (!isset($_SESSION['id']) || $user['rank'] != 1) {
    die("คุณไม่มีสิทธิ์เข้าถึงหน้านี้");
}

if (!isset($_GET['id'])) {
    die("ไม่พบข้อมูลที่ต้องการแก้ไข");
}
$id = $_GET['id'];

$data = dd_q("SELECT * FROM agents WHERE id = ?", [$id])->fetch(PDO::FETCH_ASSOC);
$users = dd_q("SELECT id, username FROM users ORDER BY username ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $agent_code = $_POST['agent_code'];
    $full_name = $_POST['full_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];
    $image_name = $data['image'];

    if ($_FILES['image']['name']) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = 'agent_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../../assets/uploads/" . $image_name);
    }

    $update = dd_q("UPDATE agents SET user_id=?, agent_code=?, full_name=?, image=?, start_date=?, end_date=?, status=?, notes=? WHERE id=?",
        [$user_id, $agent_code, $full_name, $image_name, $start_date, $end_date, $status, $notes, $id]);

    if ($update) {
        header("Location: list_agents.php");
        exit;
    } else {
        echo "<p style='color:red;'>เกิดข้อผิดพลาดในการแก้ไขข้อมูล</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลตัวแทน</title>
</head>
<body>
<h2>แก้ไขข้อมูลตัวแทน</h2>
<form method="post" enctype="multipart/form-data">
    <label for="user_id">ผู้ใช้:</label>
    <select name="user_id" required>
        <?php while($u = $users->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?= $u['id'] ?>" <?= $data['user_id']==$u['id'] ? 'selected' : '' ?>><?= htmlspecialchars($u['username']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <label for="agent_code">รหัสตัวแทน:</label>
    <input type="text" name="agent_code" value="<?= $data['agent_code'] ?>" required><br><br>

    <label for="full_name">ชื่อเต็ม:</label>
    <input type="text" name="full_name" value="<?= $data['full_name'] ?>" required><br><br>

    <label for="start_date">วันที่เริ่ม:</label>
    <input type="date" name="start_date" value="<?= $data['start_date'] ?>" required><br><br>

    <label for="end_date">วันที่หมดอายุ:</label>
    <input type="date" name="end_date" value="<?= $data['end_date'] ?>" required><br><br>

    <label for="status">สถานะ:</label>
    <select name="status">
        <option value="Active" <?= $data['status']=='Active'?'selected':'' ?>>Active</option>
        <option value="Inactive" <?= $data['status']=='Inactive'?'selected':'' ?>>Inactive</option>
    </select><br><br>

    <label for="notes">หมายเหตุ:</label><br>
    <textarea name="notes" rows="4" cols="50"><?= $data['notes'] ?></textarea><br><br>

    <label for="image">รูปภาพเดิม:</label><br>
    <img src="../../assets/uploads/<?= $data['image'] ?>" width="60"><br><br>

    <label for="image">เปลี่ยนรูป:</label>
    <input type="file" name="image" accept="image/*"><br><br>

    <button type="submit">บันทึกการแก้ไข</button>
</form>
</body>
</html>

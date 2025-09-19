<?php
include '../../system/a_func.php';

if (!isset($_SESSION['id']) || $user['rank'] != 1) {
    die("คุณไม่มีสิทธิ์เข้าถึงหน้านี้");
}

$users = dd_q("SELECT id, username FROM users WHERE username LIKE ? ORDER BY username ASC", ['%' . (isset($_GET['search_user']) ? $_GET['search_user'] : '') . '%']);

function generate_agent_code() {
    $prefix = "AGT-" . date("Ymd") . "-";
    $suffix = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ123456789"), 0, 4);
    return $prefix . $suffix;
}
$default_agent_code = generate_agent_code();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $agent_code = $_POST['agent_code'];
    $full_name = $_POST['full_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];

    $image_name = null;
    if ($_FILES['image']['name']) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = 'agent_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], "../../assets/uploads/" . $image_name);
    }

    $insert = dd_q("INSERT INTO agents (user_id, agent_code, full_name, image, start_date, end_date, status, notes)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        [$user_id, $agent_code, $full_name, $image_name, $start_date, $end_date, $status, $notes]);

    if ($insert) {
        header("Location: list_agents.php");
        exit;
    } else {
        echo "<p style='color:red;'>เกิดข้อผิดพลาดในการเพิ่มข้อมูล</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เพิ่มตัวแทน</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      font-family: 'Arial', sans-serif;
    }

    .container-custom {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      margin: auto;
    }

    .form-label {
      font-weight: bold;
    }

    .preview-image {
      max-width: 200px;
      max-height: 200px;
      margin-top: 10px;
      object-fit: cover;
      border-radius: 8px;
    }

    .input-group {
      margin-bottom: 1rem;
    }

    .btn-primary {
      width: 100%;
    }

    .btn-secondary {
      width: 100%;
      margin-top: 10px;
    }

    .mb-3 {
      margin-bottom: 1.5rem;
    }

    .form-control {
      font-size: 14px;
    }

    /* ปรับให้แสดงผลที่เหมาะสม */
    @media (max-width: 768px) {
      .container-custom {
        width: 100%;
        padding: 15px;
      }
    }
  </style>
</head>
<body>

<div class="container-custom">
  <h3 class="text-center mb-4">เพิ่มตัวแทนใหม่</h3>

  <!-- ฟอร์มการค้นหาผู้ใช้ -->
  <form method="get" class="mb-3">
    <div class="input-group">
      <input type="text" class="form-control" name="search_user" id="search_user" placeholder="ค้นหาชื่อผู้ใช้" value="<?= isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : '' ?>">
      <button type="submit" class="btn btn-primary">ค้นหา</button>
    </div>
  </form>

  <!-- ฟอร์มการเพิ่มตัวแทน -->
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="user_id" class="form-label">ผู้ใช้:</label>
      <select name="user_id" id="user_id" class="form-select" required>
        <?php while($u = $users->fetch(PDO::FETCH_ASSOC)): ?>
          <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['username']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="agent_code" class="form-label">รหัสตัวแทน:</label>
      <input type="text" name="agent_code" id="agent_code" class="form-control" value="<?= $default_agent_code ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="full_name" class="form-label">ชื่อเต็ม:</label>
      <input type="text" name="full_name" id="full_name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="start_date" class="form-label">วันที่เริ่ม:</label>
      <input type="date" name="start_date" id="start_date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="end_date" class="form-label">วันที่หมดอายุ:</label>
      <input type="date" name="end_date" id="end_date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="status" class="form-label">สถานะ:</label>
      <select name="status" id="status" class="form-select">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="notes" class="form-label">หมายเหตุ (เฉพาะ admin):</label>
      <textarea name="notes" id="notes" class="form-control" rows="4"></textarea>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">อัปโหลดรูปภาพ:</label>
      <input type="file" name="image" id="image" class="form-control" accept="image/*">
      <img id="preview-image" class="preview-image" src="#" alt="Preview Image" style="display:none;">
    </div>

    <button type="submit" class="btn btn-primary">บันทึก</button>
    <a href="list_agents.php" class="btn btn-secondary">ยกเลิก</a>
  </form>
</div>

<!-- Script เพื่อแสดงตัวอย่างรูปภาพ -->
<script>
  document.getElementById('image').onchange = function (event) {
    const reader = new FileReader();
    reader.onload = function () {
      const preview = document.getElementById('preview-image');
      preview.src = reader.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
  };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

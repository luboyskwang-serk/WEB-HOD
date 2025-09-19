<?php
include '../../system/a_func.php';

if (!isset($_SESSION['id']) || $user['rank'] != 1) {
    die("คุณไม่มีสิทธิ์เข้าถึงหน้านี้");
}

// ฟังก์ชันส่งออก CSV
if (isset($_GET['export_csv'])) {
    // ดึงข้อมูลทั้งหมดจากฐานข้อมูล
    $sql = "SELECT a.*, u.username FROM agents a 
            JOIN users u ON a.user_id = u.id";
    $result = dd_q($sql);

    // ตั้งค่าให้บราวเซอร์ดาวน์โหลดไฟล์ CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="agents.csv"');

    // เปิดไฟล์เพื่อเขียนข้อมูล
    $output = fopen('php://output', 'w');

    // เขียนหัวตาราง
    fputcsv($output, ['รหัสตัวแทน', 'ชื่อผู้ใช้', 'ชื่อเต็ม', 'เริ่ม', 'หมดอายุ', 'สถานะ']);

    // เขียนข้อมูลตัวแทน
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, [$row['agent_code'], $row['username'], $row['full_name'], $row['start_date'], $row['end_date'], $row['status']]);
    }

    fclose($output);
    exit;
}

// การค้นหาจากรหัสตัวแทนและชื่อ
$search = isset($_GET['search']) ? "%" . trim($_GET['search']) . "%" : "%%";
$status_filter = isset($_GET['status']) && in_array($_GET['status'], ['Active', 'Inactive']) ? $_GET['status'] : '';

$sql = "SELECT a.*, u.username FROM agents a 
        JOIN users u ON a.user_id = u.id 
        WHERE (a.agent_code LIKE ? OR a.full_name LIKE ?)";
$params = [$search, $search];

if ($status_filter) {
    $sql .= " AND a.status = ?";
    $params[] = $status_filter;
}

$sql .= " ORDER BY a.start_date DESC";
$result = dd_q($sql, $params);

// คำนวณจำนวนหน้าทั้งหมด
$total_results = dd_q("SELECT COUNT(*) as count FROM agents a 
                       JOIN users u ON a.user_id = u.id 
                       WHERE (a.agent_code LIKE ? OR a.full_name LIKE ?)" . 
                       ($status_filter ? " AND a.status = ?" : ""), $params)->fetch(PDO::FETCH_ASSOC)['count'];
$results_per_page = 10; // กำหนดจำนวนข้อมูลที่จะแสดงในแต่ละหน้า
$total_pages = ceil($total_results / $results_per_page);
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, min($page, $total_pages));
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ค้นหาตัวแทน</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f1f1f1;
    }

    .container-custom {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }

    .table-responsive {
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 15px;
      text-align: center;
      vertical-align: middle;
      border: 1px solid #ddd;
    }

    th {
      background-color: #007bff;
      color: white;
      font-weight: bold;
    }

    td img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
    }

    .status-active {
      color: green;
    }

    .status-inactive {
      color: red;
    }

    .status-warning {
      color: orange;
    }

    .table-hover tbody tr:hover {
      background-color: #f1f1f1;
      cursor: pointer;
    }

    /* ปรับแต่งการแสดงผลบนมือถือ */
    @media (max-width: 768px) {
      td img {
        width: 50px;
        height: 50px;
      }
    }
  </style>
</head>
<body class="container">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ค้นหาตัวแทน</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">หน้าหลัก</a>
        </li>
        <?php if ($user['rank'] == 1): ?>
          <li class="nav-item">
            <a class="nav-link" href="add_agent.php">เพิ่มตัวแทน</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- ฟอร์มการค้นหา -->
<div class="container-custom">
  <h3 class="text-center mb-4">ค้นหาตัวแทน</h3>

  <form method="get" class="mb-3" id="search-form">
    <div class="input-group">
      <input type="text" class="form-control" name="search" id="search-input" placeholder="ค้นหารหัสหรือชื่อ" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
      <select name="status" class="form-select" id="status-select">
        <option value="">-- สถานะทั้งหมด --</option>
        <option value="Active" <?= $status_filter == 'Active' ? 'selected' : '' ?>>Active</option>
        <option value="Inactive" <?= $status_filter == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
      </select>
      <button type="submit" class="btn btn-primary">ค้นหา</button>
    </div>
  </form>

  <!-- ปุ่มนำเข้า CSV และส่งออก CSV -->
  <?php if ($user['rank'] == 1): ?>
    <div class="d-flex justify-content-between mb-4">
      <form method="post" enctype="multipart/form-data" class="w-50">
        <div class="mb-3">
          <label for="csv_file" class="form-label">นำเข้าไฟล์ CSV:</label>
          <input type="file" class="form-control" name="csv_file" id="csv_file" accept=".csv">
        </div>
        <button type="submit" name="import_csv" class="btn btn-success w-100">นำเข้า CSV</button>
      </form>
      <a href="?export_csv=true" class="btn btn-info w-25 align-self-end">ส่งออก CSV</a>
    </div>
  <?php endif; ?>

</div>

<!-- ตารางแสดงข้อมูลตัวแทน -->
<div class="table-responsive">
  <table class="table table-striped table-hover ">
    <thead>
      <tr>
        <th class="text-dark" class="text-dark" scope="col">รูป</th>
        <th class="text-dark" scope="col">รหัสตัวแทน</th>
        <th class="text-dark" scope="col">ชื่อผู้ใช้</th>
        <th class="text-dark" scope="col">ชื่อเต็ม</th>
        <th class="text-dark" scope="col">เริ่ม</th>
        <th class="text-dark" scope="col">หมดอายุ</th>
        <th class="text-dark" scope="col">วันคงเหลือ</th>
        <th class="text-dark" scope="col">สถานะ</th>
        <?php if ($user['rank'] == 1): ?>
        <th class="text-dark" scope="col">จัดการ</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody id="agents-table-body">
      <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
          <td><img src="../../assets/uploads/<?= $row['image'] ?>" alt="Agent"></td>
          <td><?= htmlspecialchars($row['agent_code']) ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['full_name']) ?></td>
          <td><?= $row['start_date'] ?></td>
          <td><?= $row['end_date'] ?></td>
          <td>
            <?php
            $today = new DateTime();
            $end = new DateTime($row['end_date']);
            $interval = $today->diff($end);
            echo ($today > $end) ? 'หมดอายุแล้ว' : $interval->days . ' วัน';
            ?>
          </td>
          <td class="<?= $status_class ?>"><?= $row['status'] ?></td>
          <?php if ($user['rank'] == 1): ?>
            <td class="text-center">
              <a href="edit_agent.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
              <a href="delete_agent.php?id=<?= $row['id'] ?>" onclick="return confirm('ลบตัวแทนนี้?')" class="btn btn-danger btn-sm">ลบ</a>
            </td>
          <?php endif; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- การแบ่งหน้า -->
<div class="pagination">
  <ul class="pagination justify-content-center">
    <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
      <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&status=<?= htmlspecialchars($status_filter) ?>&page=<?= max(1, $page - 1) ?>" tabindex="-1">ก่อนหน้า</a>
    </li>
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
      <a class="page-link" href="?search=<?= urlencode(isset($_GET['search']) ? $_GET['search'] : '') ?>&status=<?= urlencode($status_filter) ?>&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
    <li class="page-item <?= ($page == $total_pages) ? 'disabled' : '' ?>">
      <a class="page-link" href="?search=<?= htmlspecialchars($search) ?>&status=<?= htmlspecialchars($status_filter) ?>&page=<?= min($total_pages, $page + 1) ?>">ถัดไป</a>
    </li>
  </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

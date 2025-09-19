<?php
include '../system/a_func.php';

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

// Calculate total pages
$total_results = dd_q("SELECT COUNT(*) as count FROM agents a 
                       JOIN users u ON a.user_id = u.id 
                       WHERE (a.agent_code LIKE ? OR a.full_name LIKE ?)" . 
                       ($status_filter ? " AND a.status = ?" : ""), $params)->fetch(PDO::FETCH_ASSOC)['count'];
$results_per_page = 10; // Adjust as needed
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
    }

    .container-custom {
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .table-responsive {
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px;
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

    /* ปรับปรุงให้ตารางดูดีขึ้นเมื่อเลื่อนเมาส์ */
    .table-hover tbody tr:hover {
      background-color: #f1f1f1;
      cursor: pointer;
    }

    /* ฟอนต์ขนาดเล็กและจัดการความยืดหยุ่น */
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
  <!-- ปุ่มเพิ่มตัวแทน -->
<?php if ($user['rank'] == 1): ?>
  <a href="backend/add_agent.php" class="btn btn-success mb-3">+ เพิ่มตัวแทน</a>
<?php endif; ?>

</div>

<!-- ตารางแสดงข้อมูลตัวแทน -->
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">รูป</th>
        <th scope="col">รหัสตัวแทน</th>
        <th scope="col">ชื่อผู้ใช้</th>
        <th scope="col">ชื่อเต็ม</th>
        <th scope="col">เริ่ม</th>
        <th scope="col">หมดอายุ</th>
        <th scope="col">วันคงเหลือ</th>
        <th scope="col">สถานะ</th>
        <?php if ($user['rank'] == 1): ?>
        <th scope="col">จัดการ</th>
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

<script>
  // ใช้ AJAX เพื่อค้นหาตัวแทนโดยไม่ต้องรีเฟรชหน้า
  $(document).ready(function() {
    $("#search-input, #status-select").on("keyup change", function(event) {
      event.preventDefault();

      var search = $("#search-input").val();
      var status = $("#status-select").val();

      $.ajax({
        url: "agents.php",
        method: "GET",
        data: { search: search, status: status },
        success: function(data) {
          $("#agents-table-body").html($(data).find("#agents-table-body").html());
        }
      });
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

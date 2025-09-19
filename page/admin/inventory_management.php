<?php
require_once 'system/a_func.php';
require_once 'system/inventory.php';

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

// ดึงรายการสินค้าทั้งหมด
$productsStmt = dd_q("SELECT * FROM box_product ORDER BY name");
$products = [];
while ($product = $productsStmt->fetch(PDO::FETCH_ASSOC)) {
    $products[] = $product;
}
?>

<style>
    .inventory-card {
        background: linear-gradient(145deg, #1a1a1a, #0d0d0d);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    
    .inventory-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .stock-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .stock-high {
        background: rgba(42, 157, 143, 0.2);
        color: #2a9d8f;
    }
    
    .stock-medium {
        background: rgba(233, 196, 106, 0.2);
        color: #e9c46a;
    }
    
    .stock-low {
        background: rgba(231, 111, 81, 0.2);
        color: #e76f51;
    }
    
    .table-inventory {
        background: rgba(30, 30, 30, 0.5);
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .table-inventory thead th {
        background: rgba(40, 40, 40, 0.8);
        border: none;
        font-weight: 600;
        padding: 15px;
    }
    
    .table-inventory tbody td {
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
    
    .search-box {
        background: rgba(30, 30, 30, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 12px 16px;
        color: #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .search-box:focus {
        background: rgba(40, 40, 40, 0.8);
        border-color: #ff6b35;
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        outline: none;
    }
</style>

<div class="container-fluid p-0 mt-4">
    <div class="container-sm m-cent ps-4 pe-4">
        <div class="container-fluid p-4 shadow-sm" style="background: linear-gradient(145deg, #1a1a1a, #0d0d0d); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="col-lg-12 m-cent">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="gradient-text" style="font-size: 28px; font-weight: 700;">จัดการสินค้าคงคลัง</h1>
                        <p class="text-muted">จัดการและติดตามสต็อกสินค้าทั้งหมดในระบบ</p>
                    </div>
                    <div>
                        <button class="btn btn-primary-modern" data-bs-toggle="modal" data-bs-target="#importStockModal">
                            <i class="fas fa-file-import"></i> นำเข้าสต็อก
                        </button>
                    </div>
                </div>
                
                <!-- สรุปสต็อก -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="inventory-card text-center">
                            <h3><?php echo count($products); ?></h3>
                            <p class="text-muted">จำนวนสินค้าทั้งหมด</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="inventory-card text-center">
                            <?php
                            $totalStock = 0;
                            foreach ($products as $product) {
                                $totalStock += $product['stock_quantity'];
                            }
                            ?>
                            <h3><?php echo $totalStock; ?></h3>
                            <p class="text-muted">จำนวนสต็อกทั้งหมด</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="inventory-card text-center">
                            <?php
                            $lowStockCount = 0;
                            foreach ($products as $product) {
                                if ($product['stock_quantity'] <= $product['low_stock_threshold'] && $product['low_stock_threshold'] > 0) {
                                    $lowStockCount++;
                                }
                            }
                            ?>
                            <h3><?php echo $lowStockCount; ?></h3>
                            <p class="text-muted">สินค้าที่ใกล้หมดสต็อก</p>
                        </div>
                    </div>
                </div>
                
                <!-- ตารางสินค้า -->
                <div class="inventory-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4><i class="fas fa-boxes"></i> รายการสินค้า</h4>
                        <div class="d-flex">
                            <input type="text" class="search-box me-2" placeholder="ค้นหาสินค้า..." id="searchProduct">
                            <select class="search-box" id="filterCategory">
                                <option value="">ทุกหมวดหมู่</option>
                                <!-- เพิ่มหมวดหมู่ที่นี่ -->
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table-inventory table table-hover">
                            <thead>
                                <tr>
                                    <th>สินค้า</th>
                                    <th>ราคาปกติ</th>
                                    <th>ราคา VIP</th>
                                    <th>สต็อก</th>
                                    <th>แจ้งเตือน</th>
                                    <th>การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $product['img']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50" class="rounded me-3">
                                            <div>
                                                <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                                                <br><small class="text-muted"><?php echo htmlspecialchars($product['c_type']); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($product['price']); ?> ฿</td>
                                    <td><?php echo number_format($product['price_vip']); ?> ฿</td>
                                    <td>
                                        <span class="stock-badge <?php 
                                            if ($product['stock_quantity'] > $product['low_stock_threshold'] * 2) {
                                                echo 'stock-high';
                                            } elseif ($product['stock_quantity'] > $product['low_stock_threshold']) {
                                                echo 'stock-medium';
                                            } else {
                                                echo 'stock-low';
                                            }
                                        ?>">
                                            <?php echo $product['stock_quantity']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $product['low_stock_threshold']; ?></td>
                                    <td>
                                        <button class="btn btn-sm action-btn btn-success-light" onclick="viewStock(<?php echo $product['id']; ?>)">
                                            <i class="fas fa-eye"></i> ดูสต็อก
                                        </button>
                                        <button class="btn btn-sm action-btn btn-warning-light" onclick="manageStock(<?php echo $product['id']; ?>)">
                                            <i class="fas fa-edit"></i> จัดการ
                                        </button>
                                        <button class="btn btn-sm action-btn btn-danger-light" onclick="exportStock(<?php echo $product['id']; ?>)">
                                            <i class="fas fa-file-export"></i> ส่งออก
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

<!-- Modal นำเข้าสต็อก -->
<div class="modal fade" id="importStockModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-modern">
            <div class="modal-header">
                <h5 class="modal-title">นำเข้าสต็อก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="importStockForm">
                    <div class="mb-3">
                        <label class="form-label">เลือกสินค้า</label>
                        <select class="form-control-modern" id="importProductId" required>
                            <option value="">เลือกสินค้า</option>
                            <?php foreach ($products as $product): ?>
                            <option value="<?php echo $product['id']; ?>">
                                <?php echo htmlspecialchars($product['name']); ?> (สต็อก: <?php echo $product['stock_quantity']; ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">วิธีการนำเข้า</label>
                        <select class="form-control-modern" id="importMethod">
                            <option value="manual">ใส่ด้วยมือ</option>
                            <option value="csv">อัปโหลดไฟล์ CSV</option>
                        </select>
                    </div>
                    
                    <div id="manualImport" class="mb-3">
                        <label class="form-label">รายการสต็อก (Username,Password แยกด้วยบรรทัดใหม่)</label>
                        <textarea class="form-control-modern" id="stockItems" rows="5" placeholder="username1,password1&#10;username2,password2"></textarea>
                    </div>
                    
                    <div id="csvImport" class="mb-3" style="display: none;">
                        <label class="form-label">อัปโหลดไฟล์ CSV</label>
                        <input type="file" class="form-control-modern" id="csvFile" accept=".csv">
                        <small class="text-muted">รูปแบบ: Username,Password,Notes</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">หมายเหตุ</label>
                        <input type="text" class="form-control-modern" id="importNotes" placeholder="ใส่หมายเหตุ (ถ้ามี)">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary-modern" id="importStockBtn">
                    <i class="fas fa-file-import"></i> นำเข้าสต็อก
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // เปลี่ยนวิธีการนำเข้า
    $('#importMethod').change(function() {
        if ($(this).val() === 'manual') {
            $('#manualImport').show();
            $('#csvImport').hide();
        } else {
            $('#manualImport').hide();
            $('#csvImport').show();
        }
    });
    
    // นำเข้าสต็อก
    $('#importStockBtn').click(function() {
        var productId = $('#importProductId').val();
        var method = $('#importMethod').val();
        var notes = $('#importNotes').val();
        
        if (!productId) {
            Swal.fire('ผิดพลาด', 'กรุณาเลือกสินค้า', 'error');
            return;
        }
        
        var data = {
            product_id: productId,
            method: method,
            notes: notes
        };
        
        if (method === 'manual') {
            var stockItems = $('#stockItems').val();
            if (!stockItems) {
                Swal.fire('ผิดพลาด', 'กรุณาใส่รายการสต็อก', 'error');
                return;
            }
            data.stock_items = stockItems;
        } else {
            var file = $('#csvFile')[0].files[0];
            if (!file) {
                Swal.fire('ผิดพลาด', 'กรุณาเลือกไฟล์ CSV', 'error');
                return;
            }
            // สำหรับไฟล์ CSV ต้องใช้ FormData
            var formData = new FormData();
            formData.append('product_id', productId);
            formData.append('method', method);
            formData.append('notes', notes);
            formData.append('csv_file', file);
            
            $.ajax({
                url: 'system/import_stock.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#importStockBtn').attr('disabled', 'disabled');
                    $('#importStockBtn').html('<i class="fas fa-spinner fa-spin"></i> กำลังนำเข้า...');
                }
            }).done(function(res) {
                if (res.status === 'success') {
                    Swal.fire('สำเร็จ', res.message, 'success').then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire('ผิดพลาด', res.message, 'error');
                }
                $('#importStockBtn').removeAttr('disabled');
                $('#importStockBtn').html('<i class="fas fa-file-import"></i> นำเข้าสต็อก');
            });
            return;
        }
        
        $.ajax({
            url: 'system/import_stock.php',
            type: 'POST',
            data: data,
            beforeSend: function() {
                $('#importStockBtn').attr('disabled', 'disabled');
                $('#importStockBtn').html('<i class="fas fa-spinner fa-spin"></i> กำลังนำเข้า...');
            }
        }).done(function(res) {
            if (res.status === 'success') {
                Swal.fire('สำเร็จ', res.message, 'success').then(function() {
                    location.reload();
                });
            } else {
                Swal.fire('ผิดพลาด', res.message, 'error');
            }
            $('#importStockBtn').removeAttr('disabled');
            $('#importStockBtn').html('<i class="fas fa-file-import"></i> นำเข้าสต็อก');
        });
    });
    
    // ค้นหาสินค้า
    $('#searchProduct').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.table-inventory tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

// ฟังก์ชันดูสต็อก
function viewStock(productId) {
    window.location.href = '?page=admin/view_stock&id=' + productId;
}

// ฟังก์ชันจัดการสต็อก
function manageStock(productId) {
    window.location.href = '?page=admin/manage_stock&id=' + productId;
}

// ฟังก์ชันส่งออกสต็อก
function exportStock(productId) {
    window.location.href = 'system/export_stock.php?id=' + productId;
}
</script>
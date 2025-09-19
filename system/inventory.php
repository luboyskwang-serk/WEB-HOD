<?php
require_once 'a_func.php';

// คลาสสำหรับจัดการ Inventory
class InventoryManager {
    
    // ดึงข้อมูลสินค้าคงคลัง
    public static function getProductStock($productId) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM box_product WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            // นับจำนวนสต็อกจากตาราง box_stock
            $stockStmt = $conn->prepare("SELECT COUNT(*) as stock_count FROM box_stock WHERE p_id = ?");
            $stockStmt->execute([$productId]);
            $stockData = $stockStmt->fetch(PDO::FETCH_ASSOC);
            
            $product['current_stock'] = $stockData['stock_count'];
            return $product;
        }
        
        return false;
    }
    
    // อัปเดตจำนวนสต็อก
    public static function updateStock($productId, $quantity) {
        global $conn;
        
        // ตรวจสอบสินค้า
        $product = self::getProductStock($productId);
        if (!$product) {
            return ['status' => 'error', 'message' => 'ไม่พบสินค้า'];
        }
        
        // อัปเดตจำนวนสต็อก
        $stmt = $conn->prepare("UPDATE box_product SET stock_quantity = ? WHERE id = ?");
        if ($stmt->execute([$quantity, $productId])) {
            return ['status' => 'success', 'message' => 'อัปเดตสต็อกสำเร็จ'];
        }
        
        return ['status' => 'error', 'message' => 'ไม่สามารถอัปเดตสต็อกได้'];
    }
    
    // เพิ่มรายการสต็อก
    public static function addStockItem($productId, $username, $password, $notes = '') {
        global $conn;
        
        // เพิ่มรายการสต็อกใหม่
        $stmt = $conn->prepare("INSERT INTO box_stock (username, password, p_id, notes, created_at) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt->execute([$username, $password, $productId, $notes])) {
            // อัปเดตจำนวนสต็อกในตาราง box_product
            self::updateProductStockCount($productId);
            return ['status' => 'success', 'message' => 'เพิ่มรายการสต็อกสำเร็จ', 'id' => $conn->lastInsertId()];
        }
        
        return ['status' => 'error', 'message' => 'ไม่สามารถเพิ่มรายการสต็อกได้'];
    }
    
    // ลบรายการสต็อก
    public static function removeStockItem($stockId) {
        global $conn;
        
        // ดึงข้อมูลรายการสต็อกก่อนลบ
        $stmt = $conn->prepare("SELECT p_id FROM box_stock WHERE id = ?");
        $stmt->execute([$stockId]);
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$stock) {
            return ['status' => 'error', 'message' => 'ไม่พบรายการสต็อก'];
        }
        
        // ลบรายการสต็อก
        $deleteStmt = $conn->prepare("DELETE FROM box_stock WHERE id = ?");
        if ($deleteStmt->execute([$stockId])) {
            // อัปเดตจำนวนสต็อกในตาราง box_product
            self::updateProductStockCount($stock['p_id']);
            return ['status' => 'success', 'message' => 'ลบรายการสต็อกสำเร็จ'];
        }
        
        return ['status' => 'error', 'message' => 'ไม่สามารถลบรายการสต็อกได้'];
    }
    
    // อัปเดตจำนวนสต็อกในตาราง box_product
    private static function updateProductStockCount($productId) {
        global $conn;
        
        // นับจำนวนสต็อกจากตาราง box_stock
        $stockStmt = $conn->prepare("SELECT COUNT(*) as stock_count FROM box_stock WHERE p_id = ?");
        $stockStmt->execute([$productId]);
        $stockData = $stockStmt->fetch(PDO::FETCH_ASSOC);
        
        // อัปเดตจำนวนสต็อกในตาราง box_product
        $updateStmt = $conn->prepare("UPDATE box_product SET stock_quantity = ? WHERE id = ?");
        $updateStmt->execute([$stockData['stock_count'], $productId]);
    }
    
    // ตรวจสอบสต็อกต่ำ
    public static function checkLowStock() {
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM box_product WHERE stock_quantity <= low_stock_threshold AND low_stock_threshold > 0");
        $stmt->execute();
        
        $lowStockProducts = [];
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lowStockProducts[] = $product;
        }
        
        return $lowStockProducts;
    }
    
    // ดึงประวัติการเคลื่อนไหวของสต็อก
    public static function getStockMovementHistory($productId = null, $limit = 50) {
        global $conn;
        
        if ($productId) {
            $stmt = $conn->prepare("SELECT sm.*, bp.name as product_name, u.username as admin_name 
                                   FROM stock_movements sm 
                                   LEFT JOIN box_product bp ON sm.product_id = bp.id 
                                   LEFT JOIN users u ON sm.admin_id = u.id 
                                   WHERE sm.product_id = ? 
                                   ORDER BY sm.created_at DESC 
                                   LIMIT ?");
            $stmt->execute([$productId, $limit]);
        } else {
            $stmt = $conn->prepare("SELECT sm.*, bp.name as product_name, u.username as admin_name 
                                   FROM stock_movements sm 
                                   LEFT JOIN box_product bp ON sm.product_id = bp.id 
                                   LEFT JOIN users u ON sm.admin_id = u.id 
                                   ORDER BY sm.created_at DESC 
                                   LIMIT ?");
            $stmt->execute([$limit]);
        }
        
        $movements = [];
        while ($movement = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $movements[] = $movement;
        }
        
        return $movements;
    }
    
    // บันทึกการเคลื่อนไหวของสต็อก
    public static function logStockMovement($productId, $quantity, $type, $adminId, $notes = '') {
        global $conn;
        
        $stmt = $conn->prepare("INSERT INTO stock_movements 
                               (product_id, quantity, type, admin_id, notes, created_at) 
                               VALUES (?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$productId, $quantity, $type, $adminId, $notes]);
    }
    
    // นำเข้าสต็อกจากไฟล์ CSV
    public static function importStockFromCSV($productId, $csvData, $adminId) {
        $lines = explode("\n", trim($csvData));
        $imported = 0;
        $errors = [];
        
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            if (count($data) >= 2) {
                $username = trim($data[0]);
                $password = trim($data[1]);
                $notes = isset($data[2]) ? trim($data[2]) : '';
                
                $result = self::addStockItem($productId, $username, $password, $notes);
                if ($result['status'] == 'success') {
                    self::logStockMovement($productId, 1, 'import', $adminId, 'Imported from CSV');
                    $imported++;
                } else {
                    $errors[] = "Error importing: " . $username . " - " . $result['message'];
                }
            }
        }
        
        return [
            'status' => 'success',
            'message' => "นำเข้าสต็อกสำเร็จ $imported รายการ",
            'imported' => $imported,
            'errors' => $errors
        ];
    }
    
    // ส่งออกสต็อกเป็น CSV
    public static function exportStockToCSV($productId) {
        global $conn;
        
        $stmt = $conn->prepare("SELECT username, password, notes FROM box_stock WHERE p_id = ?");
        $stmt->execute([$productId]);
        
        $csv = "Username,Password,Notes\n";
        while ($stock = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $csv .= '"' . $stock['username'] . '","' . $stock['password'] . '","' . $stock['notes'] . '"' . "\n";
        }
        
        return $csv;
    }
}

// สร้างตาราง stock_movements ถ้ายังไม่มี
function createStockMovementTable() {
    global $conn;
    
    $sql = "CREATE TABLE IF NOT EXISTS stock_movements (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        type ENUM('import', 'export', 'adjustment', 'sale', 'return') NOT NULL,
        admin_id INT NOT NULL,
        notes TEXT,
        created_at DATETIME,
        FOREIGN KEY (product_id) REFERENCES box_product(id) ON DELETE CASCADE,
        FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE,
        INDEX idx_product_id (product_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    try {
        $conn->exec($sql);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// เพิ่มคอลัมน์ในตาราง box_product ถ้ายังไม่มี
function updateProductTable() {
    global $conn;
    
    try {
        // เพิ่มคอลัมน์ stock_quantity
        $conn->exec("ALTER TABLE box_product ADD COLUMN IF NOT EXISTS stock_quantity INT DEFAULT 0");
        
        // เพิ่มคอลัมน์ low_stock_threshold
        $conn->exec("ALTER TABLE box_product ADD COLUMN IF NOT EXISTS low_stock_threshold INT DEFAULT 5");
        
        // เพิ่มคอลัมน์ notes ในตาราง box_stock
        $conn->exec("ALTER TABLE box_stock ADD COLUMN IF NOT EXISTS notes TEXT");
        
        // เพิ่มคอลัมน์ created_at ในตาราง box_stock
        $conn->exec("ALTER TABLE box_stock ADD COLUMN IF NOT EXISTS created_at DATETIME");
        
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// เรียกใช้ฟังก์ชันสร้างตาราง
createStockMovementTable();
updateProductTable();
?>
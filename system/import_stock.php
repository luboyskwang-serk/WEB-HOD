<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'a_func.php';
require_once 'inventory.php';

function dd_return($status, $message) {
    if ($status) {
        $json = ['status'=> 'success','message' => $message];
        http_response_code(200);
        die(json_encode($json));
    }else{
        $json = ['status'=> 'fail','message' => $message];
        http_response_code(200);
        die(json_encode($json));
    }
}

//////////////////////////////////////////////////////////////////////////

header('Content-Type: application/json; charset=utf-8;');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['id'])) {
        // ตรวจสอบสิทธิ์ admin
        $q1 = dd_q("SELECT rank FROM users WHERE id = ? LIMIT 1", [$_SESSION['id']]);
        $user = $q1->fetch(PDO::FETCH_ASSOC);
        
        if ($user['rank'] != 1) {
            dd_return(false, "คุณไม่มีสิทธิ์เข้าถึงฟังก์ชันนี้");
        }
        
        $product_id = $_POST['product_id'];
        $method = $_POST['method'];
        $notes = $_POST['notes'] ?? '';
        
        if ($method === 'manual') {
            // นำเข้าแบบ manual
            $stock_items = $_POST['stock_items'];
            $lines = explode("\n", trim($stock_items));
            $imported = 0;
            $errors = [];
            
            foreach ($lines as $line) {
                $data = str_getcsv($line);
                if (count($data) >= 2) {
                    $username = trim($data[0]);
                    $password = trim($data[1]);
                    $item_notes = isset($data[2]) ? trim($data[2]) : '';
                    
                    $result = InventoryManager::addStockItem($product_id, $username, $password, $item_notes);
                    if ($result['status'] == 'success') {
                        InventoryManager::logStockMovement($product_id, 1, 'import', $_SESSION['id'], $notes);
                        $imported++;
                    } else {
                        $errors[] = "Error importing: " . $username . " - " . $result['message'];
                    }
                }
            }
            
            if ($imported > 0) {
                dd_return(true, "นำเข้าสต็อกสำเร็จ $imported รายการ");
            } else {
                dd_return(false, "ไม่สามารถนำเข้าสต็อกได้: " . implode(", ", $errors));
            }
        } else {
            // นำเข้าแบบ CSV
            if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
                $csv_content = file_get_contents($_FILES['csv_file']['tmp_name']);
                $result = InventoryManager::importStockFromCSV($product_id, $csv_content, $_SESSION['id']);
                if ($result['status'] == 'success') {
                    dd_return(true, $result['message']);
                } else {
                    dd_return(false, $result['message']);
                }
            } else {
                dd_return(false, "ไม่พบไฟล์ CSV หรือมีข้อผิดพลาดในการอัปโหลด");
            }
        }
    } else {
        dd_return(false, "กรุณาเข้าสู่ระบบก่อน");
    }
}

dd_return(false, "Method not allowed");
?>
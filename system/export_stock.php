<?php
require_once 'a_func.php';
require_once 'inventory.php';

// ตรวจสอบการ login
if (!isset($_SESSION['id'])) {
    header('Location: ?page=login');
    exit;
}

// ตรวจสอบสิทธิ์ admin
$q1 = dd_q("SELECT rank FROM users WHERE id = ? LIMIT 1", [$_SESSION['id']]);
$user = $q1->fetch(PDO::FETCH_ASSOC);

if ($user['rank'] != 1) {
    header('Location: ?page=home');
    exit;
}

// ดึงข้อมูลสินค้า
$product_id = $_GET['id'] ?? 0;
if (!$product_id) {
    die('Invalid product ID');
}

// ดึงข้อมูลสินค้า
$productStmt = dd_q("SELECT name FROM box_product WHERE id = ?", [$product_id]);
$product = $productStmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die('Product not found');
}

// ส่งออกไฟล์ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=stock_' . $product['name'] . '_' . date('Y-m-d') . '.csv');

// สร้างไฟล์ CSV
$csv = InventoryManager::exportStockToCSV($product_id);
echo $csv;
exit;
?>
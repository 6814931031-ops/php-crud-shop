<?php
require 'db.php';

// ลบข้อมูลสินค้า
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: index.php");
    exit;
}

// ดึงข้อมูลสินค้าพร้อมชื่อหมวดหมู่
$stmt = $pdo->query("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id = c.category_id ORDER BY p.product_id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายการสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2 class="mb-4">ระบบจัดการสินค้า (Products Management)</h2>
    <a href="create.php" class="btn btn-primary mb-3">+ เพิ่มสินค้าใหม่</a>
    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>รหัส</th>
                <th>ชื่อสินค้า</th>
                <th>หมวดหมู่</th>
                <th>แบรนด์/รุ่น</th>
                <th>ราคาทุน</th>
                <th>ราคาขาย</th>
                <th>คงเหลือ</th>
                <th>สถานะ</th>
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['product_code']) ?></td>
                <td><?= htmlspecialchars($p['product_name']) ?></td>
                <td><?= htmlspecialchars($p['category_name']) ?></td>
                <td><?= htmlspecialchars($p['brand']) ?> <?= htmlspecialchars($p['model']) ?></td>
                <td><?= number_format($p['cost_price'], 2) ?></td>
                <td><?= number_format($p['selling_price'], 2) ?></td>
                <td><?= $p['stock_quantity'] ?> <?= htmlspecialchars($p['unit']) ?></td>
                <td><span class="badge bg-<?= $p['status'] == 'active' ? 'success' : 'secondary' ?>"><?= $p['status'] ?></span></td>
                <td>
                    <a href="edit.php?id=<?= $p['product_id'] ?>" class="btn btn-sm btn-warning">แก้ไข</a>
                    <a href="index.php?delete=<?= $p['product_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
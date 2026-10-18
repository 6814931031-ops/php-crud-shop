<?php
require 'db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO products (category_id, product_code, product_name, brand, model, cost_price, selling_price, stock_quantity, unit, status, supplier_name) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['category_id'], $_POST['product_code'], $_POST['product_name'],
        $_POST['brand'], $_POST['model'], $_POST['cost_price'],
        $_POST['selling_price'], $_POST['stock_quantity'], $_POST['unit'],
        $_POST['status'], $_POST['supplier_name']
    ]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้าใหม่</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>เพิ่มสินค้าใหม่</h2>
    <form method="POST" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">หมวดหมู่</label>
            <select name="category_id" class="form-select" required>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['category_id'] ?>"><?= htmlspecialchars($c['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">รหัสสินค้า (SKU)</label><input type="text" name="product_code" class="form-content form-control" required></div>
        <div class="col-md-4"><label class="form-label">ชื่อสินค้า</label><input type="text" name="product_name" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label">แบรนด์</label><input type="text" name="brand" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">รุ่น</label><input type="text" name="model" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">ผู้จัดจำหน่าย</label><input type="text" name="supplier_name" class="form-control"></div>
        <div class="col-md-3"><label class="form-label">ราคาทุน</label><input type="number" step="0.01" name="cost_price" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">ราคาขาย</label><input type="number" step="0.01" name="selling_price" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">จำนวนคงเหลือ</label><input type="number" name="stock_quantity" class="form-control" required></div>
        <div class="col-md-3"><label class="form-label">หน่วยนับ</label><input type="text" name="unit" class="form-control" placeholder="ชิ้น, เครื่อง"></div>
        <div class="col-md-4">
            <label class="form-label">สถานะ</label>
            <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
            <a href="index.php" class="btn btn-secondary">ย้อนกลับ</a>
        </div>
    </form>
</body>
</html>
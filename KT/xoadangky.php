<?php
include 'db.php';

$MaSV = $_GET['MaSV'] ?? '';
if (!$MaSV) {
    die("Chưa chọn sinh viên để xóa đăng ký.");
}

$stmt = $conn->prepare("SELECT MaDK FROM DangKy WHERE MaSV = ?");
$stmt->bind_param("s", $MaSV);
$stmt->execute();
$result = $stmt->get_result();

$maDKs = [];
while ($row = $result->fetch_assoc()) {
    $maDKs[] = $row['MaDK'];
}

$message = '';
if (count($maDKs) > 0) {
    $placeholders = implode(',', array_fill(0, count($maDKs), '?'));
    $types = str_repeat('i', count($maDKs));

    $stmt_del_ct = $conn->prepare("DELETE FROM ChiTietDangKy WHERE MaDK IN ($placeholders)");
    $stmt_del_ct->bind_param($types, ...$maDKs);
    $stmt_del_ct->execute();

    $stmt_del_dk = $conn->prepare("DELETE FROM DangKy WHERE MaDK IN ($placeholders)");
    $stmt_del_dk->bind_param($types, ...$maDKs);
    $stmt_del_dk->execute();

    $message = "Đã xóa đăng ký học phần của sinh viên <b>" . htmlspecialchars($MaSV) . "</b> thành công.";
} else {
    $message = "Sinh viên <b>" . htmlspecialchars($MaSV) . "</b> chưa có đăng ký học phần nào.";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<title>Xóa đăng ký học phần</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f7f8;
        color: #34495e;
        margin: 50px;
        text-align: center;
    }
    .message {
        background-color: #ecf0f1;
        border-radius: 8px;
        padding: 25px 35px;
        display: inline-block;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-size: 18px;
        margin-bottom: 25px;
        color: #2c3e50;
    }
    .message b {
        color: #2980b9;
    }
    a.button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #3498db;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        transition: background-color 0.3s ease;
    }
    a.button:hover {
        background-color: #2980b9;
    }
</style>
</head>
<body>
    <div class="message"><?= $message ?></div><br>
    <a href="index.php" class="button">« Quay lại danh sách sinh viên</a>
</body>
</html>

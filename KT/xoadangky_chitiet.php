<?php
include 'db.php';

$MaSV = $_GET['MaSV'] ?? '';
$MaHP = $_GET['MaHP'] ?? '';

if (!$MaSV || !$MaHP) {
    die("Thiếu dữ liệu để xóa đăng ký.");
}

// Tìm MaDK của sinh viên cho học phần đó
$sql = "
    SELECT dk.MaDK 
    FROM DangKy dk
    JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
    WHERE dk.MaSV = ? AND ctdk.MaHP = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $MaSV, $MaHP);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if (!$row) {
    die("Không tìm thấy đăng ký để xóa.");
}

$MaDK = $row['MaDK'];

// Xóa học phần khỏi ChiTietDangKy
$stmt_del = $conn->prepare("DELETE FROM ChiTietDangKy WHERE MaDK = ? AND MaHP = ?");
$stmt_del->bind_param("is", $MaDK, $MaHP);
$stmt_del->execute();

// Kiểm tra nếu ChiTietDangKy còn học phần nào không, nếu không thì xóa luôn bản đăng ký
$stmt_check = $conn->prepare("SELECT COUNT(*) as cnt FROM ChiTietDangKy WHERE MaDK = ?");
$stmt_check->bind_param("i", $MaDK);
$stmt_check->execute();
$res_check = $stmt_check->get_result();
$count = $res_check->fetch_assoc()['cnt'];

if ($count == 0) {
    $stmt_del_dk = $conn->prepare("DELETE FROM DangKy WHERE MaDK = ?");
    $stmt_del_dk->bind_param("i", $MaDK);
    $stmt_del_dk->execute();
}

header("Location: index.php?page=1&MaSV=" . urlencode($MaSV) . "&msg=" . urlencode("Xóa học phần thành công."));
exit;
?>

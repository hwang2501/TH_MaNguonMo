<?php
include 'db.php';

$MaSV = $_GET['MaSV'] ?? '';
if ($MaSV) {
    $stmt = $conn->prepare("DELETE FROM SinhVien WHERE MaSV=?");
    $stmt->bind_param("s", $MaSV);
    $stmt->execute();
}

header("Location: index.php");
exit;
?>

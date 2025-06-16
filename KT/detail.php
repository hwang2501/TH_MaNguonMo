<?php
include 'db.php';

$MaSV = $_GET['MaSV'] ?? '';
if (!$MaSV) {
    header('Location: index.php');
    exit;
}

// Lấy thông tin sinh viên + ngành học
$stmt = $conn->prepare("SELECT sv.*, nh.TenNganh FROM SinhVien sv LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh WHERE sv.MaSV = ?");
$stmt->bind_param("s", $MaSV);
$stmt->execute();
$result = $stmt->get_result();
$sv = $result->fetch_assoc();

if (!$sv) {
    echo "Không tìm thấy sinh viên.";
    exit;
}

// Đếm số môn học sinh viên đã đăng ký
$stmt2 = $conn->prepare("
    SELECT COUNT(*) AS SoLuongMon
    FROM DangKy dk
    INNER JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
    WHERE dk.MaSV = ?
");
$stmt2->bind_param("s", $MaSV);
$stmt2->execute();
$result2 = $stmt2->get_result();
$row2 = $result2->fetch_assoc();
$soLuongMon = $row2['SoLuongMon'] ?? 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Chi tiết sinh viên - <?= htmlspecialchars($sv['HoTen']) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9fbfc;
            color: #333;
            margin: 0;
            padding: 30px;
        }
        .container {
            max-width: 600px;
            background: #fff;
            margin: 0 auto;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
            color: #2c3e50;
            border-bottom: 2px solid #2980b9;
            padding-bottom: 10px;
        }
        a.back-link {
            display: inline-block;
            margin: 20px 0;
            text-decoration: none;
            color: #2980b9;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        a.back-link:hover {
            color: #1c5980;
            text-decoration: underline;
        }
        .detail-item {
            margin: 12px 0;
            font-size: 16px;
        }
        .detail-label {
            font-weight: 700;
            color: #555;
            display: inline-block;
            width: 140px;
        }
        img {
            margin-top: 10px;
            max-width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #2980b9;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .no-image {
            font-style: italic;
            color: #999;
            margin-top: 10px;
        }
        .count-mon {
            font-weight: 700;
            font-size: 18px;
            color: #27ae60;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Chi tiết sinh viên</h2>
    <a href="index.php" class="back-link">« Quay lại danh sách</a>

    <div class="detail-item">
        <span class="detail-label">Mã SV:</span> <?= htmlspecialchars($sv['MaSV']) ?>
    </div>
    <div class="detail-item">
        <span class="detail-label">Họ tên:</span> <?= htmlspecialchars($sv['HoTen']) ?>
    </div>
    <div class="detail-item">
        <span class="detail-label">Giới tính:</span> <?= htmlspecialchars($sv['GioiTinh']) ?>
    </div>
    <div class="detail-item">
        <span class="detail-label">Ngày sinh:</span> <?= htmlspecialchars($sv['NgaySinh']) ?>
    </div>
    <div class="detail-item">
        <span class="detail-label">Ngành học:</span> <?= htmlspecialchars($sv['TenNganh']) ?>
    </div>
    <div class="detail-item">
        <span class="detail-label">Hình:</span><br>
        <?php if ($sv['Hinh'] && file_exists($sv['Hinh'])): ?>
            <img src="<?= htmlspecialchars($sv['Hinh']) ?>" alt="Hình <?= htmlspecialchars($sv['HoTen']) ?>" />
        <?php else: ?>
            <div class="no-image">Chưa có hình</div>
        <?php endif; ?>
    </div>

    <div class="count-mon">
        Số lượng học phần đã đăng ký: <?= $soLuongMon ?>
    </div>
</div>
</body>
</html>

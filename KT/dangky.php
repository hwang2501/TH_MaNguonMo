<?php
include 'db.php';

// Lấy MaSV từ GET (bạn phải truyền mã sinh viên để đăng ký)
$MaSV = $_GET['MaSV'] ?? '';
if (!$MaSV) {
    die("Chưa chọn sinh viên để đăng ký học phần.");
}

// Lấy danh sách học phần
$hocphan = $conn->query("SELECT * FROM HocPhan");

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedHP = $_POST['hocphan'] ?? [];

    if (empty($selectedHP)) {
        $error = "Bạn chưa chọn học phần nào.";
    } else {
        // Thêm bản ghi vào bảng DangKy
        $ngaydk = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO DangKy (NgayDK, MaSV) VALUES (?, ?)");
        $stmt->bind_param("ss", $ngaydk, $MaSV);
        if ($stmt->execute()) {
            $MaDK = $stmt->insert_id;

            // Thêm các học phần vào ChiTietDangKy
            $stmt_ct = $conn->prepare("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)");
            foreach ($selectedHP as $hp) {
                $stmt_ct->bind_param("is", $MaDK, $hp);
                $stmt_ct->execute();
            }

            $success = "Đăng ký học phần thành công.";
        } else {
            $error = "Lỗi đăng ký: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Đăng ký học phần cho sinh viên <?= htmlspecialchars($MaSV) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7f9fc;
            color: #333;
            margin: 20px;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        a.back {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
        }
        a.back:hover {
            text-decoration: underline;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        fieldset {
            border: 1px solid #ddd;
            padding: 15px 20px 20px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        legend {
            font-weight: 600;
            color: #2980b9;
            padding: 0 10px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 15px;
            cursor: pointer;
            user-select: none;
        }
        input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
            vertical-align: middle;
        }
        button {
            background-color: #27ae60;
            border: none;
            padding: 10px 20px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #219150;
        }
        .message {
            margin-bottom: 20px;
            padding: 12px 15px;
            border-radius: 5px;
            font-weight: 600;
        }
        .error {
            background-color: #ffe3e3;
            color: #c0392b;
            border: 1px solid #e74c3c;
        }
        .success {
            background-color: #e0f8e9;
            color: #27ae60;
            border: 1px solid #2ecc71;
        }
    </style>
</head>
<body>
    <h2>Đăng ký học phần cho sinh viên: <?= htmlspecialchars($MaSV) ?></h2>
    <a href="index.php" class="back">← Quay lại danh sách sinh viên</a>

    <?php if (!empty($error)) : ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)) : ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (empty($success)) : ?>
    <form method="post">
        <fieldset>
            <legend>Chọn học phần đăng ký:</legend>
            <?php while ($hp = $hocphan->fetch_assoc()) : ?>
                <label>
                    <input type="checkbox" name="hocphan[]" value="<?= htmlspecialchars($hp['MaHP']) ?>">
                    <?= htmlspecialchars($hp['TenHP']) ?> (<?= $hp['SoTinChi'] ?> tín chỉ)
                </label>
            <?php endwhile; ?>
        </fieldset>
        <button type="submit">Đăng ký</button>
    </form>
    <?php endif; ?>
</body>
</html>

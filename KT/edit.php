<?php
include 'db.php';

$MaSV = $_GET['MaSV'] ?? '';
if (!$MaSV) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT * FROM SinhVien WHERE MaSV=?");
$stmt->bind_param("s", $MaSV);
$stmt->execute();
$result = $stmt->get_result();
$sv = $result->fetch_assoc();
if (!$sv) {
    echo "Không tìm thấy sinh viên.";
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $HoTen = trim($_POST['HoTen']);
    $GioiTinh = $_POST['GioiTinh'] ?? '';
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    $Hinh = $sv['Hinh'];
    if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fileName = basename($_FILES['Hinh']['name']);
        $targetFile = $uploadDir . time() . '_' . $fileName;
        if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $targetFile)) {
            $Hinh = '/' . $targetFile;
        }
    }

    if ($HoTen == '') $errors[] = "Họ tên không được để trống.";

    if (empty($errors)) {
        $stmt2 = $conn->prepare("UPDATE SinhVien SET HoTen=?, GioiTinh=?, NgaySinh=?, Hinh=?, MaNganh=? WHERE MaSV=?");
        $stmt2->bind_param("ssssss", $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh, $MaSV);
        if ($stmt2->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Lỗi khi cập nhật: " . $stmt2->error;
        }
    }
}

$nganhhoc = $conn->query("SELECT * FROM NganhHoc");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Sửa thông tin sinh viên - <?= htmlspecialchars($sv['HoTen']) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 30px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
            font-weight: 700;
        }
        a.back-link {
            display: inline-block;
            margin: 20px 0;
            color: #2980b9;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a.back-link:hover {
            color: #1c5980;
            text-decoration: underline;
        }
        form label {
            display: block;
            margin-bottom: 15px;
            font-size: 16px;
        }
        form input[type="text"],
        form input[type="date"],
        form select,
        form input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        form input[type="text"]:focus,
        form input[type="date"]:focus,
        form select:focus {
            border-color: #3498db;
            outline: none;
        }
        button {
            background-color: #3498db;
            border: none;
            padding: 12px 30px;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #217dbb;
        }
        .error-list {
            background: #ffe6e6;
            border: 1px solid #ff4d4d;
            padding: 12px 20px;
            border-radius: 8px;
            color: #b20000;
            margin-bottom: 20px;
        }
        .current-image {
            margin-top: 8px;
            margin-bottom: 15px;
        }
        .current-image img {
            max-width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3498db;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Sửa thông tin sinh viên</h2>
    <a href="index.php" class="back-link">« Quay lại danh sách</a>

    <?php if ($errors): ?>
        <div class="error-list">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <label><strong>Mã SV:</strong> <?= htmlspecialchars($sv['MaSV']) ?></label>

        <label for="HoTen">Họ tên:
            <input type="text" id="HoTen" name="HoTen" value="<?= htmlspecialchars($sv['HoTen']) ?>" required>
        </label>

        <label for="GioiTinh">Giới tính:
            <select id="GioiTinh" name="GioiTinh">
                <option value="Nam" <?= $sv['GioiTinh'] === 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= $sv['GioiTinh'] === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            </select>
        </label>

        <label for="NgaySinh">Ngày sinh:
            <input type="date" id="NgaySinh" name="NgaySinh" value="<?= htmlspecialchars($sv['NgaySinh']) ?>">
        </label>

        <label for="MaNganh">Ngành học:
            <select id="MaNganh" name="MaNganh">
                <?php while ($row = $nganhhoc->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['MaNganh']) ?>" <?= $row['MaNganh'] == $sv['MaNganh'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['TenNganh']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label>

        <label>Hình hiện tại:</label>
        <div class="current-image">
            <?php if ($sv['Hinh'] && file_exists(ltrim($sv['Hinh'], '/'))): ?>
                <img src="<?= htmlspecialchars($sv['Hinh']) ?>" alt="Hình sinh viên">
            <?php else: ?>
                <span>Chưa có hình</span>
            <?php endif; ?>
        </div>

        <label for="Hinh">Thay đổi hình:
            <input type="file" id="Hinh" name="Hinh" accept="image/*">
        </label>

        <button type="submit">Lưu</button>
    </form>
</div>
</body>
</html>

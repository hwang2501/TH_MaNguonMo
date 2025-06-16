<?php
include 'db.php';

$errors = [];
$MaSV = $HoTen = $GioiTinh = $NgaySinh = $MaNganh = '';
$GioiTinh = 'Nam';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MaSV = trim($_POST['MaSV']);
    $HoTen = trim($_POST['HoTen']);
    $GioiTinh = $_POST['GioiTinh'] ?? '';
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    $Hinh = '';
    if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = time() . '_' . basename($_FILES['Hinh']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['Hinh']['tmp_name'], $targetFile)) {
            $Hinh = $targetFile;
        } else {
            $errors[] = "Lỗi khi tải lên hình ảnh.";
        }
    }

    if ($MaSV == '') $errors[] = "Mã sinh viên không được để trống.";
    if ($HoTen == '') $errors[] = "Họ tên không được để trống.";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $MaSV, $HoTen, $GioiTinh, $NgaySinh, $Hinh, $MaNganh);
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Lỗi khi thêm sinh viên: " . $stmt->error;
        }
    }
}

$nganhhoc = $conn->query("SELECT * FROM NganhHoc");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thêm sinh viên</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            margin: 0; padding: 20px;
            color: #333;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        a.button-back {
            display: inline-block;
            background-color: #7f8c8d;
            color: white;
            padding: 7px 15px;
            border-radius: 4px;
            text-decoration: none;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }
        a.button-back:hover {
            background-color: #636e72;
        }
        form {
            background: white;
            padding: 25px;
            max-width: 450px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 15px;
            font-weight: 600;
        }
        input[type="text"],
        input[type="date"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: #2980b9;
            outline: none;
        }
        button {
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            width: 100%;
        }
        button:hover {
            background-color: #1c5980;
        }
        ul.errors {
            background-color: #e74c3c;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            list-style-type: none;
        }
        ul.errors li {
            margin-left: 0;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <h2>Thêm sinh viên</h2>
    <a href="index.php" class="button-back">« Quay lại danh sách</a>

    <?php if ($errors): ?>
        <ul class="errors">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" novalidate>
        <label>
            Mã SV:
            <input type="text" name="MaSV" required value="<?= htmlspecialchars($MaSV) ?>">
        </label>

        <label>
            Họ tên:
            <input type="text" name="HoTen" required value="<?= htmlspecialchars($HoTen) ?>">
        </label>

        <label>
            Giới tính:
            <select name="GioiTinh" required>
                <option value="Nam" <?= $GioiTinh === 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= $GioiTinh === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            </select>
        </label>

        <label>
            Ngày sinh:
            <input type="date" name="NgaySinh" value="<?= htmlspecialchars($NgaySinh) ?>">
        </label>

        <label>
            Ngành học:
            <select name="MaNganh" required>
                <?php
                $nganhhoc->data_seek(0);
                while ($row = $nganhhoc->fetch_assoc()):
                ?>
                    <option value="<?= htmlspecialchars($row['MaNganh']) ?>" <?= $row['MaNganh'] === $MaNganh ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['TenNganh']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label>

        <label>
            Hình:
            <input type="file" name="Hinh" accept="image/*">
        </label>

        <button type="submit">Thêm</button>
    </form>
</body>
</html>

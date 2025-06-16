<?php
include 'db.php';

// Phân trang
$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Tổng số sinh viên
$total_result = $conn->query("SELECT COUNT(*) as total FROM SinhVien");
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];
$total_pages = ceil($total / $limit);

// Lấy dữ liệu sinh viên + ngành
$sql = "SELECT sv.MaSV, sv.HoTen, sv.GioiTinh, sv.NgaySinh, sv.Hinh, nh.TenNganh 
        FROM SinhVien sv 
        LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh
        ORDER BY sv.MaSV
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

// Lấy MaSV được chọn để đăng ký học phần (nếu có)
$selectedMaSV = $_GET['MaSV'] ?? '';

// Lấy thông báo msg (nếu có)
$msg = $_GET['msg'] ?? '';

// Xử lý đăng ký học phần
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['MaSV']) && $_POST['MaSV'] === $selectedMaSV) {
    $selectedHP = $_POST['hocphan'] ?? [];

    if (empty($selectedHP)) {
        $error = "Bạn chưa chọn học phần nào.";
    } else {
        // Thêm bản ghi vào bảng DangKy
        $ngaydk = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO DangKy (NgayDK, MaSV) VALUES (?, ?)");
        $stmt->bind_param("ss", $ngaydk, $selectedMaSV);
        if ($stmt->execute()) {
            $MaDK = $stmt->insert_id;

            // Thêm các học phần vào ChiTietDangKy
            $stmt_ct = $conn->prepare("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)");
            foreach ($selectedHP as $hp) {
                $stmt_ct->bind_param("is", $MaDK, $hp);
                $stmt_ct->execute();
            }

            $message = "Đăng ký học phần thành công.";
        } else {
            $error = "Lỗi đăng ký: " . $stmt->error;
        }
    }
}

// Lấy danh sách học phần để hiển thị trong form
$hocphan = $conn->query("SELECT * FROM HocPhan");

// Lấy danh sách học phần đã đăng ký của sinh viên (nếu có)
$dkHocPhan = [];
if ($selectedMaSV) {
    $sql_dk = "
        SELECT hp.MaHP, hp.TenHP, hp.SoTinChi, dk.NgayDK 
        FROM DangKy dk
        JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
        JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
        WHERE dk.MaSV = ?
        ORDER BY dk.NgayDK DESC
    ";
    $stmt = $conn->prepare($sql_dk);
    $stmt->bind_param("s", $selectedMaSV);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $dkHocPhan[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Danh sách sinh viên</title>
    <style>
        /* CSS giữ nguyên như trước */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            margin: 0; padding: 20px;
            color: #333;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        a.button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            margin-bottom: 15px;
            transition: background-color 0.3s ease;
        }
        a.button:hover {
            background-color: #2980b9;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        th {
            background-color: #2980b9;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        tr:hover {
            background-color: #f1f9ff;
        }
        img {
            border-radius: 50%;
            object-fit: cover;
        }
        .actions a {
            margin: 0 5px;
            color: #2980b9;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        /* Phân trang */
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a, .pagination strong {
            display: inline-block;
            margin: 0 6px;
            padding: 8px 12px;
            border-radius: 4px;
            color: #2980b9;
            text-decoration: none;
            font-weight: 600;
            border: 1px solid transparent;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .pagination a:hover {
            background-color: #d6eaff;
            border-color: #2980b9;
        }
        .pagination strong {
            background-color: #2980b9;
            color: white;
            border-color: #2980b9;
            cursor: default;
        }
        /* Nút đăng ký học phần */
        .btn-dangky {
            background: #27ae60;
            padding: 5px 10px;
            color: #fff !important;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .btn-dangky:hover {
            background: #219150;
        }
        /* Nút xóa toàn bộ đăng ký */
        .btn-xoaall {
            background: #e74c3c;
            padding: 5px 10px;
            color: #fff !important;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
            transition: background-color 0.3s ease;
            margin-left: 5px;
        }
        .btn-xoaall:hover {
            background: #c0392b;
        }
        fieldset {
            border: 1px solid #2980b9;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
            background: white;
        }
        legend {
            color: #2980b9;
            font-weight: 700;
            padding: 0 10px;
        }
        button {
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1f5f8b;
        }
        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-weight: 600;
            width: fit-content;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h2>Danh sách sinh viên</h2>
    <a href="create.php" class="button">Thêm sinh viên</a>

    <?php if ($msg): ?>
        <div class="message success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if ($message): ?>
        <div class="message success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>Mã SV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình</th>
            <th>Ngành</th>
            <th>Hành Động</th>
            <th>Đăng ký HP</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= htmlspecialchars($row['MaSV']) ?></td>
                <td><?= htmlspecialchars($row['HoTen']) ?></td>
                <td><?= htmlspecialchars($row['GioiTinh']) ?></td>
                <td><?= htmlspecialchars($row['NgaySinh']) ?></td>
                <td>
                    <?php 
                    $imgPath = ltrim($row['Hinh'], '/'); 
                    if (!empty($row['Hinh']) && file_exists($imgPath)): ?>
                        <img src="<?= htmlspecialchars($row['Hinh']) ?>" alt="Hình SV" width="50" height="50" />
                    <?php else: ?>
                        <span style="color:#999;">Chưa có hình</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['TenNganh']) ?></td>
                <td class="actions">
                    <a href="detail.php?MaSV=<?= urlencode($row['MaSV']) ?>">Chi tiết</a> |
                    <a href="edit.php?MaSV=<?= urlencode($row['MaSV']) ?>">Sửa</a> |
                    <a href="delete.php?MaSV=<?= urlencode($row['MaSV']) ?>" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                </td>
                <td>
                    <a href="?page=<?= $page ?>&MaSV=<?= urlencode($row['MaSV']) ?>" class="btn-dangky">Đăng ký</a>
                    <a href="xoadangky.php?MaSV=<?= urlencode($row['MaSV']) ?>" 
                       onclick="return confirm('Bạn có chắc muốn xóa tất cả đăng ký học phần của sinh viên này?');" 
                       class="btn-xoaall">Xóa tất cả</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">« Trước</a>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
            <?php if ($p == $page): ?>
                <strong><?= $p ?></strong>
            <?php else: ?>
                <a href="?page=<?= $p ?>"><?= $p ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>">Tiếp »</a>
        <?php endif; ?>
    </div>

    <?php if ($selectedMaSV): ?>
    <hr>
    <h2>Đăng ký học phần cho sinh viên: <?= htmlspecialchars($selectedMaSV) ?></h2>

    <form method="post" action="?page=<?= $page ?>&MaSV=<?= urlencode($selectedMaSV) ?>">
        <input type="hidden" name="MaSV" value="<?= htmlspecialchars($selectedMaSV) ?>">
        <fieldset>
            <legend>Chọn học phần đăng ký:</legend>
            <?php 
            $hocphan->data_seek(0);
            while ($hp = $hocphan->fetch_assoc()) : ?>
                <label>
                    <input type="checkbox" name="hocphan[]" value="<?= htmlspecialchars($hp['MaHP']) ?>">
                    <?= htmlspecialchars($hp['TenHP']) ?> (<?= $hp['SoTinChi'] ?> tín chỉ)
                </label><br>
            <?php endwhile; ?>
        </fieldset>
        <button type="submit">Đăng ký</button>
    </form>

    <?php if ($dkHocPhan): ?>
        <h3>Chi tiết học phần đã đăng ký:</h3>
        <table>
            <thead>
                <tr>
                    <th>Mã HP</th>
                    <th>Tên học phần</th>
                    <th>Số tín chỉ</th>
                    <th>Ngày đăng ký</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dkHocPhan as $dk) : ?>
                    <tr>
                        <td><?= htmlspecialchars($dk['MaHP']) ?></td>
                        <td><?= htmlspecialchars($dk['TenHP']) ?></td>
                        <td><?= htmlspecialchars($dk['SoTinChi']) ?></td>
                        <td><?= htmlspecialchars($dk['NgayDK']) ?></td>
                        <td>
                            <a href="xoadangky_chitiet.php?MaSV=<?= urlencode($selectedMaSV) ?>&MaHP=<?= urlencode($dk['MaHP']) ?>" 
                               onclick="return confirm('Bạn có chắc muốn xóa học phần này?');"
                               style="color:red; font-weight:bold; text-decoration:none;">
                               Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có học phần nào được đăng ký.</p>
    <?php endif; ?>
    <?php endif; ?>
</body>
</html>

<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1>Danh sách sản phẩm</h1>
    <a href="/WEBBANHANG/Product/add" class="btn btn-success mb-3">
        <i class="bi bi-plus-square me-2"></i>Thêm sản phẩm mới
    </a>
    <ul class="list-group">
        <?php if (empty($products)): ?>
            <li class="list-group-item">Không có sản phẩm nào.</li>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <li class="list-group-item d-flex align-items-center">
                    <div>
                        <h2>
                            <a href="/WEBBANHANG/Product/show/<?php echo $product->id; ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h2>
                        <?php if ($product->image): ?>
                            <img src="/WEBBANHANG/<?php echo $product->image; ?>"
                                 alt="Hình ảnh sản phẩm"
                                 style="max-width: 80px; margin-right: 15px;">
                        <?php endif; ?>
                        <p class="mb-1"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="mb-1">
                            Giá: <span class="fw-bold"><?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VND</span>
                        </p>
                        <p class="mb-0">
                            Danh mục: <span class="fst-italic"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                        </p>
                    </div>
                    <div class="ms-auto">
                        <a href="/WEBBANHANG/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm me-2">
                            <i class="bi bi-pencil-square me-1"></i>Sửa
                        </a>
                        <a href="/WEBBANHANG/Product/delete/<?php echo $product->id; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            <i class="bi bi-trash me-1"></i>Xóa
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

<?php include 'app/views/shares/footer.php'; ?>
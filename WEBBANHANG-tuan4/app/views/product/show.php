<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1>Chi tiết sản phẩm</h1>

    <?php if (isset($product)): ?>
        <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                    <?php if ($product->image): ?>
                        <img src="/WEBBANHANG/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                             alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                             class="img-fluid rounded-start">
                    <?php else: ?>
                        <img src="/WEBBANHANG/assets/images/no-image.png"
                             alt="Không có hình ảnh"
                             class="img-fluid rounded-start">
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?></p>
                        <p class="card-text">
                            Giá: <span class="fw-bold"><?php echo htmlspecialchars(number_format($product->price, 2), ENT_QUOTES, 'UTF-8'); ?> VND</span>
                        </p>
                        <p class="card-text">
                            Danh mục: <span class="fst-italic"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                        </p>
                        <p class="card-text"><small class="text-muted">Ngày tạo: <?php echo date('d/m/Y H:i:s', strtotime($product->created_at)); ?></small></p>
                        <p class="card-text"><small class="text-muted">Ngày cập nhật: <?php echo date('d/m/Y H:i:s', strtotime($product->updated_at)); ?></small></p>
                        <div class="mt-3">
                            <a href="/WEBBANHANG/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning me-2">
                                <i class="bi bi-pencil-square me-1"></i>Sửa
                            </a>
                            <a href="/WEBBANHANG/Product/delete/<?php echo $product->id; ?>"
                               class="btn btn-danger"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                <i class="bi bi-trash me-1"></i>Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Không tìm thấy sản phẩm với ID này.
        </div>
    <?php endif; ?>

    <div class="mt-3">
        <a href="/WEBBANHANG/Product/list" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Quay lại danh sách sản phẩm
        </a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
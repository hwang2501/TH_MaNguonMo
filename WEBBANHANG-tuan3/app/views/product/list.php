<?php include 'app/views/shares/header.php'; ?>

<style>
    .product-card {
        transition: all 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .product-image-container {
        width: 160px;
        height: 160px;
        position: relative;
    }
    .product-image {
        object-fit: cover;
        width: 100%;
        height: 100%;
        border-radius: 8px;
    }
    .product-actions {
        min-width: 150px;
    }
    .action-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .empty-image {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-boxes me-2"></i>Danh sách sản phẩm</h1>
        <a href="/webbanhang/Product/add" class="btn btn-success btn-lg">
            <i class="fas fa-plus-circle me-2"></i>Thêm sản phẩm
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="180">Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Danh mục</th>
                            <th width="150" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr class="product-card align-middle">
                            <td>
                                <?php if (!empty($product->image)): ?>
                                <div class="product-image-container p-2">
                                    <img src="/webbanhang/<?php echo htmlspecialchars($product->image); ?>" 
                                         class="product-image shadow-sm" 
                                         alt="<?php echo htmlspecialchars($product->name); ?>">
                                </div>
                                <?php else: ?>
                                <div class="product-image-container empty-image d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-3x text-secondary"></i>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <h5 class="mb-1 fw-bold">
                                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" 
                                       class="text-decoration-none text-dark">
                                        <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                    </a>
                                </h5>
                                <small class="text-muted">ID: <?php echo $product->id; ?></small>
                            </td>
                            <td>
                                <p class="mb-0 text-muted">
                                    <?php echo !empty($product->description) ? htmlspecialchars(mb_substr($product->description, 0, 80) . (mb_strlen($product->description) > 80 ? '...' : ''), ENT_QUOTES, 'UTF-8') : 'Không có mô tả'; ?>
                                </p>
                            </td>
                            <td class="text-nowrap fw-bold text-primary fs-5">
                                <?php echo number_format($product->price, 0, ',', '.'); ?> đ
                            </td>
                            <td>
                                <span class="badge bg-info text-dark px-3 py-2">
                                    <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa phân loại'; ?>
                                </span>
                            </td>
                            <td class="product-actions text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" 
                                       class="action-btn btn btn-warning text-white"
                                       title="Sửa"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                                       class="action-btn btn btn-danger"
                                       title="Xóa"
                                       data-bs-toggle="tooltip"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" 
                                       class="action-btn btn btn-primary"
                                       title="Thêm vào giỏ"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-cart-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Kích hoạt tooltip Bootstrap
$(document).ready(function(){
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'app/views/shares/footer.php'; ?>
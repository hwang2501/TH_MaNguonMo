<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Giỏ hàng</h1>
                <span class="badge bg-primary rounded-pill">
                    <?php echo !empty($cart) ? count($cart) : '0'; ?> sản phẩm
                </span>
            </div>

            <?php if (!empty($cart)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="120">Sản phẩm</th>
                                        <th>Thông tin</th>
                                        <th width="150">Giá</th>
                                        <th width="180">Số lượng</th>
                                        <th width="150">Thành tiền</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    foreach ($cart as $id => $item): 
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $total += $itemTotal;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if ($item['image']): ?>
                                            <img src="/webbanhang/<?php echo $item['image']; ?>" 
                                                 class="img-thumbnail" 
                                                 alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                            <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 80px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h5 class="mb-1"><?php echo htmlspecialchars($item['name']); ?></h5>
                                            <small class="text-muted">Mã SP: <?php echo $id; ?></small>
                                        </td>
                                        <td class="text-nowrap">
                                            <?php echo number_format($item['price'], 0, ',', '.'); ?> đ
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <a href="/webbanhang/Product/decrease/<?php echo $id; ?>" 
                                                   class="btn btn-outline-secondary">
                                                    <i class="fas fa-minus"></i>
                                                </a>
                                                <input type="text" 
                                                       class="form-control text-center" 
                                                       value="<?php echo $item['quantity']; ?>" 
                                                       readonly>
                                                <a href="/webbanhang/Product/increase/<?php echo $id; ?>" 
                                                   class="btn btn-outline-secondary">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-nowrap fw-bold">
                                            <?php echo number_format($itemTotal, 0, ',', '.'); ?> đ
                                        </td>
                                        <td class="text-end">
                                            <a href="/webbanhang/Product/remove/<?php echo $id; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted">Giỏ hàng của bạn đang trống</h3>
                        <p class="text-muted">Hãy thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm</p>
                        <a href="/webbanhang/Product" class="btn btn-primary mt-3">
                            <i class="fas fa-store me-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($cart)): ?>
        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">Tóm tắt đơn hàng</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span><?php echo number_format($total, 0, ',', '.'); ?> đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Phí vận chuyển:</span>
                        <span>0 đ</span> <!-- Có thể thay bằng tính phí thực tế -->
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Tổng cộng:</span>
                        <span class="text-primary"><?php echo number_format($total, 0, ',', '.'); ?> đ</span>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="/webbanhang/Product/checkout" class="btn btn-primary w-100 py-2">
                        <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                    </a>
                    <a href="/webbanhang/Product" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
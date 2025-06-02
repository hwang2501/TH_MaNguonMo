<?php include 'app/views/shares/header.php'; ?>

<style>
.list-group {
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}

.list-group-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
}

.list-group-item h2 {
    flex: 2;
    margin: 0;
    font-size: 1.25rem;
    word-break: break-word;
}

.list-group-item img {
    flex: 1;
    max-width: 100px;
    max-height: 80px;
    object-fit: contain;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.list-group-item p,
.list-group-item .quantity-controls {
    flex: 1;
    margin: 0;
    font-size: 1rem;
    text-align: center;
}

.quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.quantity-controls form {
    margin: 0;
}

.quantity-controls button {
    padding: 2px 8px;
    font-size: 1rem;
}

.list-group-item .total-price {
    flex: 1;
    font-weight: 700;
    text-align: right;
    margin-left: auto;
}

h3.text-end {
    text-align: right;
}
</style>

<h1>Giỏ hàng</h1>

<?php if (!empty($cart)): ?>
    <ul class="list-group">
        <?php
        $totalAll = 0; // tổng tiền toàn giỏ
        foreach ($cart as $id => $item):
            $totalPrice = $item['price'] * $item['quantity'];
            $totalAll += $totalPrice;
        ?>
            <li class="list-group-item">
                <h2><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h2>

                <?php if ($item['image']): ?>
                    <img src="/webbanhang/<?php echo $item['image']; ?>" alt="Product Image">
                <?php else: ?>
                    <div style="flex:1; text-align:center; color:#999;">No image</div>
                <?php endif; ?>

                <p>Giá:<br> <?php echo number_format($item['price'], 0, ',', '.'); ?> VND</p>

                <div class="quantity-controls">
                    <!-- Form giảm số lượng -->
                    <form action="/webbanhang/Product/updateQuantity/<?php echo $id; ?>" method="post">
                        <input type="hidden" name="quantity" value="<?php echo max(1, $item['quantity'] - 1); ?>">
                        <button type="submit" class="btn btn-sm btn-outline-primary">-</button>
                    </form>

                    <!-- Hiển thị số lượng -->
                    <span><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></span>

                    <!-- Form tăng số lượng -->
                    <form action="/webbanhang/Product/updateQuantity/<?php echo $id; ?>" method="post">
                        <input type="hidden" name="quantity" value="<?php echo $item['quantity'] + 1; ?>">
                        <button type="submit" class="btn btn-sm btn-outline-primary">+</button>
                    </form>
                </div>

                <p class="total-price">
                    Thành tiền:<br> <?php echo number_format($totalPrice, 0, ',', '.'); ?> VND
                </p>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3 class="mt-4 text-end">
        Tổng cộng: <span class="text-success"><?php echo number_format($totalAll, 0, ',', '.'); ?> VND</span>
    </h3>
<?php else: ?>
    <p>Giỏ hàng của bạn đang trống.</p>
<?php endif; ?>

<a href="/webbanhang/Product" class="btn btn-secondary mt-2">Tiếp tục mua sắm</a>
<a href="/webbanhang/Product/checkout" class="btn btn-secondary mt-2">Thanh Toán</a>

<?php include 'app/views/shares/footer.php'; ?>

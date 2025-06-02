<?php include 'app/views/shares/header.php'; ?> 

<h1 class="mb-4" style="text-align:center; color:#007a7a; font-weight: 900; letter-spacing: 2px;">Danh sách sản phẩm</h1>
<div style="text-align:center; margin-bottom:30px;">
    <a href="/webbanhang/Product/add" class="btn btn-success px-4 py-2 rounded-pill fw-bold" style="font-size:1.1rem; letter-spacing:1px;">
        <i class="fas fa-plus me-2"></i> Thêm sản phẩm mới
    </a>
</div>

<div style="
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
    gap: 25px;
    padding: 0 15px;
">
    <?php foreach ($products as $product): ?> 
        <div style="background:#fff; border-radius: 15px; box-shadow: 0 4px 15px rgb(0 115 115 / 0.1); padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" style="text-decoration:none; color:#004d4d;">
                <h2 style="font-weight: 700; font-size: 1.3rem; margin-bottom: 12px; border-bottom: 2px solid #00b3b3; padding-bottom: 5px;">
                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                </h2>
            </a>
            <?php if ($product->image): ?> 
                <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product Image" style="width: 100%; max-height: 150px; object-fit: contain; margin-bottom: 15px; border-radius: 10px; background: #f0fafa;">
            <?php else: ?>
                <div style="width: 100%; height: 150px; background: #f0fafa; display: flex; align-items: center; justify-content: center; color: #bbb; font-style: italic; margin-bottom: 15px; border-radius: 10px;">
                    No Image
                </div>
            <?php endif; ?>
            <p style="color: #007a7a; font-weight: 600; margin-bottom: 8px; min-height: 50px; overflow: hidden; text-overflow: ellipsis;">
                <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <p style="font-weight: 700; color: #004d4d; margin-bottom: 8px;">
                Giá: <span style="color: #00b3b3;"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</span>
            </p>
            <p style="font-style: italic; font-size: 0.9rem; color: #007a7a; margin-bottom: 15px;">
                Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
            </p>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <?php if (SessionHelper::isAdmin()): ?>
                <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" 
                   style="flex: 1 1 100px; background: #ffc107; color: #222; padding: 8px 10px; border-radius: 30px; font-weight: 700; text-align: center; text-decoration: none; transition: background 0.3s;"
                   onmouseover="this.style.background='#e0a800';" onmouseout="this.style.background='#ffc107';"
                >
                    <i class="fas fa-edit me-1"></i> Sửa
                </a>
                <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                   class="delete-btn"
                   style="flex: 1 1 100px; background: #dc3545; color: #fff; padding: 8px 10px; border-radius: 30px; font-weight: 700; text-align: center; text-decoration: none; transition: background 0.3s;"
                   onmouseover="this.style.background='#b02a37';" onmouseout="this.style.background='#dc3545';"
                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"
                >
                    <i class="fas fa-trash me-1"></i> Xóa
                </a>
                <?php endif; ?>
                <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" 
                   style="flex: 1 1 140px; background: #007a7a; color: #fff; padding: 8px 10px; border-radius: 30px; font-weight: 700; text-align: center; text-decoration: none; transition: background 0.3s;"
                   onmouseover="this.style.background='#004d4d';" onmouseout="this.style.background='#007a7a';"
                >
                    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                </a>
            </div>
        </div> 
    <?php endforeach; ?> 
</div>

<style>
  /* Hover cho tất cả các nút */
  a.btn, a.delete-btn {
    cursor: pointer;
  }
</style>

<?php include 'app/views/shares/footer.php'; ?>

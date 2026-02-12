<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$cart_items = getCartItems();
$cart_total = getCartTotal();

// Xử lý cập nhật giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $product_id => $quantity) {
            updateCartQuantity($product_id, intval($quantity));
        }
        header('Location: cart.php');
        exit();
    } elseif (isset($_POST['remove_item'])) {
        removeFromCart(intval($_POST['product_id']));
        header('Location: cart.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Jenkinson's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container my-5">
        <h2 class="mb-4">Giỏ hàng</h2>
        
        <?php if (empty($cart_items)): ?>
            <div class="alert alert-info">
                <p class="mb-0">Giỏ hàng của bạn đang trống. <a href="index.php">Tiếp tục mua sắm</a></p>
            </div>
        <?php else: ?>
            <form method="POST" action="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): 
                                $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                                $subtotal = $price * $item['cart_quantity'];
                            ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($item['image']): ?>
                                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" style="width: 80px; height: 80px; object-fit: cover; margin-right: 15px;">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo htmlspecialchars($item['product_name']); ?></strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo formatCurrency($price); ?></td>
                                    <td>
                                        <input type="number" name="quantity[<?php echo $item['product_id']; ?>]" value="<?php echo $item['cart_quantity']; ?>" min="1" class="form-control" style="width: 80px;">
                                    </td>
                                    <td><?php echo formatCurrency($subtotal); ?></td>
                                    <td>
                                        <button type="submit" name="remove_item" value="1" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td colspan="2"><strong><?php echo formatCurrency($cart_total); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="index.php" class="btn btn-secondary">Tiếp tục mua sắm</a>
                    <div>
                        <button type="submit" name="update_cart" class="btn btn-warning me-2">Cập nhật giỏ hàng</button>
                        <a href="checkout.php" class="btn btn-primary">Thanh toán</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

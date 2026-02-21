<?php
$currentSite = 'sweet-shop';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Sweet Shop category_id = 3
$sweet_products = getProductsByCategory(3);

// Handle form submission: set quantity for each selected product, then redirect to cart page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    foreach ($sweet_products as $p) {
        $pid = (int) $p['product_id'];
        $qty = isset($_POST['quantity'][$pid]) ? max(0, intval($_POST['quantity'][$pid])) : 0;
        updateCartQuantity($pid, $qty);
    }
    header('Location: ../product/cart.php');
    exit;
}

include __DIR__ . '/../includes/header.php';

// Current quantities in cart (for pre-fill)
$cart = $_SESSION['cart'] ?? [];
?>

<section class="sweetshop-order-page py-5">
    <div class="container">
        <h1 class="mb-2">Select Products &amp; Quantity</h1>
        <p class="text-muted mb-4">Choose the items you want to buy and enter quantities, then click <strong>Add to Cart</strong> to view your cart.</p>

        <form method="post" action="">
            <input type="hidden" name="add_to_cart" value="1">
            <div class="table-responsive">
                <table class="table table-bordered align-middle sweetshop-order-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Product</th>
                            <th class="text-end">Price</th>
                            <th class="text-center" style="width: 140px;">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sweet_products as $p):
                            $price = !empty($p['sale_price']) ? $p['sale_price'] : $p['price'];
                            $imgSrc = !empty($p['image']) ? '../' . htmlspecialchars($p['image']) : '../img/sweetshop/p1.jpg';
                            $currentQty = isset($cart[$p['product_id']]) ? (int) $cart[$p['product_id']] : 0;
                        ?>
                        <tr>
                            <td>
                                <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" class="img-fluid rounded" style="width: 70px; height: 70px; object-fit: cover;">
                            </td>
                            <td><strong><?= htmlspecialchars($p['product_name']) ?></strong></td>
                            <td class="text-end"><?= formatCurrency($price) ?></td>
                            <td class="text-center">
                                <input type="number"
                                       name="quantity[<?= (int) $p['product_id'] ?>]"
                                       value="<?= $currentQty ?>"
                                       min="0"
                                       class="form-control form-control-sm text-center mx-auto"
                                       style="width: 90px;">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <button type="submit" name="add_to_cart" class="btn btn-primary px-4">Add to Cart</button>
                <a href="../product/cart.php" class="btn btn-outline-secondary">View Cart</a>
                <a href="sweet-shop.php" class="btn btn-link text-muted">← Back to Sweet Shop</a>
            </div>
        </form>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>

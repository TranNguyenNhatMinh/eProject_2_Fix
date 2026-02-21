<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/experience-data.php';

$currentPage = 'cart';
$cart_items = getCartItems();
$cart_total = getCartTotal();
$experience_cart_items = getExperienceCartItems();
$experience_cart_total = getExperienceCartTotal();
$all_cart_total = getAllCartTotal();
$imgBase = '../';
$currentSite = $_SESSION['current_site'] ?? 'aquarium';

// Remove product via GET (avoid nested forms)
if (isset($_GET['remove'])) {
    $pid = intval($_GET['remove']);
    if ($pid > 0) {
        removeFromCart($pid);
    }
    header('Location: cart.php');
    exit();
}

// Remove experience via GET
if (isset($_GET['remove_experience'])) {
    $key = $_GET['remove_experience'];
    removeExperienceFromCart($key);
    header('Location: cart.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        // Update products
        if (isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $product_id => $quantity) {
                updateCartQuantity($product_id, intval($quantity));
            }
        }
        // Update experiences
        if (isset($_POST['experience_quantity'])) {
            foreach ($_POST['experience_quantity'] as $key => $quantity) {
                updateExperienceCartQuantity($key, intval($quantity));
            }
        }
        header('Location: cart.php');
        exit();
    }
}

include __DIR__ . '/../includes/header.php';
?>
<main class="flex-grow-1">
    <div class="container my-5">
        <h2 class="mb-4">Shopping Cart</h2>

        <?php if (empty($cart_items) && empty($experience_cart_items)): ?>
            <div class="alert alert-info">
                <p class="mb-0">Your cart is empty.</p>
                <p>
                    <a href="../index.php">Home</a><br> 
                    <a href="../componets/boardwalk.php">Book at Boardwalk</a><br>
                    <a href="../componets/sweet-shop.php">Shop at Sweet Shop</a>
                </p>
            </div>
        <?php else: ?>
            <form method="POST" action="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product / Experience</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Products -->
                            <?php foreach ($cart_items as $item):
                                $price = $item['sale_price'] ? $item['sale_price'] : $item['price'];
                                $subtotal = $price * $item['cart_quantity'];
                            ?>
                                <tr class="cart-row cart-row-product" data-unit-price="<?php echo htmlspecialchars($price); ?>">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($item['image'])): ?>
                                                <img src="<?php echo $imgBase . htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" style="width: 80px; height: 80px; object-fit: cover; margin-right: 15px;">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?php echo htmlspecialchars($item['product_name']); ?></strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart-unit-price"><?php echo formatCurrency($price); ?></td>
                                    <td>
                                        <input type="number" name="quantity[<?php echo $item['product_id']; ?>]" value="<?php echo $item['cart_quantity']; ?>" min="1" class="form-control cart-qty-input" style="width: 80px;">
                                    </td>
                                    <td class="cart-subtotal"><?php echo formatCurrency($subtotal); ?></td>
                                    <td>
                                        <a href="cart.php?remove=<?php echo (int)$item['product_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this product?');">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <!-- Experiences -->
                            <?php foreach ($experience_cart_items as $key => $exp_item):
                                $experience = getExperienceBySlug($exp_item['slug']);
                                if ($experience):
                                    $price = $experience['price'];
                                    $subtotal = $price * $exp_item['quantity'];
                                    $imagePath = $imgBase . $experience['image'];
                            ?>
                                <tr class="cart-row cart-row-experience" data-unit-price="<?php echo htmlspecialchars($price); ?>" data-cart-key="<?php echo htmlspecialchars($key); ?>">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($experience['title']); ?>" style="width: 80px; height: 80px; object-fit: cover; margin-right: 15px;">
                                            <div>
                                                <strong><?php echo htmlspecialchars($experience['title']); ?></strong>
                                                <?php if (!empty($exp_item['certificate_name'])): ?>
                                                    <br><small class="text-muted">Certificate: <?php echo htmlspecialchars($exp_item['certificate_name']); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart-unit-price"><?php echo formatCurrency($price); ?></td>
                                    <td>
                                        <input type="number" name="experience_quantity[<?php echo htmlspecialchars($key); ?>]" value="<?php echo $exp_item['quantity']; ?>" min="1" class="form-control cart-qty-input cart-qty-input-experience" style="width: 80px;">
                                    </td>
                                    <td class="cart-subtotal"><?php echo formatCurrency($subtotal); ?></td>
                                    <td>
                                        <a href="cart.php?remove_experience=<?php echo urlencode($key); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this experience?');">Remove</a>
                                    </td>
                                </tr>
                            <?php 
                                endif;
                            endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td colspan="2"><strong id="cart-grand-total"><?php echo formatCurrency($all_cart_total); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="cart-navigation-buttons d-flex justify-content-between mt-4 flex-wrap gap-2">
                    <div class="cart-nav-left d-flex gap-2 flex-wrap">
                        <a href="../index.php" class="btn-cart-nav btn-cart-nav-home">Home</a>
                        <a href="../index.php" class="btn-cart-nav btn-cart-nav-aquarium">Aquarium</a>
                        <a href="../componets/sweet-shop.php" class="btn-cart-nav btn-cart-nav-sweet-shop">Sweet Shop</a>
                    </div>
                    <div class="cart-nav-right">
                        <input type="hidden" name="update_cart" value="1">
                        <a href="checkout.php" class="btn-cart-nav btn-cart-nav-checkout">Checkout</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (!empty($cart_items) || !empty($experience_cart_items)): ?>
    <script>
    (function() {
        function formatMoney(n) { return '$' + Number(n).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ','); }
        var form = document.querySelector('form[method="POST"]');
        var rows = form ? form.querySelectorAll('.cart-row') : [];
        var totalEl = document.getElementById('cart-grand-total');
        var updateTimer = null;
        function updateRow(row) {
            var price = parseFloat(row.getAttribute('data-unit-price'), 10) || 0;
            var input = row.querySelector('.cart-qty-input');
            var subtotalEl = row.querySelector('.cart-subtotal');
            if (!input || !subtotalEl) return;
            var qty = parseInt(input.value, 10) || 0;
            if (qty < 1) qty = 1;
            input.value = qty;
            subtotalEl.textContent = formatMoney(price * qty);
        }
        function updateTotal() {
            var total = 0;
            rows.forEach(function(row) {
                var price = parseFloat(row.getAttribute('data-unit-price'), 10) || 0;
                var input = row.querySelector('.cart-qty-input');
                if (input) total += price * (parseInt(input.value, 10) || 0);
            });
            if (totalEl) totalEl.textContent = formatMoney(total);
        }
        function onQuantityChange() {
            rows.forEach(updateRow);
            updateTotal();
            clearTimeout(updateTimer);
            updateTimer = setTimeout(function() { form.submit(); }, 600);
        }
        rows.forEach(function(row) {
            var input = row.querySelector('.cart-qty-input');
            if (input) {
                input.addEventListener('input', onQuantityChange);
                input.addEventListener('change', onQuantityChange);
            }
        });
    })();
    </script>
<?php endif; ?>
</body>
</html>

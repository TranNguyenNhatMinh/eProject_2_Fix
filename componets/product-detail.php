<?php
session_start();
$currentSite = 'sweet-shop';
$currentPage = 'product-detail';
require_once __DIR__ . '/../includes/functions.php';
include '../includes/header.php';

// Get product ID from query parameter
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id <= 0) {
    header('Location: sweet-shop.php');
    exit();
}

// Get product data
$product = getProductById($product_id);

if (!$product) {
    header('Location: sweet-shop.php');
    exit();
}

$price = !empty($product['sale_price']) ? $product['sale_price'] : $product['price'];
$imgSrc = !empty($product['image']) ? '../' . htmlspecialchars($product['image']) : '../img/sweetshop/p1.jpg';

// Get related products (same category, exclude current product)
$related_products = getProductsByCategory($product['category_id'], 4);
$related_products = array_filter($related_products, function($p) use ($product_id) {
    return $p['product_id'] != $product_id;
});
$related_products = array_slice($related_products, 0, 3); // Limit to 3 products
?>

<main class="flex-grow-1">
    <div class="product-detail-container">
        <div class="container py-5">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="product-breadcrumb mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="sweet-shop.php">Sweet Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['product_name']); ?></li>
                </ol>
            </nav>

            <!-- Success Message -->
            <div id="cart-success-message" class="alert alert-success alert-dismissible fade" role="alert" style="display: none;">
                <span id="cart-success-text"></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- Main Content -->
            <div class="row g-4 mb-5">
                <!-- Left Column - Image -->
                <div class="col-lg-6">
                    <div class="product-image-wrapper">
                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>" 
                             class="product-main-image">
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div class="col-lg-6">
                    <div class="product-details">
                        <p class="product-category">SWEET SHOP</p>
                        <h1 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
                        <div class="product-price" id="product-base-price" data-price="<?php echo $price; ?>"><?php echo formatCurrency($price); ?></div>

                        <?php if (!empty($product['description'])): ?>
                        <div class="product-description">
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>
                        <?php endif; ?>

                        <form id="add-to-cart-form">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            
                            <div class="product-total">
                                <div class="total-label">Final Total:</div>
                                <div class="total-amount" id="final-total"><?php echo formatCurrency($price); ?></div>
                            </div>

                            <div class="product-actions">
                                <div class="quantity-selector">
                                    <label for="quantity" class="visually-hidden">Quantity</label>
                                    <div class="quantity-controls">
                                        <button type="button" class="qty-btn qty-minus" aria-label="Giảm số lượng">−</button>
                                        <input type="number" 
                                               id="quantity" 
                                               name="quantity"
                                               class="form-control quantity-input" 
                                               value="1" 
                                               min="1" 
                                               max="99"
                                               onchange="updateTotal()">
                                        <button type="button" class="qty-btn qty-plus" aria-label="Tăng số lượng">+</button>
                                    </div>
                                </div>
                                <button type="submit" class="btn-add-to-cart" id="add-to-cart-btn">
                                    Add to Cart
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            <?php if (!empty($related_products)): ?>
            <div class="related-products-section">
                <h2 class="related-products-title">You May Also Like</h2>
                <div class="row g-4">
                    <?php foreach ($related_products as $related): 
                        $relatedPrice = !empty($related['sale_price']) ? $related['sale_price'] : $related['price'];
                        $relatedImgSrc = !empty($related['image']) ? '../' . htmlspecialchars($related['image']) : '../img/sweetshop/p1.jpg';
                    ?>
                    <div class="col-md-4">
                        <div class="related-product-card">
                            <a href="product-detail.php?id=<?= $related['product_id'] ?>" class="related-product-link">
                                <div class="related-product-image-wrapper">
                                    <img src="<?= $relatedImgSrc ?>" alt="<?= htmlspecialchars($related['product_name']) ?>" class="related-product-image">
                                </div>
                                <div class="related-product-info">
                                    <h3 class="related-product-title"><?= htmlspecialchars($related['product_name']) ?></h3>
                                    <p class="related-product-price"><?= formatCurrency($relatedPrice) ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/pages/product-detail.js?v=<?= time() ?>"></script>

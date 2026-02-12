<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();

$conn = getDBConnection();
$products = [];
$categories = getCategories();

// Add / Edit / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $category_id = intval($_POST['category_id']);
        $product_name = sanitize($_POST['product_name']);
        $slug = sanitize($_POST['slug'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        $short_description = sanitize($_POST['short_description'] ?? '');
        $price = floatval($_POST['price']);
        $sale_price = !empty($_POST['sale_price']) ? floatval($_POST['sale_price']) : null;
        $stock_quantity = intval($_POST['stock_quantity']);
        $sku = sanitize($_POST['sku'] ?? '');
        $image = sanitize($_POST['image'] ?? '');
        $status = sanitize($_POST['status'] ?? 'active');
        $featured = isset($_POST['featured']) ? 1 : 0;
        
        if (empty($slug)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product_name)));
        }
        
        $stmt = $conn->prepare("INSERT INTO products (category_id, product_name, slug, description, short_description, price, sale_price, stock_quantity, sku, image, status, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssdississ", $category_id, $product_name, $slug, $description, $short_description, $price, $sale_price, $stock_quantity, $sku, $image, $status, $featured);
        
        if ($stmt->execute()) {
            header('Location: products.php?success=1');
            exit();
        }
        $stmt->close();
    } elseif (isset($_POST['update_product'])) {
        $product_id = intval($_POST['product_id']);
        $category_id = intval($_POST['category_id']);
        $product_name = sanitize($_POST['product_name']);
        $slug = sanitize($_POST['slug'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        $short_description = sanitize($_POST['short_description'] ?? '');
        $price = floatval($_POST['price']);
        $sale_price = !empty($_POST['sale_price']) ? floatval($_POST['sale_price']) : null;
        $stock_quantity = intval($_POST['stock_quantity']);
        $sku = sanitize($_POST['sku'] ?? '');
        $image = sanitize($_POST['image'] ?? '');
        $status = sanitize($_POST['status'] ?? 'active');
        $featured = isset($_POST['featured']) ? 1 : 0;
        
        $stmt = $conn->prepare("UPDATE products SET category_id = ?, product_name = ?, slug = ?, description = ?, short_description = ?, price = ?, sale_price = ?, stock_quantity = ?, sku = ?, image = ?, status = ?, featured = ? WHERE product_id = ?");
        $stmt->bind_param("isssssdississi", $category_id, $product_name, $slug, $description, $short_description, $price, $sale_price, $stock_quantity, $sku, $image, $status, $featured, $product_id);
        
        if ($stmt->execute()) {
            header('Location: products.php?success=1');
            exit();
        }
        $stmt->close();
    } elseif (isset($_POST['delete_product'])) {
        $product_id = intval($_POST['product_id']);
        $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->close();
        header('Location: products.php?success=1');
        exit();
    }
}

// Fetch products list
$result = $conn->query("SELECT p.*, c.category_name FROM products p LEFT JOIN categories c ON p.category_id = c.category_id ORDER BY p.created_at DESC");
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
$conn->close();

$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_product = getProductById(intval($_GET['edit']));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-page">
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            
            <div class="admin-content">
                <div class="admin-header">
                    <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Open menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h2><i class="fa-solid fa-box"></i> Products</h2>
                </div>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Action completed successfully!</div>
                <?php endif; ?>
                
                <!-- Form thêm/sửa -->
                <div class="admin-form-card mb-4">
                    <div class="card-header">
                        <h5><i class="fa-solid fa-<?php echo $edit_product ? 'edit' : 'plus'; ?> me-2"></i><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h5>
                    </div>
                    <div>
                        <form method="POST">
                            <?php if ($edit_product): ?>
                                <input type="hidden" name="product_id" value="<?php echo $edit_product['product_id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" name="category_id" required>
                                        <option value="">Select category</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat['category_id']; ?>" <?php echo ($edit_product && $edit_product['category_id'] == $cat['category_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($cat['category_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text" class="form-control" name="product_name" value="<?php echo $edit_product ? htmlspecialchars($edit_product['product_name']) : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" value="<?php echo $edit_product ? htmlspecialchars($edit_product['slug']) : ''; ?>">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" name="sku" value="<?php echo $edit_product ? htmlspecialchars($edit_product['sku']) : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea class="form-control" name="short_description" rows="2"><?php echo $edit_product ? htmlspecialchars($edit_product['short_description']) : ''; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="4"><?php echo $edit_product ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Price *</label>
                                    <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sale Price</label>
                                    <input type="number" step="0.01" class="form-control" name="sale_price" value="<?php echo $edit_product ? $edit_product['sale_price'] : ''; ?>">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Quantity *</label>
                                    <input type="number" class="form-control" name="stock_quantity" value="<?php echo $edit_product ? $edit_product['stock_quantity'] : ''; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Image (URL)</label>
                                <input type="text" class="form-control" name="image" value="<?php echo $edit_product ? htmlspecialchars($edit_product['image']) : ''; ?>">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="active" <?php echo ($edit_product && $edit_product['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($edit_product && $edit_product['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                        <option value="out_of_stock" <?php echo ($edit_product && $edit_product['status'] == 'out_of_stock') ? 'selected' : ''; ?>>Out of Stock</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Featured</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="featured" value="1" <?php echo ($edit_product && $edit_product['featured']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Featured product</label>
                                    </div>
                                </div>
                            </div>
                            
                                <button type="submit" name="<?php echo $edit_product ? 'update_product' : 'add_product'; ?>" class="admin-btn admin-btn-primary">
                                    <i class="fa-solid fa-<?php echo $edit_product ? 'save' : 'plus'; ?> me-2"></i><?php echo $edit_product ? 'Update' : 'Add New'; ?>
                                </button>
                                
                                <?php if ($edit_product): ?>
                                    <a href="products.php" class="admin-btn admin-btn-secondary ms-2">Cancel</a>
                                <?php endif; ?>
                        </form>
                    </div>
                </div>
                
                <!-- Product list -->
                <div class="admin-table">
                    <div class="card-header" style="padding: 1.5rem; background: white; border-bottom: 2px solid #f0f0f0;">
                        <h5 style="margin: 0; font-weight: 700; color: #1e3a5f;">
                            <i class="fa-solid fa-list me-2"></i>Product List
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?php echo $product['product_id']; ?></td>
                                            <td>
                                                <?php if ($product['image']): ?>
                                                    <img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($product['category_name'] ?? '-'); ?></td>
                                            <td><?php echo formatCurrency($product['price']); ?></td>
                                            <td><?php echo $product['stock_quantity']; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $product['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                                    <?php echo $product['status']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="?edit=<?php echo $product['product_id']; ?>" class="admin-btn admin-btn-warning admin-btn-sm">
                                                    <i class="fa-solid fa-edit me-1"></i>Edit
                                                </a>
                                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete?');">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                    <button type="submit" name="delete_product" class="admin-btn admin-btn-danger admin-btn-sm ms-1">
                                                        <i class="fa-solid fa-trash me-1"></i>Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireAdmin();

$conn = getDBConnection();

// Add / Edit / Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        $category_name = sanitize($_POST['category_name']);
        $slug = sanitize($_POST['slug'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        $image = sanitize($_POST['image'] ?? '');
        $display_order = intval($_POST['display_order'] ?? 0);
        $status = sanitize($_POST['status'] ?? 'active');
        
        if (empty($slug)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category_name)));
        }
        
        $stmt = $conn->prepare("INSERT INTO categories (category_name, slug, description, image, display_order, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $category_name, $slug, $description, $image, $display_order, $status);
        $stmt->execute();
        $stmt->close();
        
        header('Location: categories.php?success=1');
        exit();
    } elseif (isset($_POST['update_category'])) {
        $category_id = intval($_POST['category_id']);
        $category_name = sanitize($_POST['category_name']);
        $slug = sanitize($_POST['slug'] ?? '');
        $description = sanitize($_POST['description'] ?? '');
        $image = sanitize($_POST['image'] ?? '');
        $display_order = intval($_POST['display_order'] ?? 0);
        $status = sanitize($_POST['status'] ?? 'active');
        
        $stmt = $conn->prepare("UPDATE categories SET category_name = ?, slug = ?, description = ?, image = ?, display_order = ?, status = ? WHERE category_id = ?");
        $stmt->bind_param("ssssisi", $category_name, $slug, $description, $image, $display_order, $status, $category_id);
        $stmt->execute();
        $stmt->close();
        
        header('Location: categories.php?success=1');
        exit();
    } elseif (isset($_POST['delete_category'])) {
        $category_id = intval($_POST['category_id']);
        $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $stmt->close();
        
        header('Location: categories.php?success=1');
        exit();
    }
}

// Fetch categories list
$result = $conn->query("SELECT * FROM categories ORDER BY display_order ASC, category_name ASC");
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}
$conn->close();

$edit_category = null;
if (isset($_GET['edit'])) {
    foreach ($categories as $cat) {
        if ($cat['category_id'] == intval($_GET['edit'])) {
            $edit_category = $cat;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Admin</title>
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
                    <h2><i class="fa-solid fa-folder"></i> Categories</h2>
                </div>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Action completed successfully!</div>
                <?php endif; ?>
                
                <!-- Add / Edit form -->
                <div class="admin-form-card mb-4">
                    <div class="card-header">
                        <h5><i class="fa-solid fa-<?php echo $edit_category ? 'edit' : 'plus'; ?> me-2"></i><?php echo $edit_category ? 'Edit Category' : 'Add New Category'; ?></h5>
                    </div>
                    <div>
                        <form method="POST">
                            <?php if ($edit_category): ?>
                                <input type="hidden" name="category_id" value="<?php echo $edit_category['category_id']; ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category Name *</label>
                                    <input type="text" class="form-control" name="category_name" value="<?php echo $edit_category ? htmlspecialchars($edit_category['category_name']) : ''; ?>" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" value="<?php echo $edit_category ? htmlspecialchars($edit_category['slug']) : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3"><?php echo $edit_category ? htmlspecialchars($edit_category['description']) : ''; ?></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image (URL)</label>
                                    <input type="text" class="form-control" name="image" value="<?php echo $edit_category ? htmlspecialchars($edit_category['image']) : ''; ?>">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Display Order</label>
                                    <input type="number" class="form-control" name="display_order" value="<?php echo $edit_category ? $edit_category['display_order'] : '0'; ?>">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="active" <?php echo ($edit_category && $edit_category['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($edit_category && $edit_category['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" name="<?php echo $edit_category ? 'update_category' : 'add_category'; ?>" class="admin-btn admin-btn-primary">
                                <i class="fa-solid fa-<?php echo $edit_category ? 'save' : 'plus'; ?> me-2"></i><?php echo $edit_category ? 'Update' : 'Add New'; ?>
                            </button>
                            
                            <?php if ($edit_category): ?>
                                <a href="categories.php" class="admin-btn admin-btn-secondary ms-2">Cancel</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                
                <!-- Categories list -->
                <div class="admin-table">
                    <div class="card-header" style="padding: 1.5rem; background: white; border-bottom: 2px solid #f0f0f0;">
                        <h5 style="margin: 0; font-weight: 700; color: #1e3a5f;">
                            <i class="fa-solid fa-list me-2"></i>Category List
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Slug</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td><?php echo $category['category_id']; ?></td>
                                            <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                            <td><?php echo htmlspecialchars($category['slug']); ?></td>
                                            <td><?php echo $category['display_order']; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $category['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                                    <?php echo $category['status']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="?edit=<?php echo $category['category_id']; ?>" class="admin-btn admin-btn-warning admin-btn-sm">
                                                    <i class="fa-solid fa-edit me-1"></i>Edit
                                                </a>
                                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete?');">
                                                    <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">
                                                    <button type="submit" name="delete_category" class="admin-btn admin-btn-danger admin-btn-sm ms-1">
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

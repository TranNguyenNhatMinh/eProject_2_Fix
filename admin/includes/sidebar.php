<?php
/**
 * Admin Sidebar - Include for all admin pages
 */
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<div class="admin-overlay" id="adminOverlay" aria-hidden="true"></div>
<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-sidebar-header">
        <h4><i class="fa-solid fa-gear"></i> Admin Panel</h4>
        <button type="button" class="admin-sidebar-close" id="adminSidebarClose" aria-label="Close menu">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page === 'index' ? 'active' : ''; ?>" href="index.php">
                <i class="fa-solid fa-chart-line"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page === 'products' ? 'active' : ''; ?>" href="products.php">
                <i class="fa-solid fa-box"></i>Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page === 'orders' || $current_page === 'order_detail' ? 'active' : ''; ?>" href="orders.php">
                <i class="fa-solid fa-shopping-cart"></i>Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo $current_page === 'categories' ? 'active' : ''; ?>" href="categories.php">
                <i class="fa-solid fa-folder"></i>Categories
            </a>
        </li>
        <li class="nav-item divider"></li>
        <li class="nav-item">
            <a class="nav-link" href="../index.php">
                <i class="fa-solid fa-home"></i>Back to Site
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>Sign Out
            </a>
        </li>
    </ul>
</aside>
<script>
(function() {
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('adminOverlay');
    var toggle = document.getElementById('adminMenuToggle');
    var closeBtn = document.getElementById('adminSidebarClose');
    function openSidebar() {
        if (sidebar) sidebar.classList.add('show');
        if (overlay) { overlay.classList.add('show'); overlay.setAttribute('aria-hidden', 'false'); }
    }
    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('show');
        if (overlay) { overlay.classList.remove('show'); overlay.setAttribute('aria-hidden', 'true'); }
    }
    if (toggle) toggle.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
})();
</script>

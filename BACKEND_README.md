# Backend System - User Guide

## Overview

The backend system is integrated into the website with the following features:
- Registration / Login
- Cart management
- Checkout and payment
- Admin panel to manage products, orders, and categories

## Database

- **Database name:** `project_data`
- **SQL file:** `database/eproject2_database.sql` (import into phpMyAdmin)
- **Config:** `database/config.php`

## File Structure

### Core Files
- `database/config.php` - Database connection configuration
- `includes/auth.php` - Authentication functions (login, register, logout)
- `includes/functions.php` - Helper functions (products, cart, orders)

### User Pages
- `login.php` - Login page
- `register.php` - Registration page
- `logout.php` - Logout
- `cart.php` - Shopping cart
- `checkout.php` - Checkout
- `order_success.php` - Order confirmation
- `my_orders.php` - User order list
- `order_detail.php` - Order details
- `add_to_cart.php` - Add product to cart (POST)

### Admin Panel
- `admin/index.php` - Dashboard
- `admin/products.php` - Manage products
- `admin/orders.php` - Manage orders
- `admin/order_detail.php` - Order details (admin)
- `admin/categories.php` - Manage categories

## Default Login

### Admin Account:
- **Username:** `admin`
- **Password:** `admin123`
- ⚠️ **IMPORTANT:** Change the password after first login!

## How to Use

### 1. Register a new account
- Go to `register.php`
- Fill in the form and register
- You will be logged in automatically after registration

### 2. Log in
- Go to `login.php`
- Enter username/email and password
- After login, admin users are redirected to `admin/index.php`
- Regular users stay on the current page or go to `index.php`

### 3. Add product to cart
- From a product page, submit a POST form to `add_to_cart.php`:
```html
<form method="POST" action="add_to_cart.php">
    <input type="hidden" name="product_id" value="1">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="redirect" value="current_page.php">
    <button type="submit">Add to Cart</button>
</form>
```

### 4. View cart
- Click the cart icon in the header
- Or go to `cart.php`
- You can update quantity or remove items

### 5. Checkout
- From the cart, click "Checkout"
- Fill in shipping information
- Select payment method
- Submit to place the order

### 6. Admin Panel
- Log in with an admin account
- Go to `admin/index.php`
- Manage:
  - **Dashboard:** View overview statistics
  - **Products:** Add/edit/delete products
  - **Orders:** View and update order status
  - **Categories:** Manage product categories

## Security Features

- ✅ Password hashing with `password_hash()` / `password_verify()`
- ✅ Prepared statements to prevent SQL injection
- ✅ Session management
- ✅ Input sanitization
- ✅ Role-based access control (admin vs customer)

## Notes

1. **Session:** Cart uses session; it is cleared when the browser is closed (can be upgraded to save in database)
2. **File upload:** Currently only image URL is supported; file upload is not implemented
3. **Payment:** No real payment gateway integrated yet
4. **Email:** No order confirmation email

## Integration

To add an "Add to Cart" button on a product page (e.g. Sweet Shop):

```php
<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';
$products = getProductsByCategory(3); // Category ID 3 = Sweet Shop
?>

<?php foreach ($products as $product): ?>
    <div class="product-card">
        <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
        <p>Price: <?php echo formatCurrency($product['price']); ?></p>
        
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="redirect" value="componets/sweet-shop.php">
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
    </div>
<?php endforeach; ?>
```

## Troubleshooting

### Database connection error
- Check that XAMPP MySQL is running
- Check `database/config.php` has correct credentials
- Check that database `project_data` has been created

### Session not working
- Ensure `session_start()` is called at the top of the file
- Check that PHP session path is writable

### Cannot log in
- Check that password is hashed correctly
- Check that username/email exists in the database

## Support

If you encounter issues, check:
1. PHP error logs
2. MySQL error logs
3. Browser console (F12)
4. Network tab for request/response

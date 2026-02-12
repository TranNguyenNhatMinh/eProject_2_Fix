# How to Import Database into phpMyAdmin

## Step 1: Open phpMyAdmin
1. Start XAMPP
2. Open your browser and go to: `http://localhost/phpmyadmin`
3. Log in (usually no password or empty password)

## Step 2: Import Database
1. Click the **"Import"** tab in the top menu
2. Click **"Choose File"** and select: `database/eproject2_database.sql`
3. Keep the default options
4. Click **"Go"** or **"Import"**

## Step 3: Verify
After a successful import you will see:
- Database: `eproject2_db`
- Tables: `users`, `categories`, `products`, `orders`, `order_items`, `cart`

## Default Login

### Admin Account:
- **Username:** `admin`
- **Email:** `admin@eproject2.com`
- **Password:** `admin123` (⚠️ **IMPORTANT:** Change password after first login!)

## Database Structure

### 1. `users` - Users
- Manages admin and customer accounts
- Fields: user_id, username, email, password (hashed), role, status

### 2. `categories` - Categories
- Product categories (Aquarium, Boardwalk, Sweet Shop)
- Fields: category_id, category_name, slug, description

### 3. `products` - Products
- Products / tickets / merchandise
- Fields: product_id, category_id, product_name, price, stock_quantity, image

### 4. `orders` - Orders
- Order information
- Fields: order_id, user_id, order_number, total_amount, order_status, payment_status

### 5. `order_items` - Order details
- Items in each order
- Fields: item_id, order_id, product_id, quantity, product_price

### 6. `cart` - Cart
- User cart (or session-based)
- Fields: cart_id, user_id, product_id, quantity

## Security Notes

1. **Change admin password right after import**
2. File `config.php` contains database connection details
3. Do not commit `config.php` to Git if it contains sensitive data

## Database Connection Config

Edit `database/config.php` with:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP has no password
define('DB_NAME', 'eproject2_db');
?>
```

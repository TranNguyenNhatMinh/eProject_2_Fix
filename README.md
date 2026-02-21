# Jenkinson's Aquarium & Boardwalk - Website

## 📖 Giới thiệu

Website giới thiệu và đặt vé/trải nghiệm cho **Jenkinson's** – hệ thống Aquarium (Thủy cung), Boardwalk (Đi bộ ven biển) và Sweet Shop tại Point Pleasant Beach, NJ, USA.

Người dùng có thể:
- Xem thông tin, sự kiện và trải nghiệm
- Đăng ký tài khoản, đăng nhập
- Mua sản phẩm (qua Sweet Shop)
- Đặt trải nghiệm và đăng ký sự kiện (Junior Keepers, Yoga, Sensory Saturdays…)
- Thanh toán qua giỏ hàng
- Quản lý đơn hàng, hồ sơ cá nhân

Admin có thể quản lý: sản phẩm, danh mục, đơn hàng, người dùng, đăng ký sự kiện, newsletter.

---

## 🛠 Ngôn ngữ & Công nghệ

| Thành phần | Công nghệ |
|------------|-----------|
| **Backend** | PHP 7.4+ |
| **Database** | MySQL / MariaDB (qua phpMyAdmin) |
| **Frontend** | HTML5, CSS3, JavaScript |
| **Framework CSS** | Bootstrap 5 |
| **Icons** | Font Awesome 7, Bootstrap Icons |
| **Fonts** | Poppins, Source Sans 3 |
| **Server** | XAMPP (Apache + PHP + MySQL) |

---

## 📁 Cấu trúc thư mục

```
eProject_2_2/
├── admin/                 # Khu vực quản trị
│   ├── includes/          # Sidebar, layout admin
│   ├── index.php          # Dashboard
│   ├── products.php       # Quản lý sản phẩm
│   ├── categories.php     # Quản lý danh mục
│   ├── orders.php         # Danh sách đơn hàng
│   ├── order_detail.php   # Chi tiết đơn hàng
│   ├── users.php          # Quản lý người dùng
│   ├── events.php         # Danh sách sự kiện
│   ├── event_registrations.php  # Đăng ký sự kiện
│   └── subscriptions.php  # Newsletter
├── auth/                  # Xác thực
│   ├── login.php
│   ├── register.php
│   ├── logout.php
│   └── profile.php
├── product/               # Giỏ hàng, checkout
│   ├── cart.php
│   ├── checkout.php
│   ├── add_to_cart.php
│   ├── my_orders.php
│   ├── order_detail.php
│   └── order_success.php
├── componets/             # Các trang nội dung
│   ├── ourmission.php     # Về chúng tôi
│   ├── boardwalk.php      # Boardwalk
│   ├── sweet-shop.php     # Sweet Shop
│   ├── sweet-shop-order.php
│   ├── beach.php          # Bãi biển
│   ├── arcades.php
│   ├── adventure-lookout.php
│   ├── mini-golf.php
│   ├── fun-games.php
│   ├── shopping.php
│   ├── product-detail.php
│   ├── experience-detail.php
│   ├── event-detail.php
│   ├── event-register.php
│   └── add_experience_to_cart.php
├── includes/
│   ├── header.php         # Header chung
│   ├── footer.php         # Footer chung
│   ├── auth.php           # Hàm auth (login, register, requireAdmin…)
│   ├── functions.php      # Hàm tiện ích (formatCurrency, getProducts…)
│   ├── experience-data.php # Dữ liệu trải nghiệm/sự kiện
│   └── variables.css
├── css/                   # Stylesheet
├── js/                    # Script
│   ├── common/newsletter.js
│   ├── pages/homepage.js
│   └── pages/product-detail.js
├── img/                   # Hình ảnh
├── database/
│   ├── config.php         # Cấu hình kết nối DB
│   └── full_database.sql  # Schema đầy đủ
├── api/
│   └── subscribe.php      # Xử lý đăng ký newsletter
└── index.php              # Trang chủ Aquarium
```

---

## ⚙️ Cơ chế hoạt động

### 1. Xác thực (Authentication)

- **Session-based**: Dùng `$_SESSION` để lưu `user_id`, `username`, `email`, `role`.
- **Mật khẩu**: Mã hóa bằng `password_hash()` (bcrypt).
- **Phân quyền**: `role` = `admin` hoặc `customer`.
- **Bảo vệ trang**: `requireLogin()`, `requireAdmin()` trong `includes/auth.php`.

### 2. Giỏ hàng (Cart)

- **Sản phẩm**: Lưu trong `$_SESSION['cart']` dạng `[product_id => quantity]`.
- **Trải nghiệm**: Lưu trong `$_SESSION['experience_cart']` dạng mảng `[slug, quantity, certificate_name]`.
- **Thêm sản phẩm**: `product/add_to_cart.php` (POST).
- **Thêm trải nghiệm**: `componets/add_experience_to_cart.php` (POST).

### 3. Đơn hàng (Orders)

- User đặt hàng tại `product/checkout.php`.
- Thông tin đơn lưu vào bảng `orders`, chi tiết sản phẩm/trải nghiệm vào `order_items`.
- Trải nghiệm dùng `product_id = 0`, tên lưu trong `product_name`.

### 4. Sự kiện (Events) & Trải nghiệm (Experiences)

- Dữ liệu tĩnh trong `includes/experience-data.php` (mảng `$experiences`).
- Có 2 loại:
  - **Experiences**: Penguin Encounter, Yoga, Otter Encounter, Shark Encounter…
  - **Events**: Junior Keepers, Yoga Event (có form đăng ký với certificate/guardian).
- Đăng ký event lưu vào `event_registrations`.

### 5. Newsletter

- Form ở footer gửi qua AJAX tới `api/subscribe.php`.
- Email lưu vào bảng `subscriptions`.

---

## 🗄 Database

- **Database**: `project_data`
- **Bảng chính**: `users`, `categories`, `products`, `orders`, `order_items`, `subscriptions`, `event_registrations`

**Import database**

1. Mở phpMyAdmin.
2. Tạo database `project_data` (hoặc dùng sẵn).
3. Import file `database/full_database.sql`.

**Cấu hình kết nối**

Chỉnh sửa `database/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');     
define('DB_NAME', 'project_data');
```

---

## 🚀 Cài đặt & Chạy

**Yêu cầu**

- XAMPP (Apache + PHP 7.4+ + MySQL)
- Trình duyệt web

**Các bước**

1. Copy project vào `C:\xampp\htdocs\eProject_2_2`
2. Khởi động Apache và MySQL trong XAMPP
3. Import `database/full_database.sql` qua phpMyAdmin
4. Kiểm tra `database/config.php`
5. Truy cập: `http://localhost/eProject_2_2/`

---

## 🔐 Chức năng Admin

- **Dashboard**: Tổng quan đơn hàng
- **Products**: CRUD sản phẩm
- **Categories**: Quản lý danh mục
- **Orders**: Xem đơn, cập nhật trạng thái
- **Users**: Quản lý user (active/inactive/banned)
- **Events**: Danh sách sự kiện và số đăng ký
- **Event Registrations**: Chi tiết người đăng ký theo event
- **Subscriptions**: Danh sách email newsletter

**Truy cập admin**: `http://localhost/eProject_2_2/admin/` (cần đăng nhập với role admin).

---

## 🌐 Các trang chính

| Trang | URL | Mô tả |
|-------|-----|-------|
| Trang chủ | `index.php` | Aquarium – Hero, About, Upcoming Events, Featured Experiences |
| Boardwalk | `componets/boardwalk.php` | Nội dung Boardwalk |
| Sweet Shop | `componets/sweet-shop.php` | Cửa hàng, sản phẩm |
| Trải nghiệm | `componets/experience-detail.php?experience=slug` | Chi tiết trải nghiệm |
| Sự kiện | `componets/event-detail.php?event=slug` | Chi tiết & đăng ký sự kiện |
| Giỏ hàng | `product/cart.php` | Xem và sửa giỏ hàng |
| Thanh toán | `product/checkout.php` | Đặt hàng (cần đăng nhập) |
| Đơn hàng | `product/my_orders.php` | Lịch sử đơn hàng |

---

## 📝 Ghi chú

- **Design system**: CSS variables trong `css/variables.css`.
- **Responsive**: Tối ưu cho desktop, tablet, mobile.
- **Bảo mật**: Đã có xử lý XSS, open redirect, SQL injection cho các vùng nhạy cảm.
- **Dữ liệu trải nghiệm**: Hiện lưu trong file PHP, có thể chuyển sang database sau.

---

## 📄 License

Dự án học tập / thực hành.

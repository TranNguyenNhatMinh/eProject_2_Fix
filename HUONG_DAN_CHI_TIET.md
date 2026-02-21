# 📚 Hướng dẫn chi tiết: Hiểu và chỉnh sửa code Website Jenkinson's

> **Dành cho người chưa biết lập trình** – tài liệu này giúp bạn hiểu cấu trúc website và cách thay đổi nội dung cơ bản.

---

## MỤC 1: Website hoạt động như thế nào?

### 1.1. Website là gì?

Website gồm 3 phần chính:

| Thành phần | Vai trò | Ví dụ |
|------------|---------|-------|
| **HTML** | Nội dung: chữ, hình, nút | Tiêu đề, đoạn văn, ảnh |
| **CSS** | Giao diện: màu sắc, bố cục, font chữ | Màu nền, khoảng cách, bo góc |
| **JavaScript** | Hành vi: bấm nút, chuyển slide, gửi form | Nút prev/next, đăng ký newsletter |

### 1.2. PHP và Database (Backend)

| Thành phần | Vai trò |
|------------|---------|
| **PHP** | Tạo trang động: lấy dữ liệu từ database, xử lý đăng nhập, giỏ hàng |
| **Database (MySQL)** | Lưu trữ: users, sản phẩm, đơn hàng, đăng ký |

**Ví dụ**: Khi bạn mở trang giỏ hàng, PHP đọc dữ liệu từ database rồi tạo HTML hiển thị.

---

## MỤC 2: Cấu trúc thư mục – Từng folder làm gì?

```
eProject_2_2/
│
├── index.php              ← Trang chủ Aquarium (điểm vào đầu tiên)
├── includes/              ← Phần dùng chung (header, footer, hàm)
├── componets/             ← Các trang con: Boardwalk, Sweet Shop, sự kiện...
├── product/               ← Giỏ hàng, thanh toán, đơn hàng
├── auth/                  ← Đăng nhập, đăng ký, profile
├── admin/                 ← Khu vực quản trị (sản phẩm, đơn, user)
├── css/                   ← File định dạng giao diện
├── js/                    ← File JavaScript (hiệu ứng, tương tác)
├── img/                   ← Hình ảnh
├── database/              ← Cấu hình database, file import
└── api/                   ← Xử lý AJAX (ví dụ: đăng ký newsletter)
```

### Giải thích ngắn gọn

| Thư mục | Nội dung |
|---------|----------|
| `includes/` | Header (menu, logo), footer (copyright, form newsletter), `auth.php`, `functions.php` – dùng lại ở nhiều trang |
| `componets/` | Các trang nội dung: Boardwalk, Sweet Shop, chi tiết sản phẩm, sự kiện... |
| `product/` | Giỏ hàng (`cart.php`), thanh toán (`checkout.php`), lịch sử đơn (`my_orders.php`) |
| `auth/` | Đăng nhập, đăng ký, đăng xuất, sửa profile |
| `admin/` | Trang admin: quản lý sản phẩm, đơn hàng, user, đăng ký sự kiện |

---

## MỤC 3: Khi mở một trang, điều gì xảy ra?

### Bước 1: Gõ URL

Ví dụ: `http://localhost/eProject_2_2/index.php`

### Bước 2: Server (XAMPP) xử lý

1. Đọc file `index.php`
2. PHP chạy code trong file đó
3. Gọi `include 'includes/header.php'` → chèn header (logo, menu)
4. In ra HTML của trang chủ (Hero, About, Events, Experiences)
5. Gọi `include 'includes/footer.php'` → chèn footer

### Bước 3: Trình duyệt nhận HTML

- Tải thêm: file CSS (trong `css/`) và JS (trong `js/`)
- Hiển thị trang với giao diện và hiệu ứng

---

## MỤC 4: Các file quan trọng và cách đọc

### 4.1. `index.php` – Trang chủ

```php
<?php
$currentSite = 'aquarium';        // Cho header biết đang ở trang Aquarium
include 'includes/header.php';    // Chèn header (logo, menu)
?>

<!-- Hero Banner Section -->
<section class="hero-banner-section">
    ...
</section>

<!-- About Us Section -->
<section class="about-us-section">
    ...
</section>

<?php include 'includes/footer.php'; ?>   // Chèn footer
```

**Ý nghĩa**:
- Dòng `include 'includes/header.php'`: chèn toàn bộ header (menu, logo).
- Phần giữa là nội dung riêng của trang chủ (Hero, About, Events, Experiences).

### 4.2. `includes/header.php` – Header chung

- Khai báo `<!DOCTYPE html>`, thẻ `<head>`, `<title>`
- Load CSS (Bootstrap, Font Awesome, file riêng của từng trang)
- In ra menu, logo, link Đăng nhập / Giỏ hàng
- Tất cả trang dùng chung header này

### 4.3. `includes/footer.php` – Footer chung

- Địa chỉ, liên hệ
- Form đăng ký newsletter
- Copyright
- Load JavaScript (Bootstrap, script riêng)

### 4.4. File CSS – Định dạng giao diện

| File | Chức năng |
|------|-----------|
| `css/variables.css` | Biến chung: màu, font, khoảng cách |
| `css/reset.css` | Reset mặc định trình duyệt |
| `css/header.css` | Style menu, logo |
| `css/footer.css` | Style footer |
| `css/homepage.css` | Hero, About, Events, Experiences trên trang chủ |

**Ví dụ đơn giản trong CSS**:
```css
.hero-banner-title {
    font-size: 2.5rem;      /* Cỡ chữ */
    color: #ffffff;         /* Màu chữ trắng */
    font-weight: 700;       /* Chữ đậm */
}
```

### 4.5. File JavaScript – Hành vi trang

| File | Chức năng |
|------|-----------|
| `js/pages/homepage.js` | Slider Featured Experiences (nút prev/next), indicators |
| `js/common/newsletter.js` | Gửi form đăng ký newsletter qua AJAX |

**Ví dụ**:
```javascript
// Khi bấm nút Next
nextBtn.addEventListener('click', function() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
});
```

---

## MỤC 5: Sửa nội dung cơ bản (không cần sâu code)

### 5.1. Đổi chữ trên trang chủ

**File**: `index.php`

- Tìm dòng có chữ cần đổi, ví dụ: `WELCOME TO JENKINSON'S AQUARIUM`
- Sửa thành nội dung mới, rồi lưu file.

### 5.2. Đổi hình ảnh Hero (banner lớn)

**File**: `index.php`

```html
<img src="img/mainmain.jpg" alt="Jenkinson's Aquarium">
```

- Thay `img/mainmain.jpg` bằng đường dẫn hình mới (đặt trong thư mục `img/`).

### 5.3. Thêm/sửa link menu

**File**: `includes/header.php`

- Tìm đoạn menu, ví dụ:
```html
<a href="componets/boardwalk.php">Boardwalk</a>
```
- Sửa `href` hoặc chữ hiển thị cho đúng.

### 5.4. Đổi màu sắc, font chữ

**File**: `css/variables.css`

```css
:root {
    --primary-color: #004b8d;    /* Màu chính - đổi số này */
    --aqua-color: #0086b3;       /* Màu aqua */
}
```

Sau khi đổi, lưu file và tải lại trang (có thể cần Ctrl+F5 để bỏ cache).

### 5.5. Thêm sự kiện hoặc trải nghiệm mới

**File**: `includes/experience-data.php`

- Mở file, tìm mảng `$experiences`
- Thêm phần tử mới theo cấu trúc có sẵn (slug, title, description, image...)

---

## MỤC 6: Cài đặt và chạy website

### 6.1. Cài XAMPP

1. Tải XAMPP: https://www.apachefriends.org/
2. Cài đặt
3. Mở **XAMPP Control Panel**
4. Bấm **Start** cho **Apache** và **MySQL**

### 6.2. Import database

1. Mở trình duyệt, vào: `http://localhost/phpmyadmin`
2. Tạo database tên `project_data` (hoặc tên bạn dùng)
3. Vào database đó → tab **Import**
4. Chọn file `database/full_database.sql`
5. Bấm **Go** (Import)

### 6.3. Cấu hình kết nối database

**File**: `database/config.php`

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');           // Mật khẩu MySQL (mặc định XAMPP để trống)
define('DB_NAME', 'project_data');
```

Sửa nếu bạn dùng database/user/pass khác.

### 6.4. Đặt thư mục project

- Copy toàn bộ project vào: `C:\xampp\htdocs\eProject_2_2`
- Hoặc: `C:\xampp\htdocs\<tên-thư-mục-của-bạn>`

### 6.5. Mở website

Trong trình duyệt gõ:
```
http://localhost/eProject_2_2/
```

 hoặc (nếu đặt tên khác):
```
http://localhost/<tên-thư-mục-của-bạn>/
```

---

## MỤC 7: Luồng chức năng chính

### 7.1. Đăng ký – Đăng nhập

1. User vào `auth/register.php` → điền form
2. PHP lưu vào bảng `users` (mật khẩu đã hash)
3. User vào `auth/login.php` → nhập email + mật khẩu
4. PHP kiểm tra → tạo Session, chuyển hướng

### 7.2. Giỏ hàng – Thanh toán

1. User bấm "Add to Cart" → gọi `product/add_to_cart.php`
2. PHP lưu `product_id`, `quantity` vào `$_SESSION['cart']`
3. User vào `product/cart.php` → xem giỏ hàng
4. User vào `product/checkout.php` → nhập thông tin → đặt hàng
5. PHP lưu đơn vào `orders`, chi tiết vào `order_items`

### 7.3. Admin

1. Đăng nhập tài khoản có `role = admin`
2. Vào `http://localhost/eProject_2_2/admin/`
3. Có thể: quản lý sản phẩm, danh mục, đơn hàng, user, đăng ký sự kiện

---

## MỤC 8: Cấu trúc HTML thường gặp

### Thẻ cơ bản

| Thẻ | Ý nghĩa |
|-----|---------|
| `<h1>`, `<h2>` | Tiêu đề cấp 1, 2 |
| `<p>` | Đoạn văn |
| `<a href="...">` | Link |
| `<img src="..." alt="...">` | Hình ảnh |
| `<div>` | Khối nội dung (thường dùng bố cục) |
| `<section>` | Một section nội dung |
| `<button>` | Nút bấm |

### Class và ID

```html
<div class="container">...</div>      <!-- class: dùng cho nhiều phần tử -->
<section id="upcoming-events">...</section>  <!-- id: dùng cho 1 phần tử duy nhất -->
```

- **Class**: dùng để gán style trong CSS (ví dụ: `.container`)
- **ID**: thường dùng cho link anchor (`#upcoming-events`) hoặc JavaScript

### Bootstrap classes thường dùng

| Class | Ý nghĩa |
|-------|---------|
| `container` | Khung nội dung, căn giữa, max-width |
| `row` | Hàng |
| `col-md-6` | Cột chiếm 6/12 trên màn vừa trở lên |
| `btn btn-primary` | Nút kiểu primary |
| `d-flex` | Flexbox layout |
| `text-center` | Canh giữa chữ |
| `mb-3` | Margin bottom |

---

## MỤC 9: Một số lỗi thường gặp

### 9.1. Trang trắng, không hiện gì

- Kiểm tra: Apache đã Start trong XAMPP chưa
- Kiểm tra: đường dẫn file có đúng không (ví dụ `includes/header.php`)
- Xem log lỗi PHP: `C:\xampp\php\logs\php_error_log`

### 9.2. Không kết nối được database

- Kiểm tra MySQL đã Start trong XAMPP
- Kiểm tra `database/config.php` (host, user, pass, tên database)
- Kiểm tra đã import `full_database.sql` chưa

### 9.3. CSS/JS không cập nhật

- Thử Ctrl+F5 (hard refresh) để xóa cache
- Kiểm tra đường dẫn file: nếu trang trong `product/` thì dùng `../css/...`

### 9.4. Ảnh không hiện

- Kiểm tra file ảnh có trong thư mục `img/` không
- Kiểm tra đường dẫn: `img/ten-file.jpg` (từ thư mục gốc project)

---

## MỤC 10: Đường dẫn file – Quan trọng

Trang nằm ở thư mục khác nhau thì đường dẫn CSS/JS/ảnh khác nhau:

| Trang đang mở | Đường dẫn file |
|---------------|----------------|
| `index.php` (thư mục gốc) | `css/style.css`, `img/logo.png` |
| `product/cart.php` | `../css/style.css`, `../img/logo.png` |
| `componets/boardwalk.php` | `../css/boardwalk.css`, `../img/...` |
| `admin/index.php` | `../css/admin.css` |

`../` nghĩa là lùi một cấp thư mục (lên thư mục cha).

---

## Tóm tắt nhanh

| Muốn làm gì | Xem file |
|-------------|----------|
| Sửa nội dung trang chủ | `index.php` |
| Sửa menu, logo | `includes/header.php` |
| Sửa footer | `includes/footer.php` |
| Sửa màu, font | `css/variables.css` |
| Sửa giao diện trang chủ | `css/homepage.css` |
| Thêm sự kiện/trải nghiệm | `includes/experience-data.php` |
| Cấu hình database | `database/config.php` |

---

**Chúc bạn học và chỉnh sửa website thuận lợi.**

# GIẢI THÍCH CHI TIẾT VỀ HEADER VÀ FOOTER
## Đồ án tốt nghiệp - Website Jenkinson's Aquarium

---

## 📋 MỤC LỤC
1. [Tổng quan về Header và Footer](#tổng-quan)
2. [HEADER - Phần đầu trang](#header)
3. [FOOTER - Phần chân trang](#footer)
4. [Cấu trúc CSS và Responsive Design](#css-responsive)
5. [Các tính năng đặc biệt](#tính-năng)

---

## 🎯 TỔNG QUAN VỀ HEADER VÀ FOOTER {#tổng-quan}

### Header là gì?
**Header** (phần đầu trang) là phần cố định ở trên cùng của website, luôn hiển thị khi người dùng cuộn trang. Header chứa:
- Logo của website
- Menu điều hướng chính
- Các liên kết tiện ích (social media, tìm kiếm, ngôn ngữ)
- Thông tin quan trọng nhất để người dùng điều hướng

### Footer là gì?
**Footer** (phần chân trang) là phần ở cuối cùng của website, chứa:
- Thông tin liên hệ
- Bản quyền
- Các liên kết quan trọng
- Form đăng ký newsletter
- Thông tin bổ sung về công ty

---

## 🎨 HEADER - PHẦN ĐẦU TRANG {#header}

### 1. CẤU TRÚC HTML CỦA HEADER

Header được chia thành **2 phần chính**:

#### **Phần 1: Top Links Bar (Thanh liên kết trên cùng)**

```php
<div class="top-links-bar">
    <div class="container">
        <div class="top-bar-content">
            <!-- Nội dung thanh trên -->
        </div>
    </div>
</div>
```

**Chức năng:**
- Hiển thị các liên kết tiện ích: Aquarium, View Hours, Translate
- Social media icons: Facebook, Instagram, Twitter, YouTube
- Nút tìm kiếm
- Font size nhỏ hơn, màu xám nhạt

**Các thành phần:**

1. **Navigation Link "Aquarium"** (dòng 46-51)
   ```php
   <a href="index.php" class="top-link text-aqua">
       <i class="fa-solid fa-fish"></i>
       <span>Aquarium</span>
   </a>
   ```
   - Icon cá + text "Aquarium"
   - Màu xanh aqua (`text-aqua`)
   - Link về trang chủ

2. **View Hours** (dòng 54-61)
   - Icon lịch + text "VIEW HOURS"
   - Ẩn text trên mobile (`d-none d-sm-inline`)

3. **Translate** (dòng 63-68)
   - Icon globe + text "TRANSLATE"
   - Chức năng đa ngôn ngữ

4. **Social Media Links** (dòng 70-103)
   ```php
   <div class="social-links">
       <a href="facebook.com">...</a>
       <a href="instagram.com">...</a>
       <!-- ... -->
   </div>
   ```
   - 4 icons: Facebook, Instagram, Twitter, YouTube
   - Mỗi icon có màu riêng khi hover
   - Mở tab mới (`target="_blank"`)

5. **Search Button** (dòng 105-111)
   - Icon kính lúp
   - Mở modal tìm kiếm (Bootstrap)

#### **Phần 2: Main Header Content (Logo + Menu chính)**

```php
<div class="main-header-content">
    <div class="container">
        <div class="header-main-row">
            <!-- Logo -->
            <!-- Navigation Menu -->
        </div>
    </div>
</div>
```

**Cấu trúc:**

1. **Logo Section** (dòng 120-127)
   ```php
   <div class="logo-section">
       <a href="index.php" class="aquarium-logo-wrapper">
           <img src="img/aquarium-logo-768x318.png" 
                alt="Jenkinson's Aquarium"
                class="aquarium-logo-img">
       </a>
   </div>
   ```
   - Logo có thể click để về trang chủ
   - Responsive: tự động resize theo màn hình
   - Max-width: 320px (desktop)

2. **Main Navigation** (dòng 129-184)
   ```php
   <nav class="main-navigation">
       <button class="navbar-toggler">☰</button> <!-- Mobile menu button -->
       <div class="navbar-collapse">
           <ul class="main-menu">
               <li><a href="#">Visit</a></li>
               <li><a href="#">Penguin Cam</a></li>
               <!-- ... -->
           </ul>
       </div>
   </nav>
   ```

   **Menu items:**
   - **Visit** - Có dropdown mega menu với submenu "JOIN OUR TEAM"
   - **Penguin Cam** - Link trực tiếp (icon video)
   - **Groups & Education** - Có dropdown với submenu "GROUPS"
   - **Adoption, Encounters & Programs** - Có dropdown menu

### 2. DROPDOWN MENU SYSTEM (Hệ thống menu dropdown)

#### **Tổng quan về Dropdown Menu**

**Dropdown menu** là menu con xuất hiện khi người dùng hover (di chuột) vào một menu item chính. Trong website này, dropdown menu được xây dựng hoàn toàn bằng **CSS** (không cần JavaScript), giúp website tải nhanh hơn và hoạt động mượt mà hơn.

**Các thành phần chính:**
- **Parent Menu Item**: Menu item chính (ví dụ: "Visit", "Groups & Education")
- **Dropdown Menu**: Menu con xuất hiện khi hover
- **Submenu**: Menu con của dropdown (cấp 2)
- **Icon Caret (▼)**: Mũi tên xuống cho biết có dropdown
- **Icon Chevron (▶)**: Mũi tên phải cho biết có submenu

**Cách hoạt động:**
1. Người dùng di chuột vào menu item chính (ví dụ: "Visit")
2. CSS phát hiện `:hover` và hiển thị dropdown menu
3. Dropdown menu đổ xuống với animation mượt mà
4. Nếu có submenu, di chuột vào item có icon ▶ sẽ hiển thị submenu sang ngang
5. Khi rời khỏi menu, dropdown tự động ẩn đi

**Lợi ích của CSS-driven dropdown:**
- ✅ Không cần JavaScript → Tải trang nhanh hơn
- ✅ Hoạt động ngay cả khi JavaScript bị tắt
- ✅ Dễ bảo trì và debug
- ✅ Hiệu suất tốt hơn (CSS được trình duyệt tối ưu hóa)

---

Website có **3 menu dropdown chính**:

#### **A. Visit Dropdown Menu**

```php
<li class="nav-item dropdown-hover">
    <a href="#" class="nav-link">
        <span>Visit</span>
        <span class="menu-caret">▼</span>
    </a>
    <ul class="dropdown-menu visit-mega-menu">
        <li><a href="#">HOURS & ADMISSION</a></li>
        <li><a href="#">UPCOMING EVENTS</a></li>
        <li><a href="#">EXPERIENCES</a></li>
        <li><a href="#">PROMOTIONS</a></li>
        <li class="dropdown-submenu">
            <a href="#">JOIN OUR TEAM <i class="fa-solid fa-chevron-right"></i></a>
            <ul class="dropdown-menu submenu">
                <li><a href="#">INTERNSHIPS</a></li>
                <li><a href="#">EMPLOYMENT</a></li>
                <li><a href="#">VOLUNTEER</a></li>
            </ul>
        </li>
        <li><a href="#">OUR MISSION</a></li>
        <li><a href="#">OUR PARTNERS</a></li>
        <li><a href="#">SELF GUIDED TOUR</a></li>
    </ul>
</li>
```

**Đặc điểm:**
- Dropdown đổ xuống khi hover vào "Visit"
- Submenu "JOIN OUR TEAM" hiển thị sang ngang (bên phải) khi hover
- Icon mũi tên (`fa-chevron-right`) với hiệu ứng di chuyển khi hover
- Animation: `fadeInDown` cho dropdown chính, `fadeInRight` cho submenu

#### **B. Groups & Education Dropdown Menu**

```php
<li class="nav-item dropdown-hover">
    <a href="#" class="nav-link">
        <span>Groups & Education</span>
        <span class="menu-caret">▼</span>
    </a>
    <ul class="dropdown-menu visit-mega-menu">
        <li><a href="#">EXPERIENCES</a></li>
        <li class="dropdown-submenu">
            <a href="#">GROUPS <i class="fa-solid fa-chevron-right"></i></a>
            <ul class="dropdown-menu submenu">
                <li><a href="#">GROUP RATES</a></li>
                <li><a href="#">TEACHER TIPS (CHECKING IN & PARKING)</a></li>
                <li><a href="#">PRE & POST VISIT ACTIVITIES</a></li>
                <li><a href="#">OUTREACH & FOCUS PROGRAMS</a></li>
            </ul>
        </li>
        <li><a href="#">OUTREACH & FOCUS PROGRAMS</a></li>
        <li><a href="#">VIRTUAL PROGRAMS</a></li>
        <li><a href="#">SUMMER CAMPS</a></li>
    </ul>
</li>
```

**Đặc điểm:**
- Tương tự "Visit" dropdown
- Submenu "GROUPS" có 4 items con
- Submenu hiển thị sang ngang với animation `fadeInRight`

#### **C. Adoption, Encounters & Programs Dropdown Menu**

```php
<li class="nav-item dropdown-hover">
    <a href="#" class="nav-link">
        <span>Adoption, Encounters & Programs</span>
        <span class="menu-caret">▼</span>
    </a>
    <ul class="dropdown-menu visit-mega-menu">
        <li><a href="#">ADOPT-AN-ANIMAL</a></li>
        <li><a href="#">ANIMAL ENCOUNTERS</a></li>
        <li><a href="#">ANIMAL PROGRAMS</a></li>
        <li><a href="#">PROMOTIONS</a></li>
        <li><a href="#">UPCOMING EVENTS</a></li>
    </ul>
</li>
```

**Đặc điểm:**
- Dropdown đổ xuống với 5 items
- Không có submenu con
- Sử dụng cùng styling với các dropdown khác

### 3. CSS VÀ STYLING CỦA HEADER

#### **A. Sticky Header (Header dính)**
```css
.main-header {
    position: sticky;
    top: 0;
    z-index: 1000;
}
```
**Giải thích:**
- `position: sticky` → Header luôn ở trên cùng khi scroll
- `top: 0` → Cách đỉnh màn hình 0px
- `z-index: 1000` → Luôn ở trên các element khác

#### **B. Top Bar Styling**
```css
.top-links-bar {
    background-color: #ffffff;
    border-bottom: 1px solid #e9ecef;
}
```
- Nền trắng
- Border dưới màu xám nhạt
- Có gradient line trang trí (`::after`)

#### **C. Logo Styling**
```css
.aquarium-logo-wrapper {
    max-width: 320px;
    transition: transform 0.3s;
}

.aquarium-logo-wrapper:hover {
    transform: scale(1.02); /* Phóng to 2% khi hover */
}
```
- Giới hạn chiều rộng tối đa
- Hiệu ứng hover: phóng to nhẹ

#### **D. Navigation Menu Styling**
```css
.main-menu .nav-link {
    padding: 0.75rem 1rem;
    transition: all 0.3s;
    position: relative;
}

.main-menu .nav-link::before {
    content: '';
    position: absolute;
    bottom: 0.5rem;
    width: 0;
    height: 2px;
    background-color: var(--aqua-color);
    transition: width 0.3s;
}

.main-menu .nav-link:hover::before {
    width: calc(100% - 2rem); /* Gạch chân xuất hiện */
}
```
**Hiệu ứng:**
- Gạch chân màu xanh xuất hiện khi hover
- Menu item nhích lên nhẹ (`translateY(-2px)`)
- Background màu xanh nhạt khi hover

#### **E. Dropdown Menu Styling**

**1. Dropdown Container**
```css
.dropdown-hover .dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 250px;
    background-color: #ffffff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    z-index: 1000;
}

.dropdown-hover:hover .dropdown-menu,
.dropdown-hover .dropdown-menu:hover {
    display: block;
    animation: fadeInDown 0.3s ease;
}
```
**Giải thích:**
- `display: none` → Ẩn mặc định
- `position: absolute` → Vị trí tuyệt đối so với parent
- `top: 100%` → Đổ xuống dưới parent
- Hiển thị khi hover vào parent hoặc chính dropdown

**2. Submenu (Menu con)**
```css
.dropdown-submenu > .dropdown-menu.submenu {
    display: none;
    position: absolute;
    top: 0;
    left: 100%;
    margin-left: 0.5rem;
    min-width: 200px;
    z-index: 1001;
}

.dropdown-submenu:hover > .dropdown-menu.submenu,
.dropdown-submenu > .dropdown-menu.submenu:hover {
    display: block;
    animation: fadeInRight 0.3s ease;
}
```
**Giải thích:**
- `left: 100%` → Hiển thị sang ngang (bên phải)
- `top: 0` → Căn với item parent
- `z-index: 1001` → Cao hơn dropdown chính
- Animation `fadeInRight` → Trượt từ trái sang phải

**3. Icon Mũi Tên (Chevron)**
```css
.visit-mega-menu .dropdown-submenu > .dropdown-item .join-team-arrow {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.7rem;
    color: var(--aqua-color);
    transition: transform 0.3s;
    opacity: 0.7;
}

.visit-mega-menu .dropdown-submenu:hover > .dropdown-item .join-team-arrow {
    transform: translateY(-50%) translateX(4px);
    opacity: 1;
}
```
**Giải thích:**
- Icon `fa-chevron-right` ở bên phải item
- Khi hover: icon dịch sang phải 4px và opacity tăng lên 1
- Tạo hiệu ứng động khi hover

**4. Safe Zone (Vùng an toàn)**
```css
.dropdown-submenu > .dropdown-item::before {
    content: "";
    position: absolute;
    top: 0;
    right: -10px;
    width: 20px;
    height: 100%;
    background: transparent;
    z-index: 1000;
}
```
**Giải thích:**
- Tạo vùng trong suốt giữa parent và submenu
- Giúp chuột di chuyển từ parent sang submenu mà không làm mất menu
- Giải quyết vấn đề "dropdown biến mất khi di chuyển chuột"

**5. Dropdown Item Styling**
```css
.visit-mega-menu .dropdown-item {
    padding: 0.75rem 1.5rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-dark);
    text-transform: uppercase;
    transition: all 0.3s;
    border-bottom: 1px solid #f0f0f0;
}

.visit-mega-menu .dropdown-item:hover {
    background-color: rgba(0, 134, 179, 0.05);
    color: var(--aqua-color);
    padding-left: 2rem;
}
```
**Giải thích:**
- Text uppercase, font-weight 600
- Border dưới để phân cách items
- Khi hover: background xanh nhạt, text xanh, padding-left tăng

### 4. RESPONSIVE DESIGN CHO HEADER

#### **Desktop (≥992px):**
- Logo và menu nằm ngang
- Menu hiển thị đầy đủ
- Hamburger button ẩn
- Dropdown menus hoạt động với hover

#### **Tablet/Mobile (<992px):**
```css
@media (max-width: 991.98px) {
    .header-main-row {
        flex-direction: column; /* Xếp dọc */
    }
    
    .navbar-toggler {
        display: block; /* Hiện hamburger button */
    }
    
    .navbar-collapse {
        display: none; /* Ẩn menu mặc định */
    }
    
    .dropdown-hover .dropdown-menu {
        position: static; /* Dropdown không float */
        box-shadow: none;
        margin-top: 0;
        padding-left: 1rem;
    }
    
    .dropdown-submenu > .dropdown-menu.submenu {
        position: static; /* Submenu không sang ngang */
        margin-left: 1rem;
        border-left: 2px solid var(--aqua-color);
        padding-left: 1rem;
    }
}
```
**Thay đổi trên mobile:**
- Logo và menu xếp dọc
- Hamburger button hiện ra
- Menu collapse thành dropdown
- Dropdown menus không float, hiển thị như accordion
- Submenu không sang ngang, mà xếp dọc với border trái

#### **Mobile (<768px):**
- Logo nhỏ hơn (220px)
- Font size nhỏ hơn
- Top bar items xếp dọc

---

## 🦶 FOOTER - PHẦN CHÂN TRANG {#footer}

### 1. CẤU TRÚC HTML CỦA FOOTER

Footer được chia thành **4 cột chính**:

```php
<footer class="boardwalk-footer">
    <div class="container">
        <div class="row footer-row">
            <!-- Cột 1: Logo -->
            <!-- Cột 2: Visit the Boardwalk -->
            <!-- Cột 3: Plan Your Visit -->
            <!-- Cột 4: Stay Connected -->
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            <!-- Copyright -->
        </div>
    </div>
</footer>
```

#### **Cột 1: Logo và Branding** (dòng 9-17)
```php
<div class="col-md-3">
    <div class="boardwalk-logo">
        <img src="img/imgfooter.ong.png" class="footer-logo-img">
        <div class="footer-badge">15 YEARS</div>
        <div class="footer-badge">BEST VALUE</div>
    </div>
</div>
```
**Nội dung:**
- Logo Jenkinson's Boardwalk
- Badge "15 YEARS"
- Badge "BEST VALUE"

#### **Cột 2: Visit the Boardwalk** (dòng 20-25)
```php
<div class="col-md-3">
    <h6 class="hover-link">Visit the Boardwalk</h6>
    <p class="hover-link">300 Ocean Avenue</p>
    <p class="hover-link">Point Pleasant Beach, NJ 08742</p>
    <p class="hover-link">732-892-0600</p>
</div>
```
**Nội dung:**
- Địa chỉ công ty
- Số điện thoại
- Tất cả có class `hover-link` → đổi màu khi hover

#### **Cột 3: Plan Your Visit** (dòng 28-38)
```php
<div class="col-md-3">
    <h6 class="plan-visit-heading">Plan Your Visit</h6>
    <ul>
        <li><a href="#" class="hover-link">Join Our Team</a></li>
        <li><a href="#" class="hover-link">Adopt-An-Animal</a></li>
    </ul>
</div>
```
**Nội dung:**
- Links điều hướng
- Hover màu xanh aqua

#### **Cột 4: Stay Connected** (dòng 41-47)
```php
<div class="col-md-3">
    <h6>Stay Connected</h6>
    <form class="newsletter-form">
        <input type="email" placeholder="E-Mail">
        <button type="submit" class="btn-subscribe">SUBSCRIBE</button>
    </form>
</div>
```
**Nội dung:**
- Form đăng ký email
- Input field với background trong suốt
- Button màu teal/aqua

#### **Footer Bottom: Copyright** (dòng 50-54)
```php
<div class="footer-bottom text-center">
    <span class="copyright-text">
        © 2026 Jenkinson's Boardwalk. All rights reserved.
    </span>
</div>
```
- Màu xanh aqua (`copyright-text`)
- Căn giữa

### 2. CSS VÀ STYLING CỦA FOOTER

#### **A. Footer Background**
```css
.boardwalk-footer {
    background: linear-gradient(180deg, #1a2332 0%, #0f1419 100%);
    padding: 3rem 0 2rem;
}
```
- Gradient từ xanh đậm → đen
- Padding trên/dưới lớn

#### **B. Footer Row Spacing**
```css
.footer-row {
    gap: 2rem 1.5rem; /* Vertical gap: 2rem, Horizontal gap: 1.5rem */
    margin-bottom: 2rem;
}

.footer-row > div {
    padding: 0 0.75rem; /* Padding trái/phải cho mỗi cột */
}
```
**Giải thích:**
- `gap: 2rem 1.5rem` → Khoảng cách giữa các cột
- Mỗi cột có padding để không sát nhau

#### **C. Column Widths**
```css
.footer-row .col-md-3 {
    width: calc(25% - 1.5rem); /* 4 cột = 25% mỗi cột */
}
```
- Desktop: 4 cột, mỗi cột 25% width
- Tablet: 2 cột, mỗi cột 50% width
- Mobile: 1 cột, 100% width

#### **D. Hover Effects**

**1. Hover Link (màu accent)**
```css
.hover-link:hover {
    color: var(--accent-color) !important; /* Màu teal */
}
```

**2. Plan Your Visit Links (màu xanh aqua)**
```css
.boardwalk-footer .list-unstyled a.hover-link:hover {
    color: var(--aqua-color) !important; /* Màu xanh aqua */
}
```

**3. Plan Your Visit Heading**
```css
.plan-visit-heading:hover {
    color: var(--aqua-color) !important;
}
```

#### **E. Subscribe Button**
```css
.btn-subscribe {
    background-color: var(--accent-color); /* Màu teal */
    color: #ffffff;
    padding: 0.6rem 1.5rem;
    text-transform: uppercase;
    transition: all 0.3s;
}

.btn-subscribe:hover {
    background-color: #589c9b; /* Màu teal đậm hơn */
    transform: translateY(-2px); /* Nhích lên */
    box-shadow: 0 4px 12px rgba(107, 180, 179, 0.4); /* Đổ bóng */
}
```

#### **F. Newsletter Form Input**
```css
.newsletter-form .form-control {
    background-color: rgba(255, 255, 255, 0.1); /* Trắng trong suốt */
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #ffffff;
}

.newsletter-form .form-control:focus {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: var(--accent-color);
    box-shadow: 0 0 0 0.2rem rgba(107, 180, 179, 0.25);
}
```

### 3. RESPONSIVE DESIGN CHO FOOTER

#### **Desktop (≥992px):**
- 4 cột ngang
- Logo căn trái
- Khoảng cách rộng

#### **Tablet (768px - 991px):**
```css
@media (max-width: 991.98px) {
    .footer-row .col-md-3 {
        width: calc(50% - 1rem); /* 2 cột */
    }
}
```
- 2 cột, mỗi cột 50%
- Logo căn giữa

#### **Mobile (<768px):**
```css
@media (max-width: 575.98px) {
    .footer-row .col-md-3 {
        width: 100%; /* 1 cột */
    }
}
```
- 1 cột, full width
- Tất cả nội dung xếp dọc

---

## 🎨 CẤU TRÚC CSS VÀ RESPONSIVE DESIGN {#css-responsive}

### 1. KIẾN TRÚC CSS MODULAR

Website sử dụng **CSS Component-based** (chia nhỏ thành các file):

```
css/
├── variables.css    → Biến CSS (màu sắc, spacing, transitions)
├── reset.css        → Reset CSS mặc định
├── header.css       → Styles cho header
├── footer.css       → Styles cho footer
├── hero.css         → Styles cho hero section
├── features.css     → Styles cho features section
├── utilities.css    → Utility classes
└── responsive.css   → Media queries responsive
```

**Lợi ích:**
- Dễ bảo trì: mỗi component có file riêng
- Dễ tìm lỗi: biết ngay file nào cần sửa
- Tái sử dụng: có thể dùng lại cho project khác

### 2. CSS VARIABLES (Biến CSS)

File `variables.css` định nghĩa các biến:

```css
:root {
    --primary-color: #004b8d;
    --aqua-color: #0086b3;
    --accent-color: #6bb4b3;
    --transition-base: 0.3s ease;
    --shadow-header: 0 2px 10px rgba(0, 0, 0, 0.05);
}
```

**Cách dùng:**
```css
.text-aqua {
    color: var(--aqua-color); /* Thay vì viết #0086b3 */
}
```

**Lợi ích:**
- Dễ thay đổi màu sắc: chỉ sửa 1 chỗ
- Nhất quán: tất cả dùng cùng biến
- Dễ bảo trì

### 3. RESPONSIVE BREAKPOINTS

```css
/* Mobile First Approach */
/* Default: Mobile styles */

/* Tablet */
@media (min-width: 768px) { ... }

/* Desktop */
@media (min-width: 992px) { ... }

/* Large Desktop */
@media (min-width: 1200px) { ... }
```

**Breakpoints phổ biến:**
- **Mobile**: < 576px
- **Tablet**: 576px - 991px
- **Desktop**: ≥ 992px
- **Large Desktop**: ≥ 1200px

---

## ⚡ CÁC TÍNH NĂNG ĐẶC BIỆT {#tính-năng}

### 1. CSS-DRIVEN DROPDOWN MENUS (Menu dropdown bằng CSS)

**Không cần JavaScript!** Tất cả dropdown menus hoạt động hoàn toàn bằng CSS:

```css
/* Hiển thị dropdown khi hover */
.dropdown-hover:hover .dropdown-menu {
    display: block;
    animation: fadeInDown 0.3s ease;
}

/* Giữ dropdown mở khi hover vào chính nó */
.dropdown-hover .dropdown-menu:hover {
    display: block;
}
```

**Lợi ích:**
- Không cần JavaScript → Tải trang nhanh hơn
- Hoạt động ngay cả khi JavaScript bị tắt
- Dễ bảo trì và debug

**Cách hoạt động:**
1. Sử dụng `:hover` pseudo-class
2. `display: none` → `display: block` khi hover
3. Animation CSS (`@keyframes`) cho hiệu ứng mượt mà

### 2. STICKY HEADER (Header dính)

```css
.main-header {
    position: sticky;
    top: 0;
    z-index: 1000;
}
```

**Cách hoạt động:**
- Khi scroll xuống, header vẫn ở trên cùng
- Giúp người dùng luôn thấy menu điều hướng
- `z-index: 1000` đảm bảo header luôn trên cùng

### 2. MULTI-LEVEL DROPDOWN SYSTEM (Hệ thống dropdown đa cấp)

#### **Giải thích chi tiết về Multi-level Dropdown**

Website hỗ trợ **dropdown 2 cấp** (parent → submenu), cho phép tạo menu phức tạp với nhiều tầng điều hướng.

**Cấu trúc phân cấp:**
```
Visit (Level 1 - Parent Menu)
  ├── HOURS & ADMISSION (Level 1 Item)
  ├── UPCOMING EVENTS (Level 1 Item)
  ├── EXPERIENCES (Level 1 Item)
  ├── PROMOTIONS (Level 1 Item)
  ├── JOIN OUR TEAM (Level 1 Item có submenu Level 2)
  │     ├── INTERNSHIPS (Level 2 Item)
  │     ├── EMPLOYMENT (Level 2 Item)
  │     └── VOLUNTEER (Level 2 Item)
  ├── OUR MISSION (Level 1 Item)
  ├── OUR PARTNERS (Level 1 Item)
  └── SELF GUIDED TOUR (Level 1 Item)
```

**Cách hoạt động từng bước:**

**Bước 1: Hover vào Parent Menu**
- Người dùng di chuột vào "Visit"
- CSS selector `.dropdown-hover:hover` được kích hoạt
- Dropdown Level 1 hiển thị với animation `fadeInDown` (trượt xuống)

**Bước 2: Hover vào Item có Submenu**
- Người dùng di chuột vào "JOIN OUR TEAM" (có icon ▶)
- CSS selector `.dropdown-submenu:hover` được kích hoạt
- Submenu Level 2 hiển thị sang ngang với animation `fadeInRight` (trượt sang phải)

**Bước 3: Di chuyển chuột vào Submenu**
- Người dùng di chuột từ "JOIN OUR TEAM" sang submenu
- Safe zone (`::before` pseudo-element) giúp giữ menu mở
- CSS selector `.dropdown-submenu .submenu:hover` giữ submenu hiển thị

**Bước 4: Rời khỏi Menu**
- Người dùng di chuột ra ngoài cả parent và submenu
- Không còn `:hover` nào được kích hoạt
- Cả dropdown Level 1 và submenu Level 2 đều ẩn đi

**CSS Key Points (Điểm quan trọng trong CSS):**

1. **Level 1 Dropdown (Đổ xuống):**
   ```css
   .dropdown-hover .dropdown-menu {
       top: 100%;  /* Đổ xuống dưới parent */
       left: 0;    /* Căn trái với parent */
   }
   ```

2. **Level 2 Submenu (Sang ngang):**
   ```css
   .dropdown-submenu > .dropdown-menu.submenu {
       top: 0;         /* Căn trên cùng với item parent */
       left: 100%;     /* Sang ngang bên phải */
       margin-left: 0.5rem; /* Khoảng cách 0.5rem */
   }
   ```

3. **Safe Zone (Vùng an toàn):**
   ```css
   .dropdown-submenu > .dropdown-item::before {
       content: "";
       position: absolute;
       right: -10px;
       width: 20px;
       height: 100%;
       background: transparent; /* Trong suốt */
   }
   ```
   - Tạo vùng "cầu nối" giữa parent và submenu
   - Giúp chuột di chuyển mượt mà mà không làm mất menu

4. **Z-index Layering (Lớp chồng):**
   - Level 1: `z-index: 1000`
   - Level 2: `z-index: 1001` (cao hơn để hiển thị trên Level 1)

**Ví dụ thực tế:**

**Visit Menu:**
- Level 1: 8 items (HOURS & ADMISSION, UPCOMING EVENTS, etc.)
- Level 2: 3 items trong "JOIN OUR TEAM" (INTERNSHIPS, EMPLOYMENT, VOLUNTEER)

**Groups & Education Menu:**
- Level 1: 5 items (EXPERIENCES, GROUPS, etc.)
- Level 2: 4 items trong "GROUPS" (GROUP RATES, TEACHER TIPS, etc.)

**Adoption Menu:**
- Level 1: 5 items (không có Level 2)

### 3. HOVER EFFECTS (Hiệu ứng khi di chuột)

#### **A. Underline Animation**
```css
.top-link::after {
    content: '';
    width: 0; /* Bắt đầu = 0 */
    height: 2px;
    background-color: var(--aqua-color);
    transition: width 0.3s;
}

.top-link:hover::after {
    width: 100%; /* Mở rộng = 100% */
}
```
→ Gạch chân xuất hiện từ trái sang phải

#### **B. Transform Effects**
```css
.main-menu .nav-link:hover {
    transform: translateY(-2px); /* Nhích lên 2px */
    background-color: rgba(0, 134, 179, 0.05);
}
```
→ Menu item nhích lên và có background khi hover

#### **C. Scale Effects**
```css
.aquarium-logo-wrapper:hover {
    transform: scale(1.02); /* Phóng to 2% */
}
```
→ Logo phóng to nhẹ khi hover

### 4. ACCESSIBILITY (Khả năng truy cập)

#### **A. ARIA Labels**
```php
<nav aria-label="Main navigation">
    <a aria-label="Visit our Facebook page">
```
- Giúp screen reader đọc được
- Tốt cho người khuyết tật

#### **B. Semantic HTML**
```php
<header role="banner">
<nav role="menubar">
<li role="menuitem">
```
- HTML có ý nghĩa
- SEO tốt hơn

#### **C. Focus States**
```css
.top-link:focus-visible {
    outline: 2px solid var(--aqua-color);
    outline-offset: 2px;
}
```
- Hiển thị outline khi dùng keyboard
- Tốt cho accessibility

### 5. BOOTSTRAP INTEGRATION

Website sử dụng **Bootstrap 5**:

```php
<!-- Bootstrap CSS -->
<link href="bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Classes -->
<div class="container">
    <div class="row">
        <div class="col-md-3">
```

**Các class Bootstrap được dùng:**
- `container` → Container responsive
- `row` → Hàng
- `col-md-3` → Cột (3/12 = 25%)
- `d-flex` → Flexbox
- `justify-content-between` → Căn đều
- `text-center` → Căn giữa text

### 6. FONT AWESOME ICONS

```php
<link rel="stylesheet" href="font-awesome.min.css">

<i class="fa-solid fa-fish"></i>
<i class="fa-brands fa-facebook-f"></i>
```

**Các icon được dùng:**
- `fa-fish` → Icon cá
- `fa-calendar-days` → Icon lịch
- `fa-bars` → Hamburger menu
- `fa-magnifying-glass` → Tìm kiếm
- `fa-chevron-right` → Mũi tên sang phải (submenu)
- `fa-facebook-f`, `fa-instagram`, etc. → Social media

### 7. CSS ANIMATIONS (Hiệu ứng chuyển động)

**1. FadeInDown Animation (Dropdown đổ xuống)**
```css
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```
**Sử dụng:** Dropdown menu Level 1 (Visit, Groups & Education, Adoption)
- Bắt đầu: trong suốt, ở trên 10px
- Kết thúc: hiển thị đầy đủ, ở vị trí đúng
- Tạo hiệu ứng "trượt xuống" mượt mà

**2. FadeInRight Animation (Submenu sang ngang)**
```css
@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
```
**Sử dụng:** Submenu Level 2 (JOIN OUR TEAM, GROUPS)
- Bắt đầu: trong suốt, ở bên trái 10px
- Kết thúc: hiển thị đầy đủ, ở vị trí đúng
- Tạo hiệu ứng "trượt sang phải" mượt mà

**Cách áp dụng:**
```css
.dropdown-hover:hover .dropdown-menu {
    animation: fadeInDown 0.3s ease;
}

.dropdown-submenu:hover > .dropdown-menu.submenu {
    animation: fadeInRight 0.3s ease;
}
```

---

## 📝 TÓM TẮT QUAN TRỌNG

### Header:
1. **2 phần**: Top bar (tiện ích) + Main header (logo + menu)
2. **Sticky**: Luôn ở trên cùng khi scroll
3. **3 Dropdown menus**: Visit, Groups & Education, Adoption Encounters & Programs
4. **Multi-level dropdowns**: Visit → JOIN OUR TEAM, Groups & Education → GROUPS
5. **CSS-driven**: Không cần JavaScript, hoạt động bằng CSS :hover
6. **Responsive**: Menu collapse thành hamburger trên mobile
7. **Hover effects**: Gạch chân, transform, background color, icon animations

### Footer:
1. **4 cột**: Logo, Visit, Plan Your Visit, Stay Connected
2. **Gradient background**: Xanh đậm → đen
3. **Hover effects**: Màu xanh aqua cho links
4. **Newsletter form**: Input + Subscribe button
5. **Copyright**: Màu xanh, căn giữa

### CSS Architecture:
1. **Modular**: Mỗi component 1 file
2. **Variables**: Dùng CSS variables cho màu sắc
3. **Responsive**: Mobile-first approach
4. **Bootstrap**: Tích hợp Bootstrap 5

---

## 🎓 KIẾN THỨC ÁP DỤNG

1. **HTML5 Semantic Elements**: `<header>`, `<footer>`, `<nav>`
2. **CSS Flexbox**: Layout responsive
3. **CSS Grid**: (Có thể dùng cho layout phức tạp)
4. **CSS Variables**: Quản lý màu sắc
5. **Media Queries**: Responsive design
6. **Bootstrap Framework**: Grid system, utilities
7. **Accessibility**: ARIA labels, semantic HTML
8. **CSS Animations**: Transitions, transforms

---



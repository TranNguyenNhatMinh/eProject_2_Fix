# GIẢI THÍCH CHI TIẾT VỀ HOMEPAGE BODY
## Đồ án tốt nghiệp - Website Jenkinson's Aquarium

---

## 📋 MỤC LỤC
1. [Tổng quan về Homepage Body](#tổng-quan)
2. [Header Navigation - Active Links Colors](#header-navigation)
3. [Boardwalk Component](#boardwalk-component) - [Xem file riêng: GIAI_THICH_BOARDWALK.md](./GIAI_THICH_BOARDWALK.md)
4. [Sweet Shop Component](#sweet-shop-component) - [Xem file riêng: GIAI_THICH_SWEET_SHOP.md](./GIAI_THICH_SWEET_SHOP.md)
5. [Hero Section](#hero-section)
6. [Upcoming Events Section](#events-section)
7. [Featured Experiences Section](#experiences-section)
8. [Promotional Section](#promo-section)
9. [CSS Styling](#css-styling)
10. [JavaScript Functionality](#javascript)
11. [Responsive Design](#responsive)

---

## 🎯 TỔNG QUAN VỀ HOMEPAGE BODY {#tổng-quan}

### Cấu trúc Homepage Body

Homepage body được chia thành **2 phần chính**:

1. **Hero Section** - Phần giới thiệu với background gradient và call-to-action buttons
2. **Features Section** - Hiển thị các sự kiện và trải nghiệm nổi bật

### File liên quan:

- **HTML**: `index.php` (phần body)
- **CSS**: `css/hero.css` và `css/features.css` (styles cho từng component)
- **JavaScript**: `js/script.js` (xử lý interactions và animations)

---

## 🎨 HEADER NAVIGATION - ACTIVE LINKS COLORS {#header-navigation}

### Mục đích:

Header navigation bar hiển thị 3 trang chính: **Boardwalk**, **Aquarium**, và **Sweet Shop**. Khi người dùng đang ở trang nào, link tương ứng sẽ được highlight với màu sắc riêng biệt và có gạch dưới.

### Cấu trúc HTML:

```php
<nav class="d-flex gap-3 me-auto text-uppercase top-links-nav">
    <a href="componets/boardwalk.php"
       class="top-link fw-semibold <?= $currentSite === 'boardwalk' ? 'text-boardwalk' : 'text-dark' ?>">
        Boardwalk
    </a>
    <a href="index.php"
       class="top-link fw-semibold <?= $currentSite === 'aquarium' ? 'text-aqua' : 'text-dark' ?>">
        Aquarium
    </a>
    <a href="componets/sweet-shop.php"
       class="top-link fw-semibold <?= $currentSite === 'sweet-shop' ? 'text-pink' : 'text-dark' ?>">
        Sweet Shop
    </a>
</nav>
```

### Màu sắc Active Links:

#### **1. Boardwalk - Màu Vàng:**
```css
--boardwalk-yellow: #FFD700;

.text-boardwalk {
    color: var(--boardwalk-yellow) !important;
    font-weight: 700 !important;
    text-shadow: 0 1px 2px rgba(255, 215, 0, 0.3);
}
```
- **Khi ở trang Boardwalk**: Chữ "Boardwalk" hiển thị màu vàng (#FFD700)
- Có gạch dưới màu vàng với animation slide-in
- Font weight: 700 (bold) để nổi bật

#### **2. Aquarium - Màu Xanh:**
```css
--aqua-color: #0086b3;

.text-aqua {
    color: var(--aqua-color) !important;
    font-weight: 700 !important;
    text-shadow: 0 1px 2px rgba(0, 134, 179, 0.2);
}
```
- **Khi ở trang Aquarium**: Chữ "Aquarium" hiển thị màu xanh (#0086b3)
- Có gạch dưới màu xanh với animation slide-in
- Font weight: 700 (bold) để nổi bật

#### **3. Sweet Shop - Màu Đỏ:**
```css
--sweet-shop-red: #dc3545;

.text-pink {
    color: var(--sweet-shop-red) !important;
    font-weight: 700 !important;
    text-shadow: 0 1px 2px rgba(220, 53, 69, 0.2);
}
```
- **Khi ở trang Sweet Shop**: Chữ "Sweet Shop" hiển thị màu đỏ (#dc3545)
- Có gạch dưới màu đỏ với animation slide-in
- Font weight: 700 (bold) để nổi bật

### Gạch dưới (Underline) Animation:

```css
.top-link.text-aqua::after,
.top-link.text-pink::after,
.top-link.text-boardwalk::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 100% !important;
    height: 3px;
    background: currentColor;
    opacity: 1 !important;
    border-radius: 2px;
    animation: underlineSlide 0.3s ease;
}

@keyframes underlineSlide {
    from {
        width: 0;
        opacity: 0;
    }
    to {
        width: 100%;
        opacity: 1;
    }
}
```

**Giải thích:**
- Gạch dưới có độ dày 3px
- Sử dụng `currentColor` để tự động lấy màu từ text
- Animation slide-in từ trái sang phải khi trang load
- Border-radius để bo góc nhẹ

### Hover Effects:

```css
/* Đảm bảo active link giữ màu khi hover */
.top-link.text-pink:hover {
    color: var(--sweet-shop-red) !important;
}

.top-link.text-aqua:hover {
    color: var(--aqua-color) !important;
}

.top-link.text-boardwalk:hover {
    color: var(--boardwalk-yellow) !important;
}
```

**Giải thích:**
- Active links giữ nguyên màu khi hover (không đổi về màu đen)
- Gạch dưới vẫn hiển thị khi hover
- Non-active links có hover effect riêng (background color và underline)

### File liên quan:

- **PHP**: `includes/header.php` (logic để set active class)
- **CSS Variables**: `css/variables.css` (định nghĩa màu sắc)
- **CSS Styles**: `css/header.css` (styles cho active links và animations)

### Cách thêm màu mới cho trang:

1. **Thêm màu vào `variables.css`:**
```css
--new-site-color: #hexcode;
```

2. **Tạo class mới trong `header.css`:**
```css
.text-new-site {
    color: var(--new-site-color) !important;
    font-weight: 700 !important;
    text-shadow: 0 1px 2px rgba(r, g, b, 0.2);
}
```

3. **Thêm vào active link styles:**
```css
.top-link.text-new-site::after {
    /* Copy từ .text-aqua::after */
}
```

4. **Cập nhật `header.php`:**
```php
class="top-link fw-semibold <?= $currentSite === 'new-site' ? 'text-new-site' : 'text-dark' ?>"
```

---

## 🎢 BOARDWALK COMPONENT {#boardwalk-component}

**Xem file riêng:** [GIAI_THICH_BOARDWALK.md](./GIAI_THICH_BOARDWALK.md)

---

## 🍬 SWEET SHOP COMPONENT {#sweet-shop-component}

**Xem file riêng:** [GIAI_THICH_SWEET_SHOP.md](./GIAI_THICH_SWEET_SHOP.md)

---

## 🎨 HERO SECTION {#hero-section}

### Mục đích:

Hero section là phần đầu tiên người dùng thấy khi vào trang chủ, với background image đẹp mắt và content box được căn phải để tạo điểm nhấn.

### Cấu trúc HTML:

```php
<section class="hero-section-new">
    <div class="hero-background"></div>
    <div class="container">
        <div class="row min-vh-75 align-items-center">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="hero-content-box">
                    <h1 class="hero-title">Welcome To Jenkinson's Aquarium</h1>
                    <p class="hero-description">...</p>
                    <a href="#" class="btn btn-primary btn-hero">Find Out More!</a>
                </div>
            </div>
        </div>
    </div>
</section>
```

### Giải thích:

#### **1. Background Image:**
```css
.hero-background {
    position: absolute;
    background-image: url('...');
    background-size: cover;
    background-position: center;
}
```
- Background image full-screen với `position: absolute`
- `background-size: cover` để phủ kín toàn bộ section
- Overlay gradient để làm tối background một chút

#### **2. Content Box:**
```css
.hero-content-box {
    background-color: rgba(240, 240, 240, 0.95);
    padding: 3rem 2.5rem;
    border-radius: 12px;
    max-width: 550px;
    margin-left: auto;
}
```
- Semi-transparent white background (`rgba(240, 240, 240, 0.95)`)
- `margin-left: auto` để căn phải content box
- Box shadow để tạo độ sâu

#### **3. Typography:**
- Title: Font size lớn (2.5rem), màu xanh đậm (#004e92)
- Description: Font size vừa (1.1rem), màu đen
- Button: Màu xanh (#0086b3), uppercase, với hover effects

---

## 📅 UPCOMING EVENTS SECTION {#events-section}

### Mục đích:

Hiển thị các sự kiện sắp tới của aquarium dưới dạng carousel tự động chuyển sang phải sau mỗi 5 giây, hiển thị 4 cards cùng lúc.

### Cấu trúc HTML:

```php
<section class="upcoming-events-section py-5">
    <div class="container">
        <h2 class="section-heading">UPCOMING EVENTS</h2>
        <div class="events-carousel-wrapper">
            <button class="carousel-nav-btn carousel-prev">←</button>
            <div class="events-carousel" id="eventsCarousel">
                <div class="event-card">...</div>
                <!-- More cards -->
            </div>
            <button class="carousel-nav-btn carousel-next">→</button>
        </div>
    </div>
</section>
```

### Event Card Structure:

```php
<div class="event-card">
    <div class="event-card-content">
        <div class="event-card-top">
            <div class="event-logo-small">Jenkinson's Aquarium</div>
            <h3 class="event-title">JUNIOR KEEPERS</h3>
        </div>
        <div class="event-card-bottom">
            <div class="event-date">FEB 19</div>
            <div class="event-info">Junior Keepers (11-15 years old)</div>
        </div>
    </div>
</div>
```

### Giải thích:

#### **1. Carousel Layout:**
```css
.events-carousel {
    display: flex;
    gap: 1.5rem;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
```
- `display: flex` → Xếp ngang các cards
- `gap: 1.5rem` → Khoảng cách đều nhau
- `transition` với `cubic-bezier` → Animation mượt mà
- `overflow: hidden` trên wrapper → Ẩn cards ngoài viewport

#### **2. Event Card:**
```css
.event-card {
    flex: 0 0 calc(25% - 1.125rem);
    min-width: calc(25% - 1.125rem);
    max-width: calc(25% - 1.125rem);
}
```
- Mỗi card chiếm 25% width (4 cards cùng lúc)
- Tính toán trừ đi gap để cards đều nhau

#### **3. Card Design:**

**Top Section:**
- Background gradient: `linear-gradient(135deg, #87CEEB 0%, #6BB4B3 100%)`
- Pattern overlay với `repeating-linear-gradient` tạo hiệu ứng sóng
- Logo nhỏ ở trên, title lớn ở giữa với text-shadow

**Bottom Section:**
- Background: `#2c5f5f` (màu teal đậm)
- Date: Font lớn, bold, uppercase
- Info: Font nhỏ hơn, mô tả chi tiết

#### **4. Navigation Buttons:**
- Circular buttons với background đen trong suốt
- Position absolute ở 2 bên carousel
- Hover: Darker và scale up

---

## ⭐ FEATURED EXPERIENCES SECTION {#experiences-section}

### Mục đích:

Hiển thị các trải nghiệm nổi bật của aquarium dưới dạng carousel tự động với pagination dots.

### Cấu trúc HTML:

```php
<section class="featured-experiences-section py-5">
    <div class="container">
        <h2 class="section-heading">FEATURED EXPERIENCES</h2>
        <div class="experiences-carousel-wrapper">
            <button class="carousel-nav-btn carousel-prev">←</button>
            <div class="experiences-carousel" id="experiencesCarousel">
                <div class="experience-card">...</div>
                <!-- More cards -->
            </div>
            <button class="carousel-nav-btn carousel-next">→</button>
        </div>
        <div class="carousel-dots" id="experiencesDots"></div>
    </div>
</section>
```

### Experience Card Structure:

```php
<div class="experience-card">
    <div class="experience-image">
        <img src="..." alt="...">
        <div class="experience-badge">YOGA</div>
    </div>
    <div class="experience-content">
        <h4 class="experience-title">Animal Programs</h4>
        <p class="experience-desc">Yoga</p>
        <a href="#" class="btn btn-primary btn-sm">Book Now</a>
    </div>
</div>
```

### Giải thích:

#### **1. Card Layout:**
- Image section: 200px height với `object-fit: cover`
- Content section: Padding, title, description, và button
- Hover effect: Image scale up, card lift up

#### **2. Badge System:**
```css
.experience-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background-color: rgba(0, 134, 179, 0.9);
}
```
- Badge overlay trên image để highlight thông tin đặc biệt
- Có thể có badge ở top và bottom

#### **3. Pagination Dots:**
- Dots được tạo động bằng JavaScript
- Active dot có màu xanh và scale lớn hơn
- Click vào dot để jump đến slide tương ứng

---

## 🎁 PROMOTIONAL SECTION {#promo-section}

### Mục đích:

Mid-footer section với logos của các thương hiệu và promotional image với text overlay.

### Cấu trúc HTML:

```php
<section class="promo-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 promo-logos">
                <div class="promo-logo-item">
                    <h3 class="promo-logo-text">JENKINSON'S BOARDWALK</h3>
                </div>
                <!-- More logos -->
            </div>
            <div class="col-lg-8 promo-image-wrapper">
                <div class="promo-image">
                    <img src="..." alt="...">
                    <div class="promo-overlay">
                        <div class="promo-text-box">
                            <h2 class="promo-title">TOP FLOOR IS OPEN!</h2>
                            <p class="promo-description">...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
```

### Giải thích:

#### **1. Background:**
- Dark blue background (`#004e92`) để tạo contrast với các section trên

#### **2. Logos Column:**
- Vertical layout với các logo text
- Font lớn, uppercase, màu trắng
- Cursive font cho "SWEET SHOP"

#### **3. Image Overlay:**
```css
.promo-overlay {
    position: absolute;
    background: linear-gradient(...);
    display: flex;
    align-items: center;
    justify-content: center;
}
```
- Overlay gradient trên image
- Text box ở giữa với white background
- Title và description với styling rõ ràng

---

## 🎨 CSS STYLING {#css-styling}

### Key Design Principles:

1. **Color Palette:**
   - Primary Blue: `#004e92`
   - Aqua Blue: `#0086b3` (dùng cho Aquarium active link)
   - Light Blue: `#87CEEB`
   - Teal: `#6BB4B3`
   - Dark Teal: `#2c5f5f`
   - **Boardwalk Yellow**: `#FFD700` (dùng cho Boardwalk active link)
   - **Sweet Shop Red**: `#dc3545` (dùng cho Sweet Shop active link)

2. **Typography:**
   - Headings: Bold, uppercase, letter-spacing
   - Body: Clean, readable, line-height 1.6-1.8
   - Buttons: Uppercase, letter-spacing

3. **Spacing:**
   - Consistent padding: `4rem 0` cho sections
   - Gap: `1.5rem` giữa carousel items
   - Padding: `3rem 2.5rem` cho content boxes

4. **Shadows & Effects:**
   - Box shadows: `0 4px 15px rgba(0, 0, 0, 0.1)`
   - Hover: Transform và shadow tăng
   - Transitions: `0.3s ease` hoặc `0.6s cubic-bezier`

---

## 💻 JAVASCRIPT FUNCTIONALITY {#javascript}

### Carousel Auto-Scroll:

#### **Upcoming Events Carousel:**

```javascript
function startEventsAutoScroll() {
    eventsAutoScrollInterval = setInterval(() => {
        nextEventsSlide();
    }, 5000); // 5 seconds
}
```

**Features:**
- Auto-scroll mỗi 5 giây
- Scroll sang 4 cards tiếp theo (không phải 1 card)
- Dừng khi hover, tiếp tục khi mouse rời khỏi
- Navigation buttons để điều khiển thủ công
- Quay về đầu khi đến cuối

#### **Featured Experiences Carousel:**

**Features:**
- Tương tự Events carousel
- Thêm pagination dots
- Dots được update khi scroll
- Click vào dot để jump đến slide

### Key Functions:

- `updateCarousel()`: Tính toán và áp dụng `transform: translateX()`
- `nextSlide()` / `prevSlide()`: Chuyển slide
- `startAutoScroll()`: Bắt đầu interval timer
- `createDots()`: Tạo pagination dots (cho Experiences)

---

## 📱 RESPONSIVE DESIGN {#responsive}

### Breakpoints:

1. **Large Desktop (1200px+):**
   - 4 cards per view
   - Full hero content box

2. **Tablet (992px - 1199px):**
   - 3 cards per view
   - Hero content box vẫn full width

3. **Mobile (768px - 991px):**
   - 2 cards per view
   - Hero content box full width
   - Promo logos column trên image

4. **Small Mobile (< 576px):**
   - 1 card per view
   - Smaller fonts
   - Reduced padding
   - Smaller navigation buttons

### Responsive Features:

- Cards tự động resize dựa trên viewport
- Navigation buttons vẫn hoạt động tốt
- Text sizes điều chỉnh phù hợp
- Images scale properly với `object-fit: cover`

---

## 🔧 MAINTENANCE & EXTENSIBILITY

### Thêm Event Card Mới:

1. Copy một event card HTML
2. Thay đổi content (title, date, info)
3. Thêm vào `eventsCarousel` div
4. Carousel tự động tính toán số slides

### Thêm Experience Card Mới:

1. Copy một experience card HTML
2. Thay đổi image, title, description
3. Thêm vào `experiencesCarousel` div
4. Dots tự động được tạo lại

### Customize Auto-Scroll Timing:

Thay đổi giá trị `5000` (milliseconds) trong:
- `startEventsAutoScroll()` function
- `startExperiencesAutoScroll()` function

---

## 📝 NOTES

- Tất cả carousels sử dụng `transform: translateX()` để scroll (performance tốt hơn `left` property)
- `will-change: transform` được sử dụng để optimize animation
- Hover pause/resume để user có thể tương tác với carousel
- Responsive design đảm bảo tốt trên mọi thiết bị

### Header Navigation Notes:

- **Active link colors** được định nghĩa trong `css/variables.css` và sử dụng CSS variables để dễ maintain
- Mỗi trang có màu riêng để user dễ nhận biết đang ở trang nào
- Gạch dưới (underline) có animation slide-in khi trang load để tạo hiệu ứng mượt mà
- Sử dụng `!important` để đảm bảo màu active không bị override bởi các CSS khác
- Active links giữ nguyên màu khi hover để consistency

### Tổng kết màu sắc:

| Trang | Màu Active | Hex Code | CSS Variable |
|-------|-----------|----------|--------------|
| Boardwalk | Vàng | `#FFD700` | `--boardwalk-yellow` |
| Aquarium | Xanh | `#0086b3` | `--aqua-color` |
| Sweet Shop | Đỏ | `#dc3545` | `--sweet-shop-red` |

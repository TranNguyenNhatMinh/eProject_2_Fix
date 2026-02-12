# GIẢI THÍCH CHI TIẾT VỀ BOARDWALK COMPONENT
## Đồ án tốt nghiệp - Website Jenkinson's Boardwalk

---

## 📋 MỤC LỤC
1. [Tổng quan](#tổng-quan)
2. [Cấu trúc Component](#cấu-trúc-component)
3. [CSS Styling](#css-styling)
4. [Responsive Design](#responsive-design)

---

## 🎯 TỔNG QUAN {#tổng-quan}

Boardwalk component là một trang riêng biệt (`componets/boardwalk.php`) với thiết kế và hiệu ứng giống Aquarium nhưng có màu sắc riêng (blue theme). Trang này bao gồm Hero section với welcome card, Events carousel, Promotional blocks, và Branding section.

### File liên quan:

- **PHP**: `componets/boardwalk.php`
- **CSS**: `css/boardwalk.css`
- **Header Active Color**: Vàng (#FFD700) - `--boardwalk-yellow`

---

## 🏗️ CẤU TRÚC COMPONENT {#cấu-trúc-component}

### 1. Hero Section với Welcome Card:

```php
<section class="hero-image-section">
    <div class="hero-image-wrapper">
        <img src="../img/boardwalk-hero.jpg" alt="Jenkinson's Boardwalk">
        <div class="hero-image-overlay"></div>
    </div>
    <div class="container">
        <div class="row align-items-center min-vh-70">
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="hero-card-body">
                    <span class="welcome-badge">WELCOME</span>
                    <h1 class="hero-heading-body">
                        Welcome To<br>
                        <span class="hero-emphasis">Jenkinson's Boardwalk!</span>
                    </h1>
                    <p class="hero-text-body">
                        The premier family-friendly destination on the Jersey Shore— with winter fun to enjoy at the Aquarium, Sweet Shop, and Arcades, open now!
                    </p>
                    <a href="#" class="btn-body-primary" id="ctaButton">
                        <span>PLAN YOUR VISIT!</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
```

**Giải thích:**
- Hero image với overlay gradient màu xanh (`rgba(0, 78, 146, 0.4)`)
- Welcome card căn phải với background trắng semi-transparent (`rgba(255, 255, 255, 0.95)`)
- Badge "WELCOME" màu xanh (#0086b3)
- Button với icon arrow có animation khi hover (arrow slide right)
- Hover effect: Card lift up (`translateY(-5px)`) và shadow tăng

### 2. Upcoming Events Section:

```php
<section class="events-section-body">
    <div class="container">
        <div class="section-title-wrapper">
            <h2 class="section-title-body">UPCOMING EVENTS</h2>
            <div class="title-underline"></div>
            <div class="d-flex justify-content-end">
                <a href="#" class="view-all-link">View All Events &gt;&gt;</a>
            </div>
        </div>
        <div class="carousel-container-body">
            <button class="nav-btn-body nav-btn-prev" aria-label="Previous">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="carousel-track-body" id="eventsCarousel">
                <div class="event-card-body">...</div>
                <!-- More event cards -->
            </div>
            <button class="nav-btn-body nav-btn-next" aria-label="Next">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>
```

**Event Card Structure:**
```php
<div class="event-card-body">
    <div class="event-card-top-body">
        <div class="event-tag-body">EVENT</div>
        <h3 class="event-name-body">OPENING WEEKEND</h3>
    </div>
    <div class="event-card-bottom-body">
        <div class="event-date-body">MAR 14</div>
        <div class="event-detail-body">Amusement Park Opening Weekend</div>
    </div>
</div>
```

**Giải thích:**
- Carousel có thể scroll ngang (horizontal scroll với `overflow-x: auto`)
- Event cards có hover effect: `translateY(-5px)` và shadow tăng
- Navigation buttons hình tròn với border màu xanh
- Event tag màu xanh (#0086b3) với uppercase text
- Date màu xanh để highlight
- Scrollbar ẩn với `scrollbar-width: none`

### 3. Promotional Blocks Section:

```php
<section class="promo-blocks-section py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Left Block: Movies on the Beach -->
            <div class="col-lg-6">
                <div class="promo-block-card">
                    <div class="promo-block-image">
                        <img src="../img/movies-beach.jpg" alt="Movies on the Beach">
                        <div class="promo-block-overlay"></div>
                    </div>
                    <div class="promo-block-content">
                        <h3 class="promo-block-title">Movies on the Beach Lineup 2026</h3>
                        <p class="promo-block-text">
                            Jenkinson's Boardwalk Presents: Movies on the Beach 2026 - The Ultimate Family-Friendly Night Under the Stars...
                        </p>
                        <a href="#" class="promo-block-link">Read More</a>
                    </div>
                    <div class="promo-indicators">
                        <span class="promo-indicator active"></span>
                        <span class="promo-indicator"></span>
                        <span class="promo-indicator"></span>
                    </div>
                </div>
            </div>

            <!-- Right Block: Pricing & Hours -->
            <div class="col-lg-6">
                <!-- Similar structure -->
            </div>
        </div>
    </div>
</section>
```

**Giải thích:**
- 2 blocks side-by-side (50% mỗi bên với `col-lg-6`)
- Image với overlay gradient từ trên xuống (`linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.5) 100%)`)
- Content box màu trắng phía dưới image
- Promo indicators (dots) ở bottom của image
- Hover effect: Card lift up (`translateY(-5px)`) và image zoom (`scale(1.05)`)
- Link có hover effect: slide right (`translateX(5px)`)

### 4. Branding Section:

```php
<section class="branding-section py-5 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center justify-content-center g-4">
            <div class="col-md-4 text-center">
                <div class="brand-logo-item">
                    <h3 class="brand-logo-text">JENKINSON'S BOARDWALK</h3>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="brand-logo-item">
                    <h3 class="brand-logo-text">Jenkinson's Aquarium</h3>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="brand-logo-item">
                    <h3 class="brand-logo-text">SWEET SHOP</h3>
                </div>
            </div>
        </div>
    </div>
</section>
```

**Giải thích:**
- Background gradient màu xanh đậm (`linear-gradient(135deg, #004e92 0%, #000428 100%)`)
- Hiển thị 3 logos của các thương hiệu
- Text màu trắng, uppercase, với hover scale effect (`scale(1.05)`)
- Layout responsive: 3 columns trên desktop, stack trên mobile

---

## 🎨 CSS STYLING {#css-styling}

### Màu sắc chủ đạo:

- **Primary Blue**: `#004e92`
- **Aqua Blue**: `#0086b3` (buttons, links, accents)
- **Overlay Gradient**: `rgba(0, 78, 146, 0.4)` → `rgba(0, 4, 40, 0.3)`

### Key CSS Classes:

#### **Hero Image với overlay xanh:**
```css
.hero-image-overlay {
    background: linear-gradient(135deg, rgba(0, 78, 146, 0.4) 0%, rgba(0, 4, 40, 0.3) 100%);
    pointer-events: none;
    transition: opacity 0.3s ease;
}
```

#### **Welcome Badge màu xanh:**
```css
.welcome-badge {
    display: inline-block;
    padding: 0.4rem 1rem;
    background: #0086b3;
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border-radius: 4px;
    margin-bottom: 1rem;
}
```

#### **Button màu xanh:**
```css
.btn-body-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2.5rem;
    background: #0086b3;
    color: #ffffff;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 134, 179, 0.3);
}

.btn-body-primary:hover {
    background: #006b8f;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 134, 179, 0.4);
}

.btn-body-primary:hover i {
    transform: translateX(5px); /* Arrow slide right */
}
```

#### **Event tag màu xanh:**
```css
.event-tag-body {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    background: #0086b3;
    color: #ffffff;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border-radius: 4px;
    margin-bottom: 1rem;
}
```

#### **Navigation buttons:**
```css
.nav-btn-body {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #ffffff;
    border: 2px solid #0086b3;
    color: #0086b3;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.nav-btn-body:hover {
    background: #0086b3;
    color: #ffffff;
    transform: scale(1.1);
}
```

---

## 📱 RESPONSIVE DESIGN {#responsive-design}

### Desktop (≥992px):
- Hero card căn phải với `col-lg-6` và `margin-left: auto`
- 2 promo blocks side-by-side với `col-lg-6`
- Event cards hiển thị nhiều cards cùng lúc trong carousel
- Branding section: 3 columns

### Tablet (768px-991px):
- Hero card vẫn căn phải nhưng nhỏ hơn
- Promo blocks vẫn side-by-side
- Event cards scroll được
- Hero image height: 50vh

### Mobile (<768px):
- Hero card full width
- Promo blocks stack vertically
- Event cards scroll được với min-width
- Hero image height: 40vh
- Reduced padding và font sizes

### Key Breakpoints:

```css
@media (max-width: 991.98px) {
    .hero-image-wrapper {
        height: 50vh;
        min-height: 400px;
    }
    
    .hero-heading-body {
        font-size: 2rem;
    }
    
    .section-title-body {
        font-size: 2rem;
    }
}

@media (max-width: 575.98px) {
    .hero-image-wrapper {
        height: 40vh;
        min-height: 300px;
    }
    
    .hero-card-body {
        padding: 2rem;
    }
    
    .hero-heading-body {
        font-size: 1.75rem;
    }
    
    .event-card-body {
        min-width: 250px;
    }
}
```

---

## 🔧 MAINTENANCE & EXTENSIBILITY

### Thêm Event Card mới:

1. Copy một event card HTML
2. Thay đổi:
   - Event tag text (`event-tag-body`)
   - Event name (`event-name-body`)
   - Event date (`event-date-body`)
   - Event detail (`event-detail-body`)
3. Thêm vào `carousel-track-body` div
4. Carousel tự động scroll được

### Thêm Promo Block mới:

1. Copy một promo block HTML
2. Thay đổi:
   - Image source
   - Title (`promo-block-title`)
   - Text (`promo-block-text`)
   - Link href
3. Thêm vào `promo-blocks-section` với `col-lg-6`
4. Layout tự động điều chỉnh

### Customize Colors:

Thay đổi màu sắc trong `css/boardwalk.css`:
- Primary Blue: Tìm và thay `#004e92`
- Aqua Blue: Tìm và thay `#0086b3`
- Overlay: Điều chỉnh `rgba()` values trong `.hero-image-overlay`

---

## 📝 NOTES

- Tất cả hover effects sử dụng `transform` và `transition` để performance tốt
- Carousel sử dụng native scroll với `scroll-behavior: smooth`
- Images có `onerror` fallback để load từ Unsplash nếu local image không có
- Component sử dụng shared header và footer từ `includes/`
- CSS được tách riêng trong `css/boardwalk.css` để dễ maintain

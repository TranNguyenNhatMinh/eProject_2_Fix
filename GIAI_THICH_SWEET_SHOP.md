# GIẢI THÍCH CHI TIẾT VỀ SWEET SHOP COMPONENT
## Đồ án tốt nghiệp - Website Jenkinson's Sweet Shop

---

## 📋 MỤC LỤC
1. [Tổng quan](#tổng-quan)
2. [Cấu trúc Component](#cấu-trúc-component)
3. [CSS Styling](#css-styling)
4. [Product Cards Features](#product-cards-features)
5. [Responsive Design](#responsive-design)

---

## 🎯 TỔNG QUAN {#tổng-quan}

Sweet Shop component là một trang riêng biệt (`componets/sweet-shop.php`) với thiết kế và hiệu ứng giống Aquarium nhưng có màu sắc riêng (pink theme). Trang này tập trung vào việc hiển thị các sản phẩm kẹo và đồ ngọt dưới dạng product cards.

### File liên quan:

- **PHP**: `componets/sweet-shop.php`
- **CSS**: `css/sweet-shop.css`
- **Header Active Color**: Đỏ (#dc3545) - `--sweet-shop-red`

---

## 🏗️ CẤU TRÚC COMPONENT {#cấu-trúc-component}

### 1. Hero Image Section:

```php
<section class="hero-image-section">
    <div class="hero-image-wrapper">
        <img src="../img/sweet-shop-interior.jpg" alt="Jenkinson's Sweet Shop" 
             onerror="this.src='https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=1920&h=800&fit=crop'">
        <div class="hero-image-overlay"></div>
    </div>
</section>
```

**Giải thích:**
- Hero image full-width với overlay gradient màu hồng
- Không có welcome card như Boardwalk (chỉ có image)
- Overlay: `rgba(232, 71, 123, 0.3)` → `rgba(214, 54, 106, 0.2)`
- Hover effect: Image zoom (`scale(1.02)`)
- Image có fallback từ Unsplash nếu local image không load được

### 2. Product Cards Section:

```php
<section class="cards-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card-item">
                    <div class="card-image">
                        <img src="../img/products/apples.jpg" alt="Caramel Apples" 
                             onerror="this.src='https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?w=400&h=300&fit=crop'">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Apples</h3>
                        <p class="card-text">Delicious caramel apples with various toppings</p>
                        <p class="card-price">$6.00 - $11.00</p>
                        <a href="#" class="card-link">Select Options</a>
                    </div>
                </div>
            </div>
            <!-- More product cards -->
        </div>
    </div>
</section>
```

**Product Card Structure:**
- **Image**: 250px height, `object-fit: cover`
- **Title**: Màu hồng (#e8477b), font-weight 700
- **Description**: Màu xám (#666)
- **Price**: Màu hồng (#e8477b), font-weight 600
- **Link**: Màu hồng với hover effect

**Giải thích:**
- Grid layout: 4 columns trên desktop (`col-md-3`), 2 trên tablet (`col-sm-6`), 1 trên mobile
- Card hover effect: Lift up (`translateY(-5px)`) và shadow tăng với màu hồng
- Image zoom khi hover card (`scale(1.05)`)
- Title và link đổi màu đậm hơn khi hover (`#d6366a`)

---

## 🎨 CSS STYLING {#css-styling}

### Màu sắc chủ đạo:

- **Pink Primary**: `#e8477b`
- **Pink Dark**: `#d6366a` (hover states)
- **Overlay Gradient**: `rgba(232, 71, 123, 0.3)` → `rgba(214, 54, 106, 0.2)`

### Key CSS Classes:

#### **Hero overlay màu hồng:**
```css
.hero-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(232, 71, 123, 0.3) 0%, rgba(214, 54, 106, 0.2) 100%);
    pointer-events: none;
    transition: opacity 0.3s ease;
}
```

#### **Card title màu hồng:**
```css
.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #e8477b;
    margin-bottom: 0.75rem;
    transition: color 0.3s ease;
}

.card-item:hover .card-title {
    color: #d6366a; /* Darker pink on hover */
}
```

#### **Card hover shadow màu hồng:**
```css
.card-item {
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.card-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(232, 71, 123, 0.2); /* Pink shadow */
}
```

#### **Link màu hồng:**
```css
.card-link {
    color: #e8477b;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.card-link:hover {
    color: #d6366a;
    text-decoration: underline;
    transform: translateX(5px); /* Slide right */
}
```

#### **Price màu hồng:**
```css
.card-price {
    font-size: 1.1rem;
    font-weight: 600;
    color: #e8477b;
    margin-bottom: 0.75rem;
}
```

---

## 🎯 PRODUCT CARDS FEATURES {#product-cards-features}

### 1. Image Section:

```css
.card-image {
    width: 100%;
    height: 250px;
    overflow: hidden;
    position: relative;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.card-item:hover .card-image img {
    transform: scale(1.05); /* Zoom effect */
}
```

**Giải thích:**
- Fixed height: 250px (desktop), 200px (mobile)
- `object-fit: cover` để crop image đẹp và đều nhau
- Overflow hidden để bo góc theo card border-radius
- Zoom effect khi hover card (`scale(1.05)`)

### 2. Content Section:

```css
.card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
```

**Giải thích:**
- Padding: 1.5rem cho spacing đẹp
- Flexbox layout để căn chỉnh content
- `flex: 1` để content section chiếm không gian còn lại
- Price và link màu hồng để highlight

### 3. Hover Effects:

```css
/* Card lift up */
.card-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(232, 71, 123, 0.2);
}

/* Image zoom */
.card-item:hover .card-image img {
    transform: scale(1.05);
}

/* Title color change */
.card-item:hover .card-title {
    color: #d6366a; /* Darker pink */
}

/* Link slide right */
.card-link:hover {
    transform: translateX(5px);
}
```

**Giải thích:**
- Tất cả effects sử dụng `transform` để performance tốt
- Shadow màu hồng để match với theme
- Smooth transitions với `0.3s ease`

---

## 📱 RESPONSIVE DESIGN {#responsive-design}

### Desktop (≥992px):
- 4 columns với `col-md-3`
- Card image height: 250px
- Full padding và spacing

### Tablet (768px-991px):
- 2 columns với `col-sm-6`
- Card image height: 250px
- Reduced padding

### Mobile (<768px):
- 1 column (full width)
- Card image height: 200px
- Reduced padding: `2rem 0` cho section

### Key Breakpoints:

```css
@media (max-width: 991.98px) {
    .hero-image-wrapper {
        height: 50vh;
        min-height: 400px;
    }
    
    .cards-section {
        padding: 3rem 0;
    }
}

@media (max-width: 575.98px) {
    .hero-image-wrapper {
        height: 40vh;
        min-height: 300px;
    }
    
    .cards-section {
        padding: 2rem 0;
    }
    
    .card-image {
        height: 200px;
    }
}
```

---

## 🔧 MAINTENANCE & EXTENSIBILITY

### Thêm Product mới:

1. Copy một product card HTML:
```php
<div class="col-md-3 col-sm-6">
    <div class="card-item">
        <div class="card-image">
            <img src="../img/products/product-name.jpg" alt="Product Name" 
                 onerror="this.src='https://images.unsplash.com/...'">
        </div>
        <div class="card-content">
            <h3 class="card-title">Product Name</h3>
            <p class="card-text">Product description</p>
            <p class="card-price">$XX.XX</p>
            <a href="#" class="card-link">Select Options</a>
        </div>
    </div>
</div>
```

2. Thay đổi:
   - Image source (`src`) và alt text
   - Title (`card-title`)
   - Description (`card-text`)
   - Price (`card-price`)
   - Link text và href

3. Thêm vào `cards-section` div với class `row g-4`
4. Grid tự động điều chỉnh layout dựa trên Bootstrap columns

### Customize Colors:

Thay đổi màu sắc trong `css/sweet-shop.css`:
- Pink Primary: Tìm và thay `#e8477b`
- Pink Dark: Tìm và thay `#d6366a`
- Overlay: Điều chỉnh `rgba()` values trong `.hero-image-overlay`

### Thay đổi Grid Layout:

- **4 columns**: `col-md-3` (mỗi card chiếm 25%)
- **3 columns**: `col-md-4` (mỗi card chiếm 33.33%)
- **2 columns**: `col-md-6` (mỗi card chiếm 50%)
- **1 column**: `col-12` (full width)

---

## 📊 SO SÁNH VỚI BOARDWALK

| Feature | Boardwalk | Sweet Shop |
|---------|-----------|------------|
| **Hero** | Image + Welcome Card | Chỉ Image |
| **Main Content** | Events Carousel + Promo Blocks | Product Cards Grid |
| **Color Theme** | Blue (#0086b3) | Pink (#e8477b) |
| **Overlay** | Blue gradient | Pink gradient |
| **Focus** | Events & Promotions | Products Display |
| **Layout** | Mixed (carousel + blocks) | Grid only |
| **Interactive** | Carousel navigation | Card hover effects |

---

## 📝 NOTES

- Tất cả hover effects sử dụng `transform` và `transition` để performance tốt
- Images có `onerror` fallback để load từ Unsplash nếu local image không có
- Component sử dụng shared header và footer từ `includes/`
- CSS được tách riêng trong `css/sweet-shop.css` để dễ maintain
- Grid layout tự động responsive với Bootstrap classes
- Product cards có consistent height với flexbox (`height: 100%`)
- Shadow màu hồng tạo điểm nhấn và match với theme

---

## 🎨 DESIGN PRINCIPLES

### Color Psychology:
- **Pink**: Tạo cảm giác ngọt ngào, thân thiện, phù hợp với sweet shop
- **Red accents**: Tạo sự nổi bật và kích thích mua hàng

### Typography:
- **Title**: Bold (700) để highlight tên sản phẩm
- **Price**: Semi-bold (600) để dễ nhận biết
- **Description**: Regular weight để dễ đọc

### Spacing:
- Consistent padding: `1.5rem` cho card content
- Gap giữa cards: `g-4` (1.5rem)
- Section padding: `4rem 0` (desktop), `3rem 0` (tablet), `2rem 0` (mobile)

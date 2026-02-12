# GIẢI THÍCH CHI TIẾT VỀ JAVASCRIPT
## Đồ án tốt nghiệp - Website Jenkinson's Aquarium

---

## 📋 MỤC LỤC
1. [Tổng quan về JavaScript trong Website](#tổng-quan)
2. [Cấu trúc File JavaScript](#cấu-trúc-file)
3. [DOMContentLoaded Event](#domcontentloaded)
4. [Các Chức Năng Chính](#chức-năng)
5. [Event Listeners](#event-listeners)
6. [Intersection Observer API](#intersection-observer)
7. [Best Practices và Tips](#best-practices)

---

## 🎯 TỔNG QUAN VỀ JAVASCRIPT TRONG WEBSITE {#tổng-quan}

### JavaScript là gì?

**JavaScript** là ngôn ngữ lập trình được sử dụng để:
- Tương tác với người dùng (click, hover, scroll)
- Thay đổi nội dung trang web động
- Xử lý form và validation
- Tạo hiệu ứng và animation
- Giao tiếp với server (AJAX)

### Vai trò trong Website này:

Trong website Jenkinson's Aquarium, JavaScript được sử dụng để:
1. **Xử lý sự kiện người dùng**: Click button, navigation
2. **Tạo hiệu ứng scroll**: Animation khi scroll đến phần tử
3. **Tương tác với Bootstrap**: Modal, dropdown (mặc dù dropdown menu chủ yếu dùng CSS)
4. **Cải thiện UX**: Smooth scroll, card animations

---

## 📁 CẤU TRÚC FILE JAVASCRIPT {#cấu-trúc-file}

### File JavaScript chính:

```
js/
└── script.js    → File JavaScript chính chứa tất cả logic
```

### Cách Load JavaScript:

File JavaScript được load ở cuối trang trong `includes/footer.php`:

```php
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="js/script.js"></script>
```

**Tại sao load ở cuối trang?**
- Đảm bảo HTML đã được load xong trước khi chạy JavaScript
- Trang web hiển thị nhanh hơn (không block rendering)
- Các element đã tồn tại trong DOM khi JavaScript chạy

---

## ⚡ DOMContentLoaded EVENT {#domcontentloaded}

### Giải thích:

`DOMContentLoaded` là event được trigger khi HTML đã được parse hoàn toàn (nhưng chưa cần đợi images, stylesheets load xong).

### Code hiện tại:

```javascript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Website loaded successfully!');
    // Tất cả code JavaScript ở đây
});
```

**Cách hoạt động:**
1. Browser parse HTML
2. Khi HTML parse xong → `DOMContentLoaded` event được trigger
3. JavaScript code bên trong được thực thi
4. Các element đã sẵn sàng để thao tác

**Lợi ích:**
- ✅ Đảm bảo DOM đã sẵn sàng
- ✅ Nhanh hơn `window.onload` (không cần đợi images)
- ✅ Code chạy ngay khi có thể

**So sánh với các event khác:**

| Event | Khi nào trigger | Khi nào dùng |
|-------|----------------|--------------|
| `DOMContentLoaded` | HTML parse xong | ✅ **Dùng cho code chính** |
| `window.onload` | Tất cả (HTML, CSS, images) load xong | Khi cần đợi images |
| `window.load` | Tương tự `onload` | Khi cần đợi tất cả resources |

---

## 🎨 CÁC CHỨC NĂNG CHÍNH {#chức-năng}

### 1. CTA Button Handler (Call-to-Action Button)

**Mục đích:** Xử lý khi người dùng click vào button "Plan Your Visit"

**Code:**
```javascript
const ctaButton = document.getElementById('ctaButton');
if (ctaButton) {
    ctaButton.addEventListener('click', function() {
        alert('Welcome! This button is working. You can customize this action.');
        // You can replace this with navigation or other functionality
    });
}
```

**Giải thích từng dòng:**

1. **`document.getElementById('ctaButton')`**
   - Tìm element có `id="ctaButton"` trong HTML
   - Trả về element hoặc `null` nếu không tìm thấy

2. **`if (ctaButton)`**
   - Kiểm tra element có tồn tại không
   - Tránh lỗi nếu element không có trong trang

3. **`addEventListener('click', function() {...})`**
   - Thêm event listener cho sự kiện 'click'
   - Khi click → function bên trong được gọi

**Cách tùy chỉnh:**
```javascript
ctaButton.addEventListener('click', function() {
    // Option 1: Scroll đến section
    document.querySelector('#visit-section').scrollIntoView({ 
        behavior: 'smooth' 
    });
    
    // Option 2: Redirect đến trang khác
    window.location.href = 'visit.php';
    
    // Option 3: Mở modal
    const modal = new bootstrap.Modal(document.getElementById('visitModal'));
    modal.show();
});
```

---

### 2. Navigation Links Handler

**Mục đích:** Xử lý khi click vào các link navigation

**Code:**
```javascript
const navLinks = document.querySelectorAll('.nav-link');
navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        // Add smooth scroll behavior here if needed
        console.log('Navigation clicked:', this.textContent);
    });
});
```

**Giải thích:**

1. **`document.querySelectorAll('.nav-link')`**
   - Tìm TẤT CẢ elements có class `nav-link`
   - Trả về NodeList (giống array)

2. **`navLinks.forEach(link => {...})`**
   - Duyệt qua từng link
   - Thêm event listener cho mỗi link

3. **`this.textContent`**
   - `this` = element đang được click
   - `textContent` = text bên trong element

**Ví dụ tùy chỉnh:**
```javascript
navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        // Nếu là anchor link (#section)
        if (href.startsWith('#')) {
            e.preventDefault(); // Ngăn jump mặc định
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});
```

---

### 3. Card Animation với Intersection Observer

**Mục đích:** Tạo hiệu ứng fade-in khi scroll đến các card

**Code:**
```javascript
const cards = document.querySelectorAll('.card');
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

cards.forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});
```

**Giải thích chi tiết:**

#### **A. Intersection Observer API là gì?**

Intersection Observer là API của browser để:
- Theo dõi khi element xuất hiện trong viewport
- Hiệu quả hơn scroll event listener
- Tự động optimize performance

#### **B. Observer Options:**

```javascript
const observerOptions = {
    threshold: 0.1,                    // Trigger khi 10% element visible
    rootMargin: '0px 0px -50px 0px'   // Offset: trigger sớm hơn 50px
};
```

**Giải thích:**
- **`threshold: 0.1`**: Trigger khi 10% của card hiển thị
- **`rootMargin: '0px 0px -50px 0px'`**: 
  - Trigger khi card còn cách bottom 50px
  - Tạo hiệu ứng mượt mà hơn

#### **C. Observer Callback:**

```javascript
const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Element đang visible trong viewport
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);
```

**Giải thích:**
- **`entries`**: Array các elements đang được observe
- **`entry.isIntersecting`**: `true` nếu element visible
- **`entry.target`**: Element đang được observe
- **`style.opacity = '1'`**: Hiển thị element
- **`style.transform = 'translateY(0)'`**: Di chuyển về vị trí ban đầu

#### **D. Setup cho từng Card:**

```javascript
cards.forEach(card => {
    // 1. Ẩn card ban đầu
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    
    // 2. Thêm transition để animation mượt
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    
    // 3. Bắt đầu observe card này
    observer.observe(card);
});
```

**Kết quả:**
- Card ban đầu ẩn và ở dưới 20px
- Khi scroll đến → Card fade-in và slide lên
- Animation mượt mà với transition 0.6s

---

## 🎯 EVENT LISTENERS {#event-listeners}

### Event Listener là gì?

Event Listener là cách để "lắng nghe" các sự kiện (click, hover, scroll, etc.) và phản ứng lại.

### Cú pháp:

```javascript
element.addEventListener('event', function() {
    // Code chạy khi event xảy ra
});
```

### Các Event phổ biến:

| Event | Khi nào trigger | Ví dụ |
|-------|----------------|-------|
| `click` | Click chuột | Button, link |
| `mouseenter` | Chuột vào element | Hover effect |
| `mouseleave` | Chuột rời element | Hover effect |
| `scroll` | Scroll trang | Scroll animations |
| `submit` | Submit form | Form validation |
| `keydown` | Nhấn phím | Keyboard shortcuts |
| `load` | Page/Image load xong | Initialize |

### Ví dụ thực tế:

**1. Click Event:**
```javascript
button.addEventListener('click', function() {
    alert('Button clicked!');
});
```

**2. Hover Event:**
```javascript
element.addEventListener('mouseenter', function() {
    this.style.backgroundColor = 'blue';
});

element.addEventListener('mouseleave', function() {
    this.style.backgroundColor = 'white';
});
```

**3. Scroll Event:**
```javascript
window.addEventListener('scroll', function() {
    const scrollY = window.scrollY;
    if (scrollY > 100) {
        header.classList.add('scrolled');
    }
});
```

---

## 👁️ INTERSECTION OBSERVER API {#intersection-observer}

### Tại sao dùng Intersection Observer?

**Vấn đề với Scroll Event:**
```javascript
// ❌ KHÔNG TỐT: Scroll event chạy quá nhiều lần
window.addEventListener('scroll', function() {
    // Chạy hàng trăm lần mỗi giây
    // → Performance kém
});
```

**Giải pháp: Intersection Observer:**
```javascript
// ✅ TỐT: Chỉ chạy khi cần
const observer = new IntersectionObserver(callback, options);
observer.observe(element);
// Chỉ chạy khi element vào/ra viewport
```

### Cách hoạt động:

1. **Tạo Observer:**
   ```javascript
   const observer = new IntersectionObserver(callback, options);
   ```

2. **Observe Element:**
   ```javascript
   observer.observe(element);
   ```

3. **Callback được gọi:**
   - Khi element vào viewport
   - Khi element ra khỏi viewport
   - Khi threshold thay đổi

### Options chi tiết:

```javascript
const options = {
    root: null,              // Viewport (null = viewport)
    rootMargin: '0px',       // Margin cho root
    threshold: 0.5           // 0.0 - 1.0 (50% visible)
};
```

**Ví dụ threshold:**
- `threshold: 0` → Trigger ngay khi element chạm viewport
- `threshold: 0.5` → Trigger khi 50% element visible
- `threshold: 1` → Trigger khi 100% element visible
- `threshold: [0, 0.5, 1]` → Trigger ở cả 3 mốc

### Use Cases:

**1. Lazy Loading Images:**
```javascript
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src; // Load image
            imageObserver.unobserve(img);
        }
    });
});

document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
});
```

**2. Infinite Scroll:**
```javascript
const loadMoreObserver = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
        loadMoreContent();
    }
});

loadMoreObserver.observe(document.querySelector('.load-more-trigger'));
```

**3. Animation on Scroll (như trong code):**
```javascript
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
        }
    });
});
```

---

## 💡 BEST PRACTICES VÀ TIPS {#best-practices}

### 1. Luôn kiểm tra Element tồn tại

**❌ KHÔNG TỐT:**
```javascript
document.getElementById('button').addEventListener('click', ...);
// Lỗi nếu button không tồn tại!
```

**✅ TỐT:**
```javascript
const button = document.getElementById('button');
if (button) {
    button.addEventListener('click', ...);
}
```

### 2. Sử dụng `querySelector` vs `getElementById`

| Method | Trả về | Khi nào dùng |
|--------|--------|--------------|
| `getElementById` | 1 element | Khi có ID cụ thể |
| `querySelector` | 1 element | Khi dùng CSS selector |
| `querySelectorAll` | NodeList | Khi cần nhiều elements |

**Ví dụ:**
```javascript
// ID
const button = document.getElementById('ctaButton');

// Class (first one)
const card = document.querySelector('.card');

// All classes
const cards = document.querySelectorAll('.card');

// Complex selector
const link = document.querySelector('nav .nav-link.active');
```

### 3. Arrow Functions vs Regular Functions

**Arrow Function:**
```javascript
element.addEventListener('click', () => {
    console.log('Clicked');
});
```

**Regular Function:**
```javascript
element.addEventListener('click', function() {
    console.log('Clicked');
    console.log(this); // 'this' = element
});
```

**Khác biệt:**
- Arrow function: `this` không bind
- Regular function: `this` = element được click

### 4. Event Delegation (Ủy quyền Event)

**❌ KHÔNG TỐT:**
```javascript
// Thêm listener cho từng button
buttons.forEach(button => {
    button.addEventListener('click', ...);
});
// Nếu thêm button mới → không có listener
```

**✅ TỐT:**
```javascript
// Thêm listener cho parent
container.addEventListener('click', function(e) {
    if (e.target.classList.contains('button')) {
        // Xử lý click
    }
});
// Button mới tự động có listener
```

### 5. Debounce và Throttle

**Vấn đề:** Scroll event chạy quá nhiều lần

**Giải pháp: Throttle**
```javascript
function throttle(func, wait) {
    let timeout;
    return function() {
        if (!timeout) {
            timeout = setTimeout(() => {
                func();
                timeout = null;
            }, wait);
        }
    };
}

window.addEventListener('scroll', throttle(function() {
    console.log('Scrolled');
}, 100)); // Chỉ chạy mỗi 100ms
```

### 6. Console.log để Debug

```javascript
console.log('Value:', value);           // Log giá trị
console.error('Error:', error);         // Log lỗi (màu đỏ)
console.warn('Warning:', warning);      // Log cảnh báo (màu vàng)
console.table(array);                   // Log dạng bảng
```

### 7. Performance Tips

**✅ TỐT:**
- Dùng `querySelector` thay vì `getElementsByTagName`
- Cache DOM elements vào biến
- Dùng `IntersectionObserver` thay vì scroll event
- Remove event listeners khi không cần

**❌ KHÔNG TỐT:**
- Query DOM nhiều lần trong loop
- Thêm quá nhiều event listeners
- Dùng `innerHTML` thay vì `textContent`

---

## 📝 TÓM TẮT QUAN TRỌNG

### Cấu trúc Code:

1. **DOMContentLoaded**: Đảm bảo DOM sẵn sàng
2. **Query Elements**: Tìm elements cần thao tác
3. **Add Event Listeners**: Thêm các sự kiện
4. **Setup Observers**: Tạo Intersection Observer cho animations

### Các Khái niệm Chính:

- **DOM**: Document Object Model (cấu trúc HTML)
- **Event**: Sự kiện (click, scroll, hover)
- **Event Listener**: Lắng nghe và phản ứng với event
- **Intersection Observer**: API để detect element vào viewport
- **Callback Function**: Function được gọi khi event xảy ra

### Flow hoạt động:

```
Page Load → DOMContentLoaded → Query Elements → Add Listeners → Ready!
                                                                    ↓
                                                           User Interaction
                                                                    ↓
                                                           Event Triggered
                                                                    ↓
                                                           Callback Executed
```

---

## 🎓 KIẾN THỨC ÁP DỤNG

1. **DOM Manipulation**: Query, modify elements
2. **Event Handling**: Click, scroll, hover events
3. **Intersection Observer API**: Scroll animations
4. **ES6 Features**: Arrow functions, const/let
5. **Performance Optimization**: Efficient event handling
6. **Debugging**: Console.log, browser DevTools

---

## 🔧 CÁCH MỞ RỘNG

### Thêm chức năng mới:

1. **Smooth Scroll cho Navigation:**
```javascript
navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href.startsWith('#')) {
            e.preventDefault();
            document.querySelector(href).scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});
```

2. **Back to Top Button:**
```javascript
const backToTop = document.createElement('button');
backToTop.textContent = '↑';
backToTop.className = 'back-to-top';
backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
document.body.appendChild(backToTop);
```

3. **Form Validation:**
```javascript
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.querySelector('input[type="email"]').value;
    if (!email.includes('@')) {
        alert('Email không hợp lệ!');
        return;
    }
    // Submit form
    this.submit();
});
```

---

**Tài liệu này giải thích chi tiết về JavaScript trong website. Nếu có thắc mắc, hãy tham khảo các ví dụ và giải thích ở trên!**

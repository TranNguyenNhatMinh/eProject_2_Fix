# JavaScript Files Organization

## Folder Structure

```
js/
├── common/          # Common scripts used across multiple pages
│   └── newsletter.js    # Newsletter subscription form handler
├── pages/           # Page-specific scripts
│   ├── homepage.js      # Homepage slider and experiences
│   └── product-detail.js  # Product detail page (quantity, add to cart)
└── components/      # Reusable component scripts (future use)
```

## File Descriptions

### common/newsletter.js
- **Purpose**: Handles newsletter subscription form submission via AJAX
- **Used on**: All pages (footer contains subscription form)
- **Features**: 
  - AJAX form submission without page reload
  - Success/error message display
  - Auto-hide success messages

### pages/homepage.js
- **Purpose**: Handles homepage-specific interactions
- **Used on**: Homepage (index.php) only
- **Features**:
  - Hero banner slider indicators
  - Featured experiences auto-slider
  - Manual dot navigation

### pages/product-detail.js
- **Purpose**: Handles product detail page functionality
- **Used on**: Product detail page (componets/product-detail.php)
- **Features**:
  - Quantity calculation (price × quantity)
  - Add to cart via AJAX
  - Cart count update in header
  - Success message display

## Usage

Files are automatically loaded based on the page:
- `newsletter.js` is loaded on all pages via footer.php
- `homepage.js` is loaded only on homepage
- `product-detail.js` is loaded only on product detail page

## Adding New Scripts

1. **Common scripts**: Add to `js/common/` folder
2. **Page-specific scripts**: Add to `js/pages/` folder
3. **Component scripts**: Add to `js/components/` folder
4. Update the appropriate PHP file to include the new script

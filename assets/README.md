# Assets Directory

This directory contains all static assets for the Catering Service signup system.

## 📁 Directory Structure

```
assets/
├── css/
│   └── style.css          # Main stylesheet with Bootstrap customizations
├── js/
│   └── script.js          # jQuery/AJAX functionality and form handling
├── images/
│   └── .gitkeep          # Placeholder for future images
├── fonts/
│   └── .gitkeep          # Placeholder for custom fonts
└── README.md             # This file
```

## 🎨 CSS (Stylesheets)

### `css/style.css`
- **Bootstrap 5 Customizations**: Overrides and extensions for Bootstrap components
- **White Text Theme**: Custom styling for the signup form with white text
- **Responsive Design**: Mobile-first approach with breakpoints
- **Animations**: Smooth transitions and hover effects
- **Form Styling**: Custom form controls with glass-morphism effect

**Key Features:**
- Gradient backgrounds
- Glass-morphism form design
- Custom button styles
- Real-time validation styling
- Loading state animations

## 🔧 JavaScript

### `js/script.js`
- **jQuery Integration**: Enhanced user interactions
- **AJAX Form Submission**: Seamless form processing without page reloads
- **Real-time Validation**: Instant feedback on form inputs
- **Phone Formatting**: Auto-format phone numbers as user types
- **Email Checking**: Debounced email availability checking

**Key Functions:**
- Password toggle visibility
- Form validation and submission
- Alert system for user feedback
- Email existence checking
- Phone number formatting

## 🖼️ Images

### Recommended Structure
```
images/
├── logos/
│   ├── logo.png
│   ├── logo-white.png
│   └── favicon.ico
├── backgrounds/
│   ├── hero-bg.jpg
│   └── pattern-overlay.png
├── icons/
│   ├── catering-icon.svg
│   └── success-icon.svg
└── gallery/
    ├── food-1.jpg
    ├── food-2.jpg
    └── event-1.jpg
```

### Image Guidelines
- **Formats**: Use WebP for modern browsers, with JPG/PNG fallbacks
- **Optimization**: Compress images for web (aim for <100KB for photos)
- **Responsive**: Provide multiple sizes for different screen densities
- **Alt Text**: Always include descriptive alt text for accessibility

## 🔤 Fonts

### Recommended Structure
```
fonts/
├── custom-font/
│   ├── CustomFont-Regular.woff2
│   ├── CustomFont-Bold.woff2
│   └── CustomFont-Light.woff2
└── icons/
    ├── catering-icons.woff2
    └── catering-icons.css
```

### Font Guidelines
- **Formats**: Use WOFF2 for modern browsers, WOFF for fallback
- **Performance**: Limit to 2-3 font families maximum
- **Loading**: Use `font-display: swap` for better performance
- **Fallbacks**: Always include web-safe font fallbacks

## 🚀 Performance Optimization

### Caching Strategy (via .htaccess)
- **CSS/JS**: 1 year cache (versioning for updates)
- **Images**: 1 year cache
- **Fonts**: 1 year cache
- **Cache-Control**: Public with max-age headers

### Best Practices
1. **Minification**: Minify CSS and JS for production
2. **Compression**: Enable GZIP compression via server
3. **CDN**: Consider using a CDN for static assets
4. **Bundling**: Combine multiple CSS/JS files when possible
5. **Lazy Loading**: Implement for images below the fold

## 🔧 Development Workflow

### Adding New Assets

1. **CSS Files**:
   ```bash
   # Add to assets/css/
   assets/css/components.css
   assets/css/utilities.css
   ```

2. **JavaScript Files**:
   ```bash
   # Add to assets/js/
   assets/js/validation.js
   assets/js/api.js
   ```

3. **Images**:
   ```bash
   # Add to appropriate subfolder
   assets/images/logos/new-logo.png
   assets/images/backgrounds/hero-2.jpg
   ```

### File Naming Convention
- **Lowercase**: Use lowercase with hyphens
- **Descriptive**: Clear, descriptive names
- **Versioning**: Include version for major updates (e.g., `style-v2.css`)

Examples:
```
✅ Good: signup-form.css, user-validation.js, hero-background.jpg
❌ Bad: SignUp.css, validation1.js, img1.jpg
```

## 🔗 Integration

### HTML References
```html
<!-- CSS -->
<link rel="stylesheet" href="assets/css/style.css">

<!-- JavaScript -->
<script src="assets/js/script.js"></script>

<!-- Images -->
<img src="assets/images/logos/logo.png" alt="Catering Service Logo">
```

### CSS References
```css
/* Background images */
background-image: url('../images/backgrounds/hero-bg.jpg');

/* Fonts */
@font-face {
    font-family: 'CustomFont';
    src: url('../fonts/custom-font/CustomFont-Regular.woff2') format('woff2');
}
```

## 📱 Responsive Considerations

### Breakpoints (Bootstrap 5)
- **xs**: <576px (extra small devices)
- **sm**: ≥576px (small devices)
- **md**: ≥768px (medium devices)  
- **lg**: ≥992px (large devices)
- **xl**: ≥1200px (extra large devices)
- **xxl**: ≥1400px (extra extra large devices)

### Image Optimization
```html
<!-- Responsive images -->
<picture>
    <source media="(min-width: 768px)" srcset="assets/images/hero-desktop.webp">
    <source media="(min-width: 576px)" srcset="assets/images/hero-tablet.webp">
    <img src="assets/images/hero-mobile.webp" alt="Hero Image">
</picture>
```

## 🔒 Security Notes

- **File Types**: Only allow safe file types (CSS, JS, images, fonts)
- **Upload Validation**: Validate file types and sizes for user uploads
- **Access Control**: Assets directory allows public access (configured in .htaccess)
- **Content Security Policy**: CSP headers configured for external CDNs

## 📊 Monitoring

### Performance Metrics to Track
- **Load Times**: CSS and JS load times
- **File Sizes**: Monitor asset sizes
- **Cache Hit Rates**: Effectiveness of caching strategy
- **Core Web Vitals**: Impact on page speed scores

### Tools
- Google PageSpeed Insights
- GTmetrix
- WebPageTest
- Chrome DevTools Network tab 
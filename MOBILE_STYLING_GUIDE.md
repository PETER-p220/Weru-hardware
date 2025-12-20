# Mobile-First Styling Guide - Oweru Hardware

## Overview
This guide documents the comprehensive mobile-first styling system implemented for the Oweru Hardware application. The system ensures optimal user experience across all device sizes with responsive font sizing, spacing, and component customization.

---

## 1. Responsive Breakpoints

All views use Tailwind CSS breakpoints with mobile-first approach:

```
xs: 320px   (small phones)
sm: 640px   (phones/tablets)
md: 768px   (tablets/small laptops)
lg: 1024px  (laptops)
xl: 1280px  (large screens)
2xl: 1536px (large monitors)
```

### Mobile-First Pattern
```html
<!-- Base (mobile): text-xs, then scales up -->
<p class="text-xs xs:text-sm sm:text-base md:text-lg">Text</p>

<!-- Spacing (mobile): p-2, then scales up -->
<div class="p-2 xs:p-3 sm:p-4 md:p-6">Content</div>

<!-- Sizes (mobile): w-8, then scales up -->
<button class="px-2 py-1.5 xs:px-3 xs:py-2 sm:px-4 sm:py-2.5">Click</button>
```

---

## 2. Typography System

### Font Sizes (Mobile-First)
All headings and text scale progressively from small to large screens:

```css
h1: text-2xl → xs:text-3xl → sm:text-4xl → md:text-5xl → lg:text-6xl
h2: text-xl → xs:text-2xl → sm:text-3xl → md:text-4xl → lg:text-5xl
h3: text-lg → xs:text-xl → sm:text-2xl → md:text-3xl → lg:text-4xl
h4: text-base → xs:text-lg → sm:text-xl → md:text-2xl → lg:text-3xl
h5: text-sm → xs:text-base → sm:text-lg → md:text-xl → lg:text-2xl

body: text-xs → xs:text-sm → md:text-base
p: text-xs → xs:text-sm → sm:text-base → md:text-base → lg:text-lg
small: text-2xs → xs:text-xs → sm:text-sm → md:text-sm → lg:text-base
```

### Implementation
Add font sizing to body tag:
```html
<body class="text-xs xs:text-sm md:text-base">
```

---

## 3. Spacing System

### Container Padding (Mobile-First)
```
DEFAULT: px-3 xs:px-4 sm:px-6 lg:px-8
```

### Sections
```
py-4 xs:py-6 sm:py-8 md:py-12 lg:py-12
```

### Gap Between Items
```
gap-2 xs:gap-3 sm:gap-4 md:gap-6
```

### Cards & Boxes
```
p-3 xs:p-4 sm:p-6 md:p-8 rounded-lg xs:rounded-xl sm:rounded-2xl
```

---

## 4. Component Sizing

### Buttons (Mobile-Optimized)

**Small Buttons:**
```html
<button class="px-2 xs:px-3 sm:px-4 py-1.5 xs:py-2 sm:py-2.5 text-xs xs:text-sm sm:text-base touch-target">
```

**Medium Buttons:**
```html
<button class="px-3 xs:px-4 sm:px-6 py-2 xs:py-2.5 sm:py-3 text-sm xs:text-base sm:text-lg touch-target">
```

**Large Buttons:**
```html
<button class="px-4 xs:px-6 sm:px-8 py-2.5 xs:py-3 sm:py-4 text-base xs:text-lg sm:text-xl touch-target">
```

### Form Inputs (Mobile-Optimized)

```html
<input class="px-2 xs:px-3 sm:px-4 py-1.5 xs:py-2 sm:py-2.5 text-xs xs:text-sm sm:text-base md:text-base touch-target rounded-md xs:rounded-lg sm:rounded-xl">
```

### Labels

```html
<label class="text-2xs xs:text-xs sm:text-sm md:text-base font-medium">Label Text</label>
```

### Error Messages

```html
<p class="text-2xs xs:text-xs sm:text-sm md:text-base text-red-600 font-medium">Error text</p>
```

---

## 5. Mobile-Specific Utilities (app.css)

### Touch Target Sizes
Ensures minimum 44x44px tap area on mobile:
```html
<button class="touch-target">Click me</button>
```

### Mobile-Specific Classes

```css
/* Buttons */
.btn-sm-mobile    → px-2 py-1.5 text-xs with md: scaling
.btn-md-mobile    → px-3 py-2 text-sm with md: scaling
.btn-lg-mobile    → px-4 py-2.5 text-base with md: scaling

/* Inputs */
.input-sm-mobile  → Mobile-optimized input sizing
.input-md-mobile  → Larger mobile input sizing

/* Labels */
.label-sm-mobile  → text-2xs xs:text-xs sm:text-sm md:text-base
.label-md-mobile  → text-xs xs:text-sm sm:text-base md:text-lg

/* Cards & Sections */
.card-sm-mobile   → p-3 xs:p-4 sm:p-6 md:p-8 with responsive rounding
.section-sm-mobile → px-mobile + py-mobile with responsive sizing
.feature-card-mobile → Optimized for feature sections

/* Spacing Utilities */
.gap-sm-mobile    → gap-2 xs:gap-3 sm:gap-4 md:gap-6
.px-mobile        → px-3 xs:px-4 sm:px-6 md:px-8
.py-mobile        → py-2 xs:py-3 sm:py-4 md:py-6
.p-mobile         → p-3 xs:p-4 sm:p-6 md:p-8

/* Visibility */
.hide-mobile      → Hidden on mobile, visible on md+
.show-mobile      → Visible on mobile, hidden on md+
.hide-tablet      → Hidden on tablet, visible on lg+
.show-tablet      → Visible on md-lg, hidden on lg+

/* Text Utilities */
.line-clamp-1-mobile  → 2 lines on mobile, 1 on md+
.line-clamp-2-mobile  → 3 lines on mobile, 2 on md+
.truncate-mobile      → Ellipsis overflow handling
```

---

## 6. Navigation Sizing

### Header Height (Mobile-First)
```
h-12 xs:h-14 sm:h-16  (Header grows from 48px to 64px)
```

### Logo Sizing
```
w-8 xs:w-9 sm:w-10 md:h-12  (Logo grows progressively)
```

### Navigation Links
```html
<a class="px-1 xs:px-2 sm:px-3 py-1 xs:py-1.5 text-2xs xs:text-xs sm:text-sm md:text-base">
```

### Hamburger Menu
```html
<button class="p-1.5 xs:p-2 touch-target rounded-md">
    <svg class="h-5 xs:h-6 w-5 xs:w-6"></svg>
</button>
```

---

## 7. Common Patterns

### Hero Section
```html
<div class="px-3 xs:px-4 sm:px-6 lg:px-8 py-6 xs:py-8 sm:py-12 md:py-16">
    <h1 class="text-2xl xs:text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black">
        Hero Title
    </h1>
    <p class="text-xs xs:text-sm sm:text-base md:text-lg mt-3 xs:mt-4 sm:mt-6">
        Hero description
    </p>
</div>
```

### Card Grid
```html
<div class="grid grid-cols-1 xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 xs:gap-4 sm:gap-6">
    <div class="p-3 xs:p-4 sm:p-6 md:p-8 rounded-lg xs:rounded-xl sm:rounded-2xl">
        <!-- Card content -->
    </div>
</div>
```

### Form Section
```html
<form class="space-y-3 xs:space-y-4 sm:space-y-5 md:space-y-6">
    <div>
        <label class="text-2xs xs:text-xs sm:text-sm font-medium">Field</label>
        <input class="mt-1 xs:mt-1.5 sm:mt-2 w-full px-2 xs:px-3 sm:px-4 py-1.5 xs:py-2 sm:py-2.5 text-xs xs:text-sm sm:text-base">
    </div>
</form>
```

---

## 8. Best Practices

### ✅ DO:
- Always start with mobile base sizes (no prefix)
- Use progressive enhancement (xs → sm → md → lg → xl)
- Test on actual devices and browser dev tools
- Use `touch-target` class for interactive elements
- Use consistent spacing scales (2, 3, 4, 6 ratio)
- Use responsive border-radius (rounded-lg xs:rounded-xl sm:rounded-2xl)

### ❌ DON'T:
- Start with md: or larger breakpoint sizes
- Use fixed sizes that don't scale
- Forget focus states for mobile keyboards
- Use very small text on mobile (minimum 12px)
- Mix size scales (don't use random px values)
- Forget to test tap targets (minimum 44x44px)

---

## 9. Testing Checklist

- [ ] Test at 320px width (small phones)
- [ ] Test at 375px width (standard phones)
- [ ] Test at 768px width (tablets)
- [ ] Test at 1024px width (small laptops)
- [ ] Test at 1280px+ (large screens)
- [ ] Test touch interactions on mobile
- [ ] Test form input focus states
- [ ] Verify no horizontal scroll on mobile
- [ ] Check image scaling
- [ ] Test navigation/menu interactions

---

## 10. File References

**Configuration:**
- `tailwind.config.js` - Breakpoints, font sizes, spacing, colors
- `resources/css/app.css` - Mobile typography, components, utilities

**Components:**
- `resources/views/components/primary-button.blade.php`
- `resources/views/components/secondary-button.blade.php`
- `resources/views/components/danger-button.blade.php`
- `resources/views/components/text-input.blade.php`
- `resources/views/components/input-label.blade.php`
- `resources/views/components/input-error.blade.php`
- `resources/views/components/nav-link.blade.php`
- `resources/views/components/responsive-nav-link.blade.php`

**Layouts:**
- `resources/views/layouts/app.blade.php` - Main layout with responsive body sizing
- `resources/views/layouts/guest.blade.php` - Auth layout with mobile optimization
- `resources/views/layouts/navigation.blade.php` - Header with mobile menu

**Pages:**
- `resources/views/auth/login.blade.php` - Mobile-first login form
- `resources/views/products.blade.php` - Product grid with mobile navigation
- And all other views in `resources/views/`

---

## 11. Quick Reference Chart

| Element | Mobile (xs) | Tablet (sm) | Desktop (md+) |
|---------|-----------|-----------|--------------|
| H1 Text | 2xl | 3xl/4xl | 5xl/6xl |
| Body Text | xs/sm | sm/base | base/lg |
| Buttons | px-2, py-1.5 | px-3, py-2 | px-4, py-2.5 |
| Inputs | px-2, py-1.5 | px-3, py-2 | px-4, py-2.5 |
| Card Padding | p-3 | p-4 | p-6/p-8 |
| Gap | gap-2 | gap-3 | gap-4/gap-6 |
| Container PX | px-3 | px-4 | px-6/px-8 |

---

## 12. Support & Questions

For questions or issues with mobile styling:
1. Check this guide for patterns
2. Review component implementations in `resources/views/components/`
3. Verify breakpoint usage in `tailwind.config.js`
4. Test in browser DevTools responsive mode
5. Check `app.css` for utility classes

---

*Last Updated: November 2025*
*Weru Hardware - Mobile-First Responsive Design System*

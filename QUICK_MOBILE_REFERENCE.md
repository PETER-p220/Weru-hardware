# Quick Mobile Styling Reference

## Fastest Patterns to Copy-Paste

### Button
```html
<button class="px-2 xs:px-3 sm:px-4 py-1.5 xs:py-2 sm:py-2.5 text-xs xs:text-sm sm:text-base touch-target rounded-md xs:rounded-lg sm:rounded-xl bg-primary text-white font-semibold hover:bg-primary-dark transition">
    Button Text
</button>
```

### Input
```html
<input type="text" class="w-full px-2 xs:px-3 sm:px-4 py-1.5 xs:py-2 sm:py-2.5 text-xs xs:text-sm sm:text-base touch-target rounded-md xs:rounded-lg sm:rounded-xl border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-500 focus:ring-offset-1 xs:focus:ring-offset-2">
```

### Label
```html
<label class="text-2xs xs:text-xs sm:text-sm md:text-base font-medium text-gray-800">
    Label Text
</label>
```

### Card
```html
<div class="p-3 xs:p-4 sm:p-6 md:p-8 rounded-lg xs:rounded-xl sm:rounded-2xl bg-white shadow-md hover:shadow-lg transition border border-gray-200">
    Card content
</div>
```

### Grid
```html
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 xs:gap-4 sm:gap-6">
    <!-- items -->
</div>
```

### Section
```html
<section class="px-3 xs:px-4 sm:px-6 lg:px-8 py-4 xs:py-6 sm:py-8 md:py-12">
    <h2 class="text-lg xs:text-xl sm:text-2xl md:text-3xl font-bold mb-4 xs:mb-6">Title</h2>
    <!-- content -->
</section>
```

### Header with Logo
```html
<header class="h-12 xs:h-14 sm:h-16 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-3 xs:px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between">
        <img src="logo.png" alt="Logo" class="h-8 xs:h-9 sm:h-10 w-auto">
        <nav class="space-x-2 xs:space-x-3 sm:space-x-4">
            <a href="#" class="text-2xs xs:text-xs sm:text-sm md:text-base font-medium hover:text-primary">Link</a>
        </nav>
    </div>
</header>
```

### Form
```html
<form class="space-y-3 xs:space-y-4 sm:space-y-5 md:space-y-6">
    <div>
        <label class="text-2xs xs:text-xs sm:text-sm font-medium text-gray-800">Field</label>
        <input type="text" class="w-full mt-1 xs:mt-1.5 sm:mt-2 px-2 xs:px-3 sm:px-4 py-1.5 xs:py-2 sm:py-2.5 text-xs xs:text-sm sm:text-base touch-target rounded-md xs:rounded-lg border border-gray-300 focus:border-primary focus:ring-primary">
    </div>
</form>
```

### Alert/Notification
```html
<div class="p-3 xs:p-4 sm:p-5 rounded-lg xs:rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-2xs xs:text-xs sm:text-sm">
    <strong class="font-semibold">Note:</strong> Message text
</div>
```

---

## Size Scales (Never Use Random Values)

### Padding/Margin Scale
```
2 (0.5rem) → 3 (0.75rem) → 4 (1rem) → 6 (1.5rem) → 8 (2rem)
```

### Font Size Scale
```
2xs (0.625rem) → xs (0.75rem) → sm (0.875rem) → base (1rem) → lg (1.125rem) → xl (1.25rem)
```

### Gap Scale
```
2 (0.5rem) → 3 (0.75rem) → 4 (1rem) → 6 (1.5rem)
```

---

## Mobile-First Progression Pattern

**Always use this pattern:**
```
Base (xs) → xs: → sm: → md: → lg: → xl:
```

**Examples:**
```html
<!-- Font scaling -->
class="text-xs xs:text-sm sm:text-base md:text-lg"

<!-- Padding scaling -->
class="p-2 xs:p-3 sm:p-4 md:p-6"

<!-- Gap scaling -->
class="gap-2 xs:gap-3 sm:gap-4 md:gap-6"

<!-- Rounding scaling -->
class="rounded-md xs:rounded-lg sm:rounded-xl"
```

---

## Breakpoint Widths

| Class | Width |
|-------|-------|
| xs: | 320px |
| sm: | 640px |
| md: | 768px |
| lg: | 1024px |
| xl: | 1280px |
| 2xl: | 1536px |

---

## Special Utility Classes

### Touch Target (44x44px minimum)
```html
class="touch-target"
<!-- = min-h-11 min-w-11 xs:min-h-12 xs:min-w-12 md:min-h-10 md:min-w-10 -->
```

### Responsive Spacing
```html
class="px-mobile"   <!-- px-3 xs:px-4 sm:px-6 md:px-8 -->
class="py-mobile"   <!-- py-2 xs:py-3 sm:py-4 md:py-6 -->
class="p-mobile"    <!-- p-3 xs:p-4 sm:p-6 md:p-8 -->
class="gap-sm-mobile" <!-- gap-2 xs:gap-3 sm:gap-4 md:gap-6 -->
```

### Visibility
```html
class="hide-mobile"  <!-- Hidden on xs-sm, visible on md+ -->
class="show-mobile"  <!-- Visible on xs-sm, hidden on md+ -->
```

---

## Common Breakpoints Pattern

### Responsive Layout
```html
<!-- 1 column on mobile, 2 on tablet, 3+ on desktop -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
```

### Hide/Show Pattern
```html
<!-- Show navigation menu on md and up, hide hamburger -->
<div class="hidden md:flex">Desktop Menu</div>
<button class="md:hidden">☰ Mobile Menu</button>
```

### Flex Direction
```html
<div class="flex flex-col sm:flex-row gap-4">
```

---

## Color System

### Primary Colors (Using Tailwind Color Class)
```
primary-700   (Default, dark blue-teal)
primary-600   (Hover state)
primary-800   (Active state)
primary-50    (Background, light)
primary-100   (Border, light)
```

### Using in Classes
```html
class="bg-primary-700 hover:bg-primary-600 text-white"
class="border-primary-100 bg-primary-50"
```

---

## Focus States (Mobile-Friendly)

### Desktop Style
```html
focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2
```

### Mobile-Optimized
```html
focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-1 xs:focus:ring-offset-2
```

---

## Text Overflow Utilities

### Line Clamping
```html
class="line-clamp-1"   <!-- Truncate to 1 line -->
class="line-clamp-2"   <!-- Truncate to 2 lines -->
class="line-clamp-3"   <!-- Truncate to 3 lines -->

<!-- Mobile adaptive -->
class="line-clamp-2 md:line-clamp-1"  <!-- 2 lines mobile, 1 desktop -->
```

### Truncate
```html
class="truncate"  <!-- Single line with ellipsis -->
```

---

## Layout Snippets

### Centered Content
```html
<div class="max-w-7xl mx-auto px-3 xs:px-4 sm:px-6 lg:px-8">
    <!-- Content -->
</div>
```

### Sticky Header
```html
<header class="sticky top-0 z-50 bg-white border-b shadow-sm">
```

### Mobile Menu Overlay
```html
<div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>
<aside class="fixed inset-y-0 left-0 w-64 z-50 transform -translate-x-full md:translate-x-0">
```

---

## Testing Guide

### Test Sizes
- 320px (iPhone SE)
- 375px (iPhone)
- 640px (tablet portrait)
- 768px (tablet)
- 1024px (small laptop)
- 1280px (desktop)

### Browser DevTools
1. Open Chrome DevTools
2. Click device toggle (Ctrl+Shift+M / Cmd+Shift+M)
3. Select responsive mode
4. Test at each breakpoint

---

## Don't Forget!

✅ Always include `touch-target` on buttons/inputs
✅ Test on real mobile devices
✅ Use consistent spacing scale (2,3,4,6)
✅ Mobile-first: base size first, no prefix
✅ Focus states on form elements
✅ Responsive border radius
✅ Proper container max-width (max-w-7xl)
✅ Include @vite directives

❌ Don't use random px values
❌ Don't skip mobile breakpoints
❌ Don't forget focus states
❌ Don't use md: or lg: as base size
❌ Don't forget touch targets
❌ Don't hardcode sizes
❌ Don't mix size scales

---

*Mobile Styling Quick Reference*
*Weru Hardware - November 2025*

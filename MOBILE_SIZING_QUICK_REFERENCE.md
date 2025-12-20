# Mobile Sizing Quick Reference Guide

## Mobile-First Font Sizing Pattern

This guide documents the mobile sizing reduction pattern applied to the Oweru Hardware app.

### Standard Typography Scales

```
TEXT SIZES (Mobile-First)
┌─────────────────────────────────────────────────────────────┐
│ Tailwind Class    │ Base    │ xs        │ sm        │ md    │
├─────────────────────────────────────────────────────────────┤
│ text-2xs          │ 9px     │ 9px       │ 11px      │ 12px  │
│ text-xs           │ 11px    │ 12px      │ 13px      │ 14px  │
│ text-sm           │ 13px    │ 14px      │ 15px      │ 16px  │
│ text-base         │ 16px    │ 18px      │ 20px      │ 22px  │
│ text-lg           │ 18px    │ 20px      │ 22px      │ 24px  │
│ text-xl           │ 20px    │ 24px      │ 28px      │ 30px  │
└─────────────────────────────────────────────────────────────┘

BREAKPOINTS:
xs = 320px (mobile)
sm = 640px (small phone)
md = 768px (tablet)
lg = 1024px (desktop)
```

### Common Component Patterns

#### Headings

**h1 (Page Titles):**
```html
<!-- Use this for main headings -->
<h1 class="text-base xs:text-lg sm:text-2xl md:text-3xl">
  Page Title
</h1>
```

**h2 (Section Headings):**
```html
<h2 class="text-sm xs:text-base sm:text-xl md:text-2xl">
  Section Title
</h2>
```

**h3 (Subsections):**
```html
<h3 class="text-xs xs:text-sm sm:text-lg md:text-xl">
  Subsection
</h3>
```

#### Body Text

**Regular Paragraph:**
```html
<p class="text-2xs xs:text-xs sm:text-sm md:text-base">
  Paragraph content...
</p>
```

**Emphasized Text:**
```html
<p class="text-xs xs:text-sm sm:text-base md:text-lg font-semibold">
  Important text
</p>
```

#### Form Elements

**Input Fields:**
```html
<input class="px-2 xs:px-3 sm:px-5 py-1 xs:py-1.5 sm:py-3 
              text-2xs xs:text-xs sm:text-base">
```

**Labels:**
```html
<label class="text-2xs xs:text-2xs sm:text-xs md:text-sm font-bold">
  Field Label
</label>
```

**Error Messages:**
```html
<p class="text-2xs xs:text-2xs sm:text-xs md:text-sm text-red-600">
  Error message
</p>
```

#### Buttons

**Primary Button:**
```html
<button class="px-2 xs:px-3 sm:px-4 py-1 xs:py-1.5 sm:py-2 
               text-2xs xs:text-xs sm:text-base font-bold">
  Button Text
</button>
```

#### Components

**Card Padding:**
```html
<div class="p-2 xs:p-3 sm:p-6">
  Card content
</div>
```

**Navigation Links:**
```html
<a class="text-xs xs:text-sm sm:text-base md:text-lg">
  Link
</a>
```

**Icons (fa-solid):**
```html
<i class="fa-solid fa-icon h-3 xs:h-4 sm:h-5 md:h-6 w-3 xs:w-4 sm:w-5 md:w-6"></i>
```

---

## Mobile-First Spacing Pattern

### Padding & Margin Scales

```
Base → xs → sm → md

px:  3 → 3 → 4 → 6
py:  2 → 2 → 3 → 4
mb:  2 → 2 → 4 → 6
mt:  1 → 2 → 3 → 4
gap: 2 → 2 → 4 → 6
```

### Spacing Examples

**Section Spacing:**
```html
<section class="py-2 xs:py-3 sm:py-6 md:py-12 px-3 xs:px-4 sm:px-6">
  Content
</section>
```

**Component Gaps:**
```html
<div class="flex gap-2 xs:gap-2 sm:gap-4 md:gap-6">
  Items
</div>
```

**Margin Bottom:**
```html
<div class="mb-2 xs:mb-3 sm:mb-4 md:mb-6">
  Content with bottom margin
</div>
```

---

## Size Reduction Checklist

When adding new components or pages, ensure mobile-first sizing:

- [ ] Body/base text uses `text-2xs` on mobile
- [ ] Headings reduced 1-2 scales on xs breakpoint
- [ ] Padding reduced by 30-50% on mobile
- [ ] Icons/images scaled appropriately for mobile
- [ ] Form inputs compact but usable on mobile
- [ ] Touch targets at least 44x44px
- [ ] No horizontal overflow on 320px viewport
- [ ] Text readable without zoom on mobile

---

## Real-World Examples

### Login Page Header

```html
<!-- BEFORE (too large) -->
<h2 class="text-2xl xs:text-3xl">Welcome Back!</h2>

<!-- AFTER (mobile-friendly) -->
<h2 class="text-base xs:text-lg sm:text-2xl md:text-4xl">Welcome Back!</h2>
```

### Product Card

```html
<!-- BEFORE -->
<div class="p-4 xs:p-6">
  <h3 class="text-xl xs:text-2xl">Product Title</h3>
  <p class="text-sm xs:text-base">$99.99</p>
</div>

<!-- AFTER -->
<div class="p-2 xs:p-3 sm:p-6">
  <h3 class="text-base xs:text-lg sm:text-xl">Product Title</h3>
  <p class="text-xs xs:text-sm sm:text-base">$99.99</p>
</div>
```

### Navigation Bar

```html
<!-- BEFORE (tall on mobile) -->
<nav class="h-16 xs:h-20">
  <span class="text-lg xs:text-2xl">Weru Hardware</span>
</nav>

<!-- AFTER (compact on mobile) -->
<nav class="h-12 xs:h-14 sm:h-16">
  <span class="text-base xs:text-lg sm:text-xl">Weru Hardware</span>
</nav>
```

---

## Common Mistakes to Avoid

❌ **DON'T:** Use only one size class
```html
<!-- Wrong - no responsive scaling -->
<h1 class="text-lg">Title</h1>
```

✅ **DO:** Use responsive sizing
```html
<!-- Right - scales with viewport -->
<h1 class="text-base xs:text-lg sm:text-2xl md:text-3xl">Title</h1>
```

❌ **DON'T:** Make mobile too large
```html
<!-- Wrong - still too large on mobile -->
<h1 class="text-xl xs:text-2xl sm:text-3xl">Title</h1>
```

✅ **DO:** Reduce mobile-first
```html
<!-- Right - starts small, scales up -->
<h1 class="text-base xs:text-lg sm:text-2xl">Title</h1>
```

❌ **DON'T:** Ignore padding on mobile
```html
<!-- Wrong - cramped on mobile -->
<div class="px-6 py-4">Content</div>
```

✅ **DO:** Scale padding
```html
<!-- Right - spacious but not wasteful -->
<div class="px-2 xs:px-3 sm:px-6 py-2 xs:py-3 sm:py-4">Content</div>
```

---

## Tips & Tricks

### Using the Sizing Pattern

1. **Start with mobile:** Always define base (xs) size first
2. **Progression:** xs → sm → md → lg (each slightly larger)
3. **Consistency:** Use same scales across similar components
4. **Test:** Check 320px, 375px, and 640px viewports

### Tailwind IntelliSense

If using VSCode with Tailwind:
- Type `text-` to see all available sizes
- Use preview to compare sizes
- Reference the `tailwind.config.js` for custom scales

### Quick Testing

In browser DevTools:
1. Open responsive mode (Ctrl+Shift+M / Cmd+Shift+M)
2. Set custom device: 320px width
3. Reload page and check layout
4. Try 375px (iPhone SE)
5. Try 390px (iPhone 12)

---

## Questions?

Refer to these files for more details:
- `MOBILE_SIZING_REDUCTION_COMPLETE.md` - Full change log
- `MOBILE_STYLING_GUIDE.md` - Original mobile styling patterns
- `tailwind.config.js` - Breakpoint definitions

---

**Last Updated:** November 2025
**Pattern Version:** 1.0 (Mobile-First Compact)
**Files Affected:** 16 core files + future components

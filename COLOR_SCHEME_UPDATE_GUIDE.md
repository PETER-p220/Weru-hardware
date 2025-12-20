# Color Scheme Update Guide - Oweru Hardware

## New Professional Color Scheme
- **Primary Background**: White (#ffffff) or Dark Blue (#1e3a5f)
- **Button Background**: Gold (#d4af37 or #fbbf24)
- **Font Colors**: Black (#000000/#1f2937) or White (#ffffff for dark backgrounds)
- **Header Background**: Dark Blue (#1e3a5f or similar)

## Global Color Replacements

### CSS Variable Replacements
```
OLD: --primary: #f97316  →  NEW: --primary: #d4af37
OLD: --primary: #ff6b35  →  NEW: --primary: #d4af37
OLD: --primary-dark: #e85a2a  →  NEW: --primary-dark: #fbbf24
OLD: --primary-dark: #ea580c  →  NEW: --primary-dark: #fbbf24
```

### Tailwind Color Class Replacements
| Component | Old | New |
|-----------|-----|-----|
| Background | `bg-gray-50` | `bg-white` |
| Buttons | `bg-orange-600` | `bg-yellow-400` |
| Buttons Hover | `hover:bg-orange-700` | `hover:bg-yellow-500` |
| Button Text | `text-white` | `text-blue-900` or `text-black` |
| Primary Text | `text-orange-600` | `text-black` or `text-blue-900` |
| Badges | `bg-orange-100` | `bg-yellow-100` |
| Borders | `border-orange-100` | `border-yellow-100` or `border-gray-300` |
| Hover Background | `hover:bg-orange-50` | `hover:bg-yellow-50` |
| Header/Nav | `bg-white` | `bg-blue-900` |
| Header Text | `text-gray-900` | `text-white` |
| Gradients | `from-orange-* to-orange-*` | `from-yellow-* to-amber-*` |

## Files Updated ✅
- ✅ order.blade.php - COMPLETE (order management page)
- ✅ welcome.blade.php - PARTIAL (landing page)
- ✅ products.blade.php - PARTIAL (background updated)
- ✅ cart.blade.php - PARTIAL (header updated)
- ✅ checkout.blade.php - PARTIAL (header and first section updated)

## Files Requiring Updates ⏳

### Priority 1 - Admin/Dashboard Pages
- [ ] **adminDashboard.blade.php** - Main admin dashboard
  - Update header: `bg-white` → `bg-blue-900`, text colors
  - Update buttons: orange → gold
  - Update sidebar: apply gold accents
  - Update stats cards: borders and backgrounds

- [ ] **indexProduct.blade.php** - Product listing
  - Update header background and text colors
  - Update buttons to gold
  - Update category chips

- [ ] **createProduct.blade.php** - Product creation form
  - Update header background
  - Update submit button to gold
  - Update form accents

- [ ] **indexCategory.blade.php** - Category management
  - Update header to dark blue
  - Update buttons to gold
  - Update cards backgrounds

- [ ] **createCategory.blade.php** - Category creation
  - Update header background
  - Update button colors

### Priority 2 - Auth Pages
- [ ] **auth/login.blade.php**
  - Update primary color CSS variable to gold
  - Update button styles
  - Update focus ring colors

- [ ] **auth/register.blade.php**
  - Update primary color CSS variable
  - Update button backgrounds
  - Update form styling

- [ ] **auth/forgot-password.blade.php**
- [ ] **auth/reset-password.blade.php**
- [ ] **auth/confirm-password.blade.php**
- [ ] **auth/verify-email.blade.php**

### Priority 3 - Customer Pages
- [ ] **dashboard.blade.php** - Customer dashboard
- [ ] **user.blade.php** - User management
- [ ] **OrderManagement.blade.php** - Order management
- [ ] **ads.blade.php** - Advertisement listing
- [ ] **advertisement.blade.php** - Create advertisement
- [ ] **editProduct.blade.php** - Edit product
- [ ] **editCategory.blade.php** - Edit category
- [ ] **showCategory.blade.php** - Category detail view
- [ ] **success.blade.php** - Order success page
- [ ] **cancel.blade.php** - Order cancel page

### Priority 4 - Other Pages
- [ ] **shopping.blade.php**
- [ ] **catalog.blade.php**
- [ ] **contact.blade.php**
- [ ] **features.blade.php**
- [ ] **show.blade.php**
- [ ] **selcom-test.blade.php**
- [ ] **redirect.blade.php**

## Bulk Search & Replace Patterns

You can use VS Code's Find & Replace feature:

### 1. Replace hex color codes
```
Find: #f97316|#ff6b35
Replace: #d4af37
```

### 2. Replace dark orange hex
```
Find: #e85a2a|#ea580c
Replace: #fbbf24
```

### 3. Replace orange CSS variables in style blocks
```
Find: --primary: #(f97316|ff6b35|e85a2a|ea580c)
Replace: Update each individually
```

### 4. Replace common Tailwind classes
```
Find: bg-orange-
Replace: bg-yellow- (or bg-blue- for headers)
```

```
Find: text-orange-
Replace: text-black (or text-white for dark backgrounds)
```

```
Find: hover:bg-orange-
Replace: hover:bg-yellow-
```

```
Find: border-orange-
Replace: border-yellow- (or border-gray-)
```

## Implementation Steps

1. **Search for CSS variables** in all `.blade.php` files
   - Find all occurrences of `primary: '#f97316'`, `primary: '#ff6b35'`, etc.
   - Replace with `primary: '#d4af37'`

2. **Update backgrounds**
   - Replace `bg-gray-50` with `bg-white`
   - Replace `from-orange-50 to-...` with `from-yellow-50 to-amber-50`

3. **Update buttons**
   - Replace `bg-orange-600 hover:bg-orange-700` with `bg-yellow-400 hover:bg-yellow-500`
   - Replace `text-white` on orange buttons with `text-blue-900` or `text-black`

4. **Update headers/navigation**
   - Change header backgrounds from `bg-white` to `bg-blue-900`
   - Change header text from `text-gray-*` to `text-white`
   - Change logo accents from `text-orange-*` to `text-yellow-400`

5. **Update form elements**
   - Change focus rings from `focus:ring-orange-*` to `focus:ring-yellow-*`
   - Update border colors on form inputs

6. **Update status badges and alerts**
   - Replace orange alert styles with yellow/gold

## Testing Checklist
- [ ] All buttons appear in gold (#fbbf24)
- [ ] All headers have dark blue backgrounds (#1e3a5f)
- [ ] All backgrounds are white (#ffffff)
- [ ] All primary text is black or blue-900
- [ ] All links and accents use gold
- [ ] Hover states work correctly
- [ ] Form inputs have proper focus states (gold rings)
- [ ] Mobile responsive design maintained
- [ ] All gradients updated to yellow/amber/blue tones

## Quick VS Code Find & Replace

Use Regex mode (Alt + R) for bulk replacements:

1. `#f97316|#ff6b35` → `#d4af37`
2. `#e85a2a|#ea580c` → `#fbbf24`
3. `bg-orange-(\d+)` → `bg-yellow-$1`
4. `text-orange-(\d+)` → `text-black`
5. `hover:bg-orange-(\d+)` → `hover:bg-yellow-$1`
6. `border-orange-(\d+)` → `border-yellow-$1`
7. `from-orange-` → `from-yellow-`
8. `to-orange-` → `to-amber-`

---

**Status**: In Progress
**Last Updated**: 2025-11-27
**Next Steps**: Update remaining priority 1 files (admin pages)

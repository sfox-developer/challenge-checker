# Global SCSS Refactoring - December 2025

## Overview

Refactored SCSS architecture to move layout-specific classes to globally reusable components, following minimalistic design principles. This reduces code duplication and improves maintainability.

## Key Changes

### 1. Typography → Global (`base/_typography.scss`)

**Moved from:** `layouts/_public.scss`  
**Moved to:** `base/_typography.scss`

All typography classes are now globally available:
- Headings: `.h1`, `.h2`, `.h3`
- Body text: `.text-body`, `.text-muted`, `.text-success`
- Links: `.link-muted`, `.text-link`
- Content: `.section-heading`, `.content-block`

### 2. Icon Wrappers → Global (`components/common/_icons.scss`)

**Problem:** Duplicate classes doing the same thing
- `feature-icon` (landing page)
- `static-page-icon` (static pages)

**Solution:** Created unified icon wrapper system

**New Classes:**
```scss
.icon-wrapper              // Base: 16x16, rounded-2xl, slate-100/slate-900
.icon-wrapper-sm          // Small: 12x12
.icon-wrapper-lg          // Large: 20x20
.icon-wrapper-accent      // Accent background (slate-700)
.icon-wrapper-centered    // Auto-centered (mx-auto)
.icon-wrapper-inline      // Inline variant (smaller padding)
```

**Migration:**
- `feature-icon` → `icon-wrapper icon-wrapper-accent icon-wrapper-centered`
- `static-page-icon` → `icon-wrapper icon-wrapper-inline`

### 3. Large Buttons → Global (`components/common/_buttons.scss`)

**Moved from:** `layouts/_public.scss`  
**Added to:** `components/common/_buttons.scss`

**New Classes:**
```scss
.btn-large               // Base large button class
.btn-large-primary       // Large primary CTA (slate-700, shadow)
.btn-large-secondary     // Large secondary CTA (transparent, bordered)
```

**Migration:**
- `cta-primary` → `btn-large btn-large-primary`
- `cta-secondary` → `btn-large btn-large-secondary`

### 4. Auth Classes → Auth Layout (`layouts/_auth.scss`)

**Moved from:** `layouts/_public.scss`  
**Moved to:** `layouts/_auth.scss`

All `.auth-*` classes moved to appropriate file:
- `.auth-layout`, `.auth-content`, `.auth-container`
- `.auth-header`, `.auth-title`, `.auth-subtitle`
- `.auth-form`, `.auth-field`, `.auth-label`, `.auth-input`
- `.auth-actions`, `.auth-remember`, `.auth-link`
- `.auth-submit`, `.auth-footer`

### 5. Public Layout Simplified (`layouts/_public.scss`)

**Before:** 391 lines (typography, components, layout, auth)  
**After:** ~160 lines (layout-specific only)

**Retained layout-specific classes:**
- Feature cards: `.feature-card`, `.feature-card-content`
- Hero section: `.hero-section`, `.hero-content`, `.hero-text-wrapper`
- Navigation: `.public-nav`, `.public-nav-container`, `.public-nav-link`
- Static pages: `.static-page-container`, `.static-page-header`, `.static-page-content`

## File Structure Changes

### New Files Created
```
resources/scss/
├── base/
│   └── _typography.scss         ← NEW (typography classes)
├── components/common/
│   ├── _icons.scss              ← NEW (icon wrappers)
│   └── _buttons.scss            ← UPDATED (added large CTAs)
└── layouts/
    ├── _auth.scss               ← UPDATED (added auth classes)
    └── _public.scss             ← REFACTORED (removed global classes)
```

### Updated Imports (app.scss)
```scss
// Added new icon component
@use 'components/common/icons';
```

## View Updates

Updated all Blade templates using old class names:

```bash
# Icon wrappers (10 instances)
feature-icon → icon-wrapper icon-wrapper-accent icon-wrapper-centered
static-page-icon → icon-wrapper icon-wrapper-inline

# Large buttons (6 instances)
cta-primary → btn-large btn-large-primary
cta-secondary → btn-large btn-large-secondary
```

**Files affected:**
- `resources/views/public/welcome.blade.php`
- `resources/views/public/privacy-policy.blade.php`
- `resources/views/public/terms-of-service.blade.php`
- `resources/views/public/imprint.blade.php`
- `resources/views/public/changelog.blade.php`
- `resources/views/welcome.blade.php` (legacy)

## Results

### Build Performance
- **Before:** 217.13 kB CSS
- **After:** 206.25 kB CSS
- **Savings:** ~11 kB (5% reduction)

### Code Quality
✅ Eliminated duplicate classes (feature-icon vs static-page-icon)  
✅ Improved global reusability (typography, icons, buttons everywhere)  
✅ Better organized SCSS (base/ for foundations, common/ for components)  
✅ Maintained visual consistency across entire app  
✅ Simplified layout files (public, auth separated)

### Maintainability
- **Typography:** Single source of truth in `base/_typography.scss`
- **Icons:** Unified wrapper system with variants
- **Buttons:** All button types in `components/common/_buttons.scss`
- **Layouts:** Context-specific classes only in layout files

## Usage Examples

### Typography (Global)
```blade
<h1 class="h1">Main Heading</h1>
<p class="text-body">Body content here</p>
<span class="text-muted">Secondary info</span>
<a href="#" class="text-link">Inline link</a>
```

### Icon Wrappers (Global)
```blade
<!-- Landing page feature -->
<div class="icon-wrapper icon-wrapper-accent icon-wrapper-centered">
    <svg class="w-8 h-8">...</svg>
</div>

<!-- Static page header -->
<div class="icon-wrapper icon-wrapper-inline">
    <svg class="w-6 h-6">...</svg>
</div>

<!-- Dashboard card -->
<div class="icon-wrapper icon-wrapper-sm">
    <svg class="w-5 h-5">...</svg>
</div>
```

### Large Buttons (Global)
```blade
<!-- Primary CTA -->
<a href="{{ route('register') }}" class="btn-large btn-large-primary">
    Get Started
    <svg class="w-5 h-5">→</svg>
</a>

<!-- Secondary CTA -->
<a href="{{ route('login') }}" class="btn-large btn-large-secondary">
    Sign In
</a>
```

## Design Philosophy

### Principles Applied
1. **Global over specific:** Typography, icons, buttons available everywhere
2. **Consolidation over duplication:** One `.icon-wrapper` instead of multiple specific classes
3. **Semantic naming:** Purpose-based class names (`.icon-wrapper-accent` not `.icon-blue`)
4. **Composition:** Base classes + modifiers (`.icon-wrapper` + `.icon-wrapper-sm`)
5. **Minimalism:** Clean, flat design with single accent color

### Pattern Recognition
When to create global classes:
- **3+ uses:** Used across multiple contexts
- **Duplicates:** Same pattern with different names
- **Semantic value:** Represents a distinct UI element
- **Consistency:** Should look identical everywhere

### Naming Conventions
- **Global components:** Describe function (`.icon-wrapper`, `.btn-large`)
- **Layout-specific:** Prefix by context (`.public-nav`, `.auth-header`)
- **Modifiers:** Add specificity (`.icon-wrapper-sm`, `.btn-large-primary`)

## Next Steps

Future refactoring opportunities:
1. Dashboard components (cards, stat displays)
2. Form elements (consolidate input styles)
3. Modal components (dialog patterns)
4. Navigation patterns (tab styles, dropdowns)

## References

- **Documentation Updated:**
  - `ai/PROMPT.md` - Global class reference
  - `ai/09-folder-structure.md` - SCSS organization
  
- **Related Documents:**
  - `ai/07-minimalistic-ui-refactoring.md` - Minimalistic design principles
  - `ai/02-database-schema.md` - No changes needed
  - `ai/06-frontend-components.md` - Component architecture (views unchanged)

## Verification

### Build Test
```bash
npm run build
# ✓ Built successfully
# ✓ CSS: 206.25 kB (reduced from 217.13 kB)
# ✓ 0 errors
```

### Visual Consistency
✅ All pages render identically  
✅ Dark mode works correctly  
✅ Responsive behavior intact  
✅ Icon wrappers styled consistently  
✅ Button sizes and colors unchanged  
✅ Typography hierarchy maintained

### Code Quality
✅ No duplicate class patterns  
✅ All global classes in appropriate files  
✅ Layout files contain only layout-specific classes  
✅ Imports ordered correctly (abstracts → base → layouts → components)  
✅ Documentation up to date

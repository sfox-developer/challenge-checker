# AI Agent Prompt Template

Copy and paste the prompt below when starting a new AI agent session for this project.

---

## 📋 Copy This Prompt:

```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-08)
3. Understand the project architecture and patterns

Task: [DESCRIBE YOUR TASK HERE]

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Use custom SCSS classes instead of inline Tailwind utilities
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
```

---

## 🎨 Styling Guidelines

### **IMPORTANT: Use Custom Classes, Not Inline Tailwind**

When creating new pages or styling components, **ALWAYS use custom SCSS classes** instead of repeating Tailwind utility classes directly in Blade templates. This keeps the codebase clean, maintainable, and consistent.

**❌ DON'T DO THIS:**
```blade
<nav class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-100 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="flex justify-between items-center h-20">
            <!-- content -->
        </div>
    </div>
</nav>
```

**✅ DO THIS INSTEAD:**
```blade
<nav class="public-nav">
    <div class="public-nav-container">
        <div class="public-nav-content">
            <!-- content -->
        </div>
    </div>
</nav>
```

### Available Custom Class Systems

#### 1. **Typography Classes** (`resources/scss/components/_public-layout.scss`)
   - `.h1` - Large heading (3xl, bold)
   - `.h2` - Medium heading (2xl, bold)
   - `.h3` - Small heading (xl, semibold)
   - `.text-body` - Body text (base size, gray-700)
   - `.text-muted` - Muted text (sm, gray-600)
   - `.text-success` - Success message (sm, green-600)
   - `.link-muted` - Muted link with hover and focus states

#### 2. **Component Classes** (`resources/scss/components/_public-layout.scss`)

**Feature/Landing Components:**
   - `.feature-icon` - Large icon wrapper (16x16, slate-700, rounded-2xl, centered)
   - `.feature-icon-sm` - Small icon wrapper (12x12, slate-700, rounded-xl)
   - `.feature-card` - Feature card container (text-center, space-y-4)
   - `.feature-card-content` - Feature card content wrapper (space-y-2)

**Hero Section:**
   - `.hero-section` - Hero section wrapper (flex-1, centered, generous padding)
   - `.hero-content` - Hero content container (max-w-5xl)
   - `.hero-text-wrapper` - Hero text wrapper (text-center, space-y-12)
   - `.hero-title-section` - Hero title section (space-y-6)

**CTA Buttons:**
   - `.cta-primary` - Large primary button (slate-700, px-10 py-4, text-lg, shadow)
   - `.cta-secondary` - Large secondary button (transparent, bordered, px-10 py-4, text-lg)

**Layout:**
   - `.features-grid` - 3-column responsive grid for features (mt-32, gap-12)

#### 3. **Public Layout Classes** (`resources/scss/components/_public-layout.scss`)
   - `.public-layout` - Full page wrapper for public pages
   - `.public-nav` - Sticky blur navigation
   - `.public-nav-container` - Max-width container
   - `.public-nav-content` - Flex content wrapper
   - `.public-nav-logo` - Logo styling
   - `.public-nav-link` - Navigation links
   - `.public-nav-button` - CTA buttons
   - `.theme-toggle` - Theme toggle button
   - `.public-main` - Main content area

#### 4. **Auth Layout Classes** (`resources/scss/components/_public-layout.scss`)
   - `.auth-layout` - Auth page wrapper
   - `.auth-content` - Centered auth content
   - `.auth-container` - Max-width container
   - `.auth-header` - Page header
   - `.auth-title` - Main heading
   - `.auth-subtitle` - Subheading
   - `.auth-form` - Form spacing
   - `.auth-field` - Form field wrapper
   - `.auth-label` - Field labels
   - `.auth-input` - Input fields
   - `.auth-actions` - Remember me / forgot password row
   - `.auth-remember` - Remember me checkbox
   - `.auth-link` - Text links
   - `.auth-submit` - Submit buttons
   - `.auth-footer` - Footer text with links

#### 5. **Static Page Classes** (`resources/scss/components/_public-layout.scss`)
   - `.static-page-container` - Max-width content container
   - `.static-page-header` - Page header with icon
   - `.static-page-icon` - Icon wrapper
   - `.static-page-title` - Page title
   - `.static-page-subtitle` - Subtitle
   - `.static-page-content` - Main content area
   - `.content-section` - Content sections
   - `.section-heading` - Section headings (with accent bar)
   - `.content-block` - Text blocks
   - `.text-link` - Inline links

#### 6. **Dashboard Classes** (`resources/scss/components/_dashboard-layout.scss`)
   - `.app-container` - Dashboard wrapper
   - `.fab` - Floating action button
   - `.modal-*` - Modal components
   - `.stat-*` - Statistics displays
   - `.grid-*-responsive` - Responsive grids
   
#### 7. **Other Component Classes** (see `resources/scss/components/`)
   - `.card` - Card containers
   - `.btn`, `.btn-primary`, `.btn-secondary` - Buttons
   - `.badge`, `.badge-accent` - Badges
   - See individual SCSS files for complete lists

---

## 📐 Component Consolidation Strategy

### Purpose
Maintain a consistent, maintainable UI by converting repeating Tailwind patterns into semantic, reusable SCSS classes.

### When to Create Component Classes

Create new custom classes when:
1. **Repetition:** A pattern is used 3+ times across the codebase
2. **Complexity:** A component has 5+ Tailwind utility classes
3. **Semantic value:** The pattern represents a distinct UI element (button, card, icon wrapper)
4. **Consistency:** Building a new layout or page type that should follow UI principles

### Discovery Process

1. **Identify Patterns:**
   ```bash
   # Search for common inline class patterns
   grep -r "class=\".*px-10 py-4.*bg-slate-700" resources/views/
   grep -r "w-16 h-16.*bg-slate-700.*rounded" resources/views/
   ```

2. **Analyze Frequency:**
   - Count occurrences across templates
   - Verify patterns are identical or very similar
   - Consider future reusability

3. **Create Semantic Names:**
   - Use descriptive, purpose-based names
   - Follow existing naming conventions (`.feature-*`, `.hero-*`, `.cta-*`, `.auth-*`)
   - Examples: `.feature-icon` not `.icon-lg-slate`, `.cta-primary` not `.btn-big-dark`

4. **Implement Classes:**
   - Add to appropriate SCSS file (`_public-layout.scss`, `_dashboard-layout.scss`, etc.)
   - Use `@apply` directive to compose Tailwind utilities
   - Group related classes together with comments

5. **Apply Systematically:**
   - Replace inline classes in templates
   - Verify visual consistency after changes
   - Test dark mode and responsive behavior

6. **Document:**
   - Add new classes to this file (ai/PROMPT.md)
   - Include purpose and use cases
   - Update examples if needed

### Naming Conventions

**Prefix by context:**
- `.public-*` - Public-facing layouts (nav, footer, etc.)
- `.auth-*` - Authentication pages
- `.static-page-*` - Static content pages (privacy, terms, changelog)
- `.feature-*` - Landing page features
- `.hero-*` - Hero sections
- `.cta-*` - Call-to-action buttons
- `.card-*` - Card components
- `.dashboard-*` / `.app-*` - Dashboard layouts

**Suffix by purpose:**
- `*-container` - Wrapper/container elements
- `*-content` - Content areas
- `*-header` / `*-footer` - Section headers/footers
- `*-icon` - Icon wrappers
- `*-grid` - Grid layouts
- `*-primary` / `*-secondary` - Variants

### Example: Icon Wrapper Consolidation

**Before (171 chars total across 3 uses):**
```blade
<div class="w-16 h-16 bg-slate-700 dark:bg-slate-600 rounded-2xl flex items-center justify-center mx-auto">
    <svg>...</svg>
</div>
```

**After (18 chars per use):**
```blade
<div class="feature-icon">
    <svg>...</svg>
</div>
```

**SCSS Implementation:**
```scss
// resources/scss/components/_public-layout.scss
.feature-icon {
    @apply w-16 h-16;
    @apply bg-slate-700 dark:bg-slate-600;
    @apply rounded-2xl;
    @apply flex items-center justify-center;
    @apply mx-auto;
}
```

### Quality Checklist

Before completing component consolidation:
- [ ] All patterns with 3+ occurrences have semantic classes
- [ ] Class names follow naming conventions
- [ ] SCSS is organized with clear comments
- [ ] Templates are refactored to use new classes
- [ ] Build completes successfully (`npm run build`)
- [ ] Visual appearance matches original
- [ ] Dark mode works correctly
- [ ] Responsive behavior maintained
- [ ] Documentation updated (this file)

---

## 🎯 When to Create New Custom Classes

**Process:**
1. Add classes to appropriate SCSS file in `resources/scss/components/`
2. Use `@apply` to compose Tailwind utilities
3. Document the class purpose with comments
4. Use the class in your Blade templates

**Example:**
```scss
// In resources/scss/components/_layout.scss

// Custom feature card for homepage
.feature-card {
    @apply bg-white dark:bg-gray-800;
    @apply rounded-xl border border-gray-200 dark:border-gray-700;
    @apply p-6 text-center;
    @apply hover:shadow-lg transition-shadow duration-200;
}

.feature-card-icon {
    @apply w-16 h-16 mx-auto mb-4;
    @apply bg-slate-700 dark:bg-slate-600;
    @apply rounded-2xl;
    @apply flex items-center justify-center;
}

.feature-card-title {
    @apply text-xl font-semibold;
    @apply text-gray-900 dark:text-white;
    @apply mb-2;
}

.feature-card-description {
    @apply text-base font-normal;
    @apply text-gray-600 dark:text-gray-400;
    @apply leading-relaxed;
}
```

---

## 🎯 How to Use

1. **Copy the prompt above**
2. **Replace `[DESCRIBE YOUR TASK HERE]`** with your actual task
3. **Paste into new AI agent chat**
4. **Wait for agent to confirm** they've read the documentation
5. **Agent will complete the task** following the workflow

---

## ✏️ Example Usage

### Example 1: Adding a New Feature
```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-08)
3. Understand the project architecture and patterns

Task: Add a "Challenge Templates" feature that allows users to save their completed challenges as templates for future use. Users should be able to create a new challenge from a template, which copies the goals but resets progress.

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
```

### Example 2: Fixing a Bug
```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-08)
3. Understand the project architecture and patterns

Task: Fix bug where users can complete the same goal multiple times on the same day by clicking the checkbox rapidly. The unique constraint should prevent this, but the UI allows duplicate requests.

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
```

### Example 3: Refactoring
```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-08)
3. Understand the project architecture and patterns

Task: Refactor the habit statistics calculation to use a database observer pattern instead of manually updating statistics in the controller. This will ensure statistics are always updated correctly regardless of how completions are created.

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
```

---

## 💡 Pro Tips

- **Be specific** in your task description
- **Mention edge cases** you're concerned about
- **Reference related features** if the task connects to existing functionality
- **Include acceptance criteria** if you have specific requirements
- **Ask for clarification** if the agent needs more context

---

## ⚡ Quick Prompts for Common Tasks

### Create a new feature
```
Read ai/README.md and follow the workflow to create: [feature name and description]
```

### Fix a bug
```
Read ai/README.md and follow the workflow to fix: [bug description and steps to reproduce]
```

### Add documentation
```
Read ai/README.md and update documentation for: [what needs documenting]
```

### Refactor code
```
Read ai/README.md and refactor: [code area and reason]
```

### Add tests
```
Read ai/README.md and add tests for: [feature/component to test]
```

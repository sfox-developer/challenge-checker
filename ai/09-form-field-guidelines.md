# Form Field Guidelines

**Last Updated:** December 29, 2025  
**Purpose:** Standards for form field labels, validation, and user experience

---

## 📋 Field Label Standards

### Required Fields

**Visual Indicator:** Red asterisk (*) after label text

**Implementation:**
```blade
<x-forms.form-input
    name="name"
    label="Challenge Name"
    required />
```

**Renders as:**
```
Challenge Name *
[                    ]
```

**SCSS Styling:**
```scss
.form-label-required {
    color: var(--color-danger); // Red color
    margin-left: 2px;
}
```

---

### Optional Fields

**Visual Indicator:** Gray "(Optional)" text after label

**Implementation:**
```blade
<x-forms.form-input
    name="description"
    label="Description"
    optional />
```

**Renders as:**
```
Description (Optional)
[                      ]
```

**SCSS Styling:**
```scss
.text-optional {
    @apply text-gray-500 dark:text-gray-400;
    @apply text-sm;
    @apply ml-1;
}
```

---

## ✅ Validation Patterns

### Client-Side Validation

**Pattern 1: Disabled Button State (Recommended)**

Disable submit/next buttons until required fields are valid.

```blade
<button 
    type="button" 
    @click="nextStep()" 
    :disabled="!name.trim()"
    class="btn-primary">
    Next
</button>
```

**Alpine.js Component:**
```javascript
data() {
    return {
        name: '',
        
        get isValid() {
            return this.name.trim().length > 0;
        }
    }
}
```

---

### Server-Side Validation

Always validate on the server even with client-side validation.

**Controller Example:**
```php
$validated = $request->validate([
    'name' => 'required|string|min:1|max:255',
    'description' => 'nullable|string|max:1000',
]);
```

**Error Display:**
Errors automatically display via form components using `$errors` bag.

---

## 🎨 Button States

### Disabled State Styling

**Requirements:**
- Grayed out appearance
- Reduced opacity
- No hover effects
- Cursor: not-allowed

**SCSS Implementation:**
```scss
.btn-primary:disabled,
.btn-secondary:disabled {
    @apply opacity-50;
    @apply cursor-not-allowed;
    @apply pointer-events-none;
}
```

---

## 🔄 Progressive Disclosure

### Multi-Step Forms

**Step Validation:**
- Validate current step before allowing navigation
- Disable "Next" button until step is valid
- Scroll to top of form on step change with offset for sticky nav
- Show progress indicator

**Example:**
```javascript
nextStep() {
    // Validate current step
    if (this.step === 1 && !this.name.trim()) {
        return; // Prevent navigation
    }
    
    if (this.step < this.maxStep) {
        this.step++;
        this.scrollToTop();
    }
}
```

---

## 📱 Mobile Considerations

### Input Types

Use appropriate input types for mobile keyboards:

- `type="email"` - Email keyboard with @ key
- `type="tel"` - Numeric keypad for phone numbers
- `type="number"` - Numeric input with steppers
- `type="url"` - URL keyboard with .com key
- `type="date"` - Native date picker

### Touch Targets

Minimum touch target size: 44x44px (iOS HIG standard)

```scss
.form-input,
.btn-primary,
.btn-secondary {
    min-height: 44px; // Ensures adequate touch target
}
```

---

## ♿ Accessibility

### Required Attributes

**All form fields must have:**
- `name` attribute for form submission
- `id` attribute for label association
- `required` attribute for required fields (HTML5 validation)
- Associated `<label>` with `for` attribute

**Example:**
```html
<label for="name">Challenge Name <span class="form-label-required">*</span></label>
<input type="text" id="name" name="name" required>
```

### ARIA Labels

For complex inputs, use ARIA labels:

```html
<input 
    type="text" 
    name="name" 
    aria-label="Challenge name" 
    aria-required="true">
```

---

## 🎯 Component Props Reference

### x-forms.form-input

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | required | Input name attribute |
| `label` | string | null | Label text |
| `required` | boolean | false | Adds asterisk (*) to label |
| `optional` | boolean | false | Adds "(Optional)" to label |
| `placeholder` | string | null | Placeholder text |
| `hint` | string | null | Help text below input |
| `type` | string | 'text' | HTML input type |
| `min` | number | null | Min value (number inputs) |
| `max` | number | null | Max value (number inputs) |

**Validation Priority:**
1. Neither `required` nor `optional` set → Assumed required (no indicator)
2. `required=true` → Show asterisk (*)
3. `optional=true` → Show "(Optional)" text

---

## 📚 Examples

### Basic Required Field
```blade
<x-forms.form-input
    name="name"
    label="Challenge Name"
    placeholder="e.g., 30-Day Fitness"
    required />
```

### Optional Field with Hint
```blade
<x-forms.form-textarea
    name="description"
    label="Description"
    placeholder="What is this about?"
    hint="Help others understand your challenge"
    optional />
```

### Number Input with Range
```blade
<x-forms.form-input
    name="days_duration"
    label="Duration (Days)"
    type="number"
    min="1"
    max="365"
    placeholder="30"
    required />
```

### Conditional Field (Alpine.js)
```blade
<div x-show="showAdvanced">
    <x-forms.form-input
        name="tags"
        label="Tags"
        placeholder="fitness, health, mindfulness"
        optional />
</div>
```

---

## ✨ Best Practices

### Do's ✅

- Always mark fields as either `required` or `optional`
- Disable submit buttons until form is valid
- Provide helpful error messages
- Use appropriate input types for mobile
- Validate on both client and server
- Show progress in multi-step forms
- Use hints for complex fields

### Don'ts ❌

- Don't rely solely on client-side validation
- Don't use generic error messages ("Invalid input")
- Don't hide validation until form submission
- Don't make users guess which fields are required
- Don't use placeholder text as labels
- Don't interrupt typing with live validation (exception: username availability)

---

## 🔍 Future Enhancements

### Planned Features

- [ ] Real-time validation with debounce
- [ ] Character count for textareas
- [ ] Password strength indicator
- [ ] Autocomplete suggestions
- [ ] Field dependency validation
- [ ] Custom validation messages per field
- [ ] Multi-field validation (e.g., password confirmation)

# Challenge Create Form Refactor Plan

**Date:** December 21, 2025  
**Goal:** Transform challenges/create.blade.php to use step-by-step form like registration

---

## 🎯 Objectives

1. **Multi-step form** - Similar to registration (3-4 steps)
2. **Remove SVG icons** from labels (they're not used elsewhere)
3. **Modal-based goal selection** - Select goals from library via modal
4. **Modal-based goal creation** - Add new goals via modal

---

## 📊 Current State

### Files Created:
- ✅ `/resources/js/components/challenge-create.js` - New component created
- ✅ Updated `/resources/js/components/index.js` - Component registered

### Files To Update:
- ❌ `/resources/views/dashboard/challenges/create.blade.php` - LARGE FILE (289 lines) - needs complete rewrite
- ❌ `/resources/views/dashboard/habits/create.blade.php` - Similar updates needed

### Current Structure:
```
create.blade.php (OLD):
- Page header
- Single long form with 4 numbered sections:
  1. Basic Information (name, description)
  2. Schedule & Tracking (frequency, duration)
  3. Settings (is_public checkbox)
  4. Your Goals (inline goal selection + creation)
- Submit buttons
- Tips section at bottom
```

---

## 🎨 Desired Structure

### New Multi-Step Form (Like Registration):

```
create.blade.php (NEW):
- Page header
- Progress indicator (1 → 2 → 3 → 4)
- x-data="challengeCreateForm()"

STEP 1: Basic Information
  - Challenge name (required, min 3 chars)
  - Description (optional)
  - [Next] button

STEP 2: Schedule
  - Frequency selector
  - Duration (optional)
  - [Back] [Next] buttons

STEP 3: Goals
  - [Select from Library] button → opens modal
  - [Create New Goal] button → opens modal
  - Display selected goals (badges/chips)
  - Display new goals to be created
  - [Back] [Next] buttons

STEP 4: Settings & Review
  - is_public checkbox
  - Summary of challenge
  - [Back] [Create Challenge] buttons

MODALS:
- Goal Selection Modal (fullscreen on mobile)
- Goal Creation Modal
```

---

## 📝 Implementation Chunks

### CHUNK 1: Create Goal Selection Modal Component
**File:** Create new component file  
**Lines:** ~100 lines  
**Location:** `resources/views/components/challenges/goal-select-modal.blade.php`

```blade
@props(['goals'])

<div x-show="showGoalSelectModal" 
     x-cloak
     @click.self="closeGoalSelectModal()"
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm">
    
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div @click.stop 
             class="card max-w-2xl w-full max-h-[80vh] flex flex-col">
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Select Goals from Library</h3>
                <button @click="closeGoalSelectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                    </svg>
                </button>
            </div>
            
            <!-- Goals List (scrollable) -->
            <div class="flex-1 overflow-y-auto space-y-2 mb-4">
                @foreach($goals as $goal)
                <label class="flex items-start p-3 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border"
                       :class="isGoalSelected({{ $goal->id }}) ? 'border-slate-500 bg-slate-50 dark:bg-slate-900/50' : 'border-gray-200 dark:border-gray-700'">
                    <input type="checkbox" 
                           :checked="isGoalSelected({{ $goal->id }})"
                           @change="toggleGoal({{ $goal->id }})"
                           class="mt-1 rounded border-gray-300 text-slate-700 focus:ring-slate-500">
                    <div class="ml-3 flex-1">
                        <div class="flex items-center space-x-2">
                            @if($goal->icon)
                                <span class="text-xl">{{ $goal->icon }}</span>
                            @endif
                            <span class="font-semibold">{{ $goal->name }}</span>
                        </div>
                        @if($goal->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $goal->description }}</p>
                        @endif
                    </div>
                </label>
                @endforeach
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-between items-center pt-4 border-t">
                <span class="text-sm text-gray-600" x-text="`${selectedGoalIds.length} selected`"></span>
                <button @click="closeGoalSelectModal()" 
                        class="btn-primary">
                    Done
                </button>
            </div>
        </div>
    </div>
</div>
```

---

### CHUNK 2: Create Goal Creation Modal Component
**File:** Create new component file  
**Lines:** ~150 lines  
**Location:** `resources/views/components/challenges/goal-create-modal.blade.php`

```blade
@props(['categories'])

<div x-show="showGoalCreateModal" 
     x-cloak
     @click.self="closeGoalCreateModal()"
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm">
    
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div @click.stop 
             class="card max-w-lg w-full">
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Create New Goal</h3>
                <button @click="closeGoalCreateModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                    </svg>
                </button>
            </div>
            
            <!-- Form -->
            <div class="space-y-4">
                <!-- Goal Name -->
                <div>
                    <label class="form-label">Goal Name</label>
                    <input type="text" 
                           x-model="newGoal.name"
                           class="form-input" 
                           placeholder="e.g., Exercise daily"
                           required>
                </div>
                
                <!-- Icon & Category Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Emoji Picker -->
                    <div x-data="emojiPicker('newGoal.icon')">
                        <label class="form-label">Icon</label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="newGoal.icon"
                                   class="form-input pr-12" 
                                   placeholder="🎯"
                                   maxlength="2">
                            <button type="button"
                                    @click="togglePicker()"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-2xl hover:scale-110 transition-transform">
                                <span x-text="newGoal.icon || '🎯'"></span>
                            </button>
                        </div>
                        <!-- Emoji picker dropdown would go here -->
                    </div>
                    
                    <!-- Category -->
                    <div>
                        <label class="form-label">Category</label>
                        <select x-model="newGoal.category_id" class="form-input">
                            <option value="">Optional</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <label class="form-label">Description <span class="text-optional">(Optional)</span></label>
                    <textarea x-model="newGoal.description"
                              rows="3" 
                              class="form-input" 
                              placeholder="What does this goal involve?"></textarea>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                <button @click="closeGoalCreateModal()" 
                        class="btn-secondary">
                    Cancel
                </button>
                <button @click="addNewGoalToList()" 
                        class="btn-primary"
                        :disabled="!newGoal.name.trim()">
                    Add Goal
                </button>
            </div>
        </div>
    </div>
</div>
```

---

### CHUNK 3A: Update Form Opening + Alpine Component
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** ~14  
**Action:** Change `x-data="{ ...challengeForm(), ...habitForm() }"` to `x-data="challengeCreateForm()"`

---

### CHUNK 3B: Add Step Progress Indicator
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** ~20  
**Action:** Add step indicator after form opening (shows on step 2+)

---

### CHUNK 3C: Wrap Basic Info in Step 1
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** ~17-47  
**Action:** Add `x-show="step === 1"` wrapper, remove SVG icons from labels

---

### CHUNK 3D: Wrap Schedule in Step 2
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** ~48-87  
**Action:** Add `x-show="step === 2"` wrapper, remove SVG icons, add navigation buttons

---

### CHUNK 3E: Wrap Settings in Step 3
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** ~88-99  
**Action:** Add `x-show="step === 3"` wrapper, remove SVG icons, add navigation buttons

---

### CHUNK 3F: Replace Goals Section with Step 4
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** ~100-234  
**Action:** Replace entire goals section with modal-based approach

---

### CHUNK 3G: Update Submit Buttons
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** ~235-257  
**Action:** Update to show only on step 4, add back button

---

### CHUNK 3H: Add Modal Components
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** After form, before tips section  
**Action:** Include goal-select-modal and goal-create-modal components

---

### CHUNK 3I: Add Hidden Inputs for Goals
**File:** `/resources/views/dashboard/challenges/create.blade.php`  
**Lines:** Inside form  
**Action:** Add template for hidden inputs to submit selected/new goals

---

### CHUNK 4: Apply Same Pattern to habits/create.blade.php
**File:** `/resources/views/dashboard/habits/create.blade.php`  
**Action:** Similar step-by-step transformation (AFTER challenges work)

---

## ⚡ Execution Order

1. ✅ DONE: Create challenge-create.js component
2. ✅ DONE: Register component in index.js
3. ✅ DONE: CHUNK 1 - Create goal-select-modal.blade.php
4. ✅ DONE: CHUNK 2 - Create goal-create-modal.blade.php
5. **NEXT:** CHUNK 3A - Update form Alpine component
6. **THEN:** CHUNK 3B - Add step progress indicator
7. **THEN:** CHUNK 3C - Wrap Basic Info in Step 1
8. **THEN:** CHUNK 3D - Wrap Schedule in Step 2
9. **THEN:** CHUNK 3E - Wrap Settings in Step 3
10. **THEN:** CHUNK 3F - Replace Goals section with Step 4
11. **THEN:** CHUNK 3G - Update submit buttons
12. **THEN:** CHUNK 3H - Add modal components
13. **THEN:** CHUNK 3I - Add hidden inputs for goals
14. **THEN:** CHUNK 4 - Apply to habits (after testing challenges)
15. **FINALLY:** Test and verify

---

## 🔍 Testing Checklist

After implementation:
- [ ] Step navigation works (Next/Back buttons)
- [ ] Goal selection modal opens/closes
- [ ] Goal creation modal opens/closes
- [ ] Selected goals display correctly
- [ ] Form submits with all data
- [ ] Validation works on each step
- [ ] Mobile responsive
- [ ] Dark mode works
- [ ] No console errors

---

## 📝 Notes

- Keep progress indicator visible on all steps except step 1
- Use Alpine.js `x-show` with `x-cloak` for step visibility
- Maintain form data across steps (keep inputs, just hide/show)
- Hidden inputs for selected goals (append before submit)
- Modal backdrop should blur and darken background
- ESC key should close modals
- Click outside modal should close it
- Goal badges/chips should be removable with X button


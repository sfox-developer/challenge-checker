# AI Agent Prompt Template

This document provides standardized prompt templates for AI agents working on the Challenge Checker project.

---

## 📋 Standard Prompt Template

Copy and paste this prompt when starting a new AI agent session:

```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-10)
3. Understand the project architecture and patterns

Task: [DESCRIBE YOUR TASK HERE]

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Follow SCSS class system (see ai/08-css-classes-usage-guide.md)
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
```

---

## 🎨 Styling Guidelines

### **IMPORTANT: Use Custom SCSS Classes**

When creating new pages or components, **use custom SCSS classes** instead of repeating inline Tailwind utilities.

**For complete reference, see:**
- **`ai/08-css-classes-usage-guide.md`** - Complete CSS/SCSS class documentation
- **`ai/10-global-scss-refactoring.md`** - Global class system and usage patterns
- **`ai/09-folder-structure.md`** - SCSS file organization

### Key Styling Principles

1. **Use semantic class names** (`.feature-card` not `.box-with-shadow`)
2. **Create classes for repeated patterns** (3+ occurrences)
3. **Follow global class system:**
   - Typography: `base/_typography.scss` (h1, h2, text-body, etc.)
   - Icons: `components/common/_icons.scss` (icon-wrapper variants)
   - Buttons: `components/common/_buttons.scss` (btn-large, btn-primary, etc.)
4. **Organize by context** (base/ → layouts/ → components/)
5. **Document new classes** in `ai/08-css-classes-usage-guide.md`

### Example: Using Custom Classes

**❌ DON'T:**
```blade
<div class="w-16 h-16 bg-slate-700 rounded-2xl flex items-center justify-center mx-auto">
    <svg>...</svg>
</div>
```

**✅ DO:**
```blade
<div class="icon-wrapper icon-wrapper-accent icon-wrapper-centered">
    <svg>...</svg>
</div>
```

---

## 🎯 Example Usage

### Example 1: Adding a New Feature
```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-10)
3. Understand the project architecture and patterns

Task: Add a "Challenge Templates" feature that allows users to save their completed challenges as templates for future use. Users should be able to create a new challenge from a template, which copies the goals but resets progress.

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Follow SCSS class system (see ai/08-css-classes-usage-guide.md)
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
```

### Example 2: Fixing a Bug
```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-10)
3. Understand the project architecture and patterns

Task: Fix bug where users can complete the same goal multiple times on the same day by clicking the checkbox rapidly. The unique constraint should prevent this, but the UI allows duplicate requests.

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Follow SCSS class system (see ai/08-css-classes-usage-guide.md)
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
```

### Example 3: Refactoring
```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-10)
3. Understand the project architecture and patterns

Task: Refactor the habit statistics calculation to use a database observer pattern instead of manually updating statistics in the controller. This will ensure statistics are always updated correctly regardless of how completions are created.

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Follow SCSS class system (see ai/08-css-classes-usage-guide.md)
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
```

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

### Update styles/design
```
Read ai/README.md and ai/08-css-classes-usage-guide.md, then update: [styling task]
```

---

## 💡 Pro Tips

- **Be specific** in your task description
- **Mention edge cases** you're concerned about
- **Reference related features** if the task connects to existing functionality
- **Include acceptance criteria** if you have specific requirements
- **Ask for clarification** if the agent needs more context
- **Reference documentation files** for styling or architecture questions

---

## 📚 Documentation Reference

When prompting agents, reference these docs as needed:

- **ai/README.md** - Standard workflow and process
- **ai/01-overview-and-tech-stack.md** - Project overview
- **ai/02-database-schema.md** - Database structure
- **ai/03-domain-models.md** - Model relationships
- **ai/04-features-and-workflows.md** - Feature documentation
- **ai/05-routing-and-controllers.md** - Routes and controllers
- **ai/06-frontend-components.md** - Frontend architecture
- **ai/07-minimalistic-ui-refactoring.md** - Design system
- **ai/08-css-classes-usage-guide.md** - SCSS classes reference
- **ai/09-folder-structure.md** - File organization
- **ai/10-global-scss-refactoring.md** - Global class patterns

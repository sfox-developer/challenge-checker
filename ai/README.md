# AI Agent Quick Start Guide

**Last Updated:** December 19, 2025  
**Purpose:** Standardized workflow for AI agents working on Challenge Checker

---

## 🎯 Overview

This guide ensures AI agents:
1. **Understand** the project architecture before making changes
2. **Execute** tasks following established patterns
3. **Document** changes to keep docs current

---

## 📋 3-Phase Workflow

### Phase 1: Understand (Required First Step)

**Read documentation in this order:**

1. **`01-architecture.md`** - Tech stack, folder structure, conventions
2. **`02-database.md`** - Database schema and relationships
3. **`03-styling-system.md`** - SCSS architecture and Tailwind patterns
4. **`04-blade-components.md`** - Component system and Alpine.js
5. **`05-features.md`** - Business logic, models, routes
6. **`06-public-pages-blueprint.md`** - Reference implementation (Gold Standard)

**⚠️ Do not skip this phase.** Misunderstanding the architecture leads to:
- Breaking existing features
- Creating duplicate code
- Violating architectural patterns
- Incorrect database relationships

---

### Phase 2: Execute

**After understanding the project:**

1. **Analyze Task Requirements**
   - What needs to be created, modified, or fixed?
   - Which domains/models are affected?
   - What database changes are needed?
   - Which routes and controllers are involved?
   - What frontend components need updates?

2. **Plan Your Approach**
   - Identify all files that need changes
   - Consider database migrations if schema changes
   - Plan authorization (policies) if needed
   - Reference `06-public-pages-blueprint.md` for patterns

3. **Implement Changes**
   - Follow existing code patterns
   - Use proper naming conventions
   - Use SCSS classes (not inline Tailwind for repeated patterns)
   - Add Alpine.js animations following blueprint
   - Handle errors gracefully

4. **Verify Implementation**
   - Check for syntax errors
   - Verify database relationships
   - Test authorization policies
   - Test both light and dark modes
   - Verify responsive design

---

### Phase 3: Document (Required)

**After completing the task:**

1. **Identify What Changed:**
   - New database tables/columns? → Update `02-database.md`
   - New business logic or workflows? → Update `05-features.md`
   - New SCSS classes? → Update `03-styling-system.md`
   - New components? → Update `04-blade-components.md`
   - Architecture changes? → Update `01-architecture.md`

2. **Update Documentation:**
   - Keep consistent formatting
   - Include code examples
   - Update relationships and dependencies
   - Document any breaking changes

---

## 🤖 Standard Prompt Template

Copy and use this when starting work:

```
Read ai/README.md and follow the 3-phase workflow.

Before starting:
1. Read ai/README.md to understand the workflow
2. Read all documentation files (01-06) in order
3. Understand the project architecture and patterns

Task: [DESCRIBE YOUR TASK HERE]

Requirements:
- Follow 3-phase workflow (Understand → Execute → Document)
- Reference 06-public-pages-blueprint.md for patterns
- Follow SCSS class system (see 03-styling-system.md)
- Use Alpine.js animations following blueprint patterns
- Update relevant documentation after changes
- Test dark mode and responsive design

Please confirm you have read the documentation before proceeding.
```

---

## 📚 Quick Task Reference

### Adding a Feature
**Read:** 02-database.md, 05-features.md, 06-public-pages-blueprint.md  
**Pattern:** Follow existing domain structure, use blueprint for UI patterns

### Creating a New Page
**Read:** 03-styling-system.md, 04-blade-components.md, 06-public-pages-blueprint.md  
**Pattern:** Copy patterns from completed public pages exactly

### Updating Styles
**Read:** 03-styling-system.md, 06-public-pages-blueprint.md  
**Pattern:** Use existing SCSS classes, create new class if pattern repeats 3+ times

### Database Changes
**Read:** 02-database.md, 05-features.md  
**Pattern:** Follow existing relationship patterns, update documentation

### Fixing a Bug
**Read:** Relevant domain documentation (01-06)  
**Pattern:** Understand the feature first, then fix following existing patterns

---

## 🎨 Key Principles

### 1. Use Completed Work as Blueprint
- **Public pages (welcome, legal, changelog) are the gold standard**
- Copy their patterns exactly for consistency
- Don't reinvent animations, spacing, or typography
- Reference `06-public-pages-blueprint.md` extensively

### 2. Follow SCSS Class System
- Use custom SCSS classes for repeated patterns (3+ occurrences)
- Use Tailwind utilities for unique, one-off styling
- See `03-styling-system.md` for complete class reference
- Create new classes in appropriate files (base/components/pages)

### 3. Maintain Consistency
- Same animation delays (100ms increments)
- Same spacing scale (py-12 md:py-20 for sections)
- Same typography hierarchy (.h1, .h2, etc.)
- Same color palette (slate-700 accent)
- Same component patterns

### 4. Always Support Dark Mode
- Include dark: variants for all colors
- Test in both light and dark modes
- Follow existing dark mode patterns

### 5. Mobile-First Responsive Design
- Base styles for mobile
- md: breakpoint for tablet (768px)
- lg: breakpoint for desktop (1024px)
- Test on all screen sizes

---

## ✅ Quality Checklist

Before marking task complete:

**Code Quality:**
- [ ] Follows existing architectural patterns
- [ ] Uses SCSS classes (not inline Tailwind for common patterns)
- [ ] Includes dark mode support
- [ ] Responsive design tested
- [ ] No console errors
- [ ] No syntax errors

**Functionality:**
- [ ] Feature works as expected
- [ ] Edge cases handled
- [ ] Authorization policies work
- [ ] Database queries optimized (no N+1)

**Design:**
- [ ] Matches completed page patterns
- [ ] Typography hierarchy correct
- [ ] Spacing consistent with blueprint
- [ ] Animations follow blueprint timing
- [ ] Colors from established palette

**Documentation:**
- [ ] Relevant docs updated
- [ ] Code examples provided
- [ ] Breaking changes noted
- [ ] New classes documented

---

## 📖 Documentation Structure

```
ai/
├── README.md                    ← You are here
├── 01-architecture.md          ← Tech stack + structure
├── 02-database.md              ← Schema + relationships
├── 03-styling-system.md        ← SCSS + Tailwind
├── 04-blade-components.md      ← Components + Alpine.js
├── 05-features.md              ← Business logic + routes
├── 06-public-pages-blueprint.md ← Reference implementation ⭐
├── PROMPT.md                    ← Prompt templates
└── archive/                     ← Old documentation
```

---

## 🚀 Getting Started

1. **Read this README** (you're doing it!)
2. **Read all 6 documentation files** in order (01-06)
3. **Review the public pages** (`resources/views/public/`) to see patterns in action
4. **Start your task** following the 3-phase workflow
5. **Update documentation** when done

---

**Remember: The completed public pages are your blueprint. When in doubt, reference them first.**


1. READ AND UNDERSTAND these documentation files in order:
   - ai/01-overview-and-tech-stack.md
   - ai/02-database-schema.md
   - ai/03-domain-models.md
   - ai/04-features-and-workflows.md
   - ai/05-routing-and-controllers.md
   - ai/06-frontend-components.md

2. ANALYZE THE TASK:
   [Describe the task here]

3. PLAN MY APPROACH:
   - Affected domains: [list]
   - Database changes needed: [yes/no - describe]
   - Files to modify: [list]
   - New files to create: [list]
   - Authorization considerations: [describe]
   - Frontend changes: [describe]

4. IMPLEMENT THE CHANGES following the project's architectural patterns and conventions.

5. UPDATE DOCUMENTATION:
   - Files to update: [list which ai/*.md files]
   - Changes to document: [brief description]

Please confirm you have read and understood the project documentation before proceeding with the task.
```

---

## ✅ Quality Checklist

Before marking a task as complete, verify:

### Code Quality
- [ ] Follows PSR-12 coding standards (PHP)
- [ ] Uses type hints for parameters and return types
- [ ] Proper error handling and validation
- [ ] No SQL injection vulnerabilities
- [ ] CSRF protection on forms
- [ ] Authorization checks in place

### Architecture Compliance
- [ ] Models in correct domain folders
- [ ] Controllers follow RESTful patterns
- [ ] Proper use of policies for authorization
- [ ] Eloquent relationships properly defined
- [ ] Eager loading used to prevent N+1 queries
- [ ] Blade components follow naming conventions

### Database
- [ ] Migrations have both `up()` and `down()` methods
- [ ] Foreign keys have proper cascade rules
- [ ] Indexes on frequently queried columns
- [ ] Unique constraints where needed
- [ ] Default values for boolean fields

### Frontend
- [ ] Alpine.js components registered globally
- [ ] Blade components use proper slots
- [ ] Tailwind classes used (avoid custom CSS)
- [ ] Dark mode support maintained
- [ ] Responsive design works on mobile
- [ ] Accessibility attributes present

### Documentation
- [ ] All affected documentation files updated
- [ ] New features documented with workflows
- [ ] Database schema changes documented
- [ ] New routes and controllers documented
- [ ] Frontend components documented
- [ ] Examples provided where helpful

---

## 🚨 Common Mistakes to Avoid

1. **Starting without reading documentation**
   - Results in duplicate code, wrong patterns, broken features

2. **Not updating documentation**
   - Future agents won't understand your changes
   - Knowledge is lost

3. **Breaking existing patterns**
   - Inconsistent code is hard to maintain
   - Creates technical debt

4. **Forgetting authorization**
   - Security vulnerabilities
   - Users accessing data they shouldn't

5. **Creating N+1 queries**
   - Performance problems
   - Always use eager loading

6. **Not handling edge cases**
   - What if user deletes a challenge mid-tracking?
   - What if habit frequency changes?
   - What if goal library item is deleted?

7. **Ignoring cascade deletes**
   - Orphaned records in database
   - Referential integrity violations

---

## 📚 Quick Reference

### Key File Locations
```
app/Domain/{Domain}/Models/     # Domain models
app/Http/Controllers/           # Controllers
app/Policies/                   # Authorization policies
database/migrations/            # Database migrations
resources/views/                # Blade templates
resources/views/components/     # Blade components
resources/js/components/        # Alpine.js components
routes/web.php                  # Route definitions
```

### Common Commands
```bash
# Run migrations
php artisan migrate

# Create migration
php artisan make:migration create_table_name

# Create model
php artisan make:model Domain\\ModelName

# Create controller
php artisan make:controller ControllerName

# Create policy
php artisan make:policy PolicyName --model=ModelName

# Build assets
npm run dev     # Development with watch
npm run build   # Production build

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Architecture Patterns
- **Domain-Driven Design**: Organize by domain, not technical layer
- **Policy-Based Authorization**: Use policies for all access control
- **Repository Pattern**: For complex queries (Infrastructure layer)
- **Single Responsibility**: Each class has one clear purpose
- **Component-Based UI**: Reusable Blade and Alpine components

---

## 🎓 Learning Path for New Agents

If you're a new AI agent to this project:

1. **Day 1**: Read all documentation files thoroughly
2. **Day 2**: Explore the codebase structure
3. **Day 3**: Study one feature end-to-end (e.g., challenge creation)
4. **Day 4**: Review database relationships and migrations
5. **Day 5**: Understand authorization and policies
6. **Day 6**: Study frontend component patterns
7. **Day 7**: Ready to implement changes!

---

## 📞 Questions to Ask Before Starting

Before implementing a feature, answer these:

1. **Domain**: Which domain does this belong to? (Challenge, Habit, Goal, User, Activity, Social)
2. **Database**: Do I need to create/modify tables? What relationships?
3. **Authorization**: Who can access this? What policy rules?
4. **Activity Feed**: Should this create an activity? What type?
5. **Frontend**: What components are affected? New components needed?
6. **Testing**: How do I verify this works? What edge cases?
7. **Documentation**: Which files need updates?

---

## 🔄 Continuous Improvement

This documentation system is designed to evolve:

- When you find gaps in documentation, fill them
- When you discover new patterns, document them
- When you fix bugs, document the root cause
- When you add features, document the workflow

**Remember:** You're not just writing code, you're maintaining knowledge for future AI agents (and humans!) to understand and extend this project efficiently.

---

## ✨ Final Note

By following this structured approach, you ensure:
- **High-quality code** that follows established patterns
- **Maintainable documentation** that stays current
- **Efficient collaboration** between AI agents across sessions
- **Reduced technical debt** through consistency
- **Better project longevity** through knowledge preservation

Good luck, and happy coding! 🚀

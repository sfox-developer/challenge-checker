# AI Agent Quick Start Guide

## 🎯 Purpose of This Document

This document provides a **standardized prompt template** for AI agents working on the Challenge Checker project. Following this workflow ensures that AI agents:

1. **Understand the project architecture** before making changes
2. **Complete tasks correctly** with proper context
3. **Update documentation** to keep it current for future agents

---

## 📋 Standard AI Agent Workflow

When an AI agent receives a task for this project, follow this workflow:

### Phase 1: Project Understanding (REQUIRED FIRST STEP)

**Before starting any task, read these documentation files in order:**

1. **`ai/01-overview-and-tech-stack.md`**
   - Understand project purpose and architecture
   - Learn tech stack (Laravel, Alpine.js, Tailwind, PostgreSQL)
   - Review development conventions

2. **`ai/02-database-schema.md`**
   - Understand all database tables and relationships
   - Review foreign key constraints and cascade rules
   - Learn unique constraints and indexes

3. **`ai/03-domain-models.md`**
   - Learn model organization and relationships
   - Understand model methods and scopes
   - Review business logic patterns

4. **`ai/04-features-and-workflows.md`**
   - Understand user workflows and features
   - Learn how features interact
   - Review state management (challenge lifecycle, habit tracking, etc.)

5. **`ai/05-routing-and-controllers.md`**
   - Understand routing structure
   - Learn controller methods and responsibilities
   - Review authorization patterns

6. **`ai/06-frontend-components.md`**
   - Understand Alpine.js component system
   - Learn Blade component patterns
   - Review frontend architecture and CSS utility classes

7. **`ai/07-minimalistic-ui-refactoring.md`**
   - Learn current design system (minimalistic, single blue accent)
   - Understand color palette and usage guidelines
   - Review recent UI consistency changes

8. **`ai/08-css-classes-usage-guide.md`**
   - Understand SCSS component system
   - Learn Tailwind utility patterns
   - Review responsive design approach

9. **`ai/09-folder-structure.md`**
   - Learn views folder organization (public, auth, dashboard, admin)
   - Understand component namespace structure (dot notation)
   - Review SCSS modular architecture (SMACSS/ITCSS)
   - See controller view path conventions

10. **`ai/10-global-scss-refactoring.md`**
   - Understand global class system (typography, icons, buttons)
   - Learn class consolidation patterns (icon-wrapper, btn-large)
   - Review global vs layout-specific organization
   - See before/after refactoring examples

**⚠️ CRITICAL:** Do not skip this phase. Misunderstanding the architecture leads to:
- Breaking existing features
- Creating duplicate code
- Violating architectural patterns
- Incorrect database relationships

---

### Phase 2: Task Execution

**After understanding the project:**

1. **Analyze the task requirements**
   - What needs to be created, modified, or fixed?
   - Which domains/models are affected?
   - What database changes are needed?
   - Which routes and controllers are involved?
   - What frontend components need updates?

2. **Plan your approach**
   - Identify all files that need changes
   - Consider database migrations if schema changes
   - Plan authorization (policies) if needed
   - Consider activity feed implications
   - Think about edge cases

3. **Implement changes**
   - Follow existing code patterns
   - Use proper naming conventions
   - Maintain separation of concerns
   - Add proper validation
   - Handle errors gracefully
   - Test authorization rules

4. **Verify the implementation**
   - Check for syntax errors
   - Verify database relationships
   - Ensure proper eager loading (no N+1 queries)
   - Test authorization policies
   - Verify frontend components work

---

### Phase 3: Documentation Updates (REQUIRED)

**After completing the task, update relevant documentation:**

1. **Identify what changed:**
   - New database tables/columns? → Update `02-database-schema.md`
   - New models or methods? → Update `03-domain-models.md`
   - New features or workflows? → Update `04-features-and-workflows.md`
   - New routes or controllers? → Update `05-routing-and-controllers.md`
   - New components or JS? → Update `06-frontend-components.md`
   - Architecture changes? → Update `01-overview-and-tech-stack.md`

2. **Update the documentation files:**
   - Keep consistent formatting
   - Be specific and detailed
   - Include code examples where helpful
   - Update relationships and dependencies
   - Document any breaking changes

3. **Verify documentation accuracy:**
   - Does it reflect the current state?
   - Are all new features documented?
   - Are examples correct?
   - Is it easy for future agents to understand?

---

## 🤖 Prompt Template for AI Agents

Copy and use this prompt template when starting work on this project:

```
I am working on the Challenge Checker Laravel project. Before starting my task, I will:

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

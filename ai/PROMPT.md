# AI Agent Prompt Template

Copy and paste the prompt below when starting a new AI agent session for this project.

---

## 📋 Copy This Prompt:

```
Read ai/README.md and follow the standard AI agent workflow for this project.

Before starting any work:
1. Read ai/README.md to understand the workflow
2. Read all documentation files in ai/ folder (01-07)
3. Understand the project architecture and patterns

Task: [DESCRIBE YOUR TASK HERE]

Requirements:
- Follow the 3-phase workflow (Understand → Execute → Document)
- Maintain existing architectural patterns
- Update relevant documentation after changes
- Use the quality checklist before marking complete

Please confirm you have read the documentation before proceeding.
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
2. Read all documentation files in ai/ folder (01-06)
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
2. Read all documentation files in ai/ folder (01-06)
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
2. Read all documentation files in ai/ folder (01-06)
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

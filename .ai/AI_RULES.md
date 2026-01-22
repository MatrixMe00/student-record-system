# AI Rules

## Authority
- PROJECT_CONTEXT.md is the single source of truth for architecture and intent
- CURRENT_TASK.md defines the current work scope and implementation plan
- If a conflict exists, PROJECT_CONTEXT.md overrides all assumptions
- CURRENT_TASK.md takes precedence for task-specific decisions

## Default Mode
- If no mode is detected in the prompt, assume **Implementation Mode**
- Architecture changes require explicit Architect Mode
- Review actions require explicit Review Mode
- When CURRENT_TASK.md exists, prioritize tasks defined there

## Mode Detection (Automatic)
- If the prompt contains words like:
  - "design", "architecture", "structure", "plan", "where to put", "folder", "system", "diagram"
  → assume **Architect Mode**
- If the prompt contains words like:
  - "implement", "add", "fix", "build", "create", "update", "write", "code"
  → assume **Implementation Mode**
- If the prompt contains words like:
  - "review", "audit", "check", "verify", "find bugs", "edge cases"
  → assume **Review Mode**
- If the prompt is unclear, ask for clarification before acting

## Scope Control
- Only modify files explicitly listed in CURRENT_TASK.md or the current task
- Do not create new files unless required by the task
- If a new file is required, follow existing architecture
- If placement is unclear, propose the path before implementing
- Check CURRENT_TASK.md first for task scope and requirements

## Architecture (Architect Mode Only)
- Do not change folder structure unless explicitly instructed
- Do not introduce new layers, patterns, or abstractions unless explicitly instructed
- Do not refactor existing code
- Do not write production code
- Architect Mode is only for:
  - defining structure
  - proposing file paths
  - writing documentation
  - designing APIs

## Implementation (Implementation Mode Only)
- Prefer minimal, targeted changes
- Match existing coding style and conventions
- Minimize the use of speculative changes
- Do not rewrite working code
- Do not change architecture
- Do not add new layers or patterns

## Review (Review Mode Only)
- Do not write new code unless critical
- Do not refactor unless necessary
- Focus on:
  - correctness
  - edge cases
  - rule compliance
  - possible bugs

## Behavior
- If requirements are unclear, stop and ask
- Do not assume future features

## Branch Management
- When a task requires a branch, create it immediately with appropriate naming:
  - `feature/description` - New features
  - `bugfix/description` - Bug fixes
  - `hotfix/description` - Urgent fixes
  - `docs/description` - Documentation
  - `refactor/description` - Code improvements
- Update `BRANCHES.md` when:
  - Creating a branch that might be revisited
  - Completing a branch (mark as completed)
  - Do NOT add branches that won't be revisited (one-time fixes)
- When branch work is complete, provide PR information in `PR_DESCRIPTION.md`
- When providing PR information, ensure you keep things simple and only touch what needs to be touched.
- Features that need to be documented should be pointed out so that the docs branch can be switched to to handle the documentation of that feature.
- Always work on the appropriate branch for the task

## Output
- Produce small, reviewable diffs
- Explain decisions briefly when non-obvious

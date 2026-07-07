# Gitmoji Commit Convention

This project uses **Gitmoji** along with **Conventional Commits** for clear, expressive commit messages.

## Commit Message Format

```
<gitmoji> <type>(<scope>): <subject>

<body>

<footer>
```

## Gitmoji & Types Reference

| Emoji | Type | Use Case | Example |
|-------|------|----------|---------|
| ✨ | `feat` | New feature | `✨ feat(auth): add two-factor authentication` |
| 🐛 | `fix` | Bug fix | `🐛 fix(timer): correct meditation duration calculation` |
| 📝 | `docs` | Documentation | `📝 docs: update API documentation` |
| 🎨 | `style` | UI/UX changes | `🎨 style(dashboard): redesign stress chart` |
| ♻️ | `refactor` | Code refactoring | `♻️ refactor: simplify user model` |
| ⚡ | `perf` | Performance | `⚡ perf(api): optimize database queries` |
| ✅ | `test` | Tests | `✅ test(auth): add login integration tests` |
| 🔧 | `chore` | Build/config changes | `🔧 chore: update dependencies` |
| 🚀 | `deploy` | Deployment | `🚀 deploy: release version 1.2.0` |
| 📱 | `mobile` | Mobile-specific | `📱 mobile: fix responsive layout` |
| 🔐 | `security` | Security fix | `🔐 security: sanitize user input` |
| ♿ | `a11y` | Accessibility | `♿ a11y: improve screen reader labels` |
| 🌐 | `i18n` | Internationalization | `🌐 i18n: add French translations` |
| 🚨 | `hotfix` | Urgent production fix | `🚨 hotfix: resolve critical memory leak` |
| 💡 | `comment` | Code comments | `💡 comment: document complex algorithm` |
| 📦 | `release` | Version bump | `📦 release: bump to 2.0.0` |

## Examples

### Feature with Gitmoji
```
✨ feat(dashboard): add stress level visualization

- Implement real-time stress chart
- Add data aggregation logic
- Integrate with meditation tracking

Closes #123
```

### Bug Fix with Gitmoji
```
🐛 fix(timer): correct pause/resume timing issue

The timer was adding extra seconds when resuming from pause.
This fix ensures accurate elapsed time tracking.

Fixes #456
```

### Multiple Changes
```
🎨 style(ui): improve visual consistency

- Update button styling to match design system
- Adjust color scheme for dark mode
- Fix spacing inconsistencies

BREAKING CHANGE: Button component API changed
```

## Rules

✅ **DO:**
- Use gitmoji from the reference table
- Include a clear type (feat, fix, docs, etc.)
- Keep subject line under 50 characters
- Use imperative mood ("add feature" not "added feature")
- Reference issues with `Closes #123` or `Fixes #456`

❌ **DON'T:**
- Mix multiple emojis in one commit
- Use vague commit messages
- Commit without tests (pre-commit hook will prevent this)
- Break formatting rules (commitlint will catch this)

## Husky Pre-Commit Hooks

Your commit will be automatically validated:

1. **Lint-staged**: Runs ESLint + Prettier on changed files
2. **PHP Analysis**: Runs Pint (Laravel code style) + PHPStan (static analysis)
3. **Tests**: Runs PHP tests with Pest
4. **Commit-msg**: Validates message format with commitlint

## Quick Reference

If using gitmoji-cli:
```bash
npm run commit
# or
npx gitmoji-cli --commit
```

This will guide you through creating a properly formatted commit interactively.

## Reverting Commits

If you need to revert a commit, use:
```bash
git revert <commit-hash>
```

This will create a new commit with:
```
🔄 chore: revert "original commit message"
```

Note: The 🔄 emoji isn't in standard gitmoji but can be used for reverts as a variant of 🔃 (refresh).

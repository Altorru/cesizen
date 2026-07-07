# Pre-Commit Hooks Setup

This project uses **Husky** to automatically run tests, linting, and formatting checks before commits to ensure code quality and consistency.

## What Happens on Commit

When you try to commit, Husky automatically runs:

1. **Lint-staged** - Checks and fixes changed files:
   - ESLint for JavaScript/Vue/TypeScript
   - Prettier for formatting
   - Pint for PHP code style
   - PHPStan for PHP static analysis

2. **PHP Tests** - Runs Pest test suite to ensure no regressions

3. **Commit message validation** - Ensures commits follow Gitmoji + conventional commits format

If any check fails, your commit is blocked until issues are fixed.

## Installation

### First-time Setup

After cloning the repository:

```bash
# Install Node dependencies
npm install

# Husky is automatically set up via the "prepare" script
# This installs git hooks automatically
```

### Manual Husky Installation

If needed, manually install Husky hooks:

```bash
npm run prepare
# or
npx husky install
```

## Commit with Gitmoji

### Option 1: Using Gitmoji CLI (Interactive)

```bash
npx gitmoji-cli --commit
# or with npm script
npm run commit
```

This will guide you through:
1. Selecting an emoji
2. Choosing a commit type
3. Writing a message
4. Providing optional scope

### Option 2: Manual Commits

Follow the format: `<emoji> <type>(<scope>): <message>`

```bash
git add .
git commit -m "✨ feat(auth): add two-factor authentication"
```

### Option 3: Using Commit Composer

With GitLens installed, use the Commit Composer:
```bash
# In VS Code Command Palette
> Commit Composer
```

## Common Commit Types

| Emoji | Type | Example |
|-------|------|---------|
| ✨ | feat | `✨ feat: add meditation timer` |
| 🐛 | fix | `🐛 fix: correct stress calculation` |
| 📝 | docs | `📝 docs: update API docs` |
| 🎨 | style | `🎨 style: improve UI design` |
| ⚡ | perf | `⚡ perf: optimize queries` |
| ✅ | test | `✅ test: add unit tests` |
| 🔧 | chore | `🔧 chore: update deps` |

See [docs/GITMOJI_COMMITS.md](../GITMOJI_COMMITS.md) for full reference.

## Bypassing Hooks (Not Recommended)

If you absolutely need to skip hooks (not recommended):

```bash
git commit -m "..." --no-verify
# or
git commit -m "..." -n
```

**Note:** This skips ALL checks including tests. Use only in emergencies!

## Troubleshooting

### "command not found: husky"

```bash
npm install
npm run prepare
```

### Tests failing on commit

Fix the failing tests:
```bash
php artisan test
```

Or run specific test:
```bash
php artisan test tests/Feature/YourTest.php
```

### Linting errors

Fix automatically:
```bash
npm run lint     # ESLint fixes
npm run format   # Prettier fixes
./vendor/bin/pint  # Laravel Pint fixes
```

### Commit message rejected

Check format with:
```bash
# View commit message format rules
cat docs/GITMOJI_COMMITS.md
```

Common issues:
- Missing emoji or type
- Emoji not in allowed list
- Type in wrong case
- Message too long

### Hooks not running

Reinstall hooks:
```bash
rm -rf .husky
npm run prepare
```

## Pre-Commit Checklist

Before committing, ensure:

- ✅ Tests pass: `php artisan test`
- ✅ Code lints: `npm run lint`
- ✅ Code formatted: `npm run format`
- ✅ Commit message follows Gitmoji format
- ✅ No console.log or debug statements
- ✅ No hardcoded credentials or secrets

## Viewing Hooks

All hooks are in `.husky/`:

```bash
ls -la .husky/
```

- `pre-commit` - Runs linting, formatting, and tests
- `commit-msg` - Validates commit message format

## Editing Hooks

To modify what runs before commit:

```bash
# Edit pre-commit hook
nano .husky/pre-commit

# Or with VS Code
code .husky/pre-commit
```

After editing, ensure the hook remains executable:
```bash
chmod +x .husky/pre-commit
```

## CI/CD Integration

Husky hooks are local (development only). CI/CD workflows in `.github/workflows/` provide additional server-side validation:

- `.github/workflows/deploy.yml` - Deployment with version management
- `.github/workflows/version.yml` - Automatic versioning

See project CI/CD documentation for details.

## Disabling Hooks Temporarily

For development branches where you're still working:

```bash
# Temporarily disable all hooks
husky disable

# Re-enable hooks
husky enable
```

## Performance Tips

If hooks are slow:

1. **Skip PHP tests locally, run in CI:**
   - Edit `.husky/pre-commit`
   - Comment out the test line
   - Tests still run in CI/CD

2. **Use partial staging:**
   ```bash
   git add --patch  # Stage only changed lines
   git commit       # Faster pre-commit checks
   ```

3. **Run tests separately:**
   ```bash
   php artisan test  # Before committing
   git add .
   git commit -m "..." --no-verify  # Skip hook if confident
   ```

## Resources

- [Husky Documentation](https://typicode.github.io/husky/)
- [Gitmoji Reference](https://gitmoji.dev/)
- [Conventional Commits](https://www.conventionalcommits.org/)
- [Commitlint Rules](https://commitlint.js.org/)

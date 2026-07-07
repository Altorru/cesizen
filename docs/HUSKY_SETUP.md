# Husky Pre-Commit Setup Summary

## Overview

CESIZen now has automated pre-commit checks using **Husky**, **Lint-staged**, and **Commitlint** with **Gitmoji** support for clear, expressive commit messages.

## What Was Added

### Packages
- `husky` - Git hooks framework
- `lint-staged` - Run linters on staged files
- `@commitlint/cli` & `@commitlint/config-conventional` - Commit message validation
- `gitmoji-cli` - Interactive gitmoji commit helper

### Configuration Files

| File | Purpose |
|------|---------|
| `.husky/pre-commit` | Runs linting, formatting, PHP analysis, and tests |
| `.husky/commit-msg` | Validates commit message with commitlint |
| `commitlint.config.js` | Gitmoji + conventional commits rules |
| `.lintstagedrc.js` | Lint-staged configuration for file patterns |

### Documentation
- `docs/PRE_COMMIT_HOOKS.md` - Complete setup and usage guide
- `docs/GITMOJI_COMMITS.md` - Gitmoji and commit format reference
- `scripts/setup-husky.sh` - Automated setup script

## How It Works

### Pre-Commit Flow

```
git commit -m "..."
    ↓
.husky/pre-commit
    ├─ Lint-staged
    │   ├─ ESLint (JS/Vue/TS)
    │   ├─ Prettier (formatting)
    │   ├─ Pint (PHP style)
    │   └─ PHPStan (PHP analysis)
    ├─ PHP Tests (Pest)
    └─ Exit with error if anything fails
    ↓
Commit accepted (if all checks pass)
```

### Commit Message Validation

```
git commit -m "✨ feat(dashboard): add charts"
    ↓
.husky/commit-msg
    ├─ Check emoji is in allowed list
    ├─ Check type is valid (feat, fix, etc.)
    ├─ Check format matches pattern
    └─ Exit with error if invalid
    ↓
Commit created (if format is valid)
```

## Quick Start

### First Time Setup

```bash
# Clone and install
git clone <repo>
cd cesizen
npm install

# Husky hooks are automatically installed via "prepare" script
# (This happens automatically when you run npm install)
```

### Making Commits

#### Option 1: Interactive Gitmoji CLI
```bash
npx gitmoji-cli --commit
```
Guides you through: emoji → type → scope → message

#### Option 2: Manual with Gitmoji
```bash
git add .
git commit -m "✨ feat(auth): add login form"
```

#### Option 3: Standard Conventional Commit
```bash
git add .
git commit -m "feat(auth): add login form"
# (Gitmoji is optional, type is required)
```

## Commit Types at a Glance

| Emoji | Type | When to Use |
|-------|------|-------------|
| ✨ | feat | New feature |
| 🐛 | fix | Bug fix |
| 📝 | docs | Documentation |
| 🎨 | style | UI/visual changes |
| ⚡ | perf | Performance improvement |
| ✅ | test | Add/update tests |
| 🔧 | chore | Build/config/deps |
| 🚀 | deploy | Release/deployment |
| 🔐 | security | Security fix |

See `docs/GITMOJI_COMMITS.md` for full reference.

## What Each Hook Does

### Pre-Commit Hook (`.husky/pre-commit`)

**Lint-staged checks** - On changed files only:
- `*.{vue,ts,tsx,js,jsx}` → ESLint + Prettier
- `*.php` → Pint + PHPStan
- Other files → Prettier

**Test execution:**
- Runs: `php artisan test`
- Fails if any test doesn't pass

**Stops commit if:**
- ESLint errors found
- Prettier formatting needed
- PHP analysis issues found
- Tests fail

### Commit-Msg Hook (`.husky/commit-msg`)

**Validates format:**
- Emoji must be in allowed list (or conventional type)
- Type must be lowercase
- Subject must be imperative mood
- No uppercase in subject (unless after code blocks)

**Examples that PASS:**
```
✨ feat(dashboard): add stress chart
🐛 fix: correct timer calculation
📝 docs: update README
```

**Examples that FAIL:**
```
feat(dashboard): Add stress chart  # Subject capitalized
✅ test add tests  # Missing type
add feature  # Missing emoji and type
```

## Common Workflows

### Fix a Failing Test Before Commit
```bash
# Fix fails tests
php artisan test

# Fix the code
# ...

# Try commit again
git add .
git commit -m "🐛 fix: resolve test failure"
```

### Fix Linting Issues
```bash
# Auto-fix linting issues
npm run lint

# Auto-format code
npm run format

# Then commit
git add .
git commit -m "🎨 style: fix formatting"
```

### Skip Hooks (Emergency Only)
```bash
git commit -m "..." --no-verify  # Skip all hooks
git commit -m "..." -n           # Shorthand
```

⚠️ **Not recommended** - hooks are there for code quality!

## Troubleshooting

### "Pre-commit hook failed"
1. Check output for specific error
2. Fix the code/tests
3. Try commit again

### "Commit message validation failed"
1. Check `docs/GITMOJI_COMMITS.md`
2. Ensure format: `<emoji> <type>: <message>`
3. Verify emoji is in the allowed list

### Hooks not running
```bash
npm run prepare    # Reinstall hooks
chmod +x .husky/* # Make executable
```

### Tests taking too long
Edit `.husky/pre-commit` and comment out test line:
```bash
# php artisan test --env=testing
```
(Tests still run in CI/CD!)

## Configuration Files

### `commitlint.config.js`
Defines allowed commit types and emoji. Modify to add/remove types.

### `.lintstagedrc.js`
Specifies which commands run on which file types. Update if adding new file types.

### `.husky/pre-commit`
Main pre-commit logic. Edit to add/remove checks.

### `.husky/commit-msg`
Commit message validation. Usually doesn't need editing.

## Integration with CI/CD

Husky runs **locally** during development.

CI/CD provides **server-side** validation:
- `.github/workflows/deploy.yml` - Deployment
- `.github/workflows/version.yml` - Versioning

Both workflows include additional checks to ensure only quality code reaches production.

## Team Setup

When team members clone the repo:

```bash
git clone <repo>
npm install
# Hooks are automatically installed!
```

The `"prepare": "husky install"` script in `package.json` ensures Husky hooks are set up automatically.

## Files Changed/Created

```
📁 .husky/
   ├─ pre-commit
   └─ commit-msg
📄 commitlint.config.js
📄 .lintstagedrc.js
📁 docs/
   ├─ PRE_COMMIT_HOOKS.md (new)
   └─ GITMOJI_COMMITS.md (new)
📁 scripts/
   └─ setup-husky.sh (new)
📄 package.json (updated with new scripts and deps)
```

## Performance Notes

- Lint-staged only checks **changed files** (fast)
- Tests run on full suite (can be slow)
- Total time: ~5-30 seconds per commit
- To speed up: comment out tests in pre-commit hook (still runs in CI)

## Resources

- [Husky Docs](https://typicode.github.io/husky/)
- [Lint-staged](https://github.com/okonet/lint-staged)
- [Commitlint](https://commitlint.js.org/)
- [Gitmoji](https://gitmoji.dev/)
- [Conventional Commits](https://www.conventionalcommits.org/)

## Next Steps

1. ✅ Dependencies added to `package.json`
2. ✅ Husky hooks configured in `.husky/`
3. ✅ Commit linting configured in `commitlint.config.js`
4. 👉 **Run `npm install` to activate hooks**
5. 👉 Read `docs/PRE_COMMIT_HOOKS.md` for usage
6. 👉 Try first commit with gitmoji: `npx gitmoji-cli --commit`

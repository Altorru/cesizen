# Auto Versioning System

## Overview

CESIZen uses **Semantic Versioning** (SemVer) with automatic version bumping based on conventional commits. Version tags and releases are automatically created during CI/CD.

## How It Works

### Version Format
- **Semantic Versioning**: `MAJOR.MINOR.PATCH` (e.g., `1.2.3`)
- **Git Tags**: `vMAJOR.MINOR.PATCH` (e.g., `v1.2.3`)
- **Release Names**: GitHub Releases named after tags

### Version Bumping Logic

The version is automatically bumped based on commit messages using **Conventional Commits**:

| Commit Type | Bump | Example |
|---|---|---|
| `feat: ...` | MINOR | New feature → `1.0.0` → `1.1.0` |
| `fix: ...` | PATCH | Bug fix → `1.0.0` → `1.0.1` |
| `BREAKING CHANGE:` | MAJOR | Breaking change → `1.0.0` → `2.0.0` |
| Other | PATCH | No change, default bump |

### Workflows

#### 1. **Auto Version Workflow** (`.github/workflows/version.yml`)
**Triggers:** On every push to `main` branch

**Actions:**
1. Detects commit messages since last tag
2. Determines bump type (major/minor/patch)
3. Updates `.version` file
4. Updates `package.json` version field
5. Creates `config/version.php` for PHP
6. Commits version bump (with skip flag to prevent loop)
7. Creates git tag (e.g., `v1.2.3`)
8. Creates GitHub Release

**Skip Condition:** If commit message starts with `chore(release):`, versioning is skipped to prevent infinite loops.

#### 2. **Deploy Workflow** (`.github/workflows/deploy.yml`)
**Triggers:** On push to `main` branch

**Additional Steps:**
1. Extracts version from `.version` file or latest git tag
2. Passes `APP_VERSION` to deployment script
3. Logs version in deployment output
4. Stores version on server in `storage/version.txt`

## Usage

### Check Current Version

**Locally:**
```bash
cat .version
```

**In GitHub Actions:**
```bash
cat .version  # Returns: 1.2.3
```

**Using Laravel Artisan:**
```bash
php artisan app:version

# Output:
# ═══════════════════════════════════
# 🚀 CESIZen Application Information
# ═══════════════════════════════════
# 
# Version: 1.2.3
# Environment: production
# PHP Version: 8.4.0
# Build Timestamp: 2026-07-07 10:30:00
# Build Commit: abc1234
# Branch: main
#
# ═══════════════════════════════════
```

**As JSON:**
```bash
php artisan app:version --json
```

### Access Version in Laravel

```php
// Get current version
$version = config('version.current');  // Returns: "1.2.3"

// Get build info
$build = config('version.build');
$timestamp = $build['timestamp'];
$commit = $build['commit'];
$branch = $build['branch'];
```

### Display Version in Vue.js Frontend

Create a new endpoint in `routes/web.php`:
```php
Route::get('/api/version', fn() => response()->json([
    'version' => config('version.current'),
    'build' => config('version.build'),
]));
```

Then in your Vue component:
```vue
<template>
  <div class="version-info">
    Version: {{ version }}
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const version = ref('0.0.0')

onMounted(async () => {
  const res = await fetch('/api/version')
  const data = await res.json()
  version.value = data.version
})
</script>
```

## Files Updated/Created

| File | Purpose |
|---|---|
| `.version` | Current version number |
| `.github/workflows/version.yml` | Automatic versioning workflow |
| `.github/workflows/deploy.yml` | Updated to extract & use version |
| `config/version.php` | Laravel version configuration |
| `app/Console/Commands/VersionCommand.php` | Artisan command for version info |
| `package.json` | Automatically updated with version |

## Conventional Commits Guide

To trigger appropriate version bumps, use conventional commit messages:

```bash
# Feature (bumps MINOR)
git commit -m "feat: add stress tracking dashboard"

# Bug fix (bumps PATCH)
git commit -m "fix: correct meditation timer calculation"

# Breaking change (bumps MAJOR)
git commit -m "feat: redesign user authentication

BREAKING CHANGE: Old auth tokens are no longer supported"

# Other commits (bumps PATCH by default)
git commit -m "docs: update README"
git commit -m "style: format code"
git commit -m "refactor: simplify database queries"
```

## Workflow Status

Monitor the versioning workflow in **GitHub → Actions → Auto Version**

## Troubleshooting

### Version Not Updating
- ✅ Verify commit uses conventional commit format
- ✅ Check that commit message doesn't start with `chore(release):`
- ✅ Ensure `.version` file exists in repo

### Duplicate Tags
- This shouldn't happen due to built-in checks, but if it does:
  ```bash
  git tag -d v1.2.3
  git push origin :v1.2.3
  ```

### Manual Version Bump
If you need to manually set version:
```bash
echo "2.0.0" > .version
git add .version
git commit -m "chore(release): manually bump to 2.0.0"
git tag v2.0.0
git push origin main --tags
```

## Environment Variables

During deployment, set these in GitHub Actions Secrets if needed:
- `BUILD_TIMESTAMP` - Automatically set by deployment
- `BUILD_COMMIT` - Git commit SHA (can be added to workflow)
- `BUILD_BRANCH` - Git branch name (can be added to workflow)

## Security Notes

- Version information is public (stored in `.version`, `package.json`, config)
- Do not use version files for sensitive information
- Consider version info when discussing security updates publicly

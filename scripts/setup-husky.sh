#!/bin/bash

# Setup script for Husky pre-commit hooks
# This script ensures all dependencies are installed and hooks are ready

set -e

echo "🚀 Setting up Husky pre-commit hooks..."
echo ""

# Check if Node is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js is not installed. Please install Node.js first."
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "❌ npm is not installed. Please install npm first."
    exit 1
fi

echo "✅ Node.js $(node --version) found"
echo "✅ npm $(npm --version) found"
echo ""

# Install dependencies
echo "📦 Installing npm dependencies..."
npm install

echo ""
echo "🔗 Installing Husky hooks..."
npm run prepare

# Make hooks executable (in case permissions were lost)
chmod +x .husky/pre-commit 2>/dev/null || true
chmod +x .husky/commit-msg 2>/dev/null || true

echo ""
echo "✨ Husky setup complete!"
echo ""
echo "📖 Next steps:"
echo "   1. Read docs/PRE_COMMIT_HOOKS.md for usage"
echo "   2. Check docs/GITMOJI_COMMITS.md for commit guidelines"
echo "   3. Try making a commit: git add . && git commit -m '✨ feat: description'"
echo ""
echo "💡 Quick commands:"
echo "   - Interactive commit: npx gitmoji-cli --commit"
echo "   - Run tests: php artisan test"
echo "   - Lint code: npm run lint"
echo "   - Format code: npm run format"
echo ""

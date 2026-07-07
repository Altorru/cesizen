#!/bin/sh

set -e

# Run Pint on staged PHP files passed by lint-staged.
./vendor/bin/pint "$@"

PHP_VERSION=$(php -r 'echo PHP_VERSION;' 2>/dev/null || true)
if [ -z "$PHP_VERSION" ]; then
  echo "⚠️  PHP not found locally, skipping PHPStan in lint-staged. CI will enforce static analysis."
  exit 0
fi

if [ "$(printf '%s\n' "8.4.0" "$PHP_VERSION" | sort -V | head -n1)" = "8.4.0" ]; then
  ./vendor/bin/phpstan analyse
else
  echo "⚠️  Local PHP version is $PHP_VERSION (< 8.4.0), skipping PHPStan in lint-staged. CI will enforce static analysis."
fi

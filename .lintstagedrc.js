export default {
  '*.{vue,ts,tsx,js,jsx,mjs}': ['eslint --fix', 'prettier --write'],
  '*.{css,scss,sass}': ['prettier --write'],
  '*.{md,json,yml,yaml}': ['prettier --write'],
  '*.php': ['./scripts/php-lintstaged.sh'],
}

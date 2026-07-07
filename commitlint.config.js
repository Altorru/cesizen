export default {
  extends: ['@commitlint/config-conventional'],
  parserPreset: {
    parserOpts: {
      headerPattern: /^(\d+\.\d+\.\d+|\s)*(.+?)(\s.+)?$/,
      headerCorrespondence: ['version', 'type', 'subject'],
    },
  },
  rules: {
    'type-enum': [
      2,
      'always',
      [
        // Standard conventional commits
        'feat',
        'fix',
        'docs',
        'style',
        'refactor',
        'perf',
        'test',
        'chore',
        'ci',
        'revert',
        // Gitmoji as type prefix (common ones)
        '✨', // sparkles - feature
        '🐛', // bug - bugfix
        '📝', // memo - docs
        '💄', // lipstick - style
        '♻️', // recycle - refactor
        '⚡', // zap - perf
        '✅', // white check mark - test
        '🔧', // wrench - chore
        '🚀', // rocket - deployment
        '🎨', // art - ui
        '📦', // package - release
        '🚨', // warning - hotfix
        '💡', // bulb - comment
        '🔐', // lock - security
        '🌐', // globe - i18n
        '📱', // iphone - mobile
        '♿', // wheelchair - accessibility
      ],
    ],
    'type-case': [2, 'always', 'lowerCase'],
    'subject-case': [2, 'never', ['start-case', 'pascal-case']],
  },
}

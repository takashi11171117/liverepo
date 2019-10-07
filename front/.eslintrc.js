module.exports = {
  root: true,
  env: {
    browser: true,
    node: true
  },
  parserOptions: {
    parser: '@typescript-eslint/parser',
		ecmaFeatures: {
			legacyDecorators: true
		}
  },
  extends: [
    '@nuxtjs/eslint-config-typescript',
    // 'prettier',
    // 'prettier/vue',
    // 'plugin:prettier/recommended',
    'plugin:nuxt/recommended'
  ],
  plugins: [
    // 'prettier'
  ],
  // add your custom rules here
  rules: {
		"camelcase": [0, {}]
  },
}

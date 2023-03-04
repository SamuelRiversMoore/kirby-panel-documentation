/** @type {import('tailwindcss').Config} */
const typography = require('./typography')

module.exports = {
  content: ['./typography.js', './src/**/*.{html,js,vue}'],
  theme: {
    typography: typography,
    extend: {
      typography: (theme) => ({
        DEFAULT: {
          css: {
            lineHeight: '1.6em',
            code: {
              color: 'var(--tw-prose-code)',
              backgroundColor: 'var(--tw-prose-pre-code)',
              fontWeight: '400',
              padding: '0.15em 0.4em',
              borderRadius: '0.2em'
            },
            h1: {
              paddingBottom: '0.5em',
              marginBottom: '0.5em'
            },
            h2: {
              fontSize: 24,
              marginBottom: '0.5em'
            },
            h3: {
              marginBottom: '0.5em'
            },
            ol: {
              paddingLeft: '1.25em'
            },
            ul: {
              paddingLeft: '1.25em'
            }
          }
        }
      })
    }
  },
  plugins: [require('@tailwindcss/typography')]
}

/** @type {Partial<CustomThemeConfig & {extend: Partial<CustomThemeConfig>}> & DefaultTheme} */
const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  content: ["./src/**/*.{html,js}",
    "./*{html,js}"
  ],
  theme: {
    extend: {
      colors: {
        transparent: 'transparent',
        current: 'currentColor',
        'fondLight': '#FBFEFB',
        'txtLight': '#030501',
        'mainLight': '#DA627D',
        'secondLight': '#FFF4C7',
        'thirdLight': '#F3E8FF',
        'fondDark': '#0F0205',
        'textDark': '#E5DADC',
        'mainDark': '#E5ACB9',
        'secondDark': '#F2EBCE',
        'thirdDark': '#E1D0F2',
      },
      fontFamily: {
        Sora: ['"Sora"', ...defaultTheme.fontFamily.sans]
      },
      backgroundImage: {
        'fond-pattern': "url('https://uxtools.co/img/grain.png')",
      }
    },
  },
  plugins: [],
}


/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./resources/tailwind/**/*.html",
    "./node_modules/daisyui/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [require(require.resolve("daisyui"))],
}

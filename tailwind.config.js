/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/views/**/*.blade.php', // Scan all Blade templates
    './resources/js/**/*.{js,jsx,ts,tsx}', // Scan JavaScript/TypeScript files
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./partials/**/*.php"],
  theme: {
    extend: {
      height: {
        "screen-wp": "calc(100vh - 32px - 40px - 10px)",
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};

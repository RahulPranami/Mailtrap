/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ["./partials/**/*.php"],
	theme: {
		extend: {
			height: {
				"screen-wp": "calc(100vh - 32px - 40px - 10px)",
			},
			width: {
				"screen-wp": "calc(100vw - 160px - 75px)",
			}
		},
	},
	plugins: [require( "@tailwindcss/forms" )],
};

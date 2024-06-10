/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
    ],
    theme: {
        extend: {},
    },
    plugins: [require("daisyui")],
    // daisyUI config (optional - here are the default values)
    daisyui: {
        themes: ["light", "dark"],
    },
    darkMode: ["class", '[data-theme="dark"]'],
};

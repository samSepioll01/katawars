const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'outter-sm': '0px 0px 5px',
                'outter-md': '0px 0px 6px',
                'outter-lg': '0px 0px 7px',
                'outter-xl': '0px 0px 8px',
                'glassmorph': '0px 0px 15px, 0px 0px 30px, 0px 0px 45px, 0px 0px 60px',
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
    darkMode: 'class',
};

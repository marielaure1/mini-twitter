const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                "poppins": ['Poppins', "sans-serif"]
            },
            colors: {
                "primary": "#5a43f5",
                "secondary": "#00bcdf",
                "tertiary": "#ae45f5",
            },
            backgroundColor: {
                "primary": "#1c242f",
                "secondary": "#191e25",
                "primary2": "#5a43f5",
                "secondary2": "#00bcdf",
                "tertiary2": "#ae45f5",
            },
            border:{
                "primary": "#5a43f5",
                "secondary": "#00bcdf",
                "tertiary": "#ae45f5",
            },
            shadow: {
                "primary": "#5a43f5",
                "secondary": "#00bcdf",
                "tertiary": "#ae45f5",
                "primary2": "#1c242f",
                "secondary2": "#191e25"
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
    
};

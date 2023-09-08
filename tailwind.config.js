import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from "daisyui";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            gridTemplateRows: {
                '12': 'repeat(12, minmax(0, 1fr))',
                '10': 'repeat(10, minmax(0, 1fr))',
                '9': 'repeat(9, minmax(0, 1fr))',
                '8': 'repeat(8, minmax(0, 1fr))',
            },
            gridRow: {
                'span-12': 'span 12 / span 12',
                'span-11': 'span 11 / span 11',
                'span-10': 'span 10 / span 10',
                'span-9': 'span 9 / span 9',
                'span-8': 'span 8 / span 8',
                'span-7': 'span 7 / span 7',
            }
        },
    },

    plugins: [forms, daisyui],
};

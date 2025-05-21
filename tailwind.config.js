import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
            colors: {
                primary: '#043873',
                secondary: '#4F9CF9',
                text: {
                    light: '#FFFFFF', 
                    dark: '#212529',
                },
                button: {
                    primary: '#4F9CF9',
                    secondary: '#FFE492',
                },
                accent: {
                    primary: '#FFE492'
                }
            }
        },
    },

    plugins: [forms],
};

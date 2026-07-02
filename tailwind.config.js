import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', 'Georgia', 'serif'],
                script: ['Dancing Script', 'cursive'],
            },
            colors: {
                wo: {
                    rose: '#B5636A',
                    'rose-dark': '#8E4E54',
                    'rose-light': '#D4929A',
                    'rose-bg': '#F0D5D8',
                    cream: '#FAF3EE',
                    'cream-dark': '#F0E4DA',
                    brown: '#2C1810',
                    'brown-text': '#4A3228',
                    'brown-light': '#7A6A65',
                },
            },
        },
    },

    plugins: [forms],
};

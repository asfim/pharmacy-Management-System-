import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        // Feature card dynamic colors
        {
            pattern: /bg-(emerald|blue|violet|amber|rose|pink|cyan|indigo|purple|orange|sky)-(50|100|200|500|600)/,
            variants: ['hover', 'group-hover'],
        },
        {
            pattern: /text-(emerald|blue|violet|amber|rose|pink|cyan|indigo|purple|orange|sky)-(200|400|500|600)/,
            variants: ['hover', 'group-hover'],
        },
        {
            pattern: /from-(emerald|blue|violet|amber|rose|pink|cyan|indigo|purple|orange|sky)-(400|500|600)/,
            variants: ['hover', 'group-hover'],
        },
        {
            pattern: /to-(emerald|blue|violet|amber|rose|pink|cyan|indigo|purple|orange|sky)-(500|600)/,
            variants: ['hover', 'group-hover'],
        },
        {
            pattern: /shadow-(emerald|blue|violet|amber|rose|pink|cyan|indigo|purple|orange|sky)-500/,
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};

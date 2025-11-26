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
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
                sm: '1.5rem',
                lg: '2rem',
            },
        },
        screens: {
            'xs': '420px',
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
        },
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#0f766e',
                    50: '#f0fdfa',
                    100: '#ccfbf1',
                    200: '#99f6e4',
                    300: '#5eead4',
                    400: '#2dd4bf',
                    500: '#14b8a6',
                    600: '#0d9488',
                    700: '#0f766e',
                    800: '#115e59',
                    900: '#134e4a'
                },
                accent: '#f97316',
                subtle: {
                    DEFAULT: '#6b7280',
                    light: '#9ca3af'
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'xs': ['0.75rem', { lineHeight: '1rem' }],
                'sm': ['0.875rem', { lineHeight: '1.25rem' }],
                'base': ['1rem', { lineHeight: '1.5rem' }],
                'lg': ['1.125rem', { lineHeight: '1.75rem' }],
                'xl': ['1.25rem', { lineHeight: '1.75rem' }],
                '2xl': ['1.5rem', { lineHeight: '2rem' }],
                '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
                '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
            },
            fontWeight: {
                normal: 400,
                medium: 600,
                bold: 700,
            },
            spacing: {
                '72': '18rem',
                '84': '21rem',
                '96': '24rem'
            }
        },
    },

    plugins: [forms],
};

import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/Domains/**/*.php',
        './app/Core/**/*.php',
    ],
    theme: {
        screens: {
            xs: '375px',
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1280px',
            '2xl': '1536px',
        },
        extend: {
            colors: {
                canvas: '#111711',
                surface: {
                    DEFAULT: '#182218',
                    hover: '#202b20',
                    active: '#283628',
                    card: '#1a241a',
                },
                primary: {
                    DEFAULT: '#346739',
                    dark: '#264e2a',
                    light: '#437d49',
                },
                secondary: {
                    DEFAULT: '#79AE6F',
                    light: '#8ec084',
                    dark: '#639659',
                },
                accent: {
                    DEFAULT: '#9FCB98',
                    light: '#b6dba0',
                    dark: '#82b37a',
                },
                cream: {
                    DEFAULT: '#F2EDC2',
                    light: '#FAF8E8',
                    dark: '#E3DC9E',
                },
                dark: {
                    DEFAULT: '#1F291E',
                    muted: '#404C3F',
                },
                'night-bg': '#111711',
                'night-surface': '#182218',
                'night-card': '#202b20',
                'night-border': 'rgba(255, 255, 255, 0.12)',
                'border-subtle': '#263526',
                'border-muted': '#364636',
                border: {
                    DEFAULT: '#263526',
                    subtle: '#263526',
                    muted: '#364636',
                },
                brand: {
                    primary: '#346739',
                    secondary: '#79AE6F',
                    accent: '#9FCB98',
                    cream: '#F2EDC2',
                    emerald: '#10B981',
                    amber: '#F59E0B',
                    danger: '#EF4444',
                    rose: '#E11D48',
                    indigo: '#4F46E5',
                },
            },
            borderColor: {
                DEFAULT: '#263526',
                subtle: '#263526',
                muted: '#364636',
                'night-border': 'rgba(255, 255, 255, 0.12)',
            },
            fontFamily: {
                heading: ['"Hedvig Letters Serif"', 'Georgia', 'serif'],
                mono: ['"Roboto Mono"', 'ui-monospace', 'monospace'],
                sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                body: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
};

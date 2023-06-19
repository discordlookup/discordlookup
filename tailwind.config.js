const plugin = require('tailwindcss/plugin');
const colors = require('tailwindcss/colors');
module.exports = {
    content: [
        './storage/framework/views/*.php',
        './resources/views/components/**/*.blade.php',
        './vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php',
    ],
    safelist: [
        'hidden',
        'bg-emerald-200',
        'text-emerald-700',
        'bg-blue-200',
        'text-blue-700',
        'bg-orange-200',
        'text-green-700',
        'bg-red-200',
        'text-red-700',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                'discord-gray-1': '#202225',
                'discord-gray-2': '#292b2f',
                'discord-gray-3': '#2f3136',
                'discord-gray-4': '#36393f',
                'discord-gray-5': '#40444b',
                'discord-blurple': '#5865F2',
                'discord-green': '#57F287',
                'discord-yellow': '#FEE75C',
                'discord-fuchsia': '#EB459E',
                'discord-red': '#ED4245',
            },
            lineHeight: {
                '16': '4rem',
            }
        },
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        plugin(function({ addUtilities }) {
            const utilBgPatterns = {
                '.pattern-dots-sm': {
                    'background-image': 'radial-gradient(currentColor 0.5px, transparent 0.5px)',
                    'background-size': 'calc(10 * 0.5px) calc(10 * 0.5px)',
                },
                '.pattern-dots-md': {
                    'background-image': 'radial-gradient(currentColor 1px, transparent 1px)',
                    'background-size': 'calc(10 * 1px) calc(10 * 1px)',
                },
                '.pattern-dots-lg': {
                    'background-image': 'radial-gradient(currentColor 1.5px, transparent 1.5px)',
                    'background-size': 'calc(10 * 1.5px) calc(10 * 1.5px)',
                },
                '.pattern-dots-xl': {
                    'background-image': 'radial-gradient(currentColor 2px, transparent 2px)',
                    'background-size': 'calc(10 * 2px) calc(10 * 2px)',
                },
            }

            addUtilities(utilBgPatterns)
        }),
        plugin(function({ addUtilities }) {
            const utilFormSwitch = {
                '.form-switch': {
                    'border': 'transparent',
                    'background-color': colors.gray[300],
                    'background-image': "url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e\")",
                    'background-position': 'left center',
                    'background-repeat': 'no-repeat',
                    'background-size': 'contain !important',
                    'vertical-align': 'top',
                    '&:checked': {
                        'border': 'transparent',
                        'background-color': 'currentColor',
                        'background-image': "url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e\")",
                        'background-position': 'right center',
                    },
                    '&:disabled, &:disabled + label': {
                        'opacity': '.5',
                        'cursor': 'not-allowed',
                    },
                },
            }
            addUtilities(utilFormSwitch)
        }),
    ],
}

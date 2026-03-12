<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $pageTitle }}</title>
    <meta name="google" value="notranslate">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-default: var(--color-default);
            --color-invers: var(--color-invers);
            --color-dimmed: var(--color-dimmed);
            --color-accent: var(--color-accent);
            --color-canvas: var(--color-canvas);
            --color-tile: var(--color-tile);
            --color-warning: var(--color-warning);
            --color-error: var(--color-error);
            --color-success: var(--color-success);

            --font-sans: "Inter UI", ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";

            --grid-template-columns-1-1: 1fr 1fr;
            --grid-template-columns-1-auto: 1fr auto;
            --grid-template-columns-1-auto-1: 1fr auto 1fr;
            --grid-template-columns-1-auto-auto: 1fr auto auto;
            --grid-template-columns-auto-1: auto 1fr;
            --grid-template-columns-auto-1-1: auto 1fr 1fr;
            --grid-template-columns-auto-1-auto: auto 1fr auto;
            --grid-template-columns-auto-auto: auto auto;

            --grid-template-rows-1-1: 1fr 1fr;
            --grid-template-rows-1-auto: 1fr auto;
            --grid-template-rows-1-auto-1: 1fr auto 1fr;
            --grid-template-rows-1-auto-auto: 1fr auto auto;
            --grid-template-rows-auto-1: auto 1fr;
            --grid-template-rows-auto-1-1: auto 1fr 1fr;
            --grid-template-rows-auto-1-auto: auto 1fr auto;
            --grid-template-rows-auto-auto: auto auto;
        }

        :root {
            --color-default: rgba(0, 0, 0, 0.9);
            --color-dimmed: rgba(0, 0, 0, 0.6);
            --color-invers: rgba(255, 255, 255, 0.9);
            --color-accent: rgba(25, 71, 147, 0.9);
            --color-canvas: rgb(240, 240, 240);
            --color-tile: rgb(255, 255, 255);
            --color-warning: rgb(255, 172, 51);
            --color-error: rgb(234, 15, 65);
            --color-success: rgb(72, 187, 120);
        }

        .dark-mode {
            --color-default: rgba(255, 255, 255, 0.9);
            --color-dimmed: rgba(255, 255, 255, 0.6);
            --color-invers: rgba(0, 0, 0, 0.9);
            --color-accent: rgb(255, 172, 51);
            --color-canvas: rgb(27, 27, 27);
            --color-tile: rgb(39, 39, 39);
            --color-warning: rgb(143, 86, 0);
            --color-error: rgb(234, 89, 114);
            --color-success: rgb(47, 133, 90);
        }

        html {
            font-size: 1.2vmax;
        }
    </style>

    {{ $assets }}

    @stack('assets')
</head>
<body class="leading-snug">
<div
    x-data="theme('{{ $theme->value }}', '{{ $initialMode->value }}')"
    x-init="init"
    :class="mode === 'dark' ? 'dark-mode' : ''"
>
    <div class="fixed inset-0 w-screen h-screen grid gap-2 p-2 bg-canvas text-default">
        <livewire:dashboard-update-mode/>

        {{ $slot }}
    </div>
</div>

@stack('scripts')

<script>
    const theme = (theme, initialMode) => ({
        theme,
        mode: initialMode,

        init() {
            if (this.theme === 'device') {
                this.detectDeviceColorScheme();

                return;
            }

            if (this.theme === 'auto') {
                this.listenForUpdateModeEvent();

                return;
            }
        },

        detectDeviceColorScheme() {
            const mediaQuery = matchMedia("(prefers-color-scheme: dark)");

            this.mode = mediaQuery.matches ? 'dark' : 'light';

            mediaQuery.addListener((event) => {
                this.mode = mediaQuery.matches ? 'dark' : 'light';
            });
        },

        listenForUpdateModeEvent() {
            window.Livewire.on('updateMode', newMode => {
                if (newMode !== this.mode) {
                    this.mode = newMode;
                }
            })
        },
    });

    document.addEventListener('livewire:init', () => {
        Livewire.hook('request', ({ fail }) => {
            fail(({ status, preventDefault }) => {
                if (status === 419) {
                    preventDefault();

                    window.location.reload();
                }
            })
        });
    });
</script>


</body>
</html>

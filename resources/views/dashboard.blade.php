<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $pageTitle }}</title>
    <meta name="google" value="notranslate">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    {{ $assets }}

    @stack('assets')
</head>
<body class="leading-snug">
<div
    x-data="theme('{{ $theme }}', '{{ $initialMode }}')"
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

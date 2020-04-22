<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>
        <meta name="google" value="notranslate">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@1.3.4/dist/tailwind.css">
        <livewire:styles />

        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <livewire:scripts />
    </head>
    <body>
        <div id="dashboard" x-data="theme('{{ $theme }}', '{{ $initialMode }}')" x-init="init">
            <div
                class="fixed inset-0 w-screen h-screen grid gap-2 p-2"
                :class="darkMode ? 'bg-gray-900' : 'bg-gray-100'"
            >
                {{ $slot }}
            </div>
        </div>
        <script>
            const theme = (theme, initialMode) => ({
                theme,
                mode: initialMode,

                get darkMode() {
                    return this.mode === 'dark';
                },

                init() {
                    if (this.theme === 'device') {
                        this.detectDeviceColorScheme();

                        return;
                    }

                    if (this.theme === 'auto') {
                        this.pollForThemeChange();

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

                pollForThemeChange() {
                    //
                },
            });
        </script>
    </body>
</html>

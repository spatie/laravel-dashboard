<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>
        <meta name="google" value="notranslate">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        {{ $assets }}

        <livewire:styles />
    </head>
    <body>
        <div
            x-data="theme('{{ $theme }}', '{{ $initialMode }}')"
            x-init="init"
            :class="mode === 'dark' ? 'dark-mode' : ''"
        >
            <div class="fixed inset-0 w-screen h-screen grid gap-2 p-2 bg-canvas">
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
        <livewire:scripts />
    </body>
</html>

const defaultConfig = require("tailwindcss/defaultConfig");

module.exports = {
    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultConfig.theme.fontFamily.sans],
            },
            colors: {
                default: "var(--color-default)",
                invers: "var(--color-invers)",
                dimmed: "var(--color-dimmed)",
                accent: "var(--color-accent)",
                canvas: "var(--color-canvas)",
                tile: "var(--color-tile)",
                warn: "var(--color-warn)",
                error: "var(--color-error)",
            },
        },
    },
    variants: {},
    plugins: [],
};

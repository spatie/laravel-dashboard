const defaultConfig = require("tailwindcss/defaultConfig");

const gridTemplates = {
    "1-1": "1fr 1fr",
    "1-auto": "1fr auto",
    "1-auto-1": "1fr auto 1fr",
    "1-auto-auto": "1fr auto auto",
    "auto-1": "auto 1fr",
    "auto-1-1": "auto 1fr 1fr",
    "auto-1-auto": "auto 1fr auto",
    "auto-auto": "auto auto",
};

module.exports = {
    theme: {
        extend: {
            colors: {
                default: "var(--color-default)",
                invers: "var(--color-invers)",
                dimmed: "var(--color-dimmed)",
                accent: "var(--color-accent)",
                canvas: "var(--color-canvas)",
                tile: "var(--color-tile)",
                warning: "var(--color-warning)",
                error: "var(--color-error)",
                success: "var(--color-success)",
            },
            borderColor: (theme) => ({
                default: theme("colors.canvas", "currentColor"),
            }),
            gridTemplateColumns: gridTemplates,
            gridTemplateRows: gridTemplates,
            fontFamily: {
                sans: ["Inter", ...defaultConfig.theme.fontFamily.sans],
            },
        },
    },
    variants: {},
    plugins: [],
};

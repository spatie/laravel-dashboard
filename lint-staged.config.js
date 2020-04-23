module.exports = {
    "resources/**/*.css": () => [
        "yarn format",
        "yarn build",
        "git add resources/dist",
    ],
};

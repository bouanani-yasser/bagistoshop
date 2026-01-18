/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/Resources/**/*.blade.php", "./src/Resources/**/*.js"],

    theme: {
        container: {
            center: true,

            screens: {
                "2xl": "1920px",
            },

            padding: {
                DEFAULT: "16px",
            },
        },

        screens: {
            sm: "525px",
            md: "768px",
            lg: "1024px",
            xl: "1240px",
            "2xl": "1920px",
        },

        extend: {
            colors: {
                /* A.B DENTAIRE Brand Colors */
                brandNavy: "#0c1a2e" /* Primary dark navy */,
                brandBlue: "#2563eb" /* Accent blue - buttons, links */,
                brandBlueHover: "#1d4ed8" /* Darker blue for hover states */,
                brandBlueLighter: "#3b82f6" /* Lighter blue for accents */,
                brandWhite: "#ffffff" /* White text/elements */,
                brandGray: "#94a3b8" /* Muted text */,
                brandGrayLight: "#f1f5f9" /* Light backgrounds */,
                /* Legacy colors */
                darkGreen: "#40994A",
                darkBlue: "#2563eb" /* Updated to brand blue */,
                darkPink: "#F85156",
            },

            fontFamily: {
                inter: ["Inter"],
                icon: ["icomoon"],
            },
        },
    },

    darkMode: "class",

    plugins: [],

    safelist: [
        {
            pattern: /icon-/,
        },
    ],
};

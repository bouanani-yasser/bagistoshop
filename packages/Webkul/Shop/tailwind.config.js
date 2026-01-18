/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/Resources/**/*.blade.php", "./src/Resources/**/*.js"],

    theme: {
        container: {
            center: true,

            screens: {
                "2xl": "1440px",
            },

            padding: {
                DEFAULT: "90px",
            },
        },

        screens: {
            sm: "525px",
            md: "768px",
            lg: "1024px",
            xl: "1240px",
            "2xl": "1440px",
            1180: "1180px",
            1060: "1060px",
            991: "991px",
            868: "868px",
        },

        extend: {
            colors: {
                /* A.B DENTAIRE Brand Colors */
                navyBlue: "#0c1a2e" /* Primary dark navy - background */,
                brandNavy: "#0c1a2e" /* Primary dark navy */,
                brandBlue: "#2563eb" /* Accent blue - buttons, links */,
                brandBlueHover: "#1d4ed8" /* Darker blue for hover states */,
                brandBlueLighter: "#3b82f6" /* Lighter blue for accents */,
                brandWhite: "#ffffff" /* White text/elements */,
                brandGray: "#94a3b8" /* Muted text */,
                brandGrayLight: "#f1f5f9" /* Light backgrounds */,
                /* Legacy colors (can be removed if not used) */
                lightOrange: "#F6F2EB",
                darkGreen: "#40994A",
                darkBlue: "#2563eb" /* Updated to brand blue */,
                darkPink: "#F85156",
            },

            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
                dmserif: ["DM Serif Display", "serif"],
            },
        },
    },

    plugins: [],

    safelist: [
        {
            pattern: /icon-/,
        },
    ],
};

import flowbite from "flowbite/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                "blue-gray": {
                    50: "#f8fafc",
                    100: "#f1f5f9",
                    200: "#e2e8f0",
                    300: "#cbd5e1",
                    400: "#94a3b8",
                    500: "#64748b",
                    600: "#475569",
                    700: "#334155",
                    800: "#1e293b",
                    900: "#0f172a",
                    950: "#020617",
                },
                dark: {
                    bg: "#080a0f",
                    container: "#0d1017",
                    hover: "#10141d",
                    border: "#1a1f2e",
                    text: {
                        primary: "#e4e4e7",
                        secondary: "#a1a1aa",
                        muted: "#71717a",
                    },
                },
            },
            fontFamily: {
                sans: ["Space Grotesk", "system-ui", "sans-serif"],
            },
        },
    },
    plugins: [flowbite],
};

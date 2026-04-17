/** @type {import('tailwindcss').Config} */
export default {
    content: ["./resources/views/**/*.blade.php", "./resources/js/**/*.js"],
    theme: {
        extend: {
            colors: {
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
    plugins: [],
};

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: false,
        }),
        tailwindcss(),
    ],
    server: {
        hmr: false, // This kills the Hot Module Replacement connection entirely
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});

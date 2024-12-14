import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import * as path from "node:path";

export default defineConfig({
    plugins: [vue()],
    build: {
        emptyOutDir: true,
        outDir: path.resolve(__dirname, "../../public/app/admin"),
        minify: true,
        rollupOptions: {
            input: {
                admin: path.resolve(__dirname, "src/index.ts"),
            },
            output: {
                entryFileNames: "admin.js",
                assetFileNames: "admin.css",
            },
        },
    },
});

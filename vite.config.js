import {defineConfig} from "vite";
import compress from "rollup-plugin-brotli";
import dotenv from "dotenv";


dotenv.config();

export default defineConfig({
    plugins: process.env.MODE === "DEV" ? [compress()] : [],
    css: {
        devSourcemap: process.env.MODE !== "PROD",
    },
    build: {
        sourcemap: process.env.NODE_ENV !== "PROD",
        cssCodeSplit: false,
        emptyOutDir: false,
        rollupOptions: {
            input: {
                main: "./public/js/main.js",
            },
            output: {
                dir: "./public/dist",
                entryFileNames: "js/index.js",
                assetFileNames: "[ext]/[name].[ext]",
            }
        }
    }
});
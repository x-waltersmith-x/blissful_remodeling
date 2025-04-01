import { defineConfig } from 'vite';
import path from 'path';
import viteImagemin from 'vite-plugin-imagemin';
import postcssPresetEnv from 'postcss-preset-env';
import fs from 'fs';

const isProduction = process.env.NODE_ENV === 'production';

// Dynamically collect all SCSS and JS files
const scssFiles = fs.readdirSync(path.resolve(__dirname, 'src/scss')).filter(file => file.endsWith('.scss'));
const jsFiles = fs.readdirSync(path.resolve(__dirname, 'src/js')).filter(file => file.endsWith('.js') && !file.includes('theme')); // Explicitly exclude theme.js

export default defineConfig({
  root: path.resolve(__dirname, 'src'),
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
  },
  css: {
    postcss: {
      plugins: [postcssPresetEnv()],
    },
    preprocessorOptions: {
      scss: {
        includePaths: [path.resolve(__dirname, 'src/scss')],
      }
    }
  },
  build: {
    outDir: path.resolve(__dirname, 'dist'),
    sourcemap: !isProduction,
    cssCodeSplit: false, // Disable CSS chunking
    minify: isProduction ? 'esbuild' : false,
    rollupOptions: {
      input: {
        ...Object.fromEntries([
          ...jsFiles.map(file => [file.replace(/\.js$/, ''), path.resolve(__dirname, `src/js/${file}`)]),
          ...scssFiles.map(file => [file.replace(/\.scss$/, ''), path.resolve(__dirname, `src/scss/${file}`)]),
        ]),
      },
      output: {
        // Direct JS files to dist/js/
        entryFileNames: 'js/[name].min.js', // Output JS files to dist/js/
        assetFileNames: 'css/[name].min.css', // Output CSS files to dist/css/
        chunkFileNames: '[name].min.js', // Output chunked JS files to dist/js/
      },
    }
  },
  plugins: [
    viteImagemin({
      webp: { quality: 80 },
      gifsicle: {},
      optipng: {},
      mozjpeg: {},
    }),
    {
      name: 'compile-scss',
      buildStart() {
        scssFiles.forEach(file => {
          this.emitFile({
            type: 'asset',
            fileName: `css/${file.replace(/\.scss$/, '.min.css')}`, // Direct SCSS to dist/css/
            source: fs.readFileSync(path.resolve(__dirname, `src/scss/${file}`), 'utf-8')
          });
        });
      }
    }
  ]
});
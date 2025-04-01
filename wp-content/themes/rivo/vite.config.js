import { defineConfig } from 'vite';
import path from 'path';
import viteImagemin from 'vite-plugin-imagemin';
import postcssPresetEnv from 'postcss-preset-env';
import fs from 'fs';

const isProduction = process.env.NODE_ENV === 'production';
const distDir = path.resolve(__dirname, 'dist');

// Function to clean dist folder
function cleanDist() {
  if (fs.existsSync(distDir)) {
    fs.readdirSync(distDir).forEach(file => {
      if (file.endsWith('.css') || file.endsWith('.js')) {
        fs.unlinkSync(path.join(distDir, file));
      }
    });
  }
}

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
    outDir: distDir,
    sourcemap: !isProduction,
    cssCodeSplit: false, // Disable CSS chunking
    minify: isProduction ? 'esbuild' : false,
    rollupOptions: {
      input: {
        ...Object.fromEntries([
          ...jsFiles.map(file => [file.replace(/\.js$/, ''), path.resolve(__dirname, `src/js/${file}`)])
        ]),
      },
      output: {
        manualChunks: undefined, // Disable JS chunking
        entryFileNames: '[name].min.js',
        assetFileNames: '[name].min.[ext]',
        chunkFileNames: '[name].min.js'
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
        cleanDist(); // Clear dist folder before build
        scssFiles.forEach(file => {
          this.emitFile({
            type: 'asset',
            fileName: `${file.replace(/\.scss$/, '.min.css')}`,
            source: fs.readFileSync(path.resolve(__dirname, `src/scss/${file}`), 'utf-8')
          });
        });
      }
    }
  ]
});
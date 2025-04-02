import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs';
import sass from 'sass';
import { rmSync } from 'fs';
import postcssPresetEnv from 'postcss-preset-env';

const isProduction = process.env.NODE_ENV === 'production';

// Clean dist folders
const cleanDist = () => {
  const distFolders = ['dist/css', 'dist/js', 'dist/media'];
  distFolders.forEach(folder => {
    const fullPath = path.resolve(__dirname, folder);
    if (fs.existsSync(fullPath)) {
      fs.readdirSync(fullPath).forEach(file => rmSync(path.resolve(fullPath, file)));
    }
  });
};

// Handle SCSS, JS, and media files
const scssFiles = fs.readdirSync(path.resolve(__dirname, 'src/scss')).filter(file => file.endsWith('.scss') && !file.startsWith('_'));
const jsFiles = fs.readdirSync(path.resolve(__dirname, 'src/js')).filter(file => file.endsWith('.js'));
const mediaFiles = fs.readdirSync(path.resolve(__dirname, 'src/media')).filter(file => !file.endsWith('.svg'));

// SVG files handling
const svgFiles = fs.readdirSync(path.resolve(__dirname, 'src/media')).filter(file => file.endsWith('.svg'));

export default defineConfig({
  root: path.resolve(__dirname, 'src'),
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
  },
  css: {
    postcss: { plugins: [postcssPresetEnv()] },
    preprocessorOptions: {
      scss: { includePaths: [path.resolve(__dirname, 'src/scss')] }
    }
  },
  build: {
    outDir: path.resolve(__dirname, 'dist'),
    sourcemap: true,
    cssCodeSplit: false,
    minify: isProduction ? 'esbuild' : false,
    rollupOptions: {
      input: {
        ...Object.fromEntries(jsFiles.map(file => [file.replace(/\.js$/, ''), path.resolve(__dirname, `src/js/${file}`)])),
      },
      output: {
        entryFileNames: 'js/[name].min.js',
        assetFileNames: ({ name }) => name.includes('.css') ? 'css/[name].min.css' : 'media/[name].[ext]',
        chunkFileNames: 'js/[name].min.js',
      }
    },
  },
  plugins: [
    {
      name: 'compile-scss',
      buildStart() {
        cleanDist();

        // Process SCSS files and generate CSS
        scssFiles.forEach(file => {
          const result = sass.renderSync({
            file: path.resolve(__dirname, `src/scss/${file}`),
            outputStyle: isProduction ? 'compressed' : 'expanded',
          });

          let cssContent = result.css.toString();

          // Replace image paths in SCSS to point to dist/media and change to .webp
          mediaFiles.forEach(img => {
            const webpImg = img.replace(/\.(png|jpg|jpeg)$/, '.webp');

            // Ensure that the correct path to the dist/media folder is set in the final CSS
            cssContent = cssContent.replace(
              new RegExp(`url\\((['"]?)(\\.\\.\\/media\\/${img})(['"]?)\\)`, 'g'),
              (match, quoteStart, imgPath, quoteEnd) => {
                return `url(${quoteStart}../media/${webpImg}${quoteEnd})`;
              }
            );
          });

          // Emit compiled CSS with the new image paths
          this.emitFile({
            type: 'asset',
            fileName: `css/${file.replace(/\.scss$/, '.min.css')}`,
            source: cssContent,
          });
        });
      }
    },
    {
      name: 'imagemin-and-path-rewrite',
      generateBundle() {
        // Handle raster images (convert to .webp and emit to dist/media)
        mediaFiles.forEach(file => {
          const targetPath = file.endsWith('.svg') ? file : file.replace(/\.(png|jpg|jpeg)$/, '.webp');
          this.emitFile({
            type: 'asset',
            fileName: `media/${targetPath}`,
            source: fs.readFileSync(path.resolve(__dirname, `src/media/${file}`)),
          });
        });

        // Handle SVG files (copy them directly to dist/media)
        svgFiles.forEach(file => {
          this.emitFile({
            type: 'asset',
            fileName: `media/${file}`,
            source: fs.readFileSync(path.resolve(__dirname, `src/media/${file}`)),
          });
        });
      }
    }
  ]
});
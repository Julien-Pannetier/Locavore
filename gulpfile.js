"use strict";

// Load plugins
const autoprefixer = require("gulp-autoprefixer");
const browsersync = require("browser-sync").create();
const cleanCSS = require("gulp-clean-css");
const del = require("del");
const gulp = require("gulp");
const merge = require("merge-stream");
const plumber = require("gulp-plumber");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
//const uglify = require("gulp-uglify");
//const terserPlugin = require('terser-webpack-plugin');

/* new terserPlugin({
  parallel: true,
  terserOptions: {
    ecma: 6,
  },
}), */
 
/* module.exports = {
  optimization: {
    minimize: true,
    minimizer: [new TerserPlugin()],
  },
}; */
//const connect = require('gulp-connect-php');

// BrowserSync
function browserSync(done) {
  browsersync.init({
    server: {
      baseDir: "./dist"
    },
    port: 3000
  });
  done();
}

// BrowserSync reload
function browserSyncReload(done) {
  browsersync.reload();
  done();
}

// Clean vendor
function clean() {
  return del(["./dist"]);
}

// Bring third party dependencies from node_modules into vendor directory
function modules() {
  // Bootstrap
  var bootstrap = gulp.src('./node_modules/bootstrap/dist/**/*')
    .pipe(gulp.dest('./dist/vendor/bootstrap'));
  // Font Awesome CSS
  var fontAwesomeCSS = gulp.src('./node_modules/@fortawesome/fontawesome-free/css/**/*')
    .pipe(gulp.dest('./dist/vendor/fontawesome-free/css'));
  // Font Awesome Webfonts
  var fontAwesomeWebfonts = gulp.src('./node_modules/@fortawesome/fontawesome-free/webfonts/**/*')
    .pipe(gulp.dest('./dist/vendor/fontawesome-free/webfonts'));
  // jQuery
  var jquery = gulp.src([
      './node_modules/jquery/dist/*',
      '!./node_modules/jquery/dist/core.js'
    ])
    .pipe(gulp.dest('./dist/vendor/jquery'));
  return merge(bootstrap, fontAwesomeCSS, fontAwesomeWebfonts, jquery);
}

// CSS task
function css() {
  return gulp
    .src("app/scss/**/*.scss")
    .pipe(plumber())
    .pipe(sass({
      outputStyle: "expanded",
      includePaths: "./node_modules",
    }))
    .on("error", sass.logError)
    .pipe(autoprefixer({
      cascade: false
    }))
    .pipe(gulp.dest("./dist/css"))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest("./dist/css"))
    .pipe(browsersync.stream());
}

// JS task
function js() {
  return gulp
    .src([
      './app/js/*.js',
      '!./app/js/*.min.js',
      '!./app/js/contact_me.js',
      '!./app/js/jqBootstrapValidation.js'
    ])
/*     .pipe(terserPlugin())
    .pipe(rename({
      suffix: '.min'
    })) */
    .pipe(gulp.dest('./dist/js'))
    .pipe(browsersync.stream());
}

// Assets task
function assets() {
  return gulp
    .src("app/assets/**/*")
    .pipe(gulp.dest("./dist/assets"))
    .pipe(browsersync.stream());
}

//HTML task
function html() {
  return gulp
    .src("./app/**/*.html")
    .pipe(gulp.dest("./dist/"))
    .pipe(browsersync.stream());
}

// Watch files
function watchFiles() {
  gulp.watch("./app/scss/**/*", css);
  gulp.watch(["./app/js/**/*", "!./js/**/*.min.js"], js);
  gulp.watch("./app/assets/**/*", assets);
  gulp.watch("./app/**/*.html", html);
}

// Define complex tasks
const vendor = gulp.series(clean, modules);
const build = gulp.series(vendor, gulp.parallel(css, js, assets, html));
const watch = gulp.series(build, gulp.parallel(watchFiles, browserSync));

// Export tasks
exports.css = css;
exports.js = js;
exports.clean = clean;
exports.vendor = vendor;
exports.build = build;
exports.watch = watch;
exports.default = build;

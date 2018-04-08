/**
 * API Boilerplate Gulp File
 *
 * @package    api_boilerplate
 * @link       https://github.com/SeanBlakeley/WordPress-API-Plugin-Boilerplate
 * @since      0.1.0
 * @author     Sean Blakeley <sean@seanblakeley.co.uk>
 *
 */

// Load API Boilerplate Gulp Dependancies
const gulp          = require('gulp')
const sass          = require('gulp-ruby-sass')
const autoprefixer  = require('gulp-autoprefixer')
const csslint       = require('gulp-csslint')
const sourcemaps    = require('gulp-sourcemaps')
const cleanCSS      = require('gulp-clean-css')
const jslint        = require('gulp-jslint')
const uglify        = require('gulp-uglify')
const imagemin      = require('gulp-imagemin')
const rename        = require('gulp-rename')
const concat        = require('gulp-concat')
const cache         = require('gulp-cache')
const livereload    = require('gulp-livereload')
const notify        = require('gulp-notify')
const injectVersion = require('gulp-inject-version')

// Process API Boilerplate Public Sass Files
gulp.task('sass', function () {
  return sass('public/assets/sass/api-boilerplate.scss', { style: 'expanded', sourcemap: true })
  .pipe(autoprefixer('last 3 versions'))
  .pipe(injectVersion())
  .pipe(csslint())
  .pipe(cleanCSS({compatibility: 'ie8'}))
  .pipe(rename({ suffix: '.min' }))
  .pipe(gulp.dest('public/dist/css'))
  .pipe(sourcemaps.write('../../assets/sass/maps', {
    includeContent: false,
    sourceRoot: 'source'
  }))
});

// Process API Boilerplate Public JavaScript Files
gulp.task('scripts', function () {
  return gulp.src([
    'public/assets/js/plugins/**/*.js',
    'public/assets/js/functions.js',
    'public/assets/js/onReady.js'
  ])
    .pipe(jslint())
		.pipe(concat('api-boilerplate.js'))
		.pipe(rename({ suffix: '.min' }))
		.pipe(uglify())
		.pipe(gulp.dest('public/dist/js'))
});

// Process API Boilerplate Admin Sass Files
gulp.task('admin-sass', function () {
  return sass('admin/assets/sass/api-boilerplate-admin.scss', { style: 'expanded', sourcemap: true })
  .pipe(autoprefixer('last 3 versions'))
  .pipe(injectVersion())
  .pipe(csslint())
  .pipe(cleanCSS({compatibility: 'ie8'}))
  .pipe(rename({ suffix: '.min' }))
  .pipe(gulp.dest('admin/dist/css'))
  .pipe(sourcemaps.write('../../assets/sass/maps', {
    includeContent: false,
    sourceRoot: 'source'
  }))
});

// Process API Boilerplate Admin JavaScript Files
gulp.task('admin-scripts', function () {
  return gulp.src([
    'admin/assets/js/plugins/**/*.js',
    'admin/assets/js/functions.js',
    'admin/assets/js/onReady.js'
  ])
    .pipe(jslint())
		.pipe(concat('api-boilerplate-admin.js'))
		.pipe(rename({ suffix: '.min' }))
		.pipe(uglify())
		.pipe(gulp.dest('admin/dist/js'))
    .pipe(notify({
      title: 'API Boilerplate',
      message: 'Styles & Scripts completed'
    }))
});

// Compress API Boilerplate Image Files
gulp.task('images', function () {
  return gulp.src('public/assets/images/**/**')
		.pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
		.pipe(gulp.dest('public/dist/images'))
})

// Compress API Boilerplate Admin Image Files
gulp.task('admin-images', function () {
  return gulp.src('admin/assets/images/**/**')
		.pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
		.pipe(gulp.dest('admin/dist/images'))
    .pipe(notify({
      title: 'API Boilerplate',
      message: 'Images Compressed'
    }))
})

// Set default task order
gulp.task('default', function () {
  gulp.start('sass', 'scripts', 'images', 'admin-sass', 'admin-scripts', 'admin-images', 'watch')
})

// Watch for changing files
gulp.task('watch', function () {
  // Watch Admin Sass files
  gulp.watch('admin/assets/sass/**/*.scss', ['admin-sass'])
  // Watch Public Sass files
  gulp.watch('public/assets/sass/**/*.scss', ['sass'])
  // Watch Admin JS files
  gulp.watch('admin/assets/js/**/*.js', ['admin-scripts'])
  // Watch Public JS files
  gulp.watch('public/assets/js/**/*.js', ['scripts'])
  // Watch Admin Image files
  gulp.watch('admin/assets/images/**/*', ['admin-images'])
  // Watch Public Image files
  gulp.watch('admin/assets/images/**/*', ['images'])
})

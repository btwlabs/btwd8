// ////////////////////////////////////
// Required
// ////////////////////////////////////

// Main dependencies
var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var sass = require('gulp-dart-sass');
var sassGlob = require('gulp-sass-glob');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var cache = require('gulp-cache');

/**
 * @task sass
 * Compile files from scss
 */
gulp.task('sass', function () {
    return gulp
      .src('sass/main.scss')
      .pipe(sassGlob())
      .pipe(sourcemaps.init())
      .pipe(sass({includePaths: ['./node_modules/breakpoint-sass/stylesheets']}))
      .pipe(sass().on('error', sass.logError))
      .pipe(autoprefixer(['last 3 versions', '> 1%', 'ie 8'], { cascade: true }))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('css'))
      .pipe(browserSync.reload({stream:true}))
  }

);

/**
 * Launch the Server
 */
 gulp.task('browser-sync', gulp.series('sass', function() {
      browserSync.init({
      // Change as required, also remember to set in theme settings
      proxy: "https://flat-file-backend.lndo.site"
      //port: 8000
      });
    }
  )
 );


/**
 * @task reload
 * Refresh the page after clearing cache
 */
gulp.task('reload', gulp.series(
    function() {
      cache.clearAll();
    },
    function () {
      browserSync.reload();
    }
  )
);


/**
 * @task watch
 * Watch scss files for changes & recompile
 * Clear cache when Drupal related files are changed
 */
gulp.task('watch', function () {
    gulp.watch(['sass/*.scss', 'sass/**/*.scss'], gulp.series('sass'));
    //gulp.watch(['js/*.js'], gulp.series('scripts'));
    gulp.watch(['templates/*.html.twig', '**/*.yml'],  gulp.series('reload'));
  }
);


/**
 * Default task, running just `gulp` will
 * compile Sass files, launch BrowserSync, watch files.
 */

gulp.task('default', gulp.parallel('browser-sync', 'watch'));

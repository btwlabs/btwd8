var gulp = require('gulp');
var argv = require('yargs').argv;

var autoprefixer = require('gulp-autoprefixer');
var babel = require('gulp-babel');
var bs = require('browser-sync').create();
var imagemin = require('gulp-imagemin');
var pixrem = require('gulp-pixrem');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var sourcemaps = require('gulp-sourcemaps');
var svgmin = require('gulp-svgmin');
var uglify = require('gulp-uglify');

var paths = {
	sassSrc: 'sass/**/*.{scss,sass}',
	sassDest: 'css',
	jsSrc: 'js/source/*.js',
	jsDest: 'js/build',
	imgSrc: 'images/source/**/*.{png,jpg,gif}',
	imgDest: 'images/optimized',
	svgSrc: 'images/source/**/*.svg',
	svgDest: 'images/optimized'
}

var browserList = ['last 5 versions', '> 5%', 'Firefox ESR'];
 
gulp.task('sass', function () {
	return gulp.src(paths.sassSrc)
		.pipe(sourcemaps.init())
		.pipe(sassGlob())
		.pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
		// Need the next two lines as an intermediate write, otherwise autoprefizer doesnt cooperate with sourcemaps
		// https://github.com/ByScripts/gulp-sample/blob/master/gulpfile.js
		.pipe(sourcemaps.write({includeContent: false}))
    .pipe(sourcemaps.init({loadMaps: true}))
		.pipe(autoprefixer({browsers: browserList}))
		.pipe(pixrem())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(paths.sassDest))
		.pipe(bs.stream());
});

gulp.task('js', function() {
	return gulp.src(paths.jsSrc)
		.pipe(sourcemaps.init())
		.pipe(babel({
			presets: [
				['env', {
					targets: {
						browsers: browserList
					}
				}]
			]
		}))
		.pipe(uglify())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(paths.jsDest));
});

gulp.task('imagemin', function() {
	return gulp.src(paths.imgSrc)
		.pipe(imagemin())
		.pipe(gulp.dest(paths.imgDest));
});

gulp.task('svgmin', function() {
	return gulp.src(paths.svgSrc)
		.pipe(svgmin())
		.pipe(gulp.dest(paths.svgDest));
});

// Watch files for change and set Browser Sync
gulp.task('watch', function() {
	bs.init({
		files: [
			'css/**/*.css',
			'templates/**/*.twig',
			'images/optimized/**/*.{png,jpg,gif,svg}',
			'js/build/**/*.js',
			'*.theme'
		],
		proxy: argv.proxy
	});
	gulp.watch(paths.sassSrc, ['sass']);
	gulp.watch(paths.jsSrc, ['js']).on('change', bs.reload);
});
 
// Default task
gulp.task('default', ['sass', 'js', 'watch']);
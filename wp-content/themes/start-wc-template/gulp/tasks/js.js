var gulp = require('gulp');
var runSequence = require('gulp4-run-sequence');
var include = require('gulp-include');
var babel = require('gulp-babel');
var sourcemaps = require('gulp-sourcemaps');
var plumber = require('gulp-plumber');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var notify = require('gulp-notify');
var browserSync = require('browser-sync');
var reload = browserSync.reload;

var config = require('../config');

// Js Task

gulp.task('js', function() {
    return gulp
        .src([config.src.js + '/*.js', '!' + config.src.js + '/*.libs.js'])
        .pipe(
            plumber({
                errorHandler: config.errorHandler,
            })
        )
        .pipe(include())
        .pipe(sourcemaps.init())
        .pipe(babel())
        .pipe(rename({ suffix: '.min', prefix: '' }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(config.dest.js + '/'))
        .pipe(reload({ stream: true }));
});

gulp.task('js:libs', function() {
    return gulp
        .src(config.src.js + '/*libs.js')
        .pipe(include())
        .on('error', function() {
            notify('Javascript include error');
        })
        .pipe(rename({ suffix: '.min', prefix: '' }))
        .pipe(uglify())
        .pipe(gulp.dest(config.dest.js + '/'))
        .pipe(reload({ stream: true }));
});

gulp.task('js:all', function(js) {
    runSequence('js:libs', 'js', js);
});

gulp.task('js:watch', function() {
    gulp.watch(
        [
            config.src.js + '/**/*.js',
            '!' + config.src.js + '/libs.js',
            '!' + config.src.js + '/_lib',
            '!' + config.src.js + '/assets',
            '!' + config.dest.js + '/main.js',
        ],
        gulp.series('js')
    );
    gulp.watch([config.src.js + '/*libs.js'], gulp.series('js:libs'));
});

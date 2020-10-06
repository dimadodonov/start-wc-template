var gulp = require('gulp');
var postcss = require('gulp-postcss');
var sass = require('gulp-sass');
var cached = require('gulp-cached');
var rename = require('gulp-rename');
var autoprefixer = require('autoprefixer');
var mqpacker = require('css-mqpacker');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync');
var cssnano = require('cssnano');
var path = require('path');
var stream = browserSync.stream;

var config = require('../config');

var plugins = [
    autoprefixer({ overrideBrowserslist: ['last 10 version'] }),
    mqpacker({
        sort: sortMediaQueries,
    }),
    cssnano()
];

// Sass Task
gulp.task('sass', function () {
    return gulp
        .src(config.src.sass + '/**/*.{sass,scss}')

        .pipe(sourcemaps.init())
        .pipe(
            sass({
                // nested, expanded, compact, compressed
                outputStyle: config.production ? 'compressed' : 'expanded',
                precision: 5,
            })
        )
        .on('error', config.errorHandler)
        .pipe(cached('styles'))
        .pipe(postcss(plugins))
        .pipe(rename({ suffix: '.min', prefix: '' }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(config.dest.css))
        .pipe(stream());
});

gulp.task('sass:watch', function () {
    gulp.watch(config.src.sass + '/**/*.{sass,scss}', gulp.series('sass')).on(
        'unlink',
        function (filepath) {
            delete cached.caches.styles[path.resolve(filepath)];
        }
    );
});

function isMax(mq) {
    return /max-width/.test(mq);
}

function isMin(mq) {
    return /min-width/.test(mq);
}

function sortMediaQueries(a, b) {
    A = a.replace(/\D/g, '');
    B = b.replace(/\D/g, '');

    if (isMax(a) && isMax(b)) {
        return B - A;
    } else if (isMin(a) && isMin(b)) {
        return A - B;
    } else if (isMax(a) && isMin(b)) {
        return 1;
    } else if (isMin(a) && isMax(b)) {
        return -1;
    }

    return 1;
}

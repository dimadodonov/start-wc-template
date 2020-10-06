var gulp = require('gulp');
var runSequence = require('gulp4-run-sequence');
var config = require('../config');

function build(cb) {
    runSequence(
        // 'clean',
        // 'clean:temp',
        // 'sprite:svg:build',
        // 'svgo',
        // 'sass',
        // 'js:all',
        // 'copy',
        // 'copy:watch',
        cb
    );
}

function buildDev(cb) {
    runSequence(
        'clean',
        // 'clean:temp',
        'sprite:svg:build',
        'svgo',
        'sass',
        'js:all',
        'copy',
        // 'copy:watch',
        cb
    );
}

gulp.task('build', function(cb) {
    config.setEnv('production');
    config.logEnv();
    build(cb);
});

gulp.task('build:dev', function(cb) {
    config.setEnv('development');
    config.logEnv();
    buildDev(cb);
});

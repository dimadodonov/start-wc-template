var gulp = require('gulp');
var runSequence = require('gulp4-run-sequence');
var config = require('../config');

gulp.task('watch', function() {
    runSequence(
        'copy:watch',
        'sprite:svg:watch',
        // 'sprite:png:watch',
        'svgo:watch',
        'sass:watch',
        'js:watch'
    );
});

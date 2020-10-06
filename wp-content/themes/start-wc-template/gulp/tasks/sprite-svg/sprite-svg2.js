var config = require('../../config');
var gulp = require('gulp');
var plumber = require('gulp-plumber');
var cheerio = require('gulp-cheerio');
var svgSprite = require('gulp-svg-sprite');
var replace = require('gulp-replace');
var concat = require('gulp-concat');
var inject = require('gulp-inject-string');
var svgmin = require('gulp-svgmin');
var changed = require('gulp-changed');
var runSequence = require('gulp4-run-sequence');

//Sprite SVG
gulp.task('sprite:svg', function () {
    return (
        gulp
            .src(config.src.iconsSvg + '/*.svg')
            .pipe(
                plumber({
                    errorHandler: config.errorHandler,
                })
            )
            // .pipe(changed(config.dest.iconsSvg + '/'))
            //.pipe(svgmin())
            // remove all fill, style and stroke declarations in out shapes
            // .pipe(cheerio({
            //     run: function ($) {
            //         $('[opacity]').removeAttr('opacity');
            //         $('[fill]').removeAttr('fill');
            //         $('[stroke]').removeAttr('stroke');
            //         $('[style]').removeAttr('style');
            //     },
            //     parserOptions: { xmlMode: true }
            // }))
            .pipe(replace('&gt;', '>'))
            .pipe(
                svgmin({
                    js2svg: {
                        pretty: true,
                    },
                    plugins: [
                        {
                            removeDesc: true,
                        },
                        {
                            cleanupIDs: true,
                        },
                        {
                            mergePaths: false,
                        },
                    ],
                })
            )
            .pipe(
                svgSprite({
                    mode: {
                        symbol: {
                            dest: config.src.none,
                            sprite: 'sprite.svg',
                            example: {
                                dest: 'symbols.html',
                            },
                        },
                    },
                })
            )
            .pipe(gulp.dest(config.src.files + '/'))
    );
});

/*  Переводим полученный SVG спрайт в строку,
 Чтобы иметь возможность подключить его прямо из документа
 ------------------------------------ */
gulp.task('svg2string', function () {
    return (
        gulp.src(config.src.files + '/sprite.svg')
        // Меняем формат в .js
        .pipe(concat('svg-sprite.js'))
        // Удаляем все переносы строк
        .pipe(replace('\n', ''))
        // Оборачиваем в переменную, которую потом запросим из HTML документа
        .pipe(inject.wrap("var SVG_SPRITE = ['", "'];"))
        // Перемещаем в общую директорию для .js файлов
        .pipe(gulp.dest(config.src.js + '/_lib'))
    );
});

/*  Объединяем задачи в последовательность
 ------------------------------------ */
gulp.task('sprite:svg:build', function (cb) {
    runSequence(
        'sprite:svg', 
        'svg2string',
        cb
        );
});

gulp.task('sprite:svg:watch', function () {
    gulp.watch(config.src.iconsSvg + '/*.svg', gulp.series('sprite:svg:build'));
});
var util = require('gulp-util');

var production = util.env.production || util.env.prod || false;
var destPath = 'assets';

var config = {
    env: 'development',
    production: production,

    src: {
        none: '',
        root: 'src',

        sass: 'src/sass',
        js: 'src/js',

        images: 'src/images',
        files: 'src/files',
        img: 'src/files/img',
        iconsPng: 'src/files/icons/png',
        iconsSvg: 'src/files/icons/svg',
        iconsFont: 'src/files/img/icons',
        fonts: 'src/files/fonts',

        libs: 'src/libs',
    },
    dest: {
        root: destPath,
        css: destPath + '/css',
        js: destPath + '/js',

        files: destPath + '/files',
        img: destPath + '/files/img',
        images: destPath + '/images',
        iconsSvg: destPath + '/files/icons/svg',
        iconsPng: destPath + '/files/icons/png',
        sprite: destPath + '/files/sprite',
        fonts: destPath + '/files/fonts',

        libs: destPath + '/libs',
    },
    php: './**/*.php',

    setEnv: function(env) {
        if (typeof env !== 'string') return;
        this.env = env;
        this.production = env === 'production';
        process.env.NODE_ENV = env;
    },

    logEnv: function() {
        util.log(
            'Environment:',
            util.colors.white.bgRed(' ' + process.env.NODE_ENV + ' ')
        );
    },

    errorHandler: require('./util/handle-errors'),
};

config.setEnv(production ? 'production' : 'development');

module.exports = config;

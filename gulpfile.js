'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    cleanCSS = require('gulp-clean-css'),
    autoprefixer = require('gulp-autoprefixer'),
    concat = require('gulp-concat'),
    plumber = require('gulp-plumber'),
    notify = require('gulp-notify'),
    uglify = require('gulp-uglify'),
    livereload = require('gulp-livereload'),
    util = require('gulp-util');

var app = {};

var config = {
    nodeModules: 'node_modules',
    assetsDir: 'assets',
    themeDir: 'web/app/themes/timber',
    scssPattern: 'scss/**/*.scss',
    production: !!util.env.production
};

app.addStyle = function (paths, outputFilename) {
    gulp.src(paths)
        .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
        .pipe(!config.production ? sourcemaps.init() : util.noop())
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(concat(outputFilename))
        .pipe(config.production ? cleanCSS() : util.noop())
        .pipe(!config.production ? sourcemaps.write('.') : util.noop())
        .pipe(gulp.dest(config.themeDir + '/assets/css'))
        .pipe(notify('Styles done.'))
        .pipe(livereload())
    ;
};

app.addScript = function (paths, outputFilename) {
    gulp.src(paths)
        .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
        .pipe(!config.production ? sourcemaps.init() : util.noop())
        .pipe(concat(outputFilename))
        .pipe(config.production ? uglify() : util.noop())
        .pipe(!config.production ? sourcemaps.write('.') : util.noop())
        .pipe(gulp.dest(config.themeDir + '/assets/js'))
        .pipe(notify('Scripts done.'))
        .pipe(livereload())
    ;
};

app.copy = function (srcFiles, outputDir) {
    gulp.src(srcFiles)
        .pipe(gulp.dest(outputDir));
};

gulp.task('styles', function () {
    app.addStyle([
        config.nodeModules + '/font-awesome/css/font-awesome.css',
        config.nodeModules + '/animate.css/animate.css',
        config.assetsDir + '/' + config.scssPattern
    ], 'styles.css');
});

gulp.task('scripts', function () {
    app.addScript([
        config.nodeModules + '/jquery/dist/jquery.js'
    ], 'jquery.js');
    app.addScript([
        config.nodeModules + '/bootstrap-sass/assets/javascripts/bootstrap.js'
    ], 'bootstrap.js');
    app.addScript([
        config.assetsDir + '/js/site.js'
    ], 'site.js');
});

gulp.task('fonts', function () {
    app.copy(
        config.nodeModules + '/font-awesome/fonts/*',
        config.themeDir + '/assets/fonts'
    );
    app.copy(
        config.nodeModules + '/bootstrap-sass/assets/fonts/**/*',
        config.themeDir + '/assets/fonts'
    );
});

gulp.task('images', function () {
    app.copy(
        config.assetsDir + '/img/**/*',
        config.themeDir + '/assets/img'
    );
});

gulp.task('watch', function () {
    livereload.listen();
    gulp.watch(config.assetsDir + '/' + config.scssPattern, ['styles']);
    gulp.watch(config.assetsDir + '/js/**/*.js', ['scripts']);
});

gulp.task('default', ['styles', 'scripts', 'watch']);
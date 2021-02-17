'use strict';
let gulp = require('gulp'),
    watch = require('gulp-watch'),
    imagemin = require('gulp-imagemin'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),
    rename = require("gulp-rename"),
    pug = require('gulp-pug'),
    uglyfly = require('gulp-uglyfly');


let browserSync = require('browser-sync').create();

var folders = {
    src : "./src",
    dist : "./dist",
}

gulp.task('sass', function () {
    return gulp.src(folders.src + '/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            includePaths: ['node_modules/foundation-sites/scss','node_modules/normalize.css']
        }))
        .pipe(sass().on('error', sass.logError))
        // .pipe(cleanCSS())
        .pipe(rename('style.css'))
        .pipe(sourcemaps.write(folders.dist + '/map/'))
        .pipe(gulp.dest(folders.dist + '/css/'));
});

gulp.task('pug', function () {
    return gulp.src(folders.src + '/views/pages/*.pug')
        .pipe(pug({
            pretty : '\t'
        }))
        .pipe(gulp.dest('./'));
});

gulp.task('img', function() {
    return gulp.src([folders.src + "/img/*" , folders.src + "/img/*/*"])
        .pipe(imagemin())
        .pipe(gulp.dest(folders.dist + '/img'))
});

gulp.task('compressJs', function() {
    gulp.src(folders.src + "/js/*.js")
        .pipe(uglyfly())
        .pipe(gulp.dest(folders.dist + '/js'))
});
gulp.task('autoprefixer', () =>
    gulp.src(folders.dist + '/css/style.min.css')
        .pipe(autoprefixer({
            browsers: ['last 5 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(folders.dist + "/css/with_prefix"))
);

gulp.task('minify-css', () => {
    return gulp.src(folders.dist + '/css/style.css')
        .pipe(cleanCSS({debug: false}, (details) => {autoprefixer
            console.log(`${details.name}: ${details.stats.originalSize}`);
            console.log(`${details.name}: ${details.stats.minifiedSize}`);
        }))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename('style.min.css'))
        .pipe(gulp.dest(folders.dist + "/css"));
});

gulp.task('serve', function() {
    browserSync.init({
        server: {
            baseDir: './'
        }
    });
    gulp.watch(folders.src + "/sass/*/*", gulp.series('sass'));
    gulp.watch(folders.src + "/sass/*", gulp.series('sass'));
    gulp.watch([folders.src + "/img/*" , folders.src + "/img/*/*"], gulp.series('img'));
    gulp.watch([folders.src + "/views/*/*",folders.src + "/views/*"], gulp.series('pug'));
    gulp.watch(folders.src + "/js/*", gulp.series('compressJs'));
    gulp.watch(folders.src + "/css/*", gulp.series('minify-css'));


    gulp.watch(folders.dist + "/img/*").on('change', browserSync.reload);
    gulp.watch(folders.dist + "/css/*.css").on('change', browserSync.reload);
    gulp.watch("./*.html").on('change', browserSync.reload);
});

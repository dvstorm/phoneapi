const gulp = require('gulp');
const { watch, series } = gulp;
const livereload = require('gulp-livereload');
const less = require('gulp-less');

function processLess(cb) {
  gulp.src('webroot/less/style.less')
    .pipe(less())
    .pipe(gulp.dest('webroot/css'));
  cb();
}

function reload(cb) {
  gulp.src('Gulpfile.js')
    .pipe(livereload());
  cb();
}

exports.default = function() {
  livereload.listen();
  watch(['webroot/*.html', 'webroot/js/*.js'], reload);
  watch('webroot/less/*.less', series(processLess, reload));
};

'use strict';

const gulp = require('gulp');
const watch = require('gulp-watch');
const del = require('del');
const plumber = require('gulp-plumber');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const webpack = require('webpack');
const webpackStream = require('webpack-stream');
const webpackConfig = require('./webpack.config');
const runSequence = require('run-sequence');
const uglify = require('gulp-uglify');

const _config = {
  inputFileName: {
    js: 'import.js',
    css: 'import.scss',
  },
  outputFileName: {
    css: 'style.css',
    js: 'common.js',
  },
  path: {
    src: {
      css: './src/scss',
      js: './src/js',
    },
    public: './public',
    dist: './build',
    release: './release'
  },
  autoprefixer: {
    browsers: ['last 2 versions'],
    cascade: false
  },
  minify: {
    js: true,
    css: true,
  }
};

/* generate javascript files */
gulp.task('js', () => {
  return gulp.src(`${_config.path.src.js}/${_config.inputFileName.js}`)
    .pipe(plumber())
    .pipe(webpackStream(webpackConfig, webpack))
    .pipe(uglify({
      preserveComments: 'some'
    }))
    .pipe(rename(_config.outputFileName.js))
    .pipe(gulp.dest('assets/js'));
});

/* generate css files */
gulp.task('css', () => {
  return gulp
    .src(`${_config.path.src.css}/${_config.inputFileName.css}`)
    .pipe(plumber())
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(autoprefixer(_config.autoprefixer))
    .pipe(rename(_config.outputFileName.css))
    .pipe(gulp.dest('assets/css'));
});

/* serve */
gulp.task('serve', () => {
  watch([`${_config.path.src.js}/**/*.js`], () => {
    return gulp.start(['js']);
  });
  watch([`${_config.path.src.css}/**/*.scss`], () => {
    return gulp.start(['css']);
  });
});

/* default task */
gulp.task('default', ['js', 'css', 'serve']);

gulp.task('release:clean', () => {
  return del([
    _config.path.release
  ]);
});

gulp.task('release:fix', () => {
  return del([
    `${_config.path.release}/node_modules`,
    `${_config.path.release}/src`
  ]);
});

gulp.task('release:copy', () => {
  return gulp
    .src([
      './**',
      '!./.*',
      '!./gulpfile.js',
      '!./package.json',
      '!./package-lock.json',
      '!./README.md',
      '!./src/**',
      '!./node_modules/**',
      '!./webpack.config.js',
      '!./yarn.lock'
    ], {
      base: './'
    })
    .pipe(gulp.dest(_config.path.release));
});

/* build */
gulp.task('build', () => {
  runSequence(
    'release:clean',
    'release:copy',
    'release:fix'
  );
});

'use scrict';

const gulp = require('gulp');
const sourcemaps = require('gulp-sourcemaps');

const sass = require('gulp-ruby-sass');
const uglify = require('gulp-uglify');
const uglifyCSS = require('gulp-uglifycss');
const cleanCSS = require('gulp-clean-css');
const prefixer = require('gulp-autoprefixer');
const gulpImports = require('gulp-imports');
const del = require('del');
const browserSync = require("browser-sync");
const imagemin = require('gulp-imagemin');
const pug = require('gulp-pug');
const babel = require('gulp-babel');
const es2015 = require('babel-preset-es2015');

const reload = browserSync.reload;
const config = {
    server: {
        baseDir: "public"
    },
    host: 'localhost',
    port: 9000,
    logPrefix: "lestro"
};



const path = {
    build: { //build files
        html: 'public/',
        js: 'public/js/',
        css: 'public/css/',
        img: 'public/img/',
        fonts: 'public/css/fonts/'
    },
    src: { //assets/resources files
        html: 'resources/views/*.pug',
        css: 'resources/scss/*.scss',
        js: 'resources/js/*.js',
        img: 'resources/img/**/*.*', 
        fonts: 'resources/fonts/**/*.*'
    },
    watch: { //watch folder
        html: 'resources/views/**/*.pug',
        js: 'resources/js/**/*.js',
        css: 'resources/scss/**/*.scss',
        img: 'resources/img/**/*.*',
        fonts: 'resources/fonts/**/*.*'
    },
    clean: './public'
};

gulp.task('hello', () => console.log('Hello'));

/*=======
    convert scss to css
=============*/
gulp.task('css:build', () => {
	sass(path.src.css, {force: true, noCache: true})
    .pipe(sourcemaps.init()) //Инициализируем sourcemap
    .pipe(cleanCSS())
    .pipe(prefixer({
        browsers: ['last 6 versions']
    }))
    .pipe(uglifyCSS())
    .pipe(sourcemaps.write()) //Пропишем карты
    .pipe(gulp.dest(path.build.css))
    .pipe(reload({stream: true}));

});

/*=======
		convert pug(jade) templates
=============*/
gulp.task('views:build', () => {
    gulp.src(path.src.html)
    .pipe(pug({
        pretty: true
    }))
    .pipe(gulp.dest(path.build.html))
    .pipe(reload({stream: true}));
});

/*=======
    minimize images
=============*/
gulp.task('image:build', () => {
  gulp.src(path.src.img) //Выберем наши картинки
    .pipe(imagemin({ //Сожмем их
      progressive: true,
      svgoPlugins: [{removeViewBox: false}],
      //use: [pngquant()],
      interlaced: true
    }))
    .pipe(gulp.dest(path.build.img)) //И бросим в build
    .pipe(reload({stream: true}));
});

/*=======
    js build
=============*/
gulp.task('js:build', () => {
  gulp.src(path.src.js) //Найдем наш main файл
    .pipe(gulpImports())
    .pipe(sourcemaps.init()) //Инициализируем sourcemap
    .pipe(babel({
      presets: ['es2015']
    }))
    .pipe(uglify()) //Сожмем наш js
    .pipe(sourcemaps.write()) //Пропишем карты
    .pipe(gulp.dest(path.build.js)) //Выплюнем готовый файл в build
    .pipe(reload({stream: true})) //И перезагрузим сервер
})

/*=======
    fonts build
=============*/
gulp.task('fonts:build', () => {
  gulp.src(path.src.fonts)
    .pipe(gulp.dest(path.build.fonts))
})


/*=======
    clean
=============*/
gulp.task('clean', () => {
  del('public/css', 'public/js', 'public/img', 'public/*.html')
})

/*=======
    build
=============*/
gulp.task('build', [
  'views:build',
  'js:build',
  'css:build',
  'fonts:build',
  'image:build'
]);


/*=======
    watch
=============*/
gulp.task('watch', () => {
  gulp.watch([path.watch.html], ['views:build']);
  gulp.watch([path.watch.css], ['css:build']);
  gulp.watch([path.watch.js], ['js:build']);
  gulp.watch([path.watch.img], ['image:build']);
  gulp.watch([path.watch.fonts], ['fonts:build']);
})

/*=======
    webserver
=============*/
gulp.task('webserver', () => {
    browserSync(config)
})


/*=======
    gulp general task
=============*/
gulp.task('default', ['build', 'webserver', 'watch']);


/*=======
    !!!!!!!!!! use gulp command to launch all tasks
=============*/

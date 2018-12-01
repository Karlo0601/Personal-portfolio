// Include gulp
var gulp = require('gulp');
var gulpLoadPlugins = require('gulp-load-plugins');
var plugins = gulpLoadPlugins();
browserSync =  require('browser-sync').create();

// Include plugins
plugins.sass = require('gulp-sass');
plugins.sourcemaps = require('gulp-sourcemaps');
plugins.autoprefixer = require('gulp-autoprefixer');
plugins.runSequence = require('run-sequence');
plugins.revAll = require('gulp-rev-all');
plugins.cleanCSS = require('gulp-clean-css');
plugins.svgSprite = require('gulp-svg-sprite');
plugins.concat = require('gulp-concat');
plugins.minify = require('gulp-minify');
plugins.del = require('del');
plugins.merge = require('merge-stream');

/** DEV/DEFAULT TASK **/
gulp.task('default', ['scss', 'watch']);

/** BUILD TASK **/
gulp.task('build', function() {
	return plugins.runSequence('build-delete', 'build-scss', 'build-svg-sprite', 'build-js', 'revision');
});

// Paths
var paths = {

	theme: 'wp-content/themes/blackhat/',

	css: {
		src: 'wp-content/themes/blackhat/assets/css/*.css',
		dest: 'wp-content/themes/blackhat/assets/css/',
		build: 'wp-content/themes/blackhat/assets/build/'
	},

	scss: {
		src: 'wp-content/themes/blackhat/resources/scss/**/*',
		main: 'wp-content/themes/blackhat/resources/scss/style.scss'
	},

	js: {
		src: 'wp-content/themes/blackhat/resources/js/',
		dest: 'wp-content/themes/blackhat/assets/js/',
		main: 'wp-content/themes/blackhat/assets/js/blackhat-functions.min.js',
		build: 'wp-content/themes/blackhat/assets/build/',
		concat: [
            'wp-content/themes/blackhat/resources/js/blackhat-core.js',
            'wp-content/themes/blackhat/resources/js/functions.js',
			'wp-content/themes/blackhat/resources/js/svg4everybody.js'
        ],
		file: 'blackhat-functions.js'
	},

	svg: {
		src: 'wp-content/themes/blackhat/resources/svg-builder/**/*.svg',
		dest: 'wp-content/themes/blackhat/assets/images/'
	},

	build: 'wp-content/themes/blackhat/assets/build/'

};

// autoprefixer options
var autoprefixerOptions = {
	browsers: ['last 3 versions', '> 5%', 'Firefox ESR']
};

// minify JS options
var minifyJSOptions = {
    noSource: true,
	ext:{
		min:'.min.js'
	}
};

// Browsersync
var bsync = function (proxy) {
    if (proxy) {
        browserSync.init({
            proxy: proxy
        });
    }
    else {
        browserSync.init({
            server: {
                baseDir: './'
            },
            online: true
        });
    }
};

/**** DEV TASKS ****/

// Compile SCSS to CSS
gulp.task('scss', function() {
	gulp.src(paths.scss.main)
		.pipe(plugins.sourcemaps.init())
			.pipe(plugins.sass())
			.on('error',console.log.bind(console))
			.pipe(plugins.autoprefixer(autoprefixerOptions))
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest(paths.css.dest))
		.pipe(browserSync.reload({stream:true}));
});

// Watch Files For Changes
gulp.task('watch', function() {
    // with proxy
    bsync('http://portfolio.mydev');
	
	return gulp.watch(paths.scss.src, ['scss']);
});

/**** BUILD TASKS ****/

// delete build folder
gulp.task('build-delete', function () {
  return plugins.del([paths.build]);
});

// Compile SCSS to CSS and minify
gulp.task('build-scss', function() {
	//Optimized style.css file
	var stream1 = gulp.src(paths.scss.main)
		.pipe(plugins.sass())
		.on('error',console.log.bind(console))
		.pipe(plugins.autoprefixer(autoprefixerOptions))
		.pipe(plugins.cleanCSS({
			level: {
				1: {
					specialComments: false
				}
			}
		}))
		.pipe(gulp.dest(paths.css.dest));
	
	//Theme style.css
	var streblackhat = gulp.src(paths.scss.main)
		.pipe(plugins.sass())
		.on('error',console.log.bind(console))
		.pipe(plugins.autoprefixer(autoprefixerOptions))
		.pipe(gulp.dest(paths.theme));

	return plugins.merge(stream1, streblackhat);
});

// Concat Theme Core JS files and minify
gulp.task('build-js', function(){
    return gulp.src(paths.js.concat)
        .pipe(plugins.concat(paths.js.file))
        .pipe(plugins.minify(minifyJSOptions))
        .pipe(gulp.dest(paths.js.dest))
});

// Revision/Cache Buster
gulp.task('revision', function () {

	//Revision CSS
  	var stream1 = gulp.src(paths.css.src) // Find all .css files in this folder
		.pipe(plugins.revAll.revision())
		.pipe(gulp.dest(paths.css.build)); // Place hashed files in the build folder

	//Revision JS
  	var streblackhat = gulp.src(paths.js.main) // Find main .js file
		.pipe(plugins.revAll.revision())
		.pipe(gulp.dest(paths.js.build)); // Place hashed files in the build folder

	return plugins.merge(stream1, streblackhat);
 
});

//SVG Sprite Builder
var svgBuildOptions = {
    mode: {
        symbol: { // symbol mode to build the SVG
            dest: paths.svg.dest, // destination folder
            sprite: 'sprite.svg', //sprite name
            example: true // Build sample page
        }
    },
    svg: {
        xmlDeclaration: false, // strip out the XML attribute
        doctypeDeclaration: false // don't include the !DOCTYPE declaration
    }
};

// Build SVG Sprite
gulp.task('build-svg-sprite', function() {
    return gulp.src( paths.svg.src )
        .pipe(plugins.svgSprite(svgBuildOptions))
		.on('error',console.log.bind(console))
        .pipe(gulp.dest('.'));
});
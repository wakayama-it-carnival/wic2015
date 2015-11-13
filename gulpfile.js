'use strict';

var gulp = require( 'gulp' );
var replace = require( 'gulp-replace' );
var concat = require( 'gulp-concat' );
var uglify = require( 'gulp-uglify' );
var rename = require( 'gulp-rename' );
var minifyCss = require( 'gulp-minify-css' );
var download = require( 'gulp-download' );

gulp.task( 'download', function () {
	return download( [
			'https://raw.githubusercontent.com/mrdoob/three.js/master/examples/js/Detector.js',
			'https://raw.githubusercontent.com/mrdoob/three.js/master/examples/js/controls/DeviceOrientationControls.js',
		] )
		.pipe( gulp.dest( 'src' ) );
});

gulp.task( 'twentythirteen_style', function () {
	return gulp.src( [
			'../twentythirteen/style.css'
		] )
		.pipe( replace( '#f7f5e7', '#fafafa' ) )
		.pipe( replace( '#e8e5ce', '#333' ) )
		.pipe( replace( '#bc360a', '#337ab7' ) )
		.pipe( replace( '604px', '750px' ) )
		.pipe( replace( 'italic', 'normal' ) )
		.pipe( replace( 'images/search-icon.png', '../../twentythirteen/images/search-icon.png' ) )
		.pipe( rename( {
			basename: 'twentythirteen',
			extname: '.css'
		} ) )
		.pipe( gulp.dest( 'src' ) );
} );

gulp.task( 'npm', function () {
	return gulp.src( [
			'node_modules/three.js/build/three.js'
		] )
		.pipe( gulp.dest( 'src' ) );
} );

gulp.task( 'twitter_bootstrap', function () {
	return gulp.src( [
			'node_modules/bootstrap/dist/css/bootstrap.css'
		] )
		.pipe( gulp.dest( 'src' ) );
} );

gulp.task( 'css', [ 'twentythirteen_style', 'twitter_bootstrap' ], function () {
	return gulp.src( [
			'src/*.css'
		] )
		.pipe( minifyCss() )
		.pipe( rename( {
			extname: '.min.css'
		} ) )
		.pipe( gulp.dest( 'css' ) );
} );

gulp.task( 'uglify', [ 'download', 'npm' ], function(){
  return gulp.src( [
		  'src/*.js'
	  ] )
	  .pipe( uglify() )
	  .pipe( rename( {
		  extname: '.min.js'
	  } ) )
	  .pipe( gulp.dest( 'js' ) );
} );

gulp.task( 'default', [ 'uglify', 'css' ], function () {

} );

'use strict';

var gulp = require( 'gulp' );
var replace = require( 'gulp-replace' );
var concat = require( 'gulp-concat' );
var uglify = require( 'gulp-uglify' );
var rename = require( 'gulp-rename' );
var minifyCss = require( 'gulp-minify-css' );
var download = require( 'gulp-download' );
var decompress = require( 'gulp-decompress' );

gulp.task( 'download_twentythirteen', function () {
	return download( [
				'https://downloads.wordpress.org/theme/twentythirteen.1.6.zip',
		] )
		.pipe( decompress() )
		.pipe( gulp.dest( 'tmp' ) );
} );

gulp.task( 'twentythirteen_style', [ 'download_twentythirteen' ], function () {
	return gulp.src( [
			'tmp/twentythirteen/style.css'
		] )
		.pipe( decompress() )
		.pipe( replace( '#f7f5e7', '#fafafa' ) )
		.pipe( replace( '#e8e5ce', '#333' ) )
		.pipe( replace( '#bc360a', '#337ab7' ) )
		.pipe( replace( '#e6402a', '#7ccaff' ) )
		.pipe( replace( '#220e10', '#000000' ) )
		.pipe( replace( '#db572f', '#337ab7' ) )
		.pipe( replace( '604px', '750px' ) )
		.pipe( replace( 'italic', 'normal' ) )
		.pipe( replace( 'images/search-icon.png', '../../twentythirteen/images/search-icon.png' ) )
		.pipe( replace( 'images/search-icon-2x.png', '../../twentythirteen/images/search-icon-2x.png' ) )
		.pipe( replace( 'input', '__' ) )
		.pipe( replace( '.error404', '__' ) )
		.pipe( rename( {
			basename: 'twentythirteen',
			extname: '.css'
		} ) )
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

gulp.task( "genericons", function(){
	return gulp.src( [
			'node_modules/genericons/genericons/*',
		] )
		.pipe( gulp.dest( 'css' ) );
} );

gulp.task( 'default', [ 'css', 'genericons' ], function () {

} );

<?php

if ( ! isset( $content_width ) )
	$content_width = 750;

define( 'WIC2015_VERSION', '1.0.0' );

add_action( 'after_setup_theme', 'wic2015_a_after_setup_theme_01' );

function wic2015_a_after_setup_theme_01() {
	add_theme_support( 'custom-background' );
	// Disable custom header of the Twenty Thirteen
	remove_action( 'after_setup_theme', 'twentythirteen_custom_header_setup', 11 );
}

add_action( 'after_setup_theme', 'wic2015_after_setup_theme_02', 11 );

function wic2015_after_setup_theme_02() {
	set_post_thumbnail_size( 750, 270, true );
}

add_action( "wp_enqueue_scripts", 'wic2015_wp_enqueue_scripts_01', 11 );

function wic2015_wp_enqueue_scripts_01() {
	wp_dequeue_script( 'jquery-masonry' );
}

add_action( 'wp_enqueue_scripts', 'wic2015_wp_enqueue_scripts_02' );

function wic2015_wp_enqueue_scripts_02() {
	wp_enqueue_style(
		'twentythirteen-style',
		get_stylesheet_directory_uri() . '/css/twentythirteen.min.css',
		array(),
		WIC2015_VERSION
	);

	wp_enqueue_style(
		'bootstrap-style',
		get_stylesheet_directory_uri() . '/css/bootstrap.min.css',
		array( 'twentythirteen-style' ),
		WIC2015_VERSION
	);

	wp_enqueue_style(
		'bootstrap-style',
		get_stylesheet_directory_uri() . '/css/bootstrap.min.css',
		array(),
		WIC2015_VERSION
	);

	wp_enqueue_style(
		'genericons',
		get_stylesheet_directory_uri() . '/css/genericons.css',
		array(),
		WIC2015_VERSION
	);

	wp_enqueue_style(
		'wic2015-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'twentythirteen-style', 'bootstrap-style' ),
		WIC2015_VERSION
	);

	wp_enqueue_script(
		'wic2015-script',
		get_stylesheet_directory_uri() . '/js/wic2015.js',
		array( 'jquery' ),
		WIC2015_VERSION,
		true
	);
}

function wic2015_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-container">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'wic2015_widgets_init', 11 );

function wic2015_custom_header_setup() {
	$args = array(
		'default-text-color'     => '#ffffff',

		// Set height and width, with a maximum value for the width.
		'height'                 => 460,
		'width'                  => 1600,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'twentythirteen_header_style',
		'admin-head-callback'    => 'twentythirteen_admin_header_style',
		'admin-preview-callback' => 'twentythirteen_admin_header_image',
	);

	add_theme_support( 'custom-header', $args );

	register_default_headers( array(
		// 'circle' => array(
		// 	'url'           => '%s/images/headers/circle.png',
		// 	'thumbnail_url' => '%s/images/headers/circle-thumbnail.png',
		// 	'description'   => _x( 'Circle', 'header image description', 'twentythirteen' )
		// ),
	) );
}

add_action( 'after_setup_theme', 'wic2015_custom_header_setup', 11 );

function wic2015_wp_head() {
?>
	<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<?php
}

add_action( "wp_head", "wic2015_wp_head" );

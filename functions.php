<?php

require_once dirname( __FILE__ ) .'/lib/logo-customizer.php';

if ( ! isset( $content_width ) )
	$content_width = 750;

define( 'WIC2015_SCRIPTS_VERSION', 'v0.1.2' );


add_action( 'after_setup_theme', 'wic2015_a_after_setup_theme_01', 10 );

function wic2015_a_after_setup_theme_01() {
	add_theme_support( 'custom-background', array( 'wp-head-callback' => 'wic2015_custom_background_cb' ) );

	// Disable custom header of the Twenty Thirteen
	remove_action( 'after_setup_theme', 'twentythirteen_custom_header_setup', 11 );
}


add_action( 'after_setup_theme', 'wic2015_after_setup_theme_02', 11 );

function wic2015_after_setup_theme_02() {
	set_post_thumbnail_size( 750, 270, true );

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

	register_default_headers( array() );
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
		WIC2015_SCRIPTS_VERSION
	);

	wp_enqueue_style(
		'bootstrap-style',
		get_stylesheet_directory_uri() . '/css/bootstrap.min.css',
		array( 'twentythirteen-style' ),
		WIC2015_SCRIPTS_VERSION
	);

	wp_enqueue_style(
		'bootstrap-style',
		get_stylesheet_directory_uri() . '/css/bootstrap.min.css',
		array(),
		WIC2015_SCRIPTS_VERSION
	);

	wp_enqueue_style(
		'genericons',
		get_stylesheet_directory_uri() . '/css/genericons.css',
		array(),
		WIC2015_SCRIPTS_VERSION
	);

	wp_enqueue_style(
		'wic2015-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'twentythirteen-style', 'bootstrap-style', 'genericons' ),
		WIC2015_SCRIPTS_VERSION
	);

	wp_enqueue_script(
		'wic2015-script',
		get_stylesheet_directory_uri() . '/js/wic2015.js',
		array( 'jquery' ),
		WIC2015_SCRIPTS_VERSION,
		true
	);
}


add_action( 'widgets_init', 'wic2015_widgets_init', 11 );

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

	unregister_sidebar( 'sidebar-2' );
}


add_action( "wp_head", "wic2015_wp_head" );

function wic2015_wp_head() {
?>
	<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<?php
}


add_action( 'customize_register', 'wic2015_customize_unregister', 11 );

function wic2015_customize_unregister( $wp_customize ) {
	$wp_customize->remove_control( "background_repeat" );
	$wp_customize->remove_setting( "background_repeat" );
	$wp_customize->remove_control( "background_position_x" );
	$wp_customize->remove_setting( "background_position_x" );
	$wp_customize->remove_control( "background_attachment" );
	$wp_customize->remove_setting( "background_attachment" );
}


function wic2015_custom_background_cb() {
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
	$color = false;
	}

	if ( ! $background && ! $color )
		return;

		$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
			$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
			$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
			$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	}
?>
<style type="text/css" id="custom-background-css">
div.custom-background-container { <?php echo trim( $style ); ?> }
</style>
<?php
}

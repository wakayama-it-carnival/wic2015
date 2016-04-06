<?php

if ( ! isset( $content_width ) )
	$content_width = 750;

define( 'WIC2015_SCRIPTS_VERSION', 'v1.1.3' );

load_theme_textdomain( 'wic2015', get_stylesheet_directory() . '/languages' );


add_action( 'after_setup_theme', 'wic2015_a_after_setup_theme_01', 10 );

function wic2015_a_after_setup_theme_01() {
	// Disable custom header of the Twenty Thirteen
	remove_action( 'after_setup_theme', 'twentythirteen_custom_header_setup', 11 );
}


add_action( 'after_setup_theme', 'wic2015_after_setup_theme_02', 11 );

function wic2015_after_setup_theme_02() {
	set_post_thumbnail_size( 750, 270, true );

	$args = array(
		'default-text-color'     => '#ffffff',
		'default-image'          => get_stylesheet_directory_uri() . '/img/default-header.png',

		// Set height and width, with a maximum value for the width.
		'height'                 => 460,
		'width'                  => 1600,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'twentythirteen_header_style',
		'admin-head-callback'    => 'twentythirteen_admin_header_style',
		'admin-preview-callback' => 'twentythirteen_admin_header_image',
	);

	add_theme_support( "custom-header", $args );
	add_theme_support( "title-tag" );

	register_default_headers( array(
		'alpha' => array(
			'url'           => get_stylesheet_directory_uri() . '/img/default-header.png',
			'thumbnail_url' => get_stylesheet_directory_uri() . '/img/default-header.png',
			'description'   => __( 'Alpha Channel', 'wic2015' )
		),
	) );
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

	wp_enqueue_style( 'dashicons' );

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
		'name'          => __( 'Main Widget Area', 'wic2015' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'wic2015' ),
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

$background = get_theme_mod( 'wic2015_background', wic2015_get_default_background() );

if ( $background ) {
	$style = " background-image: url('$background');";
} else {
	$style = "";
}

?>
<style type="text/css" id="custom-background-css">
div.custom-background-container { <?php echo trim( $style ); ?> }
</style>
<?php
}


add_action( 'customize_register', 'wic2015_customize_register' );

function wic2015_customize_register( $wp_customize )
{
	/*
	 * Theme customizer for logo
	 */
	$wp_customize->add_section( 'wic2015_logo', array(
		'title'    => __( 'Logo', 'wic2015' ),
		'priority' => 41,
	) );

	$wp_customize->add_setting( 'wic2015_logo', array(
		'default'           => apply_filters( 'wic2015_default_logo', '' ),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'wic2015_logo',
		array(
			'label'	   => __( 'Logo', 'wic2015' ),
			'section'  => 'wic2015_logo',
			'settings' => 'wic2015_logo',
		)
	) );

	/*
	 * Theme customizer for background
	 */
	$wp_customize->add_section( 'wic2015_background', array(
		'title'    => __( 'Background Image', 'wic2015' ),
		'priority' => 42,
	) );

	$wp_customize->add_setting( 'wic2015_background', array(
		'default'           => wic2015_get_default_background(),
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'wic2015_background',
		array(
			'label'	   => __( 'Background Image', 'wic2015' ),
			'section'  => 'wic2015_background',
			'settings' => 'wic2015_background',
		)
	) );

	/*
	 * Theme customizer for footer
	 */
	$wp_customize->add_section( 'wic2015_footer', array(
		'title'    => __( 'Footer', 'wic2015' ),
		'priority' => 200,
	) );

	// it allows html
	$wp_customize->add_setting( 'wic2015_footer', array(
		'default' => '<a href="https://firegoby.jp/">WIC2015</a> powered by <a href="https://wordpress.org/">WordPress</a>',
		'type'       => 'theme_mod',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'wic2015_sanitize_footer_callback'
	) );

	$wp_customize->add_control( 'wic2015_footer', array(
		'label'   => __( 'Footer', 'wic2015' ),
		'section' => 'wic2015_footer',
		'type'    => 'textarea',
	) );
}

function wic2015_get_default_background() {
	return apply_filters(
		'wic2015_default_background',
		get_stylesheet_directory_uri() . "/img/default-background.jpg"
	);
}

function wic2015_sanitize_footer_callback( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

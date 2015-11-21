<?php

$wic2015_customizer = new WIC2015_Customizer();
$wic2015_customizer->register();

class WIC2015_Customizer {

	function register()
	{
		load_plugin_textdomain(
			"wic2015",
			false,
			dirname( plugin_basename( __FILE__ ) ).'/languages'
		);

		add_action( 'customize_register', array( $this, 'customize_register' ) );
	}

	public function customize_register( $wp_customize )
	{
		$wp_customize->add_section( 'wic2015_logo', array(
			'title'    => __( 'Logo', 'wic2015' ),
			'priority' => 41,
		) );

		$wp_customize->add_setting( 'wic2015_logo', array(
			'default'    => apply_filters( 'wic2015_default_logo', '' ),
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
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


		$wp_customize->add_section( 'wic2015_background', array(
			'title'    => __( 'Background Image', 'wic2015' ),
			'priority' => 42,
		) );

		$wp_customize->add_setting( 'wic2015_background', array(
			'default'    => apply_filters( 'wic2015_default_background', get_stylesheet_directory_uri() . "/img/default-background.jpg" ),
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
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
	}
} // end class LogoCustomizer


/*
 * Template Tag "the_logo()"
 */
function the_logo() {

	$logo = get_theme_mod( 'wic2015_logo' );

	if ( $logo ) {
		$image = '<img id="site-logo" src="%s" alt="%s" style="max-width:100%%; height:auto;">';
		printf(
			$image,
			esc_url( $logo ),
			esc_attr( get_bloginfo( 'name' ) )
		);
	} else {
		bloginfo( 'name' );
	}
}

// EOF

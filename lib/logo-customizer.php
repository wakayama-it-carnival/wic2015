<?php

$logo_customizer = new Logo_Customizer();
$logo_customizer->register();

class Logo_Customizer {

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

		$wp_customize->add_section( 'wic2015', array(
			'title'    => __( 'Logo Image', 'wic2015' ),
			'priority' => 15,
		) );

		$wp_customize->add_setting( 'wic2015', array(
			'default'    => apply_filters( 'logo_customizer_default_logo', '' ),
			'type'       => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			'logo_Image',
			array(
				'label'	   => __( 'Image', 'wic2015' ),
				'section'  => 'wic2015',
				'settings' => 'wic2015',
			)
		) );

	}
} // end class LogoCustomizer


/*
 * Template Tag "the_logo()"
 */
function the_logo() {

	$logo = get_option( 'wic2015', apply_filters( 'logo_customizer_default_logo', '' ) );

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

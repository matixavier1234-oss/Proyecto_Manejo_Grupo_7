<?php
/**
 * Settings for Demo Import
 *
 * @package Whizzie
 * @since 1.0.0
 */

if ( ! defined( 'WHIZZIE_DIR' ) ) {
	define( 'WHIZZIE_DIR', dirname( __FILE__ ) );
}

require trailingslashit( WHIZZIE_DIR ) . 'importer.php';

$current_theme = wp_get_theme();
$theme_title = $current_theme->get( 'Name' );

$bike_rental_services_config['page_slug'] 	= 'bike-rental-services';
$bike_rental_services_config['page_title']	= 'Get Started';

$bike_rental_services_config['steps'] = array(
	'widgets' => array(
		'id'			=> 'widgets',
		'title'			=> __( 'Demo Importer', 'bike-rental-services' ),
		'icon'			=> 'welcome-widgets-menus',
		'button_text_one'	=> __( 'Click On The Image To Import Customizer Demo', 'bike-rental-services' ),
		'button_text_two'	=> __( 'Click On The Image To Import Gutenberg Block Demo', 'bike-rental-services' ),
		'can_skip'		=> true,
	),
	'done' => array(
		'id'			=> 'done',
		'title'			=> __( 'All Done', 'bike-rental-services' ),
		'icon'			=> 'yes',
	)
);

if( class_exists( 'ThemeWhizzie' ) ) {
	$ThemeWhizzie = new ThemeWhizzie( $bike_rental_services_config );
}
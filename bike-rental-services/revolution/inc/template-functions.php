<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Bike Rental Services
 */

function bike_rental_services_body_classes( $bike_rental_services_classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$bike_rental_services_classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$bike_rental_services_classes[] = 'no-sidebar'; 
	}

	return $bike_rental_services_classes;
}
add_filter( 'body_class', 'bike_rental_services_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bike_rental_services_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'bike_rental_services_pingback_header' );

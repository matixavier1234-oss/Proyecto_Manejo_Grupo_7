<?php
/**
 * Jetpack Compatibility File
 *
 * @package Bike Rental Services
 */

function bike_rental_services_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'main',
			'render'    => 'bike_rental_services_infinite_scroll_render',
			'footer'    => 'page',
		)
	);

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options.
	add_theme_support(
		'jetpack-content-options',
		array(
			'post-details' => array(
				'stylesheet' => 'bike-rental-services-style',
				'date'       => '.posted-on',
				'categories' => '.cat-links',
				'tags'       => '.tags-links',
				'author'     => '.byline',
				'comment'    => '.comments-link',
			),
			'featured-images' => array(
				'archive' => true,
				'post'    => true,
				'page'    => true,
			),
		)
	);
}
add_action( 'after_setup_theme', 'bike_rental_services_jetpack_setup' );

if ( ! function_exists( 'bike_rental_services_infinite_scroll_render' ) ) :
	/**
	 * Custom render function for Infinite Scroll.
	 */
	function bike_rental_services_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'revolution/template-parts/content', 'search' );
			else :
				get_template_part( 'revolution/template-parts/content', get_post_type() );
			endif;
		}
	}
endif;

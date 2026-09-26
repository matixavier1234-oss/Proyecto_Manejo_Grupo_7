<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * @package Bike Rental Services
 */

function bike_rental_services_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'bike_rental_services_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'flex-width'        => true,
				'wp-head-callback'   => 'bike_rental_services_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'bike_rental_services_custom_header_setup' );

if ( ! function_exists( 'bike_rental_services_header_style' ) ) :	
	function bike_rental_services_header_style() {
		$bike_rental_services_header_text_color = get_header_textcolor();
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $bike_rental_services_header_text_color ) {
			return;
		}
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
			// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $bike_rental_services_header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
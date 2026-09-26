<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Bike Rental Services
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<?php bike_rental_services_breadcrumbs(); ?>
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'bike-rental-services' ); ?></h1>
	</header>

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'bike-rental-services' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'bike-rental-services' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'bike-rental-services' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div>
</section>
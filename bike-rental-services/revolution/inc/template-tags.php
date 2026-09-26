<?php
/**
 * Custom template tags for this theme
 *
 * @package Bike Rental Services
 */

if ( ! function_exists( 'bike_rental_services_posted_on' ) ) :
	function bike_rental_services_posted_on() {
		$bike_rental_services_time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$bike_rental_services_time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$bike_rental_services_time_string = sprintf(
			$bike_rental_services_time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$bike_rental_services_posted_on = sprintf(
			/* translators: %s: post date. */
			wp_kses_post( __( '<strong>Posted on:</strong> %s', 'bike-rental-services' ) ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $bike_rental_services_time_string . '</a>'
		);

		echo '<span class="posted-on">' . $bike_rental_services_posted_on . '</span>';
	}
endif;

if ( ! function_exists( 'bike_rental_services_posted_by' ) ) :	
	function bike_rental_services_posted_by() {
		$bike_rental_services_byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( '- %s', 'post author', 'bike-rental-services' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $bike_rental_services_byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'bike_rental_services_entry_footer' ) ) :	
	function bike_rental_services_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$bike_rental_services_categories_list = get_the_category_list( esc_html__( ', ', 'bike-rental-services' ) );
			if ( $bike_rental_services_categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'bike-rental-services' ) . '</span>', $bike_rental_services_categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$bike_rental_services_tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'bike-rental-services' ) );
			if ( $bike_rental_services_tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'bike-rental-services' ) . '</span>', $bike_rental_services_tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'bike-rental-services' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'bike-rental-services' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'bike_rental_services_post_thumbnail' ) ) :
	function bike_rental_services_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if( !function_exists('bike_rental_services_breadcrumbs') ) :
    /**
     * Bike Rental Services Breadcrumbs Function
     */
    function bike_rental_services_breadcrumbs($bike_rental_services_comment = null){

        echo '<div class="bike-rental-services-breadcrumbs">';
        	bike_rental_services_breadcrumbs_trail();
        echo '</div>';

    }
endif;
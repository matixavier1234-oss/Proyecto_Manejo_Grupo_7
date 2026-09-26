<?php
/**
 * Breadcrumb Trail - A breadcrumb menu script for WordPress.
 *
 * Breadcrumb Trail is a script for showing a breadcrumb trail for any type of page.  It tries to
 * anticipate any type of structure and display the best possible trail that matches your site's
 * permalink structure.  While not perfect, it attempts to fill in the gaps left by many other
 * breadcrumb scripts.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package   BreadcrumbTrail
 * @version   1.1.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2017, Justin Tadlock
 * @link      https://themehybrid.com/plugins/breadcrumb-trail
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Shows a breadcrumb for all types of pages.  This is a wrapper function for the Bike_Rental_Services_Breadcrumb_Trail class,
 * which should be used in theme templates.
 *
 * @since  0.1.0
 * @access public
 * @param  array $bike_rental_services_args Arguments to pass to Bike_Rental_Services_Breadcrumb_Trail.
 * @return void
 */
function bike_rental_services_breadcrumbs_trail( $bike_rental_services_args = array() ) {

    $bike_rental_services_breadcrumb = apply_filters( 'bike_rental_services_breadcrumbs_trail_object', null, $bike_rental_services_args );

    if ( ! is_object( $bike_rental_services_breadcrumb ) )
        $bike_rental_services_breadcrumb = new Bike_Rental_Services_Breadcrumb_Trail( $bike_rental_services_args );

    return $bike_rental_services_breadcrumb->trail();
}

/**
 * Creates a breadcrumbs menu for the site based on the current page that's being viewed by the user.
 *
 * @since  0.6.0
 * @access public
 */
class Bike_Rental_Services_Breadcrumb_Trail {

    /**
     * Array of items belonging to the current breadcrumb trail.
     *
     * @since  0.1.0
     * @access public
     * @var    array
     */
    public $items = array();

    /**
     * Arguments used to build the breadcrumb trail.
     *
     * @since  0.1.0
     * @access public
     * @var    array
     */
    public $bike_rental_services_args = array();

    /**
     * Array of text labels.
     *
     * @since  1.0.0
     * @access public
     * @var    array
     */
    public $bike_rental_services_labels = array();

    /**
     * Array of post types (key) and taxonomies (value) to use for single post views.
     *
     * @since  1.0.0
     * @access public
     * @var    array
     */
    public $bike_rental_services_post_taxonomy = array();

    public $labels;
    public $post_taxonomy;
	public $args;

    /* ====== Magic Methods ====== */

    /**
     * Magic method to use in case someone tries to output the layout object as a string.
     * We'll just return the trail HTML.
     *
     * @since  1.0.0
     * @access public
     * @return string
     */
    public function __toString() {
        return $this->trail();
    }

    /**
     * Sets up the breadcrumb trail properties.  Calls the `Bike_Rental_Services_Breadcrumb_Trail::add_items()` method
     * to creat the array of breadcrumb items.
     *
     * @since  0.6.0
     * @access public
     * @param  array   $bike_rental_services_args  {
     *     @type string    $container      Container HTML element. nav|div
     *     @type string    $before         String to output before breadcrumb menu.
     *     @type string    $after          String to output after breadcrumb menu.
     *     @type string    $browse_tag     The HTML tag to use to wrap the "Browse" header text.
     *     @type string    $list_tag       The HTML tag to use for the list wrapper.
     *     @type string    $bike_rental_services_item_tag       The HTML tag to use for the item wrapper.
     *     @type bool      $show_on_front  Whether to show when `is_front_page()`.
     *     @type bool      $bike_rental_services_network        Whether to link to the network main site (multisite only).
     *     @type bool      $show_title     Whether to show the title (last item) in the trail.
     *     @type bool      $show_browse    Whether to show the breadcrumb menu header.
     *     @type array     $bike_rental_services_labels         Text labels. @see Bike_Rental_Services_Breadcrumb_Trail::set_labels()
     *     @type array     $bike_rental_services_post_taxonomy  Taxonomies to use for post types. @see Bike_Rental_Services_Breadcrumb_Trail::set_post_taxonomy()
     *     @type bool      $echo           Whether to print or return the breadcrumbs.
     * }
     * @return void
     */
    public function __construct( $bike_rental_services_args = array() ) {

        $bike_rental_services_defaults = array(
            'container'       => 'nav',
            'before'          => '',
            'after'           => '',
            'browse_tag'      => 'h2',
            'list_tag'        => 'ul',
            'item_tag'        => 'li',
            'show_on_front'   => true,
            'network'         => false,
            'show_title'      => true,
            'show_browse'     => false,
            'labels'          => array(),
            'post_taxonomy'   => array(),
            'echo'            => true
        );

        // Parse the arguments with the deaults.
        $this->args = apply_filters( 'bike_rental_services_breadcrumbs_trail_args', wp_parse_args( $bike_rental_services_args, $bike_rental_services_defaults ) );

        // Set the labels and post taxonomy properties.
        $this->set_labels();
        $this->set_post_taxonomy();

        // Let's find some items to add to the trail!
        $this->add_items();
    }

    /* ====== Public Methods ====== */

    /**
     * Formats the HTML output for the breadcrumb trail.
     *
     * @since  0.6.0
     * @access public
     * @return string
     */
    public function trail() {

        // Set up variables that we'll need.
        $bike_rental_services_breadcrumb    = '';
        $bike_rental_services_item_count    = count( $this->items );
        $bike_rental_services_item_position = 0;

        // Connect the breadcrumb trail if there are items in the trail.
        if ( 0 < $bike_rental_services_item_count ) {

            // Add 'browse' label if it should be shown.
            if ( true === $this->args['show_browse'] ) {

                $bike_rental_services_breadcrumb .= sprintf(
                    '<%1$s class="trail-browse">%2$s</%1$s>',
                    tag_escape( $this->args['browse_tag'] ),
                    $this->labels['browse']
                );
            }

            // Open the unordered list.
            $bike_rental_services_breadcrumb .= sprintf(
                '<%s class="trail-items" itemscope itemtype="http://schema.org/BreadcrumbList">',
                tag_escape( $this->args['list_tag'] )
            );

            // Add the number of items and item list order schema.
            $bike_rental_services_breadcrumb .= sprintf( '<meta name="numberOfItems" content="%d" />', absint( $bike_rental_services_item_count ) );
            $bike_rental_services_breadcrumb .= '<meta name="itemListOrder" content="Ascending" />';

            // Loop through the items and add them to the list.
            foreach ( $this->items as $bike_rental_services_item ) {

                // Iterate the item position.
                ++$bike_rental_services_item_position;

                // Check if the item is linked.
                preg_match( '/(<a.*?>)(.*?)(<\/a>)/i', $bike_rental_services_item, $bike_rental_services_matches );

                // Wrap the item text with appropriate itemprop.
                $bike_rental_services_item = ! empty( $bike_rental_services_matches ) ? sprintf( '%s<span itemprop="name">%s</span>%s', $bike_rental_services_matches[1], $bike_rental_services_matches[2], $bike_rental_services_matches[3] ) : sprintf( '<span itemprop="name">%s</span>', $bike_rental_services_item );

                // If viewing a single post.
                if ( is_singular() || is_page() ){

                    global $post;
                    $bike_rental_services_link_item = get_permalink( $post->ID );

                }
                elseif ( is_archive() && ( !is_day() && !is_month() && !is_year() && !is_tag() ) ) {

                    $bike_rental_services_category = get_queried_object();
                    $bike_rental_services_link_item = get_category_link( $bike_rental_services_category->term_id );

                } elseif ( is_day() ) {

                    $bike_rental_services_link_item = get_day_link( get_the_time('Y'),get_the_time('m'),get_the_time('d') );

                } elseif ( is_month() ) {

                   $bike_rental_services_link_item = get_month_link( get_the_time('Y'),get_the_time('m') );

                } elseif ( is_year() ) {

                    $bike_rental_services_link_item = get_year_link( get_the_time('Y') );

                }elseif ( is_tag() ) {

                    $bike_rental_services_tag_id = get_queried_object()->term_id;
                    $bike_rental_services_link_item = get_tag_link( $bike_rental_services_tag_id );

                } elseif ( is_author() ) {

                    $bike_rental_services_link_item = get_author_posts_url( get_current_user_id() );

                }
                elseif ( is_search() ) {

                    $bike_rental_services_link_item = home_url();

                }
                else{

                    $bike_rental_services_link_item = home_url();

                }

                $bike_rental_services_item = ! empty( $bike_rental_services_matches )
                    ? preg_replace( '/(<a.*?)([\'"])>/i', '$1$2 itemprop=$2item$2>', $bike_rental_services_item )
                    : sprintf( '<a href="'.esc_url( $bike_rental_services_link_item ).'" itemprop="item">%s</a>', $bike_rental_services_item );

                // Add list item classes.
                $bike_rental_services_item_class = 'trail-item';

                if ( 1 === $bike_rental_services_item_position && 1 < $bike_rental_services_item_count )
                    $bike_rental_services_item_class .= ' trail-begin';

                elseif ( $bike_rental_services_item_count === $bike_rental_services_item_position )
                    $bike_rental_services_item_class .= ' trail-end';

                // Create list item attributes.
                $attributes = 'itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="' . $bike_rental_services_item_class . '"';

                // Build the meta position HTML.
                $meta = sprintf( '<meta itemprop="position" content="%s" />', absint( $bike_rental_services_item_position ) );

                // Build the list item.
                $bike_rental_services_breadcrumb .= sprintf( '<%1$s %2$s>%3$s%4$s</%1$s>', tag_escape( $this->args['item_tag'] ),$attributes, $bike_rental_services_item, $meta );
            }

            // Close the unordered list.
            $bike_rental_services_breadcrumb .= sprintf( '</%s>', tag_escape( $this->args['list_tag'] ) );

            // Wrap the breadcrumb trail.
            $bike_rental_services_breadcrumb = sprintf(
                '<%1$s role="navigation" aria-label="%2$s" class="breadcrumb-trail" itemprop="breadcrumb">%3$s%4$s%5$s</%1$s>',
                tag_escape( $this->args['container'] ),
                esc_attr( $this->labels['aria_label'] ),
                $this->args['before'],
                $bike_rental_services_breadcrumb,
                $this->args['after']
            );
        }

        // Allow developers to filter the breadcrumb trail HTML.
        $bike_rental_services_breadcrumb = apply_filters( 'bike_rental_services_breadcrumbs_trail', $bike_rental_services_breadcrumb, $this->args );

        if ( false === $this->args['echo'] )
            return $bike_rental_services_breadcrumb;

        echo $bike_rental_services_breadcrumb;
    }

    /* ====== Protected Methods ====== */

    /**
     * Sets the labels property.  Parses the inputted labels array with the defaults.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function set_labels() {

        $bike_rental_services_defaults = array(
            'browse'              => esc_html__( 'Browse:',                               'bike-rental-services' ),
            'aria_label'          => esc_attr_x( 'Breadcrumbs', 'breadcrumbs aria label', 'bike-rental-services' ),
            'home'                => esc_html__( 'Home',                                  'bike-rental-services' ),
            'error_404'           => esc_html__( '404 Not Found',                         'bike-rental-services' ),
            'archives'            => esc_html__( 'Archives',                              'bike-rental-services' ),
            // Translators: %s is the search query.
            'search'              => esc_html__( 'Search results for: %s',                'bike-rental-services' ),
            // Translators: %s is the page number.
            'paged'               => esc_html__( 'Page %s',                               'bike-rental-services' ),
            // Translators: %s is the page number.
            'paged_comments'      => esc_html__( 'Comment Page %s',                       'bike-rental-services' ),
            // Translators: Minute archive title. %s is the minute time format.
            'archive_minute'      => esc_html__( 'Minute %s',                             'bike-rental-services' ),
            // Translators: Weekly archive title. %s is the week date format.
            'archive_week'        => esc_html__( 'Week %s',                               'bike-rental-services' ),

            // "%s" is replaced with the translated date/time format.
            'archive_minute_hour' => '%s',
            'archive_hour'        => '%s',
            'archive_day'         => '%s',
            'archive_month'       => '%s',
            'archive_year'        => '%s',
        );

        $this->labels = apply_filters( 'bike_rental_services_breadcrumbs_trail_labels', wp_parse_args( $this->args['labels'], $bike_rental_services_defaults ) );
    }

    /**
     * Sets the `$bike_rental_services_post_taxonomy` property.  This is an array of post types (key) and taxonomies (value).
     * The taxonomy's terms are shown on the singular post view if set.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function set_post_taxonomy() {

        $bike_rental_services_defaults = array();

        // If post permalink is set to `%postname%`, use the `category` taxonomy.
        if ( '%postname%' === trim( get_option( 'permalink_structure' ), '/' ) )
            $bike_rental_services_defaults['post'] = 'category';

        $this->post_taxonomy = apply_filters( 'bike_rental_services_breadcrumbs_trail_post_taxonomy', wp_parse_args( $this->args['post_taxonomy'], $bike_rental_services_defaults ) );
    }

    /**
     * Runs through the various WordPress conditional tags to check the current page being viewed.  Once
     * a condition is met, a specific method is launched to add items to the `$items` array.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_items() {

        // If viewing the front page.
        if ( is_front_page() ) {
            $this->add_front_page_items();
        }

        // If not viewing the front page.
        else {

            // Add the network and site home links.
            $this->add_network_home_link();
            $this->add_site_home_link();

            // If viewing the home/blog page.
            if ( is_home() ) {
                $this->add_blog_items();
            }

            // If viewing a single post.
            elseif ( is_singular() ) {
                $this->add_singular_items();
            }

            // If viewing an archive page.
            elseif ( is_archive() ) {

                if ( is_post_type_archive() )
                    $this->add_post_type_archive_items();

                elseif ( is_category() || is_tag() || is_tax() )
                    $this->add_term_archive_items();

                elseif ( is_author() )
                    $this->add_user_archive_items();

                elseif ( get_query_var( 'minute' ) && get_query_var( 'hour' ) )
                    $this->add_minute_hour_archive_items();

                elseif ( get_query_var( 'minute' ) )
                    $this->add_minute_archive_items();

                elseif ( get_query_var( 'hour' ) )
                    $this->add_hour_archive_items();

                elseif ( is_day() )
                    $this->add_day_archive_items();

                elseif ( get_query_var( 'w' ) )
                    $this->add_week_archive_items();

                elseif ( is_month() )
                    $this->add_month_archive_items();

                elseif ( is_year() )
                    $this->add_year_archive_items();

                else
                    $this->add_default_archive_items();
            }

            // If viewing a search results page.
            elseif ( is_search() ) {
                $this->add_search_items();
            }

            // If viewing the 404 page.
            elseif ( is_404() ) {
                $this->add_404_items();
            }
        }

        // Add paged items if they exist.
        $this->add_paged_items();

        // Allow developers to overwrite the items for the breadcrumb trail.
        $this->items = array_unique( apply_filters( 'bike_rental_services_breadcrumbs_trail_items', $this->items, $this->args ) );
    }

    /**
     * Gets front items based on $wp_rewrite->front.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_rewrite_front_items() {
        global $wp_rewrite;

        if ( $wp_rewrite->front )
            $this->add_path_parents( $wp_rewrite->front );
    }

    /**
     * Adds the page/paged number to the items array.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_paged_items() {

        // If viewing a paged singular post.
        if ( is_singular() && 1 < get_query_var( 'page' ) && true === $this->args['show_title'] )
            $this->items[] = sprintf( $this->labels['paged'], number_format_i18n( absint( get_query_var( 'page' ) ) ) );

        // If viewing a singular post with paged comments.
        elseif ( is_singular() && get_option( 'page_comments' ) && 1 < get_query_var( 'cpage' ) )
            $this->items[] = sprintf( $this->labels['paged_comments'], number_format_i18n( absint( get_query_var( 'cpage' ) ) ) );

        // If viewing a paged archive-type page.
        elseif ( is_paged() && true === $this->args['show_title'] )
            $this->items[] = sprintf( $this->labels['paged'], number_format_i18n( absint( get_query_var( 'paged' ) ) ) );
    }

    /**
     * Adds the network (all sites) home page link to the items array.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_network_home_link() {

        if ( is_multisite() && ! is_main_site() && true === $this->args['network'] )
            $this->items[] = sprintf( '<a href="%s" rel="home">%s</a>', esc_url( network_home_url() ), $this->labels['home'] );
    }

    /**
     * Adds the current site's home page link to the items array.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_site_home_link() {

        $bike_rental_services_network = is_multisite() && ! is_main_site() && true === $this->args['network'];
        $bike_rental_services_label   = $bike_rental_services_network ? get_bloginfo( 'name' ) : $this->labels['home'];
        $rel     = $bike_rental_services_network ? '' : ' rel="home"';

        $this->items[] = sprintf( '<a href="%s"%s>%s</a>', esc_url( user_trailingslashit( home_url() ) ), $rel, $bike_rental_services_label );
    }

    /**
     * Adds items for the front page to the items array.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_front_page_items() {

        // Only show front items if the 'show_on_front' argument is set to 'true'.
        if ( true === $this->args['show_on_front'] || is_paged() || ( is_singular() && 1 < get_query_var( 'page' ) ) ) {

            // Add network home link.
            $this->add_network_home_link();

            // If on a paged view, add the site home link.
            if ( is_paged() )
                $this->add_site_home_link();

            // If on the main front page, add the network home title.
            elseif ( true === $this->args['show_title'] )
                $this->items[] = is_multisite() && true === $this->args['network'] ? get_bloginfo( 'name' ) : $this->labels['home'];
        }
    }

    /**
     * Adds items for the posts page (i.e., is_home()) to the items array.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_blog_items() {

        // Get the post ID and post.
        $bike_rental_services_post_id = get_queried_object_id();
        $post    = get_post( $bike_rental_services_post_id );

        // If the post has parents, add them to the trail.
        if ( 0 < $post->post_parent )
            $this->add_post_parents( $post->post_parent );

        // Get the page title.
        $bike_rental_services_title = get_the_title( $bike_rental_services_post_id );

        // Add the posts page item.
        if ( is_paged() )
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink( $bike_rental_services_post_id ) ), $bike_rental_services_title );

        elseif ( $bike_rental_services_title && true === $this->args['show_title'] )
            $this->items[] = $bike_rental_services_title;
    }

    /**
     * Adds singular post items to the items array.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_singular_items() {

        // Get the queried post.
        $post    = get_queried_object();
        $bike_rental_services_post_id = get_queried_object_id();

        // If the post has a parent, follow the parent trail.
        if ( 0 < $post->post_parent )
            $this->add_post_parents( $post->post_parent );

        // If the post doesn't have a parent, get its hierarchy based off the post type.
        else
            $this->add_post_hierarchy( $bike_rental_services_post_id );

        // Display terms for specific post type taxonomy if requested.
        if ( ! empty( $this->post_taxonomy[ $post->post_type ] ) )
            $this->add_post_terms( $bike_rental_services_post_id, $this->post_taxonomy[ $post->post_type ] );

        // End with the post title.
        if ( $bike_rental_services_post_title = single_post_title( '', false ) ) {

            if ( ( 1 < get_query_var( 'page' ) || is_paged() ) || ( get_option( 'page_comments' ) && 1 < absint( get_query_var( 'cpage' ) ) ) )
                $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink( $bike_rental_services_post_id ) ), $bike_rental_services_post_title );

            elseif ( true === $this->args['show_title'] )
                $this->items[] = $bike_rental_services_post_title;
        }
    }

    /**
     * Adds the items to the trail items array for taxonomy term archives.
     *
     * @since  1.0.0
     * @access protected
     * @global object $wp_rewrite
     * @return void
     */
    protected function add_term_archive_items() {
        global $wp_rewrite;

        // Get some taxonomy and term variables.
        $bike_rental_services_term           = get_queried_object();
        $bike_rental_services_taxonomy       = get_taxonomy( $bike_rental_services_term->taxonomy );
        $bike_rental_services_done_post_type = false;

        // If there are rewrite rules for the taxonomy.
        if ( false !== $bike_rental_services_taxonomy->rewrite ) {

            // If 'with_front' is true, dd $wp_rewrite->front to the trail.
            if ( isset( $bike_rental_services_taxonomy->rewrite['with_front'] ) && $bike_rental_services_taxonomy->rewrite['with_front'] && isset( $wp_rewrite->front ) && $wp_rewrite->front )
                $this->add_rewrite_front_items();

            // Get parent pages by path if they exist.
            $this->add_path_parents( $bike_rental_services_taxonomy->rewrite['slug'] );

            // Add post type archive if its 'has_archive' matches the taxonomy rewrite 'slug'.
            if ( $bike_rental_services_taxonomy->rewrite['slug'] ) {

                $bike_rental_services_slug = trim( $bike_rental_services_taxonomy->rewrite['slug'], '/' );

                // Deals with the situation if the slug has a '/' between multiple
                // strings. For example, "movies/genres" where "movies" is the post
                // type archive.
                $bike_rental_services_matches = explode( '/', $bike_rental_services_slug );

                // If matches are found for the path.
                if ( isset( $bike_rental_services_matches ) ) {

                    // Reverse the array of matches to search for posts in the proper order.
                    $bike_rental_services_matches = array_reverse( $bike_rental_services_matches );

                    // Loop through each of the path matches.
                    foreach ( $bike_rental_services_matches as $bike_rental_services_match ) {

                        // If a match is found.
                        $bike_rental_services_slug = $bike_rental_services_match;

                        // Get public post types that match the rewrite slug.
                        $bike_rental_services_post_types = $this->get_post_types_by_slug( $bike_rental_services_match );

                        if ( ! empty( $bike_rental_services_post_types ) ) {

                            $bike_rental_services_post_type_object = $bike_rental_services_post_types[0];

                            // Add support for a non-standard label of 'archive_title' (special use case).
                            $bike_rental_services_label = ! empty( $bike_rental_services_post_type_object->labels->archive_title ) ? $bike_rental_services_post_type_object->labels->archive_title : $bike_rental_services_post_type_object->labels->name;

                            // Core filter hook.
                            $bike_rental_services_label = apply_filters( 'post_type_archive_title', $bike_rental_services_label, $bike_rental_services_post_type_object->name );

                            // Add the post type archive link to the trail.
                            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_post_type_archive_link( $bike_rental_services_post_type_object->name ) ), $bike_rental_services_label );

                            $bike_rental_services_done_post_type = true;

                            // Break out of the loop.
                            break;
                        }
                    }
                }
            }
        }

        // If there's a single post type for the taxonomy, use it.
        if ( false === $bike_rental_services_done_post_type && 1 === count( $bike_rental_services_taxonomy->object_type ) && post_type_exists( $bike_rental_services_taxonomy->object_type[0] ) ) {

            // If the post type is 'post'.
            if ( 'post' === $bike_rental_services_taxonomy->object_type[0] ) {
                $bike_rental_services_post_id = get_option( 'page_for_posts' );

                if ( 'posts' !== get_option( 'show_on_front' ) && 0 < $bike_rental_services_post_id )
                    $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink( $bike_rental_services_post_id ) ), get_the_title( $bike_rental_services_post_id ) );

            // If the post type is not 'post'.
            } else {
                $bike_rental_services_post_type_object = get_post_type_object( $bike_rental_services_taxonomy->object_type[0] );

                $bike_rental_services_label = ! empty( $bike_rental_services_post_type_object->labels->archive_title ) ? $bike_rental_services_post_type_object->labels->archive_title : $bike_rental_services_post_type_object->labels->name;

                // Core filter hook.
                $bike_rental_services_label = apply_filters( 'post_type_archive_title', $bike_rental_services_label, $bike_rental_services_post_type_object->name );

                $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_post_type_archive_link( $bike_rental_services_post_type_object->name ) ), $bike_rental_services_label );
            }
        }

        // If the taxonomy is hierarchical, list its parent terms.
        if ( is_taxonomy_hierarchical( $bike_rental_services_term->taxonomy ) && $bike_rental_services_term->parent )
            $this->add_term_parents( $bike_rental_services_term->parent, $bike_rental_services_term->taxonomy );

        // Add the term name to the trail end.
        if ( is_paged() )
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $bike_rental_services_term, $bike_rental_services_term->taxonomy ) ), single_term_title( '', false ) );

        elseif ( true === $this->args['show_title'] )
            $this->items[] = single_term_title( '', false );
    }

    /**
     * Adds the items to the trail items array for post type archives.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_post_type_archive_items() {

        // Get the post type object.
        $bike_rental_services_post_type_object = get_post_type_object( get_query_var( 'post_type' ) );

        if ( false !== $bike_rental_services_post_type_object->rewrite ) {

            // If 'with_front' is true, add $wp_rewrite->front to the trail.
            if ( isset( $bike_rental_services_post_type_object->rewrite['with_front'] ) && $bike_rental_services_post_type_object->rewrite['with_front'] )
                $this->add_rewrite_front_items();

            // If there's a rewrite slug, check for parents.
            if ( ! empty( $bike_rental_services_post_type_object->rewrite['slug'] ) )
                $this->add_path_parents( $bike_rental_services_post_type_object->rewrite['slug'] );
        }

        // Add the post type [plural] name to the trail end.
        if ( is_paged() || is_author() )
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_post_type_archive_link( $bike_rental_services_post_type_object->name ) ), post_type_archive_title( '', false ) );

        elseif ( true === $this->args['show_title'] )
            $this->items[] = post_type_archive_title( '', false );

        // If viewing a post type archive by author.
        if ( is_author() )
            $this->add_user_archive_items();
    }

    /**
     * Adds the items to the trail items array for user (author) archives.
     *
     * @since  1.0.0
     * @access protected
     * @global object $wp_rewrite
     * @return void
     */
    protected function add_user_archive_items() {
        global $wp_rewrite;

        // Add $wp_rewrite->front to the trail.
        $this->add_rewrite_front_items();

        // Get the user ID.
        $user_id = get_query_var( 'author' );

        // If $author_base exists, check for parent pages.
        if ( ! empty( $wp_rewrite->author_base ) && ! is_post_type_archive() )
            $this->add_path_parents( $wp_rewrite->author_base );

        // Add the author's display name to the trail end.
        if ( is_paged() )
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_author_posts_url( $user_id ) ), get_the_author_meta( 'display_name', $user_id ) );

        elseif ( true === $this->args['show_title'] )
            $this->items[] = get_the_author_meta( 'display_name', $user_id );
    }

    /**
     * Adds the items to the trail items array for minute + hour archives.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_minute_hour_archive_items() {

        // Add $wp_rewrite->front to the trail.
        $this->add_rewrite_front_items();

        // Add the minute + hour item.
        if ( true === $this->args['show_title'] )
            $this->items[] = sprintf( $this->labels['archive_minute_hour'], get_the_time( esc_html_x( 'g:i a', 'minute and hour archives time format', 'bike-rental-services' ) ) );
    }

    /**
     * Adds the items to the trail items array for minute archives.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_minute_archive_items() {

        // Add $wp_rewrite->front to the trail.
        $this->add_rewrite_front_items();

        // Add the minute item.
        if ( true === $this->args['show_title'] )
            $this->items[] = sprintf( $this->labels['archive_minute'], get_the_time( esc_html_x( 'i', 'minute archives time format', 'bike-rental-services' ) ) );
    }

    /**
     * Adds the items to the trail items array for hour archives.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_hour_archive_items() {

        // Add $wp_rewrite->front to the trail.
        $this->add_rewrite_front_items();

        // Add the hour item.
        if ( true === $this->args['show_title'] )
            $this->items[] = sprintf( $this->labels['archive_hour'], get_the_time( esc_html_x( 'g a', 'hour archives time format', 'bike-rental-services' ) ) );
    }

    /**
     * Adds the items to the trail items array for day archives.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_day_archive_items() {

        // Add $wp_rewrite->front to the trail.
        $this->add_rewrite_front_items();

        // Get year, month, and day.
        $bike_rental_services_year  = sprintf( $this->labels['archive_year'],  get_the_time( esc_html_x( 'Y', 'yearly archives date format',  'bike-rental-services' ) ) );
        $bike_rental_services_month = sprintf( $this->labels['archive_month'], get_the_time( esc_html_x( 'F', 'monthly archives date format', 'bike-rental-services' ) ) );
        $bike_rental_services_day   = sprintf( $this->labels['archive_day'],   get_the_time( esc_html_x( 'j', 'daily archives date format',   'bike-rental-services' ) ) );

        // Add the year and month items.
        $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_year_link( get_the_time( 'Y' ) ) ), $bike_rental_services_year );
        $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ), $bike_rental_services_month );

        // Add the day item.
        if ( is_paged() )
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_day_link( get_the_time( 'Y' ) ), get_the_time( 'm' ), get_the_time( 'd' ) ), $bike_rental_services_day );

        elseif ( true === $this->args['show_title'] )
            $this->items[] = $bike_rental_services_day;
    }

    /**
     * Adds the items to the trail items array for week archives.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_week_archive_items() {

        // Add $wp_rewrite->front to the trail.
        $this->add_rewrite_front_items();

        // Get the year and week.
        $bike_rental_services_year = sprintf( $this->labels['archive_year'],  get_the_time( esc_html_x( 'Y', 'yearly archives date format', 'bike-rental-services' ) ) );
        $bike_rental_services_week = sprintf( $this->labels['archive_week'],  get_the_time( esc_html_x( 'W', 'weekly archives date format', 'bike-rental-services' ) ) );

        // Add the year item.
        $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_year_link( get_the_time( 'Y' ) ) ), $bike_rental_services_year );

        // Add the week item.
        if ( is_paged() )
            $this->items[] = esc_url( get_archives_link( add_query_arg( array( 'm' => get_the_time( 'Y' ), 'w' => get_the_time( 'W' ) ), home_url() ), $bike_rental_services_week, false ) );

        elseif ( true === $this->args['show_title'] )
            $this->items[] = $bike_rental_services_week;
    }

    /**
     * Adds the items to the trail items array for month archives.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_month_archive_items() {

        // Add $wp_rewrite->front to the trail.
        $this->add_rewrite_front_items();

        // Get the year and month.
        $bike_rental_services_year  = sprintf( $this->labels['archive_year'],  get_the_time( esc_html_x( 'Y', 'yearly archives date format',  'bike-rental-services' ) ) );
        $bike_rental_services_month = sprintf( $this->labels['archive_month'], get_the_time( esc_html_x( 'F', 'monthly archives date format', 'bike-rental-services' ) ) );

        // Add the year item.
        $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_year_link( get_the_time( 'Y' ) ) ), $bike_rental_services_year );

        // Add the month item.
        if ( is_paged() )
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ), $bike_rental_services_month );

        elseif ( true === $this->args['show_title'] )
            $this->items[] = $bike_rental_services_month;
    }

    /**
     * Adds the items to the trail items array for year archives.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_year_archive_items() {

        // Add $wp_rewrite->front to the trail.
        $this->add_rewrite_front_items();

        // Get the year.
        $bike_rental_services_year  = sprintf( $this->labels['archive_year'],  get_the_time( esc_html_x( 'Y', 'yearly archives date format',  'bike-rental-services' ) ) );

        // Add the year item.
        if ( is_paged() )
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_year_link( get_the_time( 'Y' ) ) ), $bike_rental_services_year );

        elseif ( true === $this->args['show_title'] )
            $this->items[] = $bike_rental_services_year;
    }

    /**
     * Adds the items to the trail items array for archives that don't have a more specific method
     * defined in this class.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_default_archive_items() {

        // If this is a date-/time-based archive, add $wp_rewrite->front to the trail.
        if ( is_date() || is_time() )
            $this->add_rewrite_front_items();

        if ( true === $this->args['show_title'] )
            $this->items[] = $this->labels['archives'];
    }

    /**
     * Adds the items to the trail items array for search results.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_search_items() {

        if ( is_paged() )
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_search_link() ), sprintf( $this->labels['search'], get_search_query() ) );

        elseif ( true === $this->args['show_title'] )
            $this->items[] = sprintf( $this->labels['search'], get_search_query() );
    }

    /**
     * Adds the items to the trail items array for 404 pages.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function add_404_items() {

        if ( true === $this->args['show_title'] )
            $this->items[] = $this->labels['error_404'];
    }

    /**
     * Adds a specific post's parents to the items array.
     *
     * @since  1.0.0
     * @access protected
     * @param  int    $bike_rental_services_post_id
     * @return void
     */
    protected function add_post_parents( $bike_rental_services_post_id ) {
        $bike_rental_services_parents = array();

        while ( $bike_rental_services_post_id ) {

            // Get the post by ID.
            $post = get_post( $bike_rental_services_post_id );

            // If we hit a page that's set as the front page, bail.
            if ( 'page' == $post->post_type && 'page' == get_option( 'show_on_front' ) && $bike_rental_services_post_id == get_option( 'page_on_front' ) )
                break;

            // Add the formatted post link to the array of parents.
            $bike_rental_services_parents[] = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink( $bike_rental_services_post_id ) ), get_the_title( $bike_rental_services_post_id ) );

            // If there's no longer a post parent, break out of the loop.
            if ( 0 >= $post->post_parent )
                break;

            // Change the post ID to the parent post to continue looping.
            $bike_rental_services_post_id = $post->post_parent;
        }

        // Get the post hierarchy based off the final parent post.
        $this->add_post_hierarchy( $bike_rental_services_post_id );

        // Display terms for specific post type taxonomy if requested.
        if ( ! empty( $this->post_taxonomy[ $post->post_type ] ) )
            $this->add_post_terms( $bike_rental_services_post_id, $this->post_taxonomy[ $post->post_type ] );

        // Merge the parent items into the items array.
        $this->items = array_merge( $this->items, array_reverse( $bike_rental_services_parents ) );
    }

    /**
     * Adds a specific post's hierarchy to the items array.  The hierarchy is determined by post type's
     * rewrite arguments and whether it has an archive page.
     *
     * @since  1.0.0
     * @access protected
     * @param  int    $bike_rental_services_post_id
     * @return void
     */
    protected function add_post_hierarchy( $bike_rental_services_post_id ) {

        // Get the post type.
        $bike_rental_services_post_type        = get_post_type( $bike_rental_services_post_id );
        $bike_rental_services_post_type_object = get_post_type_object( $bike_rental_services_post_type );

        // If this is the 'post' post type, get the rewrite front items and map the rewrite tags.
        if ( 'post' === $bike_rental_services_post_type ) {

            // Add $wp_rewrite->front to the trail.
            $this->add_rewrite_front_items();

            // Map the rewrite tags.
            $this->map_rewrite_tags( $bike_rental_services_post_id, get_option( 'permalink_structure' ) );
        }

        // If the post type has rewrite rules.
        elseif ( false !== $bike_rental_services_post_type_object->rewrite ) {

            // If 'with_front' is true, add $wp_rewrite->front to the trail.
            if ( isset( $bike_rental_services_post_type_object->rewrite['with_front'] ) && $bike_rental_services_post_type_object->rewrite['with_front'] )
                $this->add_rewrite_front_items();

            // If there's a path, check for parents.
            if ( ! empty( $bike_rental_services_post_type_object->rewrite['slug'] ) )
                $this->add_path_parents( $bike_rental_services_post_type_object->rewrite['slug'] );
        }

        // If there's an archive page, add it to the trail.
        if ( $bike_rental_services_post_type_object->has_archive ) {

            // Add support for a non-standard label of 'archive_title' (special use case).
            $bike_rental_services_label = ! empty( $bike_rental_services_post_type_object->labels->archive_title ) ? $bike_rental_services_post_type_object->labels->archive_title : $bike_rental_services_post_type_object->labels->name;

            // Core filter hook.
            $bike_rental_services_label = apply_filters( 'post_type_archive_title', $bike_rental_services_label, $bike_rental_services_post_type_object->name );

            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_post_type_archive_link( $bike_rental_services_post_type ) ), $bike_rental_services_label );
        }

        // Map the rewrite tags if there's a `%` in the slug.
        if ( 'post' !== $bike_rental_services_post_type && ! empty( $bike_rental_services_post_type_object->rewrite['slug'] ) && false !== strpos( $bike_rental_services_post_type_object->rewrite['slug'], '%' ) )
            $this->map_rewrite_tags( $bike_rental_services_post_id, $bike_rental_services_post_type_object->rewrite['slug'] );
    }

    /**
     * Gets post types by slug.  This is needed because the get_post_types() function doesn't exactly
     * match the 'has_archive' argument when it's set as a string instead of a boolean.
     *
     * @since  0.6.0
     * @access protected
     * @param  int    $bike_rental_services_slug  The post type archive slug to search for.
     * @return void
     */
    protected function get_post_types_by_slug( $bike_rental_services_slug ) {

        $bike_rental_services_return = array();

        $bike_rental_services_post_types = get_post_types( array(), 'objects' );

        foreach ( $bike_rental_services_post_types as $bike_rental_services_type ) {

            if ( $bike_rental_services_slug === $bike_rental_services_type->has_archive || ( true === $bike_rental_services_type->has_archive && $bike_rental_services_slug === $bike_rental_services_type->rewrite['slug'] ) )
                $bike_rental_services_return[] = $bike_rental_services_type;
        }

        return $bike_rental_services_return;
    }

    /**
     * Adds a post's terms from a specific taxonomy to the items array.
     *
     * @since  1.0.0
     * @access protected
     * @param  int     $bike_rental_services_post_id  The ID of the post to get the terms for.
     * @param  string  $bike_rental_services_taxonomy The taxonomy to get the terms from.
     * @return void
     */
    protected function add_post_terms( $bike_rental_services_post_id, $bike_rental_services_taxonomy ) {

        // Get the post type.
        $bike_rental_services_post_type = get_post_type( $bike_rental_services_post_id );

        // Get the post categories.
        $bike_rental_services_terms = get_the_terms( $bike_rental_services_post_id, $bike_rental_services_taxonomy );

        // Check that categories were returned.
        if ( $bike_rental_services_terms && ! is_wp_error( $bike_rental_services_terms ) ) {

            // Sort the terms by ID and get the first category.
            if ( function_exists( 'wp_list_sort' ) )
                $bike_rental_services_terms = wp_list_sort( $bike_rental_services_terms, 'term_id' );

            else
                usort( $bike_rental_services_terms, '_usort_terms_by_ID' );

            $bike_rental_services_term = get_term( $bike_rental_services_terms[0], $bike_rental_services_taxonomy );

            // If the category has a parent, add the hierarchy to the trail.
            if ( 0 < $bike_rental_services_term->parent )
                $this->add_term_parents( $bike_rental_services_term->parent, $bike_rental_services_taxonomy );

            // Add the category archive link to the trail.
            $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $bike_rental_services_term, $bike_rental_services_taxonomy ) ), $bike_rental_services_term->name );
        }
    }

    /**
     * Get parent posts by path.  Currently, this method only supports getting parents of the 'page'
     * post type.  The goal of this function is to create a clear path back to home given what would
     * normally be a "ghost" directory.  If any page matches the given path, it'll be added.
     *
     * @since  1.0.0
     * @access protected
     * @param  string $bike_rental_services_path The path (slug) to search for posts by.
     * @return void
     */
    function add_path_parents( $bike_rental_services_path ) {

        // Trim '/' off $bike_rental_services_path in case we just got a simple '/' instead of a real path.
        $bike_rental_services_path = trim( $bike_rental_services_path, '/' );

        // If there's no path, return.
        if ( empty( $bike_rental_services_path ) )
            return;

        // Get parent post by the path.
        $post = get_page_by_path( $bike_rental_services_path );

        if ( ! empty( $post ) ) {
            $this->add_post_parents( $post->ID );
        }

        elseif ( is_null( $post ) ) {

            // Separate post names into separate paths by '/'.
            $bike_rental_services_path = trim( $bike_rental_services_path, '/' );
            preg_match_all( "/\/.*?\z/", $bike_rental_services_path, $bike_rental_services_matches );

            // If matches are found for the path.
            if ( isset( $bike_rental_services_matches ) ) {

                // Reverse the array of matches to search for posts in the proper order.
                $bike_rental_services_matches = array_reverse( $bike_rental_services_matches );

                // Loop through each of the path matches.
                foreach ( $bike_rental_services_matches as $bike_rental_services_match ) {

                    // If a match is found.
                    if ( isset( $bike_rental_services_match[0] ) ) {

                        // Get the parent post by the given path.
                        $bike_rental_services_path = str_replace( $bike_rental_services_match[0], '', $bike_rental_services_path );
                        $post = get_page_by_path( trim( $bike_rental_services_path, '/' ) );

                        // If a parent post is found, set the $bike_rental_services_post_id and break out of the loop.
                        if ( ! empty( $post ) && 0 < $post->ID ) {
                            $this->add_post_parents( $post->ID );
                            break;
                        }
                    }
                }
            }
        }
    }

    /**
     * Searches for term parents of hierarchical taxonomies.  This function is similar to the WordPress
     * function get_category_parents() but handles any type of taxonomy.
     *
     * @since  1.0.0
     * @param  int    $bike_rental_services_term_id  ID of the term to get the parents of.
     * @param  string $bike_rental_services_taxonomy Name of the taxonomy for the given term.
     * @return void
     */
    function add_term_parents( $bike_rental_services_term_id, $bike_rental_services_taxonomy ) {

        // Set up some default arrays.
        $bike_rental_services_parents = array();

        // While there is a parent ID, add the parent term link to the $bike_rental_services_parents array.
        while ( $bike_rental_services_term_id ) {

            // Get the parent term.
            $bike_rental_services_term = get_term( $bike_rental_services_term_id, $bike_rental_services_taxonomy );

            // Add the formatted term link to the array of parent terms.
            $bike_rental_services_parents[] = sprintf( '<a href="%s">%s</a>', esc_url( get_term_link( $bike_rental_services_term, $bike_rental_services_taxonomy ) ), $bike_rental_services_term->name );

            // Set the parent term's parent as the parent ID.
            $bike_rental_services_term_id = $bike_rental_services_term->parent;
        }

        // If we have parent terms, reverse the array to put them in the proper order for the trail.
        if ( ! empty( $bike_rental_services_parents ) )
            $this->items = array_merge( $this->items, array_reverse( $bike_rental_services_parents ) );
    }

    /**
     * Turns %tag% from permalink structures into usable links for the breadcrumb trail.  This feels kind of
     * hackish for now because we're checking for specific %tag% examples and only doing it for the 'post'
     * post type.  In the future, maybe it'll handle a wider variety of possibilities, especially for custom post
     * types.
     *
     * @since  0.6.0
     * @access protected
     * @param  int    $bike_rental_services_post_id ID of the post whose parents we want.
     * @param  string $bike_rental_services_path    Path of a potential parent page.
     * @param  array  $bike_rental_services_args    Mixed arguments for the menu.
     * @return array
     */
    protected function map_rewrite_tags( $bike_rental_services_post_id, $bike_rental_services_path ) {

        $post = get_post( $bike_rental_services_post_id );

        // Trim '/' from both sides of the $bike_rental_services_path.
        $bike_rental_services_path = trim( $bike_rental_services_path, '/' );

        // Split the $bike_rental_services_path into an array of strings.
        $bike_rental_services_matches = explode( '/', $bike_rental_services_path );

        // If matches are found for the path.
        if ( is_array( $bike_rental_services_matches ) ) {

            // Loop through each of the matches, adding each to the $trail array.
            foreach ( $bike_rental_services_matches as $bike_rental_services_match ) {

                // Trim any '/' from the $bike_rental_services_match.
                $bike_rental_services_tag = trim( $bike_rental_services_match, '/' );

                // If using the %year% tag, add a link to the yearly archive.
                if ( '%year%' == $bike_rental_services_tag )
                    $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_year_link( get_the_time( 'Y', $bike_rental_services_post_id ) ) ), sprintf( $this->labels['archive_year'], get_the_time( esc_html_x( 'Y', 'yearly archives date format',  'bike-rental-services' ) ) ) );

                // If using the %monthnum% tag, add a link to the monthly archive.
                elseif ( '%monthnum%' == $bike_rental_services_tag )
                    $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_month_link( get_the_time( 'Y', $bike_rental_services_post_id ), get_the_time( 'm', $bike_rental_services_post_id ) ) ), sprintf( $this->labels['archive_month'], get_the_time( esc_html_x( 'F', 'monthly archives date format', 'bike-rental-services' ) ) ) );

                // If using the %day% tag, add a link to the daily archive.
                elseif ( '%day%' == $bike_rental_services_tag )
                    $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_day_link( get_the_time( 'Y', $bike_rental_services_post_id ), get_the_time( 'm', $bike_rental_services_post_id ), get_the_time( 'd', $bike_rental_services_post_id ) ) ), sprintf( $this->labels['archive_day'], get_the_time( esc_html_x( 'j', 'daily archives date format', 'bike-rental-services' ) ) ) );

                // If using the %author% tag, add a link to the post author archive.
                elseif ( '%author%' == $bike_rental_services_tag )
                    $this->items[] = sprintf( '<a href="%s">%s</a>', esc_url( get_author_posts_url( $post->post_author ) ), get_the_author_meta( 'display_name', $post->post_author ) );

                // If using the %category% tag, add a link to the first category archive to match permalinks.
                elseif ( taxonomy_exists( trim( $bike_rental_services_tag, '%' ) ) ) {

                    // Force override terms in this post type.
                    $this->post_taxonomy[ $post->post_type ] = false;

                    // Add the post categories.
                    $this->add_post_terms( $bike_rental_services_post_id, trim( $bike_rental_services_tag, '%' ) );
                }
            }
        }
    }
}
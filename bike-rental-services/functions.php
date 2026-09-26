<?php
/**
 * Bike Rental Services functions and definitions
 *
 * @package Bike Rental Services
 */

if ( ! defined( 'BIKE_RENTAL_SERVICES_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'BIKE_RENTAL_SERVICES_VERSION', '1.0.0' );
}

function bike_rental_services_setup() {

	load_theme_textdomain( 'bike-rental-services', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'bike-rental-services' ),
			'social-menu' => esc_html__('Social Menu', 'bike-rental-services'),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'bike_rental_services_custom_background_args',
			array(
				'default-color' => '#fafafa',
				'default-image' => '',
			)
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support( 'post-formats', array(
        'image',
        'video',
        'gallery',
        'audio', 
    ));
	
}
add_action( 'after_setup_theme', 'bike_rental_services_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $bike_rental_services_content_width
 */
function bike_rental_services_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bike_rental_services_content_width', 640 );
}
add_action( 'after_setup_theme', 'bike_rental_services_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.WordPress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bike_rental_services_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'bike-rental-services' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'bike-rental-services' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'bike-rental-services' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'bike-rental-services' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'bike-rental-services' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'bike-rental-services' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'bike-rental-services' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'bike-rental-services' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'bike_rental_services_widgets_init' );


function bike_rental_services_social_menu()
    {
        if (has_nav_menu('social-menu')) :
            wp_nav_menu(array(
                'theme_location' => 'social-menu',
                'container' => 'ul',
                'menu_class' => 'social-menu menu',
                'menu_id'  => 'menu-social',
            ));
        endif;
    }

/**
 * Enqueue scripts and styles.
 */
function bike_rental_services_scripts() {

	// Load fonts locally
	require_once get_theme_file_path('revolution/inc/wptt-webfont-loader.php');

	$bike_rental_services_font_families = array(
		'Titillium Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700',
		'Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900',
	);
	
	$bike_rental_services_fonts_url = add_query_arg( array(
		'family' => implode( '&family=', $bike_rental_services_font_families ),
		'display' => 'swap',
	), 'https://fonts.googleapis.com/css2' );

	wp_enqueue_style('bike-rental-services-google-fonts', wptt_get_webfont_url(esc_url_raw($bike_rental_services_fonts_url)), array(), '1.0.0');
	
	// Font Awesome CSS
    wp_enqueue_style('font-awesome-6', get_template_directory_uri() . '/revolution/assets/vendors/font-awesome-6/css/all.min.css', array(), '6.7.2');

	wp_enqueue_style('owl.carousel.style', get_template_directory_uri() . '/revolution/assets/css/owl.carousel.css', array());
	
	wp_enqueue_style( 'bike-rental-services-style', get_stylesheet_uri(), array(), BIKE_RENTAL_SERVICES_VERSION );

	require get_parent_theme_file_path( '/custom-style.php' );
	wp_add_inline_style( 'bike-rental-services-style',$bike_rental_services_custom_css );

	wp_style_add_data('bike-rental-services-style', 'rtl', 'replace');

	wp_enqueue_script( 'bike-rental-services-navigation', get_template_directory_uri() . '/js/navigation.js', array(), BIKE_RENTAL_SERVICES_VERSION, true );

	wp_enqueue_script( 'owl.carousel.jquery', get_template_directory_uri() . '/revolution/assets/js/owl.carousel.js', array(), BIKE_RENTAL_SERVICES_VERSION, true );

	wp_enqueue_script( 'bike-rental-services-custom-js', get_template_directory_uri() . '/revolution/assets/js/custom.js', array('jquery'), BIKE_RENTAL_SERVICES_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bike_rental_services_scripts' );

if (!function_exists('bike_rental_services_related_post')) :
    /**
     * Display related posts from same category
     *
     */

    function bike_rental_services_related_post($post_id){        
        $bike_rental_services_categories = get_the_category($post_id);
        if ($bike_rental_services_categories) {
            $bike_rental_services_category_ids = array();
            $bike_rental_services_category = get_category($bike_rental_services_category_ids);
            $bike_rental_services_categories = get_the_category($post_id);
            foreach ($bike_rental_services_categories as $bike_rental_services_category) {
                $bike_rental_services_category_ids[] = $bike_rental_services_category->term_id;
            }
            $count = $bike_rental_services_category->category_count;
            if ($count > 1) { ?>

         	<?php
		$bike_rental_services_related_post_wrap = absint(get_theme_mod('bike_rental_services_enable_related_post', 1));
		if($bike_rental_services_related_post_wrap == 1){ ?>
                <div class="related-post">
                    
                    <h2 class="post-title"><?php esc_html_e(get_theme_mod('bike_rental_services_related_post_text', __('Related Post', 'bike-rental-services'))); ?></h2>
                    <?php
                    $bike_rental_services_cat_post_args = array(
                        'category__in' => $bike_rental_services_category_ids,
                        'post__not_in' => array($post_id),
                        'post_type' => 'post',
                        'posts_per_page' =>  get_theme_mod( 'bike_rental_services_related_post_count', '3' ),
                        'post_status' => 'publish',
						'orderby'           => 'rand',
                        'ignore_sticky_posts' => true
                    );
                    $bike_rental_services_featured_query = new WP_Query($bike_rental_services_cat_post_args);
                    ?>
                    <div class="rel-post-wrap">
                        <?php
                        if ($bike_rental_services_featured_query->have_posts()) :

                        while ($bike_rental_services_featured_query->have_posts()) : $bike_rental_services_featured_query->the_post();
                            ?>

							<div class="card-item rel-card-item">
								<div class="card-content">
                                    <?php if ( has_post_thumbnail() ) { ?>
                                        <div class="card-media">
                                            <?php bike_rental_services_post_thumbnail(); ?>
                                        </div>
                                    <?php } else {
                                        // Fallback default image
                                        $bike_rental_services_default_post_thumbnail = get_template_directory_uri() . '/revolution/assets/images/slider1.png';
                                        echo '<img class="default-post-img" src="' . esc_url( $bike_rental_services_default_post_thumbnail ) . '" alt="' . esc_attr( get_the_title() ) . '">';
                                    } ?>
									<div class="entry-title">
										<h3>
											<a href="<?php the_permalink() ?>">
												<?php the_title(); ?>
											</a>
										</h3>
									</div>
									<div class="entry-meta">
                                        <?php
                                        bike_rental_services_posted_on();
                                        bike_rental_services_posted_by();
                                        ?>
                                    </div>
								</div>
							</div>
                        <?php
                        endwhile;
                        ?>
                <?php
                endif;
                wp_reset_postdata();
                ?>
                </div>
                <?php } ?>
                <?php
            }
        }
    }
endif;
add_action('bike_rental_services_related_posts', 'bike_rental_services_related_post', 10, 1);

function bike_rental_services_sanitize_choices( $bike_rental_services_input, $bike_rental_services_setting ) {
    global $wp_customize; 
    $bike_rental_services_control = $wp_customize->get_control( $bike_rental_services_setting->id ); 
    if ( array_key_exists( $bike_rental_services_input, $bike_rental_services_control->choices ) ) {
        return $bike_rental_services_input;
    } else {
        return $bike_rental_services_setting->default;
    }
}

//Excerpt 
function bike_rental_services_excerpt_function($bike_rental_services_excerpt_count = 35) {
    $bike_rental_services_excerpt = get_the_excerpt();
    $bike_rental_services_text_excerpt = wp_strip_all_tags($bike_rental_services_excerpt);
    $bike_rental_services_excerpt_limit = (int) get_theme_mod('bike_rental_services_excerpt_limit', $bike_rental_services_excerpt_count);
    $bike_rental_services_words = preg_split('/\s+/', $bike_rental_services_text_excerpt); 
    $bike_rental_services_trimmed_words = array_slice($bike_rental_services_words, 0, $bike_rental_services_excerpt_limit);
    $bike_rental_services_theme_excerpt = implode(' ', $bike_rental_services_trimmed_words);

    return $bike_rental_services_theme_excerpt;
}

// Add admin notice
function bike_rental_services_admin_notice() { 
    global $pagenow;
    $bike_rental_services_theme_args      = wp_get_theme();
    $bike_rental_services_meta            = get_option( 'bike_rental_services_admin_notice' );
    $name            = $bike_rental_services_theme_args->__get( 'Name' );
    $bike_rental_services_current_screen  = get_current_screen();

    if( !$bike_rental_services_meta ){
	    if( is_network_admin() ){
	        return;
	    }

	    if( ! current_user_can( 'manage_options' ) ){
	        return;
	    } 
		
		if( $bike_rental_services_current_screen->base !== 'appearance_page_bike_rental_services_guide' && 
            $bike_rental_services_current_screen->base !== 'toplevel_page_bikerentalservices-demoimport' ) { ?>

            <div class="notice notice-success bike-rental-services-welcome-notice">
                <p class="bike-rental-services-dismiss-link">
                    <strong>
                        <a href="<?php echo esc_url( add_query_arg( 'bike_rental_services_admin_notice', '1' ) ); ?>">
                            <?php esc_html_e( 'Dismiss', 'bike-rental-services' ); ?>
                        </a>
                    </strong>
                </p>

                <div class="bike-rental-services-welcome-notice-wrap">
                    <h2 class="bike-rental-services-notice-title">
                        <span class="dashicons dashicons-admin-home"></span> 
                        <?php 
                            $bike_rental_services_theme_name = wp_get_theme()->get( 'Name' );
                            /* translators: %s!: Theme Name. */
                            echo esc_html( sprintf( __( 'Welcome to the free theme: %s!', 'bike-rental-services' ), $bike_rental_services_theme_name ) );
                        ?>
                    </h2>
                    <p class="bike-rental-services-notice-desc">
                        <?php esc_html_e( 'Get started by exploring the features of your new theme. Customize your design, add your content, and create a site that fits your vision.', 'bike-rental-services' ); ?>
                    </p>

                    <div class="bike-rental-services-welcome-info">
                        <div class="bike-rental-services-welcome-thumb">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/screenshot.png' ); ?>" alt="<?php esc_attr_e( 'Theme Screenshot', 'bike-rental-services' ); ?>">
                        </div>

                        <div class="bike-rental-services-welcome-import">
                            <h3><span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Quick Start: Import Demo', 'bike-rental-services' ); ?></h3>
                            <p><?php esc_html_e( 'Use the Demo Importer to quickly set up your site with a pre-made layout. Get a complete site in minutes.', 'bike-rental-services' ); ?></p>
                            <p><a class="button info-link button-primary" href="<?php echo esc_url( admin_url( 'themes.php?page=bikerentalservices-demoimport' ) ); ?>"><?php esc_html_e( 'Go to Demo Importer', 'bike-rental-services' ); ?></a></p>
                        </div>

                        <div class="bike-rental-services-welcome-getting-started">
                            <h3><span class="dashicons dashicons-art"></span> <?php esc_html_e( 'Customize Your Theme', 'bike-rental-services' ); ?></h3>
                            <p><?php esc_html_e( 'Want to make it truly yours? Explore the Getting Started Guide to personalize your site to suit your needs.', 'bike-rental-services' ); ?></p>
                            <p><a class="info-link button" href="<?php echo esc_url( admin_url( 'themes.php?page=bike-rental-services-getstart-page' ) ); ?>"><?php esc_html_e( 'View Getting Started Guide', 'bike-rental-services' ); ?></a></p>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        }

	}
}

add_action( 'admin_notices', 'bike_rental_services_admin_notice' );

if( ! function_exists( 'bike_rental_services_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function bike_rental_services_update_admin_notice(){
    if ( isset( $_GET['bike_rental_services_admin_notice'] ) && $_GET['bike_rental_services_admin_notice'] = '1' ) {
        update_option( 'bike_rental_services_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'bike_rental_services_update_admin_notice' );


add_action('after_switch_theme', 'bike_rental_services_setup_options');
function bike_rental_services_setup_options () {
    update_option('bike_rental_services_admin_notice', FALSE );
}

/**
 * Checkbox sanitization callback example.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$bike_rental_services_checked`
 * as a boolean value, either TRUE or FALSE.
 */
function bike_rental_services_sanitize_checkbox($bike_rental_services_checked)
{
    // Boolean check.
    return ((isset($bike_rental_services_checked) && true == $bike_rental_services_checked) ? true : false);
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/revolution/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/revolution/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/revolution/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/revolution/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/revolution/inc/jetpack.php';

}

/**
 * Breadcrumb File.
 */
require get_template_directory() . '/revolution/inc/breadcrumbs.php';

/**
 * Custom typography options for this theme.
 */
require get_template_directory() . '/revolution/inc/typography-options.php';

//////////////////////////////////////////////   Function for Translation Error   //////////////////////////////////////////////////////
function bike_rental_services_enqueue_function() {

	/**
	* GET START.
	*/
	require get_template_directory() . '/getstarted/bike_rental_services_about_page.php';

	/**
	* DEMO IMPORT.
	*/
	require get_template_directory() . '/demo-import/bike_rental_services_config_file.php';


	define('BIKE_RENTAL_SERVICES_FREE_SUPPORT',__('https://WordPress.org/support/theme/bike-rental-services/','bike-rental-services'));
	define('BIKE_RENTAL_SERVICES_PRO_SUPPORT',__('https://www.revolutionwp.com/pages/community/','bike-rental-services'));
	define('BIKE_RENTAL_SERVICES_REVIEW',__('https://WordPress.org/support/theme/bike-rental-services/reviews/#new-post','bike-rental-services'));
	define('BIKE_RENTAL_SERVICES_BUY_NOW',__('https://www.revolutionwp.com/products/bike-shop-WordPress-theme','bike-rental-services'));
	define('BIKE_RENTAL_SERVICES_LIVE_DEMO',__('https://demo.revolutionwp.com/bike-rental-services-pro/','bike-rental-services'));
	define('BIKE_RENTAL_SERVICES_PRO_DOC',__('https://demo.revolutionwp.com/wpdocs/bike-rental-services-pro/','bike-rental-services'));
	define('BIKE_RENTAL_SERVICES_LITE_DOC',__('https://demo.revolutionwp.com/wpdocs/bike-rental-services-free','bike-rental-services'));
	define('BIKE_RENTAL_SERVICES_BUNDLE',__('https://www.revolutionwp.com/products/WordPress-theme-bundle','bike-rental-services'));

}
add_action( 'after_setup_theme', 'bike_rental_services_enqueue_function' );

function bike_rental_services_remove_customize_register() {
    global $wp_customize;

    $wp_customize->remove_setting( 'display_header_text' );
    $wp_customize->remove_control( 'display_header_text' );

}

add_action( 'customize_register', 'bike_rental_services_remove_customize_register', 11 );

/**
 * WooCommerce custom filters
 */
add_filter('loop_shop_columns', 'bike_rental_services_loop_columns');

if (!function_exists('bike_rental_services_loop_columns')) {

	function bike_rental_services_loop_columns() {

		$bike_rental_services_columns = get_theme_mod( 'bike_rental_services_per_columns', 3 );

		return $bike_rental_services_columns;
	}
}

/************************************************************************************/

add_filter( 'loop_shop_per_page', 'bike_rental_services_per_page', 20 );

function bike_rental_services_per_page( $bike_rental_services_cols ) {

  	$bike_rental_services_cols = get_theme_mod( 'bike_rental_services_product_per_page', 9 );

	return $bike_rental_services_cols;
}

/************************************************************************************/

add_filter( 'woocommerce_output_related_products_args', 'bike_rental_services_products_args' );

function bike_rental_services_products_args( $bike_rental_services_args ) {

    $bike_rental_services_args['posts_per_page'] = get_theme_mod( 'custom_related_products_number', 6 );

    $bike_rental_services_args['columns'] = get_theme_mod( 'custom_related_products_number_per_row', 3 );

    return $bike_rental_services_args;
}

/************************************************************************************/

/**
 * Custom logo
 */

function bike_rental_services_custom_css() {
?>
	<style type="text/css" id="custom-theme-colors" >
        :root {
           
            --bike_rental_services_logo_width: <?php echo absint(get_theme_mod('bike_rental_services_logo_width')); ?> ;   
        }
        .site-branding img {
            max-width:<?php echo esc_html(get_theme_mod('bike_rental_services_logo_width')); ?>px ;    
        }         
	</style>
<?php
}
add_action( 'wp_head', 'bike_rental_services_custom_css' );

function get_changelog_from_readme() {
    $file_path = get_template_directory() . '/readme.txt'; // Adjust path if necessary

    if (file_exists($file_path)) {
        $content = file_get_contents($file_path);

        // Extract changelog section
        $changelog_start = strpos($content, "== Changelog ==");
        $changelog = substr($content, $changelog_start);

        // Split changelog into versions (supports "* X.Y.Z - Date", bare "* X.Y.Z",
        // and "= X.Y.Z =" style entries, with tab, space, or "*" indented details).
        preg_match_all('/^(?:\*[ \t]*([\d.]+)(?:[ \t]*-[ \t]*(.+?))?|=[ \t]*([\d.]+)[ \t]*=)[ \t]*\r?\n((?:(?:\t|[ ]{2,}|\*(?!\s*[\d.]+(?:\s|\r?$)))[ \t]*-?[ \t]*.+?\r?\n)*)/m', $changelog, $raw_matches, PREG_SET_ORDER);

        $matches = [];

        foreach ($raw_matches as $raw_match) {
            $version = '' !== $raw_match[1] ? $raw_match[1] : $raw_match[3];
            $details = preg_replace('/^([ \t]*)\*[ \t]*/m', '$1', $raw_match[4]);

            if ('' !== $version && '' !== trim($details)) {
                $matches[] = array( $raw_match[0], $version, trim($raw_match[2]), $details );
            }
        }

        return $matches;
    }
    return [];
}
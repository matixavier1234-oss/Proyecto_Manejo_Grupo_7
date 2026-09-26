<?php
/**
 * @package Demo Import
 * @since 1.0.0
 */

class ThemeWhizzie {

	protected $version = '1.1.0';

	/** @var string Current theme name, used as namespace in actions. */
	protected $theme_name = '';
	protected $theme_title = '';

	/** @var string Demo Import page slug and title. */
	protected $page_slug = '';
	protected $page_title = '';

	/** @var array Demo Import steps set by user. */
	protected $config_steps = array();
	public $parent_slug;
	/**
	 * Constructor
	 *
	 * @param $bike_rental_services_config	Our config parameters
	*/
	public function __construct( $bike_rental_services_config ) {
		$this->set_vars( $bike_rental_services_config );
		$this->init();
	}

	/**
	 * Set some settings
	 * @since 1.0.0
	 * @param $bike_rental_services_config	Our config parameters
	*/
	public function set_vars( $bike_rental_services_config ) {
		if( isset( $bike_rental_services_config['page_slug'] ) ) {
			$this->page_slug = esc_attr( $bike_rental_services_config['page_slug'] );
		}
		if( isset( $bike_rental_services_config['page_title'] ) ) {
			$this->page_title = esc_attr( $bike_rental_services_config['page_title'] );
		}
		if( isset( $bike_rental_services_config['steps'] ) ) {
			$this->config_steps = $bike_rental_services_config['steps'];
		}

		$current_theme = wp_get_theme();
		$this->theme_title = $current_theme->get( 'Name' );
		$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
		$this->page_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_page_slug', $this->theme_name . '-demoimport' );
		$this->parent_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_parent_slug', '' );
	}

	/**
	 * Hooks and filters
	 * @since 1.0.0
	*/
	public function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'wp_ajax_setup_widgets', array( $this, 'setup_widgets' ) );
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'demo-import-style', get_template_directory_uri() . '/demo-import/assets/css/demo-import-style.css');
		wp_register_script( 'demo-import-script', get_template_directory_uri() . '/demo-import/assets/js/demo-import-script.js', array( 'jquery' ), time() );
		wp_localize_script(
			'demo-import-script',
			'bike_rental_services_whizzie_params',
			array(
				'ajaxurl' 		=> admin_url( 'admin-ajax.php' ),
				'wpnonce' 		=> wp_create_nonce( 'whizzie_nonce' ),
				'verify_text'	=> esc_html( 'verifying', 'bike-rental-services' )
			)
		);
		wp_enqueue_script( 'demo-import-script' );
	}

	/**  Make a modal screen for the wizard **/
	public function menu_page() {
		add_menu_page( esc_html( $this->page_title ), esc_html( $this->page_title ), 'manage_options', $this->page_slug, array( $this, 'bike_rental_services_guide' ) ,'',40);
	}

	/** Make an interface for the wizard **/
	public function wizard_page() {
		/* If we arrive here, we have the filesystem */ ?>
		<div class="wrap">
			<?php echo '<div class="whizzie-wrap">';
				// The wizard is a list with only one item visible at a time
				$steps = $this->get_steps();
				echo '<ul class="whizzie-nav wizard-icon-nav">';?>
				<?php
					$stepI=1;
					foreach( $steps as $step ) {
						$stepAct=($stepI ==1)? 1 : 0;
						if( isset( $step['icon_text'] ) && $step['icon_text'] ) {
							echo '<li class="commom-cls nav-step-' . esc_attr( $step['id'] ) . '" wizard-steps="step-'.esc_attr( $step['id'] ).'" data-enable="'.$stepAct.'">
							<p>'.esc_attr( $step['icon_text'] ).'</p>
							</li>';
						}
					$stepI++;}
			 	echo '</ul>';
				echo '<ul class="whizzie-menu wizard-menu-page">';
				foreach( $steps as $step ) {
					$class = 'step step-' . esc_attr( $step['id'] );
					echo '<li data-step="' . esc_attr( $step['id'] ) . '" class="' . esc_attr( $class ) . '" >';
						$content = call_user_func( array( $this, $step['view'] ) );
						printf('<div class="wizard-button-wrapper">');
							if( isset( $step['button_text_one'] )) {
								printf(
									'<div class="button-wrap button-wrap-one">
										<a href="#" class="button button-primary do-it" data-callback="install_widgets" data-step="widgets"><p class="demo-type-text">%s</p></a>
									</div>',
									esc_html( $step['button_text_one'] )
								);
							}
						printf('</div>');
					echo '</li>';
				}
				echo '</ul>';
				?>
				<div class="step-loading"><span class="spinner">
					<img src="<?php echo esc_url(get_template_directory_uri().'/demo-import/assets/images/Spinner-Animaion.gif'); ?>">
				</span></div>
			<?php echo '</div>';?>
		</div>
	<?php }

	/**
	 * Set options for the steps
	 * @return Array
	*/
	public function get_steps() {
		$dev_steps = $this->config_steps;
		$steps = array(
			'widgets' => array(
				'id'			=> 'widgets',
				'title'			=> __( 'Customizer', 'bike-rental-services' ),
				'icon'			=> 'welcome-widgets-menus',
				'view'			=> 'get_step_widgets',
				'callback'		=> 'install_widgets',
				'button_text_one'	=> __( 'Import Demo', 'bike-rental-services' ),
				'can_skip'		=> true,
				'icon_text'      => 'Import Demo'
			),
			'done' => array(
				'id'			=> 'done',
				'title'			=> __( 'All Done', 'bike-rental-services' ),
				'icon'			=> 'yes',
				'view'			=> 'get_step_done',
				'callback'		=> '',
				'icon_text'      => 'Done'
			)
		);
		// Iterate through each step and replace with dev config values
		if( $dev_steps ) {
			// Configurable elements - these are the only ones the dev can update from config.php
			$can_config = array( 'title', 'icon', 'button_text', 'can_skip' );
			foreach( $dev_steps as $dev_step ) {
				// We can only proceed if an ID exists and matches one of our IDs
				if( isset( $dev_step['id'] ) ) {
					$id = $dev_step['id'];
					if( isset( $steps[$id] ) ) {
						foreach( $can_config as $element ) {
							if( isset( $dev_step[$element] ) ) {
								$steps[$id][$element] = $dev_step[$element];
							}
						}
					}
				}
			}
		}
		return $steps;
	}

	/**    Print the content for the intro step     **/
		public function get_step_importer() { ?>
		<div class="summary">
			<p>
				<?php esc_html_e('Thank you for choosing this Bike Rental Services Theme. Using this quick setup wizard, you will be able to configure your new website and get it running in just a few minutes. Just follow these simple steps mentioned in the wizard and get started with your website.','bike-rental-services'); ?>
			</p>
		</div>
	<?php }

	/**   Print the content for the widgets step   **/
	public function get_step_widgets() { ?>
		<div class="summary">
			<p>
				<?php esc_html_e('This theme allows you to import demo content and add widgets. Install them using the button below. You can also update or deactivate them using the Customizer.','bike-rental-services'); ?>
			</p>
		</div>
	<?php }

	/** Print the content for the final step **/
	public function get_step_done() { ?>

		<div class="setup-finish">
			<p>
				<?php echo esc_html('Your demo content has been imported successfully. Click the finish button for more information.'); ?>
			</p>
			<div class="finish-buttons">
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=bike-rental-services-getstart-page' ) ); ?>" class="wz-btn-customizer" target="_blank"><?php esc_html_e('About Bike Rental Services','bike-rental-services') ?></a>
				<a href="<?php echo esc_url(admin_url('/customize.php')); ?>" class="wz-btn-customizer" target="_blank"><?php esc_html_e('Customize Your Demo','bike-rental-services') ?></a>
				<a href="" class="wz-btn-builder" target="_blank"><?php esc_html_e('Customize Your Demo','bike-rental-services'); ?></a>
				<a href="<?php echo esc_url(home_url()); ?>" class="wz-btn-visit-site" target="_blank"><?php esc_html_e('Visit Your Site','bike-rental-services'); ?></a>
			</div>
			<div class="finish-buttons">
				<a href="<?php echo esc_url(admin_url()); ?>" class="button button-primary"><?php esc_html_e('Finish','bike-rental-services'); ?></a>
			</div>
		</div>

	<?php }


	public function bike_rental_services_customizer_nav_menu() {
		// ------- Create Primary Menu --------
		$bike_rental_services_themename = 'Bike Rental Services'; // Ensure the theme name is set
		$bike_rental_services_menuname = $bike_rental_services_themename . ' Primary Menu';
		$bike_rental_services_menulocation = 'menu-1';
		$bike_rental_services_menu_exists = wp_get_nav_menu_object($bike_rental_services_menuname);

		if (!$bike_rental_services_menu_exists) {
			$bike_rental_services_menu_id = wp_create_nav_menu($bike_rental_services_menuname);

			// Home
			wp_update_nav_menu_item($bike_rental_services_menu_id, 0, array(
				'menu-item-title' => __('Home', 'bike-rental-services'),
				'menu-item-classes' => 'home',
				'menu-item-url' => home_url('/'),
				'menu-item-status' => 'publish'
			));

			// About
			$bike_rental_services_page_about = get_page_by_path('about');
			if($bike_rental_services_page_about){
				wp_update_nav_menu_item($bike_rental_services_menu_id, 0, array(
					'menu-item-title' => __('About', 'bike-rental-services'),
					'menu-item-classes' => 'about',
					'menu-item-url' => get_permalink($bike_rental_services_page_about),
					'menu-item-status' => 'publish'
				));
			}

			// Services
			$bike_rental_services_page_services = get_page_by_path('services');
			if($bike_rental_services_page_services){
				wp_update_nav_menu_item($bike_rental_services_menu_id, 0, array(
					'menu-item-title' => __('Services', 'bike-rental-services'),
					'menu-item-classes' => 'services',
					'menu-item-url' => get_permalink($bike_rental_services_page_services),
					'menu-item-status' => 'publish'
				));
			}

			// Blog
			$bike_rental_services_page_blog = get_page_by_path('blog');
			if($bike_rental_services_page_blog){
				wp_update_nav_menu_item($bike_rental_services_menu_id, 0, array(
					'menu-item-title' => __('Blog', 'bike-rental-services'),
					'menu-item-classes' => 'blog',
					'menu-item-url' => get_permalink($bike_rental_services_page_blog),
					'menu-item-status' => 'publish'
				));
			}

			// Contact Us
			$bike_rental_services_page_contact = get_page_by_path('contact');
			if($bike_rental_services_page_contact){
				wp_update_nav_menu_item($bike_rental_services_menu_id, 0, array(
					'menu-item-title' => __('Contact Us', 'bike-rental-services'),
					'menu-item-classes' => 'contact',
					'menu-item-url' => get_permalink($bike_rental_services_page_contact),
					'menu-item-status' => 'publish'
				));
			}

			// Assign menu to location if not set
			if (!has_nav_menu($bike_rental_services_menulocation)) {
				$bike_rental_services_locations = get_theme_mod('nav_menu_locations');
				$bike_rental_services_locations[$bike_rental_services_menulocation] = $bike_rental_services_menu_id; // Use $bike_rental_services_menu_id here
				set_theme_mod('nav_menu_locations', $bike_rental_services_locations);
			}
		}
	}

	public function bike_rental_services_social_menu() {

		// ------- Create Social Menu --------
		$bike_rental_services_menuname = $bike_rental_services_themename . 'Social Menu';
		$bike_rental_services_menulocation = 'social-menu';
		$bike_rental_services_menu_exists = wp_get_nav_menu_object( $bike_rental_services_menuname );

		if( !$bike_rental_services_menu_exists){
			$bike_rental_services_menu_id = wp_create_nav_menu($bike_rental_services_menuname);

			wp_update_nav_menu_item( $bike_rental_services_menu_id, 0, array(
				'menu-item-title'  => __( 'Facebook', 'bike-rental-services' ),
				'menu-item-url'    => 'https://www.facebook.com',
				'menu-item-status' => 'publish',
			) );

			wp_update_nav_menu_item( $bike_rental_services_menu_id, 0, array(
				'menu-item-title'  => __( 'Pinterest', 'bike-rental-services' ),
				'menu-item-url'    => 'https://www.pinterest.com',
				'menu-item-status' => 'publish',
			) );
	
			wp_update_nav_menu_item( $bike_rental_services_menu_id, 0, array(
				'menu-item-title'  => __( 'Twitter', 'bike-rental-services' ),
				'menu-item-url'    => 'https://www.twitter.com',
				'menu-item-status' => 'publish',
			) );
	
			wp_update_nav_menu_item( $bike_rental_services_menu_id, 0, array(
				'menu-item-title'  => __( 'Youtube', 'bike-rental-services' ),
				'menu-item-url'    => 'https://www.youtube.com',
				'menu-item-status' => 'publish',
			) );

			wp_update_nav_menu_item( $bike_rental_services_menu_id, 0, array(
				'menu-item-title'  => __( 'Instagram', 'bike-rental-services' ),
				'menu-item-url'    => 'https://www.instagram.com',
				'menu-item-status' => 'publish',
			) );

			if( !has_nav_menu( $bike_rental_services_menulocation ) ){
					$locations = get_theme_mod('nav_menu_locations');
					$locations[$bike_rental_services_menulocation] = $bike_rental_services_menu_id;
					set_theme_mod( 'nav_menu_locations', $locations );
			}
		}
	}

	/**
	* Imports the Demo Content
	* @since 1.1.0
	*/
	public function setup_widgets() {

		//................................................. MENU PAGES .................................................//
		
		$bike_rental_services_home_id='';
		$bike_rental_services_home_content = '';

		$bike_rental_services_home_title = 'Home';
		$bike_rental_services_home = array(
				'post_type' => 'page',
				'post_title' => $bike_rental_services_home_title,
				'post_content'  => $bike_rental_services_home_content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_slug' => 'home'
		);
		$bike_rental_services_home_id = wp_insert_post($bike_rental_services_home);

		//Set the home page template
		add_post_meta( $bike_rental_services_home_id, '_wp_page_template', 'revolution-home.php' );

		//Set the static front page
		$bike_rental_services_home = get_page_by_title( 'Home' );
		update_option( 'page_on_front', $bike_rental_services_home->ID );
		update_option( 'show_on_front', 'page' );


		// Create a posts page and assign the template
		$bike_rental_services_blog_title = 'Blog';
		$bike_rental_services_blog_check = get_page_by_path('blog');
		if (!$bike_rental_services_blog_check) {
			$bike_rental_services_blog = array(
				'post_type'    => 'page',
				'post_title'   => $bike_rental_services_blog_title,
				'post_status'  => 'publish',
				'post_author'  => 1,
				'post_name'    => 'blog' // Unique slug for the blog page
			);
			$bike_rental_services_blog_id = wp_insert_post($bike_rental_services_blog);

			// Set the posts page
			if (!is_wp_error($bike_rental_services_blog_id)) {
				update_option('page_for_posts', $bike_rental_services_blog_id);
			}
		}

		// Create a Contact Us page and assign the template
		$bike_rental_services_contact_title = 'Contact Us';
		$bike_rental_services_contact_check = get_page_by_path('contact');
		if (!$bike_rental_services_contact_check) {
			$bike_rental_services_contact = array(
				'post_type'    => 'page',
				'post_title'   => $bike_rental_services_contact_title,
				'post_content'   => '"More About The Free Bike Rental WordPress Theme"
										The visual design of the Free Bike Rental WordPress Theme is clean, modern, and tailored to evoke the spirit of adventure and dynamism associated with bike exploration. The layout is structured intuitively, ensuring easy navigation for users to explore available bikes, check rental details, and make bookings effortlessly. The carefully chosen color palette and imagery contribute to the overall appeal, creating an inviting digital space for bike enthusiasts. Key features of this theme include a robust booking system, allowing customers to check bike availability, choose rental durations, and make reservations seamlessly. Admins can efficiently manage bookings, set pricing, and customize availability schedules. The theme\'s responsiveness ensures a consistent and optimal user experience across devices, allowing customers to easily browse and book bikes on desktops, tablets, or smartphones.	

										A dedicated section for showcasing the bike fleet is included, complete with images, specifications, and rental details. This feature enables customers to thoroughly explore the available options. The Free Bike Rental WordPress Theme also integrates Google Maps, improving user experience by displaying rental locations, providing directions, and facilitating easy location finding for customers. Online payments are simplified with built-in payment options that support various gateways, allowing customers to make secure online payments for their reservations. Moreover, customer reviews and ratings are encouraged, building trust and credibility by showcasing positive feedback from satisfied clients. Customization options that come with this theme allow businesses to tailor the theme to align with their brand identity, including customizing colors, fonts, and layout elements for a unique and branded online presence.

										Social media integration is seamless, enabling businesses to leverage the power of social platforms. The theme integrates with various social networks, allowing businesses to share promotions, updates, and connect with their audience effectively. SEO optimization follows best practices to enhance the visibility of the bike rental business, improving search engine rankings and attracting organic traffic with optimized content and structure. The Free Bike Rental WordPress Theme is more than just a template; it\'s a comprehensive solution designed to enhance the online presence of bike rental businesses. Whether you\'re a small rental service or a large bike tour operator, the Free Bike Rental WordPress Theme provides the tools and features needed to create an engaging and efficient online platform for showcasing bikes and managing reservations.',
					'post_status'  => 'publish',
				'post_author'  => 1,
				'post_name'    => 'contact' // Unique slug for the Contact Us page
			);
			wp_insert_post($bike_rental_services_contact);
		}

		// Create a About page and assign the template
		$bike_rental_services_about_title = 'About';
		$bike_rental_services_about_check = get_page_by_path('about');
		if (!$bike_rental_services_about_check) {
			$bike_rental_services_about = array(
				'post_type'    => 'page',
				'post_title'   => $bike_rental_services_about_title,
				'post_content'   => '"More About The Free Bike Rental WordPress Theme"
										The visual design of the Free Bike Rental WordPress Theme is clean, modern, and tailored to evoke the spirit of adventure and dynamism associated with bike exploration. The layout is structured intuitively, ensuring easy navigation for users to explore available bikes, check rental details, and make bookings effortlessly. The carefully chosen color palette and imagery contribute to the overall appeal, creating an inviting digital space for bike enthusiasts. Key features of this theme include a robust booking system, allowing customers to check bike availability, choose rental durations, and make reservations seamlessly. Admins can efficiently manage bookings, set pricing, and customize availability schedules. The theme\'s responsiveness ensures a consistent and optimal user experience across devices, allowing customers to easily browse and book bikes on desktops, tablets, or smartphones.	

										A dedicated section for showcasing the bike fleet is included, complete with images, specifications, and rental details. This feature enables customers to thoroughly explore the available options. The Free Bike Rental WordPress Theme also integrates Google Maps, improving user experience by displaying rental locations, providing directions, and facilitating easy location finding for customers. Online payments are simplified with built-in payment options that support various gateways, allowing customers to make secure online payments for their reservations. Moreover, customer reviews and ratings are encouraged, building trust and credibility by showcasing positive feedback from satisfied clients. Customization options that come with this theme allow businesses to tailor the theme to align with their brand identity, including customizing colors, fonts, and layout elements for a unique and branded online presence.

										Social media integration is seamless, enabling businesses to leverage the power of social platforms. The theme integrates with various social networks, allowing businesses to share promotions, updates, and connect with their audience effectively. SEO optimization follows best practices to enhance the visibility of the bike rental business, improving search engine rankings and attracting organic traffic with optimized content and structure. The Free Bike Rental WordPress Theme is more than just a template; it\'s a comprehensive solution designed to enhance the online presence of bike rental businesses. Whether you\'re a small rental service or a large bike tour operator, the Free Bike Rental WordPress Theme provides the tools and features needed to create an engaging and efficient online platform for showcasing bikes and managing reservations.',
					'post_status'  => 'publish',
				'post_author'  => 1,
				'post_name'    => 'about' // Unique slug for the About page
			);
			wp_insert_post($bike_rental_services_about);
		}

		// Create a Services page and assign the template
		$bike_rental_services_services_title = 'Services';
		$bike_rental_services_services_check = get_page_by_path('services');
		if (!$bike_rental_services_services_check) {
			$bike_rental_services_services = array(
				'post_type'    => 'page',
				'post_title'   => $bike_rental_services_services_title,
				'post_content'   => '"More About The Free Bike Rental WordPress Theme"
										The visual design of the Free Bike Rental WordPress Theme is clean, modern, and tailored to evoke the spirit of adventure and dynamism associated with bike exploration. The layout is structured intuitively, ensuring easy navigation for users to explore available bikes, check rental details, and make bookings effortlessly. The carefully chosen color palette and imagery contribute to the overall appeal, creating an inviting digital space for bike enthusiasts. Key features of this theme include a robust booking system, allowing customers to check bike availability, choose rental durations, and make reservations seamlessly. Admins can efficiently manage bookings, set pricing, and customize availability schedules. The theme\'s responsiveness ensures a consistent and optimal user experience across devices, allowing customers to easily browse and book bikes on desktops, tablets, or smartphones.	

										A dedicated section for showcasing the bike fleet is included, complete with images, specifications, and rental details. This feature enables customers to thoroughly explore the available options. The Free Bike Rental WordPress Theme also integrates Google Maps, improving user experience by displaying rental locations, providing directions, and facilitating easy location finding for customers. Online payments are simplified with built-in payment options that support various gateways, allowing customers to make secure online payments for their reservations. Moreover, customer reviews and ratings are encouraged, building trust and credibility by showcasing positive feedback from satisfied clients. Customization options that come with this theme allow businesses to tailor the theme to align with their brand identity, including customizing colors, fonts, and layout elements for a unique and branded online presence.

										Social media integration is seamless, enabling businesses to leverage the power of social platforms. The theme integrates with various social networks, allowing businesses to share promotions, updates, and connect with their audience effectively. SEO optimization follows best practices to enhance the visibility of the bike rental business, improving search engine rankings and attracting organic traffic with optimized content and structure. The Free Bike Rental WordPress Theme is more than just a template; it\'s a comprehensive solution designed to enhance the online presence of bike rental businesses. Whether you\'re a small rental service or a large bike tour operator, the Free Bike Rental WordPress Theme provides the tools and features needed to create an engaging and efficient online platform for showcasing bikes and managing reservations.',
					'post_status'  => 'publish',
				'post_author'  => 1,
				'post_name'    => 'services' // Unique slug for the Services page
			);
			wp_insert_post($bike_rental_services_services);
		}


		// ------------------------------------------ Header -------------------------------------- //

			set_theme_mod('bike_rental_services_phone_number_text','PHONE');
			set_theme_mod('bike_rental_services_phone_number_option','+00 123 456 7890');

			set_theme_mod('bike_rental_services_mail_address_text','EMAIL');
			set_theme_mod('bike_rental_services_mail_address_option','xyz123@example.com');

			set_theme_mod('bike_rental_services_header_button_text','SELL YOUR CAR');
			set_theme_mod('bike_rental_services_header_button_link','#');


		// ------------------------------------------ Slider Section -------------------------------------- //

			set_theme_mod('bike_rental_services_enable_slider',1);
			set_theme_mod('bike_rental_services_enable_featured_bike',1);

			for($i=1;$i<=3;$i++){
				set_theme_mod( 'bike_rental_services_slider_image'.$i,get_template_directory_uri().'/revolution/assets/images/slider'.$i.'.png' );
				set_theme_mod( 'bike_rental_services_slider_xtra_heading'.$i, 'FIND YOUR DREAM BIKE' );
				set_theme_mod( 'bike_rental_services_slider_heading'.$i, 'ULTRAVIOLETTE F77' );
				set_theme_mod( 'bike_rental_services_slider_text'.$i, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.' );
				set_theme_mod( 'bike_rental_services_slider_button1_text'.$i, 'LEARN MORE' );
				set_theme_mod( 'bike_rental_services_slider_button1_link'.$i, '#' );
			}

		// ------------------------------------------ Popular Section -------------------------------------- //

			set_theme_mod('bike_rental_services_feature_short_heading','Most Popular');
			set_theme_mod('bike_rental_services_feature_heading','MOST POPULAR FEATURED BIKE SPECIAL OFFERS');

			set_theme_mod('bike_rental_services_feature_bike_box_tab_count','6');
			$bike_rental_services_bike_headings = array(
				'Yamaha FZ-S FI V3',
				'Bajaj Pulsar NS200',
				'KTM Duke 200',
				'Suzuki Gixxer SF',
				'Hero Xtreme 160R',
				'TVS Apache RR 310'
			);

			for ($i = 1; $i <= 6; $i++) {
				set_theme_mod( 'bike_rental_services_feature_bike_image_tab' . $i, get_template_directory_uri() . '/revolution/assets/images/bikes' . $i . '.png' );
				set_theme_mod( 'bike_rental_services_feature_bike_box_heading_tab' . $i, $bike_rental_services_bike_headings[$i - 1] );
				set_theme_mod( 'bike_rental_services_feature_bike_box_content_tab' . $i, 'Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
					Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.' );
				set_theme_mod( 'bike_rental_services_tab_button_text' . $i, 'LEARN MORE' );
				set_theme_mod( 'bike_rental_services_tab_button_link' . $i, '#' );
			}


  	 	$this->bike_rental_services_customizer_nav_menu();
		$this->bike_rental_services_social_menu();
	}

	public function bike_rental_services_guide() {
		$display_string = '';
		$return = add_query_arg( array()) ;
		$theme = wp_get_theme( 'bike-rental-services' );
		?>
		<div class="wrapper-info get-stared-page-wrap">
			<div class="wrapper-info-content">
				<div class="buynow__">
					<h2><?php esc_html_e( 'Welcome to Bike Rental Services', 'bike-rental-services' ); ?> <span class="version">Version: <?php echo esc_html($theme['Version']);?></span></h2>
					<p><?php esc_html_e('The quick setup wizard will assist you in configuring your new website. This wizard will import the demo content.', 'bike-rental-services'); ?></p>
				</div>
				<div class="buynow_">
					<a target="_blank" class="buynow_themepage" href="<?php echo esc_url('https://www.revolutionwp.com/products/bike-shop-WordPress-theme'); ?>"><?php echo esc_html__('Go Premium Now', 'bike-rental-services'); ?></a>
				</div>
			</div>
			<div class="tab-sec theme-option-tab">
				<div id="demo_offer" class="tabcontent open">
					<?php $this->wizard_page(); ?>
				</div>
			</div>
		</div>
	<?php }
}
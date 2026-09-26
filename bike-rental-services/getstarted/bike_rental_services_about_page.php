<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'Bike_Rental_Services_Welcome' ) ) {

	class Bike_Rental_Services_Welcome {
		public $theme_fields;

		public function __construct( $fields = array() ) {
			$this->theme_fields = $fields;
			add_action ('admin_init' , array( $this, 'admin_scripts' ) );
			add_action('admin_menu', array( $this, 'bike_rental_services_getstart_page_menu' ));
		}

		public function admin_scripts() {
			global $pagenow;
			$file_dir = get_template_directory_uri() . '/getstarted/assets/';

			if ( $pagenow === 'themes.php' && isset($_GET['page']) && $_GET['page'] === 'bike-rental-services-getstart-page' ) {

				wp_enqueue_style (
					'bike-rental-services-getstart-page-style',
					$file_dir . 'css/getstart-page.css',
					array(), '1.0.0'
				);

				wp_enqueue_script (
					'bike-rental-services-getstart-page-functions',
					$file_dir . 'js/getstart-page.js',
					array('jquery'),
					'1.0.0',
					true
				);
			}
		}

        public function theme_info($id, $bike_rental_services_screenshot = false) {
            $themedata = wp_get_theme();
            return ($bike_rental_services_screenshot === true) ? esc_url($themedata->get_screenshot()) : esc_html($themedata->get($id));
        }

        public function bike_rental_services_getstart_page_menu() {
            add_theme_page(
                /* translators: 1: Theme Name. */
                sprintf(esc_html__('About %1$s', 'bike-rental-services'), $this->theme_info('Name')),
                sprintf(esc_html__('About %1$s', 'bike-rental-services'), $this->theme_info('Name')),
                'edit_theme_options',
                'bike-rental-services-getstart-page',
                array( $this, 'bike_rental_services_getstart_page' )
            );
		}

        public function bike_rental_services_getstart_page() {
            $bike_rental_services_tabs = array(
                'bike_rental_services_getting_started' => esc_html__('Getting Started', 'bike-rental-services'),
                'bike_rental_services_free_pro' => esc_html__('Free VS Pro', 'bike-rental-services'),
                'changelog' => esc_html__('Changelog', 'bike-rental-services'),
                'support' => esc_html__('Support', 'bike-rental-services'),
                'review' => esc_html__('Rate & Review', 'bike-rental-services'),
            );
            ?>
                <div class="wrap about-wrap access-wrap">

                    <div class="abt-promo-wrap clearfix">
                        <div class="abt-theme-wrap">
                            <h1>
                                <?php
                                printf(
                                    /* translators: 1: Theme Name. */
                                    esc_html__('Welcome to %1$s - Version %2$s', 'bike-rental-services'),
                                    esc_html($this->theme_info('Name')),
                                    esc_html($this->theme_info('Version'))
                                );
                                ?>
                            </h1>
                            <div class="buttons">
                                <a target="_blank" href="<?php echo esc_url('https://www.revolutionwp.com/products/bike-shop-WordPress-theme'); ?>"><?php echo esc_html__('Buy Pro Theme', 'bike-rental-services'); ?></a>
                                <a target="_blank" href="<?php echo esc_url('https://demo.revolutionwp.com/bike-rental-services-pro/'); ?>"><?php echo esc_html__('Preview Pro Version', 'bike-rental-services'); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="nav-tab-wrapper clearfix">
                        <?php
                            $tabHTML = '';

                            foreach ($bike_rental_services_tabs as $id => $label) :

                                $bike_rental_services_target = '';
                                $bike_rental_services_nav_class = 'nav-tab';
                                $bike_rental_services_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : 'bike_rental_services_getting_started';

                                if ($id === $bike_rental_services_section) {
                                    $bike_rental_services_nav_class .= ' nav-tab-active';
                                }

                                if ($id === 'bike_rental_services_free_pro') {
                                    $bike_rental_services_nav_class .= ' upgrade-button';
                                }

                                switch ($id) {

                                    case 'support':
                                        $bike_rental_services_target = 'target="_blank"';
                                        $bike_rental_services_url = esc_url('https://WordPress.org/support/theme/' . esc_html($this->theme_info('TextDomain')));
                                    break;

                                    case 'review':
                                        $bike_rental_services_target = 'target="_blank"';
                                        $bike_rental_services_url = esc_url('https://WordPress.org/support/theme/' . esc_html($this->theme_info('TextDomain')) . '/reviews/#new-post');
                                    break;
                                    
                                    case 'bike_rental_services_getting_started':
                                        $bike_rental_services_url = esc_url(admin_url('themes.php?page=bike-rental-services-getstart-page'));
                                    break;

                                    default:
                                        $bike_rental_services_url = esc_url(admin_url('themes.php?page=bike-rental-services-getstart-page&section=' . esc_attr($id)));
                                    break;

                                }

                                $tabHTML .= '<a ';
                                $tabHTML .= $bike_rental_services_target;
                                $tabHTML .= ' href="' . $bike_rental_services_url . '"';
                                $tabHTML .= ' class="' . esc_attr($bike_rental_services_nav_class) . '"';
                                $tabHTML .= '>';
                                $tabHTML .= esc_html($label);
                                $tabHTML .= '</a>';

                            endforeach;

                            echo $tabHTML;
                        ?>
                    </div>

                    <div class="getstart-section-wrapper">
                        <div class="getstart-section bike_rental_services_getting_started clearfix">
                            <?php
                                $bike_rental_services_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : 'bike_rental_services_getting_started';
                                switch ($bike_rental_services_section) {

                                    case 'bike_rental_services_free_pro':
                                        $this->bike_rental_services_free_pro();
                                    break;

                                    case 'changelog':
                                        $this->changelog();
                                    break;

                                    case 'bike_rental_services_getting_started':
                                    default:
                                        $this->bike_rental_services_getting_started();
                                    break;

                                }
                            ?>
                        </div>
                    </div>

                </div>
            <?php
		}

        public function bike_rental_services_getting_started() {
            ?>
            <div class="getting-started-top-wrap clearfix">
                <div class="theme-details">
                    <div class="theme-screenshot">
                        <img src="<?php echo esc_url( $this->theme_info( 'Screenshot', true ) ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'bike-rental-services' ); ?>"/>
                    </div>
                    <div class="about-text"><?php echo esc_html( $this->theme_info( 'Description' ) ); ?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="theme-steps-list">
                    <div class="theme-steps demo-import">
                        <h3><?php echo esc_html__( 'One Click Demo Import', 'bike-rental-services' ); ?></h3>
                        <p><?php echo esc_html__( 'Easily set up your website with our One Click Demo Import feature. This functionality allows you to replicate our demo site with just a single click, ensuring you have a fully functional layout to start from. Whether you’re a beginner or an experienced developer, this tool simplifies the setup process, saving you time and effort.', 'bike-rental-services' ); ?></p>
                        <a target="_blank" class="button button-primary" href="<?php echo esc_url( admin_url( 'themes.php?page=bikerentalservices-demoimport' ) ); ?>"><?php echo esc_html__( 'Click Here For Demo Import', 'bike-rental-services' ); ?></a>
                    </div>
                    <div class="getstart">
                        <div class="theme-steps">
                            <h3><?php echo esc_html__( 'Documentation', 'bike-rental-services' ); ?></h3>
                            <p><?php echo esc_html__( 'Need more details? Check our comprehensive documentation for step-by-step guidance on using the Bike Rental Services Theme.', 'bike-rental-services' ); ?></p>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://demo.revolutionwp.com/wpdocs/bike-rental-services-free/' ); ?>"><?php echo esc_html__( 'Go to Free Docs', 'bike-rental-services' ); ?></a>
                        </div>

                        <div class="theme-steps">
                            <h3><?php echo esc_html__( 'Preview Pro Theme', 'bike-rental-services' ); ?></h3>
                            <p><?php echo esc_html__( 'Discover the full potential of our Pro Theme! Click the Live Demo button to experience premium features and beautiful designs.', 'bike-rental-services' ); ?></p>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://demo.revolutionwp.com/bike-rental-services-pro/' ); ?>"><?php echo esc_html__( 'Live Demo', 'bike-rental-services' ); ?></a>
                        </div>

                        <div class="theme-steps highlight">
                            <h3><?php echo esc_html__( 'Buy Bike Rental Services Pro', 'bike-rental-services' ); ?></h3>
                            <p><?php echo esc_html__( 'Unlock unlimited features and enhancements by purchasing the Pro version of Bike Rental Services Theme.', 'bike-rental-services' ); ?></p>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://www.revolutionwp.com/products/bike-shop-WordPress-theme' ); ?>"><?php echo esc_html__( 'Buy Pro Version @$39', 'bike-rental-services' ); ?></a>
                        </div>

                        <div class="theme-steps highlight">
                            <h3><?php echo esc_html__( 'Get the Bundle', 'bike-rental-services' ); ?></h3>
                            <p><?php echo esc_html__( 'The WordPress Theme Bundle is a comprehensive collection of all premium themes, offering everything you need to create stunning, professional websites with ease.', 'bike-rental-services' ); ?></p>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url( 'https://www.revolutionwp.com/products/WordPress-theme-bundle' ); ?>"><?php echo esc_html__( 'Get Bundle', 'bike-rental-services' ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

		public function bike_rental_services_free_pro() {
            ?>
            <table class="card table free-pro" cellspacing="0" cellpadding="0">
                <tbody class="table-body">
                    <tr class="table-head">
                        <th class="large"><?php echo esc_html__( 'Features', 'bike-rental-services' ); ?></th>
                        <th class="indicator"><?php echo esc_html__( 'Free theme', 'bike-rental-services' ); ?></th>
                        <th class="indicator"><?php echo esc_html__( 'Pro Theme', 'bike-rental-services' ); ?></th>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'One Click Demo Import', 'bike-rental-services' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'After the activation of Bike Rental Services theme, all settings will be imported and Data Import.', 'bike-rental-services' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Responsive Design', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Site Logo upload', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Footer Copyright text', 'bike-rental-services' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'Remove the copyright text from the Footer.', 'bike-rental-services' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Global Color', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Regular Bug Fixes', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Theme Sections', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="abc"><?php echo esc_html__( '2 Sections', 'bike-rental-services' ); ?></span></td>
                        <td class="indicator"><span class="abc"><?php echo esc_html__( '15+ Sections', 'bike-rental-services' ); ?></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Custom colors', 'bike-rental-services' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'Choose a color for links, buttons, icons and so on.', 'bike-rental-services' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Google fonts', 'bike-rental-services' ); ?></h4>
                                <div class="feature-inline-row">
                                    <span class="info-icon dashicon dashicons dashicons-info"></span>
                                    <span class="feature-description">
                                        <?php echo esc_html__( 'You can choose and use over 600 different fonts, for the logo, the menu and the titles.', 'bike-rental-services' ); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Enhanced Plugin Integration', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Fully SEO Optimized', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Premium Support', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Extensive Customization', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'Custom Post Types', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="feature-row">
                        <td class="large">
                            <div class="feature-wrap">
                                <h4><?php echo esc_html__( 'High-Level Compatibility with Modern Browsers', 'bike-rental-services' ); ?></h4>
                            </div>
                        </td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                        <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                    </tr>

                    <tr class="upsell-row">
                        <td></td>
                        <td><span class="abc"><?php echo esc_html__( 'Try Out Our Premium Version', 'bike-rental-services' ); ?></span></td>
                        <td>
                            <a target="_blank" href="<?php echo esc_url( 'https://www.revolutionwp.com/products/bike-shop-WordPress-theme' ); ?>" class="button button-primary"><?php echo esc_html__( 'Buy Pro Theme', 'bike-rental-services' ); ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
        }

		public function changelog() {
            if ( is_file( trailingslashit( get_stylesheet_directory() ) . '/getstarted/bike_rental_services_changelog.php' ) ) {
                require_once( trailingslashit( get_stylesheet_directory() ) . '/getstarted/bike_rental_services_changelog.php' );
            } else {
                require_once( trailingslashit( get_template_directory() ) . '/getstarted/bike_rental_services_changelog.php' );
            }
        }
	}

}
new Bike_Rental_Services_Welcome();
?>
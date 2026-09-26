<?php
/**
 * The header for our theme
 *
 * @package Bike Rental Services
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'bike-rental-services' ); ?></a>

	<?php
		$bike_rental_services_preloader_wrap = absint(get_theme_mod('bike_rental_services_enable_preloader', 0));
		if($bike_rental_services_preloader_wrap == 1){ ?>
			<div id="loader">
				<div class="loader-container">
					<div id="preloader" class="loader-2">
						<div class="dot"></div>
					</div>
				</div>
			</div>
	<?php } ?>

	<header id="masthead" class="site-header">
		<?php $bike_rental_services_has_header_image = has_header_image(); ?>
		<div class="header-info-box" <?php if (!empty($bike_rental_services_has_header_image)) { ?> style="background-image: url(<?php echo header_image(); ?>);" <?php } ?> >
			<div class="header-top">
				<div class="main-header-wrap">
				<div class="top-box">
					<div class="container">
						<div class="flex-row">
							<div class="nav-box-header-one">
								<div class="site-branding">
									<?php
									the_custom_logo();
									if ( is_front_page() && is_home() ) :
										?>
										<?php if( get_theme_mod('bike_rental_services_site_title_text',true)){ ?>
											<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
										<?php } ?>
										<?php
									else :
										?>
										<?php if( get_theme_mod('bike_rental_services_site_title_text',true)){ ?>
											<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
										<?php } ?>
										<?php
									endif; ?>
									<?php $bike_rental_services_description = get_bloginfo( 'description', 'display' );
										if ( $bike_rental_services_description || is_customize_preview() ) :
										?>
										<?php if( get_theme_mod('bike_rental_services_site_tagline_text',false)){ ?>
											<p class="site-description"><?php echo $bike_rental_services_description; ?></p>
										<?php } ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="nav-box-header-two">
								<div class="phone-box flex-row">
									<?php if ( get_theme_mod('bike_rental_services_phone_number_option','+00 123 456 7890') ) : ?><div class="phone-icon"><i class="<?php echo esc_attr(get_theme_mod('bike_rental_services_header_phone_icon','fas fa-phone-alt')); ?>"></i></div><div class="phone-content"><h6><?php echo esc_html(get_theme_mod('bike_rental_services_phone_number_text', 'PHONE')); ?></h6><p><?php echo esc_html(get_theme_mod('bike_rental_services_phone_number_option', '+00 123 456 7890')); ?></p></div><?php endif; ?>
								</div>	
							</div>
							<div class="nav-box-header-three">
								<div class="phone-box flex-row">
									<?php if ( get_theme_mod('bike_rental_services_mail_address_option','xyz123@example.com') ) : ?><div class="phone-icon"><i class="<?php echo esc_attr(get_theme_mod('bike_rental_services_header_mail_icon','fas fa-envelope-open-text')); ?>"></i></div><div class="phone-content"><h6><?php echo esc_html(get_theme_mod('bike_rental_services_mail_address_text', 'EMAIL')); ?></h6><p><?php echo esc_html(get_theme_mod('bike_rental_services_mail_address_option', 'xyz123@example.com')); ?></p></div><?php endif; ?>
								</div>
							</div>
							<div class="nav-box-header-four">
								<div class="header-button">
									<?php if ( get_theme_mod('bike_rental_services_header_button_link','#') ||  get_theme_mod('bike_rental_services_header_button_text','SELL YOUR CAR' )) : ?><a href="<?php echo esc_url( get_theme_mod('bike_rental_services_header_button_link','#') ); ?>"><?php echo esc_html( get_theme_mod('bike_rental_services_header_button_text','SELL YOUR CAR') ); ?></a><?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header-menu-box">
				<div class="container <?php echo esc_attr( get_theme_mod( 'bike_rental_services_enable_sticky_header', false ) ? 'sticky-header' : '' ); ?>">
					<div class="flex-row menu-bg">
						<div class="nav-box-header-left">
							<nav id="site-navigation" class="main-navigation">
								<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
								<?php
									wp_nav_menu(
										array(
											'theme_location' => 'menu-1',
											'menu_id'        => 'primary-menu',
										)
									);
								?>
							</nav>
						</div>
						<div class="nav-box-header-right">
							<div class="header-admin">
								<span><?php 
						            $get_author_id = get_the_author_meta('ID');
						            echo get_avatar( get_the_author_meta('ID') );
						        ?></span>
							</div>
							<?php if( get_theme_mod( 'bike_rental_services_header_search',true) == 1) { ?>
						        <div class="search-box">
			                      <span><a href="#"><i class="fas fa-search"></i></a></span>
			                    </div>
					        <?php }?>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="serach_outer">
          <div class="closepop"><a href="#maincontent"><i class="fa fa-window-close"></i></a></div>
          <div class="serach_inner">
            <?php get_search_form(); ?>
          </div>
        </div>
	</header>
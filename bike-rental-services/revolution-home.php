<?php
/**
 * Template Name: Home Page
 */

get_header();
?>

<main id="primary">

    <?php 
    $bike_rental_services_main_slider_wrap = absint(get_theme_mod('bike_rental_services_enable_slider', 0));
    if($bike_rental_services_main_slider_wrap == 1){ 
    ?>
    <div class="slider-bg">
       <section id="main-slider-wrap">
        <div class="owl-carousel">
            <?php for ($bike_rental_services_i=1; $bike_rental_services_i <= 3; $bike_rental_services_i++) { ?>
                <div class="main-slider-inner-box">
                    <?php if ( get_theme_mod('bike_rental_services_slider_image'.$bike_rental_services_i) ) : ?>
                        <img src="<?php echo esc_url( get_theme_mod('bike_rental_services_slider_image'.$bike_rental_services_i) ); ?>">
                        <div class="main-slider-content-box">
                            <?php if ( get_theme_mod('bike_rental_services_slider_xtra_heading'.$bike_rental_services_i) ) : ?><h6><?php echo esc_html( get_theme_mod('bike_rental_services_slider_xtra_heading'.$bike_rental_services_i) ); ?></h6><?php endif; ?>
                            <?php if ( get_theme_mod('bike_rental_services_slider_heading'.$bike_rental_services_i) ) : ?><h3><?php echo esc_html( get_theme_mod('bike_rental_services_slider_heading'.$bike_rental_services_i) ); ?></h3><?php endif; ?>
                            <?php if ( get_theme_mod('bike_rental_services_slider_text'.$bike_rental_services_i) ) : ?><p><?php echo esc_html( get_theme_mod('bike_rental_services_slider_text'.$bike_rental_services_i) ); ?></p><?php endif; ?>
                            <div class="main-slider-button">
                                <?php if ( get_theme_mod('bike_rental_services_slider_button1_link'.$bike_rental_services_i) ||  get_theme_mod('bike_rental_services_slider_button1_text'.$bike_rental_services_i )) : ?><a href="<?php echo esc_url( get_theme_mod('bike_rental_services_slider_button1_link'.$bike_rental_services_i) ); ?>"><?php echo esc_html( get_theme_mod('bike_rental_services_slider_button1_text'.$bike_rental_services_i) ); ?></a><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>
    </section> 
    </div>
    <?php } ?>
    <?php 
    $bike_rental_services_main_expert_wrap = absint(get_theme_mod('bike_rental_services_enable_featured_bike', 0));
    $bike_rental_services_count = get_theme_mod('bike_rental_services_feature_bike_box_tab_count') !== '' ? get_theme_mod('bike_rental_services_feature_bike_box_tab_count') : 6;
    if($bike_rental_services_main_expert_wrap == 1){ 
    ?>

<section id="main-expert-wrap">
    <div class="container">
        <div class="feature-left">
                <?php if ( get_theme_mod('bike_rental_services_feature_short_heading') ) : ?><h5><?php echo esc_html( get_theme_mod('bike_rental_services_feature_short_heading') ); ?></h5><?php endif; ?>
                <?php if ( get_theme_mod('bike_rental_services_feature_heading') ) : ?><h3><?php echo esc_html( get_theme_mod('bike_rental_services_feature_heading') ); ?></h3><hr><?php endif; ?>
            </div>
        <div class="tabs">
            <?php 
            for ($bike_rental_services_i=1; $bike_rental_services_i <=$bike_rental_services_count; $bike_rental_services_i++) { 
                if ( get_theme_mod('bike_rental_services_feature_bike_image_tab'.$bike_rental_services_i) ) { ?>
                    <div class="tab" data-tab="tab<?php echo $bike_rental_services_i;?>"><img src="<?php echo esc_url( get_theme_mod('bike_rental_services_feature_bike_image_tab'.$bike_rental_services_i) ); ?>"></div>
                <?php }
            } ?>
        </div>
        <div class="content-box">
            <?php 
            for ($bike_rental_services_i=1; $bike_rental_services_i <=$bike_rental_services_count; $bike_rental_services_i++) { ?>
                <div id="tab<?php echo $bike_rental_services_i;?>" class="content <?php echo $bike_rental_services_i > 1 ? 'hidden' : ''; ?>"> 
                    <div class="tab-content mt-4">
                        <div class="tab-partition">
                            <div class="tab-left">
                                <div class="box-content">
                                    <?php if ( get_theme_mod('bike_rental_services_feature_bike_box_heading_tab'.$bike_rental_services_i) ) : ?><h4><?php echo esc_html( get_theme_mod('bike_rental_services_feature_bike_box_heading_tab'.$bike_rental_services_i) ); ?></h4><?php endif; ?>
                                    <?php if ( get_theme_mod('bike_rental_services_feature_bike_box_content_tab'.$bike_rental_services_i) ) : ?><p><?php echo esc_html( get_theme_mod('bike_rental_services_feature_bike_box_content_tab'.$bike_rental_services_i) ); ?></p><?php endif; ?>
                                    <div class="tab-button">
                                        <?php if ( get_theme_mod('bike_rental_services_tab_button_link'.$bike_rental_services_i) ||  get_theme_mod('bike_rental_services_tab_button_text'.$bike_rental_services_i )) : ?><a href="<?php echo esc_url( get_theme_mod('bike_rental_services_tab_button_link'.$bike_rental_services_i) ); ?>"><?php echo esc_html( get_theme_mod('bike_rental_services_tab_button_text'.$bike_rental_services_i) ); ?></a><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-right">
                                <?php if ( get_theme_mod('bike_rental_services_feature_bike_image_tab'.$bike_rental_services_i) ) : ?><img src="<?php echo esc_url( get_theme_mod('bike_rental_services_feature_bike_image_tab'.$bike_rental_services_i) ); ?>"><?php endif; ?>
                            </div> 
                        </div>
                    </div> 
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php } ?>
    
</main>

<?php
get_footer();
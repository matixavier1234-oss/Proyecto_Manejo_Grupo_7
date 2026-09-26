<?php
/**
 * Bike Rental Services Theme Customizer
 *
 * @package Bike Rental Services
 */

function bike_rental_services_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . 'revolution/inc/fontawesome-change.php' );

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'bike_rental_services_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'bike_rental_services_customize_partial_blogdescription',
			)
		);
	}

	/* WooCommerce custom settings */

	$wp_customize->add_section('woocommerce_custom_settings', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('WooCommerce Custom Settings', 'bike-rental-services'),
		'panel'       => 'woocommerce',
	));

	$wp_customize->add_setting(
		'bike_rental_services_per_columns',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_per_columns',
		array(
			'label'       => __('Product Per Single Row', 'bike-rental-services'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 4,
	             'step' => 1,
	         ),
		)
	);

	$wp_customize->add_setting(
		'bike_rental_services_product_per_page',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '6',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_product_per_page',
		array(
			'label'       => __('Product Per One Page', 'bike-rental-services'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 12,
	             'step' => 1,
	         ),
		)
	);

	/*Related Products Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_related_product',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_related_product',
		array(
			'label'       => __('Enable Related Product', 'bike-rental-services'),
			'description' => __('Checked to show Related Product', 'bike-rental-services'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'custom_related_products_number',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'custom_related_products_number',
		array(
			'label'       => __('Related Product Count', 'bike-rental-services'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 20,
	             'step' => 1,
	         ),
		)
	);

	$wp_customize->add_setting(
		'custom_related_products_number_per_row',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'custom_related_products_number_per_row',
		array(
			'label'       => __('Related Product Per Row', 'bike-rental-services'),
			'section'     => 'woocommerce_custom_settings',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 4,
	             'step' => 1,
	         ),
		)
	);

	/*Archive Product layout*/
	$wp_customize->add_setting('bike_rental_services_archive_product_layout',array(
        'default' => 'layout-1',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
	));
	$wp_customize->add_control('bike_rental_services_archive_product_layout',array(
        'type' => 'select',
        'label' => esc_html__('Archive Product Layout','bike-rental-services'),
        'section' => 'woocommerce_custom_settings',
        'choices' => array(
            'layout-1' => esc_html__('Sidebar On Right','bike-rental-services'),
            'layout-2' => esc_html__('Sidebar On Left','bike-rental-services'),
			'layout-3' => esc_html__('Full Width Layout','bike-rental-services')
        ),
	) );

	/*Single Product layout*/
	$wp_customize->add_setting('bike_rental_services_single_product_layout',array(
        'default' => 'layout-1',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
	));
	$wp_customize->add_control('bike_rental_services_single_product_layout',array(
        'type' => 'select',
        'label' => esc_html__('Single Product Layout','bike-rental-services'),
        'section' => 'woocommerce_custom_settings',
        'choices' => array(
            'layout-1' => esc_html__('Sidebar On Right','bike-rental-services'),
            'layout-2' => esc_html__('Sidebar On Left','bike-rental-services'),
			'layout-3' => esc_html__('Full Width Layout','bike-rental-services')
        ),
	) );

	$wp_customize->add_setting('bike_rental_services_woocommerce_product_sale',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
        'default'           => 'Right',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
    ));
    $wp_customize->add_control('bike_rental_services_woocommerce_product_sale',array(
        'label'       => esc_html__( 'Woocommerce Product Sale Positions','bike-rental-services' ),
        'type' => 'select',
        'section' => 'woocommerce_custom_settings',
        'choices' => array(
            'Right' => __('Right','bike-rental-services'),
            'Left' => __('Left','bike-rental-services'),
            'Center' => __('Center','bike-rental-services')
        ),
    ) );

	/*
    * Theme Options Panel
    */
	$wp_customize->add_panel('bike_rental_services_panel', array(
		'priority' => 25,
		'capability' => 'edit_theme_options',
		'title' => __('Bike Rental Services Theme Options', 'bike-rental-services'),
	));

	/*Additional Options*/
	$wp_customize->add_section('bike_rental_services_additional_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Additional Options', 'bike-rental-services'),
		'panel'       => 'bike_rental_services_panel',
	));

	/*Main Slider Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_sticky_header',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => false,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_sticky_header',
		array(
			'label'       => __('Enable Sticky Header', 'bike-rental-services'),
			'description' => __('Checked to enable sticky header', 'bike-rental-services'),
			'section'     => 'bike_rental_services_additional_section',
			'type'        => 'checkbox',
		)
	);

	/*Main Slider Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_preloader',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 0,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_preloader',
		array(
			'label'       => __('Enable Preloader', 'bike-rental-services'),
			'description' => __('Checked to show preloader', 'bike-rental-services'),
			'section'     => 'bike_rental_services_additional_section',
			'type'        => 'checkbox',
		)
	);

	/*Breadcrumbs Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_breadcrumbs',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_breadcrumbs',
		array(
			'label'       => __('Enable Breadcrumbs', 'bike-rental-services'),
			'description' => __('Checked to show Breadcrumbs', 'bike-rental-services'),
			'section'     => 'bike_rental_services_additional_section',
			'type'        => 'checkbox',
		)
	);

	/*Pagination Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_pagination',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_pagination',
		array(
			'label'       => __('Enable Pagination', 'bike-rental-services'),
			'description' => __('Checked to show Pagination', 'bike-rental-services'),
			'section'     => 'bike_rental_services_additional_section',
			'type'        => 'checkbox',
		)
	);

	/*Pagination Select Type Option*/
	$wp_customize->add_setting('bike_rental_services_pagination_type',array(
        'default' => 'type-1',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
	));
	$wp_customize->add_control('bike_rental_services_pagination_type',array(
        'type' => 'select',
        'label' => esc_html__('Select Pagination Type','bike-rental-services'),
        'section' => 'bike_rental_services_additional_section',
        'choices' => array(
            'type-1' => esc_html__('Type 1','bike-rental-services'),
            'type-2' => esc_html__('Type 2','bike-rental-services'),
        ),
	) );

	/*Post layout*/
	$wp_customize->add_setting('bike_rental_services_archive_layout',array(
        'default' => 'layout-1',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
	));
	$wp_customize->add_control('bike_rental_services_archive_layout',array(
        'type' => 'select',
        'label' => esc_html__('Post Layout','bike-rental-services'),
        'section' => 'bike_rental_services_additional_section',
        'choices' => array(
            'layout-1' => esc_html__('Sidebar On Right','bike-rental-services'),
            'layout-2' => esc_html__('Sidebar On Left','bike-rental-services'),
			'layout-3' => esc_html__('Full Width Layout','bike-rental-services')
        ),
	) );

	/*single post layout*/
	$wp_customize->add_setting('bike_rental_services_post_layout',array(
        'default' => 'layout-1',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
	));
	$wp_customize->add_control('bike_rental_services_post_layout',array(
        'type' => 'select',
        'label' => esc_html__('Single Post Layout','bike-rental-services'),
        'section' => 'bike_rental_services_additional_section',
        'choices' => array(
            'layout-1' => esc_html__('Sidebar On Right','bike-rental-services'),
            'layout-2' => esc_html__('Sidebar On Left','bike-rental-services'),
			'layout-3' => esc_html__('Full Width Layout','bike-rental-services')
        ),
	) );

	/*single page layout*/
	$wp_customize->add_setting('bike_rental_services_page_layout',array(
        'default' => 'layout-1',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
	));
	$wp_customize->add_control('bike_rental_services_page_layout',array(
        'type' => 'select',
        'label' => esc_html__('Single Page Layout','bike-rental-services'),
        'section' => 'bike_rental_services_additional_section',
        'choices' => array(
            'layout-1' => esc_html__('Sidebar On Right','bike-rental-services'),
            'layout-2' => esc_html__('Sidebar On Left','bike-rental-services'),
			'layout-3' => esc_html__('Full Width Layout','bike-rental-services')
        ),
	) );

	/*Archive Post Options*/
	$wp_customize->add_section('bike_rental_services_blog_post_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Blog Page Options', 'bike-rental-services'),
		'panel'       => 'bike_rental_services_panel',
	));

	$wp_customize->add_setting('bike_rental_services_enable_blog_post_title',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_blog_post_title',array(
		'label'       => __('Enable Blog Post Title', 'bike-rental-services'),
		'description' => __('Checked To Show Blog Post Title', 'bike-rental-services'),
		'section'     => 'bike_rental_services_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_blog_post_meta',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_blog_post_meta',array(
		'label'       => __('Enable Blog Post Meta', 'bike-rental-services'),
		'description' => __('Checked To Show Blog Post Meta Feilds', 'bike-rental-services'),
		'section'     => 'bike_rental_services_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_blog_post_tags',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_blog_post_tags',array(
		'label'       => __('Enable Blog Post Tags', 'bike-rental-services'),
		'description' => __('Checked To Show Blog Post Tags', 'bike-rental-services'),
		'section'     => 'bike_rental_services_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_blog_post_image',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_blog_post_image',array(
		'label'       => __('Enable Blog Post Image', 'bike-rental-services'),
		'description' => __('Checked To Show Blog Post Image', 'bike-rental-services'),
		'section'     => 'bike_rental_services_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_blog_post_content',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_blog_post_content',array(
		'label'       => __('Enable Blog Post Content', 'bike-rental-services'),
		'description' => __('Checked To Show Blog Post Content', 'bike-rental-services'),
		'section'     => 'bike_rental_services_blog_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_blog_post_button',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_blog_post_button',array(
		'label'       => __('Enable Blog Post Read More Button', 'bike-rental-services'),
		'description' => __('Checked To Show Blog Post Read More Button', 'bike-rental-services'),
		'section'     => 'bike_rental_services_blog_post_section',
		'type'        => 'checkbox',
	));

	/*Blog post Content layout*/
	$wp_customize->add_setting('bike_rental_services_blog_Post_content_layout',array(
        'default' => 'Left',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
	));
	$wp_customize->add_control('bike_rental_services_blog_Post_content_layout',array(
        'type' => 'select',
        'label' => esc_html__('Blog Post Content Layout','bike-rental-services'),
        'section' => 'bike_rental_services_blog_post_section',
        'choices' => array(
            'Left' => esc_html__('Left','bike-rental-services'),
            'Center' => esc_html__('Center','bike-rental-services'),
            'Right' => esc_html__('Right','bike-rental-services')
        ),
	) );

	/*Excerpt*/
    $wp_customize->add_setting(
		'bike_rental_services_excerpt_limit',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '25',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_excerpt_limit',
		array(
			'label'       => __('Excerpt Limit', 'bike-rental-services'),
			'section'     => 'bike_rental_services_blog_post_section',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 2,
	             'max' => 50,
	             'step' => 2,
	         ),
		)
	);

	/*Archive Button Text*/
	$wp_customize->add_setting(
		'bike_rental_services_read_more_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'Continue Reading....',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_read_more_text',
		array(
			'label'       => __('Edit Button Text ', 'bike-rental-services'),
			'section'     => 'bike_rental_services_blog_post_section',
			'type'        => 'text',
		)
	);

	/*Single Post Options*/
	$wp_customize->add_section('bike_rental_services_single_post_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Single Post Options', 'bike-rental-services'),
		'panel'       => 'bike_rental_services_panel',
	));

	$wp_customize->add_setting('bike_rental_services_enable_single_blog_post_title',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_single_blog_post_title',array(
		'label'       => __('Enable Single Post Title', 'bike-rental-services'),
		'description' => __('Checked To Show Single Blog Post Title', 'bike-rental-services'),
		'section'     => 'bike_rental_services_single_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_single_blog_post_meta',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_single_blog_post_meta',array(
		'label'       => __('Enable Single Post Meta', 'bike-rental-services'),
		'description' => __('Checked To Show Single Blog Post Meta Feilds', 'bike-rental-services'),
		'section'     => 'bike_rental_services_single_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_single_blog_post_tags',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_single_blog_post_tags',array(
		'label'       => __('Enable Single Post Tags', 'bike-rental-services'),
		'description' => __('Checked To Show Single Blog Post Tags', 'bike-rental-services'),
		'section'     => 'bike_rental_services_single_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_single_post_image',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_single_post_image',array(
		'label'       => __('Enable Single Post Image', 'bike-rental-services'),
		'description' => __('Checked To Show Single Post Image', 'bike-rental-services'),
		'section'     => 'bike_rental_services_single_post_section',
		'type'        => 'checkbox',
	));

	$wp_customize->add_setting('bike_rental_services_enable_single_blog_post_content',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 1,
		'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
	));
	$wp_customize->add_control('bike_rental_services_enable_single_blog_post_content',array(
		'label'       => __('Enable Single Post Content', 'bike-rental-services'),
		'description' => __('Checked To Show Single Blog Post Content', 'bike-rental-services'),
		'section'     => 'bike_rental_services_single_post_section',
		'type'        => 'checkbox',
	));

	/*Related Post Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_related_post',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_related_post',
		array(
			'label'       => __('Enable Related Post', 'bike-rental-services'),
			'description' => __('Checked to show Related Post', 'bike-rental-services'),
			'section'     => 'bike_rental_services_single_post_section',
			'type'        => 'checkbox',
		)
	);

	/*Related post Edit Text*/
	$wp_customize->add_setting(
		'bike_rental_services_related_post_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'Related Post',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_related_post_text',
		array(
			'label'       => __('Edit Related Post Text ', 'bike-rental-services'),
			'section'     => 'bike_rental_services_single_post_section',
			'type'        => 'text',
		)
	);	

	/*Related Post Per Page*/
	$wp_customize->add_setting(
		'bike_rental_services_related_post_count',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '3',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_related_post_count',
		array(
			'label'       => __('Related Post Count', 'bike-rental-services'),
			'section'     => 'bike_rental_services_single_post_section',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 1,
	             'max' => 9,
	             'step' => 1,
	         ),
		)
	);

	/* Comment Section Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_comment_section',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_comment_section',
		array(
			'label'       => __('Enable Comment Section', 'bike-rental-services'),
			'description' => __('Checked to show Comment Section', 'bike-rental-services'),
			'section'     => 'bike_rental_services_single_post_section',
			'type'        => 'checkbox',
		)
	);

	/*
	* Customizer Global COlor
	*/

	/*Global Color Options*/
	$wp_customize->add_section('bike_rental_services_global_color_section', array(
		'priority'       => 1,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Global Color Options', 'bike-rental-services'),
		'panel'       => 'bike_rental_services_panel',
	));

	$wp_customize->add_setting( 'bike_rental_services_primary_color',
		array(
		'default'           => '#fd1717',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'bike_rental_services_primary_color',
		array(
			'label'      => esc_html__( 'Primary Color', 'bike-rental-services' ),
			'section'    => 'bike_rental_services_global_color_section',
			'settings'   => 'bike_rental_services_primary_color',
		) ) 
	);

	/*
	* Customizer top header section
	*/

	$wp_customize->add_setting(
		'bike_rental_services_site_title_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_site_title_text',
		array(
			'label'       => __('Enable Title', 'bike-rental-services'),
			'description' => __('Enable or Disable Title from the site', 'bike-rental-services'),
			'section'     => 'title_tagline',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'bike_rental_services_site_tagline_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 0,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_site_tagline_text',
		array(
			'label'       => __('Enable Tagline', 'bike-rental-services'),
			'description' => __('Enable or Disable Tagline from the site', 'bike-rental-services'),
			'section'     => 'title_tagline',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'bike_rental_services_logo_width',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '150',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_logo_width',
		array(
			'label'       => __('Logo Width in PX', 'bike-rental-services'),
			'section'     => 'title_tagline',
			'type'        => 'number',
			'input_attrs' => array(
	            'min' => 100,
	             'max' => 300,
	             'step' => 1,
	         ),
		)
	);

	/*Typography Options*/
	$wp_customize->add_section( 'bike_rental_services_typography_section', array(
		'panel'       => 'bike_rental_services_panel',
        'title'    => __( 'Typography Options', 'bike-rental-services' ),
        'priority' => 2,
    ) );

    $wp_customize->add_setting( 'bike_rental_services_font_family', array(
		'default'           => 'default',
		'sanitize_callback' => 'bike_rental_services_sanitize_font_family',
	) );
	
	$wp_customize->add_control( 'bike_rental_services_font_family', array(
		'label'    => __( 'Global Font Family', 'bike-rental-services' ),
		'section'  => 'bike_rental_services_typography_section',
		'type'     => 'select',
		'choices'  => array(
			'default'          => __( 'Default (Theme Font)', 'bike-rental-services' ),
			'bad_script'       => 'Bad Script',
			'roboto'           => 'Roboto',
			'playfair_display' => 'Playfair Display',
			'open_sans'        => 'Open Sans',
			'lobster'          => 'Lobster',
			'merriweather'     => 'Merriweather',
			'oswald'           => 'Oswald',
			'raleway'          => 'Raleway',
			// Add new fonts here
			'poppins'            => 'Poppins',
			'lato'               => 'Lato',
			'source_sans_pro'    => 'Source Sans Pro',
			'quicksand'          => 'Quicksand',
			'nunito'             => 'Nunito',
			'montserrat'         => 'Montserrat',
			'roboto_condensed'   => 'Roboto Condensed',
			'playfair_display_sc'=> 'Playfair Display SC',
			'alegreya'           => 'Alegreya',
			'fira_sans'          => 'Fira Sans',
		),
	) );

	/*Top Header Options*/
	$wp_customize->add_section('bike_rental_services_topbar_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Top Header Options', 'bike-rental-services'),
		'panel'       => 'bike_rental_services_panel',
	));

	/*Phone Number Text*/
	$wp_customize->add_setting(
		'bike_rental_services_phone_number_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'PHONE',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_phone_number_text',
		array(
			'label'       => __('Edit Phone Text', 'bike-rental-services'),
			'section'     => 'bike_rental_services_topbar_section',
			'type'        => 'text',
		)
	);

	/*Phone Number*/
	$wp_customize->add_setting(
		'bike_rental_services_phone_number_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '+00 123 456 7890',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_phone_number_option',
		array(
			'label'       => __('Edit Phone Number', 'bike-rental-services'),
			'section'     => 'bike_rental_services_topbar_section',
			'type'        => 'text',
		)
	);


	$wp_customize->add_setting('bike_rental_services_header_phone_icon',array(
		'default'	=> 'fas fa-phone-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Bike_Rental_Services_Icon_Changer(
        $wp_customize,'bike_rental_services_header_phone_icon',array(
		'label'	=> __('Phone Number Icon','bike-rental-services'),
		'transport' => 'refresh',
		'section'	=> 'bike_rental_services_topbar_section',
		'type'		=> 'icon'
	)));

	/*Mail Address Text*/
	$wp_customize->add_setting(
		'bike_rental_services_mail_address_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'EMAIL',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_mail_address_text',
		array(
			'label'       => __('Edit Mail Text', 'bike-rental-services'),
			'section'     => 'bike_rental_services_topbar_section',
			'type'        => 'text',
		)
	);

	/*Mail Address*/
	$wp_customize->add_setting(
		'bike_rental_services_mail_address_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'xyz123@example.com',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_mail_address_option',
		array(
			'label'       => __('Edit Mail Address ', 'bike-rental-services'),
			'section'     => 'bike_rental_services_topbar_section',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting('bike_rental_services_header_mail_icon',array(
		'default'	=> 'fas fa-envelope-open-text',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Bike_Rental_Services_Icon_Changer(
        $wp_customize,'bike_rental_services_header_mail_icon',array(
		'label'	=> __('Mail Icon','bike-rental-services'),
		'transport' => 'refresh',
		'section'	=> 'bike_rental_services_topbar_section',
		'type'		=> 'icon'
	)));

	/*Main Header Button Text*/
	$wp_customize->add_setting(
		'bike_rental_services_header_button_text',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 'SELL YOUR CAR',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_header_button_text',
		array(
			'label'       => __('Edit Button Text ', 'bike-rental-services'),
			'section'     => 'bike_rental_services_topbar_section',
			'type'        => 'text',
		)
	);

	/*Main Header Button Link*/
	$wp_customize->add_setting(
		'bike_rental_services_header_button_link',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_header_button_link',
		array(
			'label'       => __('Edit Button Link ', 'bike-rental-services'),
			'section'     => 'bike_rental_services_topbar_section',
			'type'        => 'url',
		)
	);

	$wp_customize->add_setting(
		'bike_rental_services_header_search',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_header_search',
		array(
			'label'       => __('Enable Disable Search', 'bike-rental-services'),
			'description' => __('Enable or Disable header Search', 'bike-rental-services'),
			'section'     => 'bike_rental_services_topbar_section',
			'type'        => 'checkbox',
		)
	);

	/*
	* Customizer main slider section
	*/
	/*Main Slider Options*/
	$wp_customize->add_section('bike_rental_services_slider_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Main Slider Options', 'bike-rental-services'),
		'panel'       => 'bike_rental_services_panel',
	));

	/*Main Slider Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_slider',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 0,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_slider',
		array(
			'label'       => __('Enable Main Slider', 'bike-rental-services'),
			'description' => __('Checked to show the main slider', 'bike-rental-services'),
			'section'     => 'bike_rental_services_slider_section',
			'type'        => 'checkbox',
		)
	);

	for ($bike_rental_services_i=1; $bike_rental_services_i <= 3; $bike_rental_services_i++) { 

		/*Main Slider Image*/
		$wp_customize->add_setting(
			'bike_rental_services_slider_image'.$bike_rental_services_i,
			array(
				'capability'    => 'edit_theme_options',
		        'default'       => '',
		        'transport'     => 'postMessage',
		        'sanitize_callback' => 'esc_url_raw',
	    	)
	    );

		$wp_customize->add_control( 
			new WP_Customize_Image_Control( $wp_customize, 
				'bike_rental_services_slider_image'.$bike_rental_services_i, 
				array(
			        'label' => __('Edit Slider Image ', 'bike-rental-services') .$bike_rental_services_i,
			        'description' => __('Edit the slider image.', 'bike-rental-services'),
			        'section' => 'bike_rental_services_slider_section',
				)
			)
		);

		/*Main Slider xtra Heading*/
		$wp_customize->add_setting(
			'bike_rental_services_slider_xtra_heading'.$bike_rental_services_i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'bike_rental_services_slider_xtra_heading'.$bike_rental_services_i,
			array(
				'label'       => __('Edit Extra Heading Text ', 'bike-rental-services') .$bike_rental_services_i,
				'description' => __('Edit the slider extra heading text.', 'bike-rental-services'),
				'section'     => 'bike_rental_services_slider_section',
				'type'        => 'text',
			)
		);

		/*slider heading*/
		$wp_customize->add_setting(
			'bike_rental_services_slider_heading'.$bike_rental_services_i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'bike_rental_services_slider_heading'.$bike_rental_services_i,
			array(
				'label'       => __('Edit Heading Text ', 'bike-rental-services') .$bike_rental_services_i,
				'description' => __('Edit the slider heading text.', 'bike-rental-services'),
				'section'     => 'bike_rental_services_slider_section',
				'type'        => 'text',
			)
		);

		/*Main Slider Content*/
		$wp_customize->add_setting(
			'bike_rental_services_slider_text'.$bike_rental_services_i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'bike_rental_services_slider_text'.$bike_rental_services_i,
			array(
				'label'       => __('Edit Content Text ', 'bike-rental-services') .$bike_rental_services_i,
				'description' => __('Edit the slider content text.', 'bike-rental-services'),
				'section'     => 'bike_rental_services_slider_section',
				'type'        => 'text',
			)
		);


		/*Main Slider Button1 Text*/
		$wp_customize->add_setting(
			'bike_rental_services_slider_button1_text'.$bike_rental_services_i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'bike_rental_services_slider_button1_text'.$bike_rental_services_i,
			array(
				'label'       => __('Edit Button #1 Text ', 'bike-rental-services') .$bike_rental_services_i,
				'description' => __('Edit the slider button text.', 'bike-rental-services'),
				'section'     => 'bike_rental_services_slider_section',
				'type'        => 'text',
			)
		);

		/*Main Slider Button1 URL*/
		$wp_customize->add_setting(
			'bike_rental_services_slider_button1_link'.$bike_rental_services_i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			'bike_rental_services_slider_button1_link'.$bike_rental_services_i,
			array(
				'label'       => __('Edit Button #1 URL ', 'bike-rental-services') .$bike_rental_services_i,
				'description' => __('Edit the slider button url.', 'bike-rental-services'),
				'section'     => 'bike_rental_services_slider_section',
				'type'        => 'url',
			)
		);
	}

	/*
	* Customizer feature bike section
	*/
	/*Project Options*/
	$wp_customize->add_section('bike_rental_services_project_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Featured Bike Options', 'bike-rental-services'),
		'panel'       => 'bike_rental_services_panel',
	));

	/*Project Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_featured_bike',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 0,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_featured_bike',
		array(
			'label'       => __('Enable Featured Bike Section', 'bike-rental-services'),
			'description' => __('Checked to show the project', 'bike-rental-services'),
			'section'     => 'bike_rental_services_project_section',
			'type'        => 'checkbox',
		)
	);

	/*Featured Bike Short Heading*/
    $wp_customize->add_setting(
        'bike_rental_services_feature_short_heading',
        array(
            'capability'        => 'edit_theme_options',
            'transport'         => 'refresh',
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'bike_rental_services_feature_short_heading',
        array(
            'label'       => __('Edit Section Short Heading', 'bike-rental-services'),
            'description' => __('Edit feature section short heading', 'bike-rental-services'),
            'section'     => 'bike_rental_services_project_section',
            'type'        => 'text',
        )
    );

    /*Featured Bike Heading*/
    $wp_customize->add_setting(
        'bike_rental_services_feature_heading',
        array(
            'capability'        => 'edit_theme_options',
            'transport'         => 'refresh',
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'bike_rental_services_feature_heading',
        array(
            'label'       => __('Edit Section Heading', 'bike-rental-services'),
            'description' => __('Edit feature section heading', 'bike-rental-services'),
            'section'     => 'bike_rental_services_project_section',
            'type'        => 'text',
        )
    );

	$wp_customize->add_setting(
		'bike_rental_services_feature_bike_box_tab_count',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 6,
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_feature_bike_box_tab_count',
		array(
			'label'       => __('Number Of Tab to Show', 'bike-rental-services'),
			'description' => __('Number Of Tab to Show.', 'bike-rental-services'),
			'section'     => 'bike_rental_services_project_section',
			'type'        => 'number',
			  'input_attrs' => array(
		        'min' => 0,
		        'max' => 6,
		        'step' => 1
		    )
		)
	);

	$bike_rental_services_count = get_theme_mod('bike_rental_services_feature_bike_box_tab_count') !== '' ? get_theme_mod('bike_rental_services_feature_bike_box_tab_count') : 6;
	for ($bike_rental_services_i=1; $bike_rental_services_i <=$bike_rental_services_count ; $bike_rental_services_i++) { 

		/*Project Image*/
		$wp_customize->add_setting(
			'bike_rental_services_feature_bike_image_tab'.$bike_rental_services_i,
			array(
				'capability'    => 'edit_theme_options',
		        'default'       => '',
		        'transport'     => 'postMessage',
		        'sanitize_callback' => 'esc_url_raw',
	    	)
	    );

		$wp_customize->add_control( 
			new WP_Customize_Image_Control( $wp_customize, 
				'bike_rental_services_feature_bike_image_tab'.$bike_rental_services_i, 
				array(
			        'label' => __('Edit Project Image ', 'bike-rental-services') .$bike_rental_services_i,
			        'description' => __('Edit the project image.', 'bike-rental-services'),
			        'section' => 'bike_rental_services_project_section',
				)
			)
		);

		/*Project Title*/
		$wp_customize->add_setting(
			'bike_rental_services_feature_bike_box_heading_tab'.$bike_rental_services_i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'bike_rental_services_feature_bike_box_heading_tab'.$bike_rental_services_i,
			array(
				'label'       => __('Edit Project Title ', 'bike-rental-services') .$bike_rental_services_i,
				'description' => __('Edit the project name.', 'bike-rental-services'),
				'section'     => 'bike_rental_services_project_section',
				'type'        => 'text',
			)
		);

		/*Project Text*/
		$wp_customize->add_setting(
			'bike_rental_services_feature_bike_box_content_tab'.$bike_rental_services_i,
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'bike_rental_services_feature_bike_box_content_tab'.$bike_rental_services_i,
			array(
				'label'       => __('Edit Project Text ', 'bike-rental-services') .$bike_rental_services_i,
				'description' => __('Edit the project text.', 'bike-rental-services'),
				'section'     => 'bike_rental_services_project_section',
				'type'        => 'text',
			)
		);

		/*Main Header Button Text*/
	$wp_customize->add_setting(
		'bike_rental_services_tab_button_text'.$bike_rental_services_i,
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_tab_button_text'.$bike_rental_services_i,
		array(
			'label'       => __('Edit Button Text ', 'bike-rental-services').$bike_rental_services_i,
			'section'     => 'bike_rental_services_project_section',
			'type'        => 'text',
		)
	);

	/*Main Header Button Link*/
	$wp_customize->add_setting(
		'bike_rental_services_tab_button_link'.$bike_rental_services_i,
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_tab_button_link'.$bike_rental_services_i,
		array(
			'label'       => __('Edit Button Link ', 'bike-rental-services').$bike_rental_services_i,
			'section'     => 'bike_rental_services_project_section',
			'type'        => 'url',
		)
	);

	}

	/*
	* Customizer Footer Section
	*/
	/*Footer Options*/
	$wp_customize->add_section('bike_rental_services_footer_section', array(
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __('Footer Options', 'bike-rental-services'),
		'panel'       => 'bike_rental_services_panel',
	));

	/*Footer Enable Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_footer',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'bike_rental_services_enable_footer',
		array(
			'label'       => __('Enable Footer', 'bike-rental-services'),
			'description' => __('Checked to show Footer', 'bike-rental-services'),
			'section'     => 'bike_rental_services_footer_section',
			'type'        => 'checkbox',
		)
	);

	/*Footer bg image Option*/
	$wp_customize->add_setting('bike_rental_services_footer_bg_image',array(
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'bike_rental_services_footer_bg_image',array(
        'label' => __('Footer Background Image','bike-rental-services'),
        'section' => 'bike_rental_services_footer_section',
        'priority' => 1,
    )));

	/*Footer Social Menu Option*/
	$wp_customize->add_setting(
		'bike_rental_services_footer_social_menu',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bike_rental_services_footer_social_menu',
		array(
			'label'       => __('Enable Footer Social Menu', 'bike-rental-services'),
			'description' => __('Checked to show the footer social menu. Go to Dashboard >> Appearance >> Menus >> Create New Menu >> Add Custom Link >> Add Social Menu >> Checked Social Menu >> Save Menu.', 'bike-rental-services'),
			'section'     => 'bike_rental_services_footer_section',
			'type'        => 'checkbox',
		)
	);	

	/*Go To Top Option*/
	$wp_customize->add_setting(
		'bike_rental_services_enable_go_to_top_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => 1,
			'sanitize_callback' => 'bike_rental_services_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'bike_rental_services_enable_go_to_top_option',
		array(
			'label'       => __('Enable Go To Top', 'bike-rental-services'),
			'description' => __('Checked to enable Go To Top option.', 'bike-rental-services'),
			'section'     => 'bike_rental_services_footer_section',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->add_setting('bike_rental_services_go_to_top_position',array(
        'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'default'           => 'Right',
        'sanitize_callback' => 'bike_rental_services_sanitize_choices'
    ));
    $wp_customize->add_control('bike_rental_services_go_to_top_position',array(
        'type' => 'select',
        'section' => 'bike_rental_services_footer_section',
        'label' => esc_html__('Go To Top Positions','bike-rental-services'),
        'choices' => array(
            'Right' => __('Right','bike-rental-services'),
            'Left' => __('Left','bike-rental-services'),
            'Center' => __('Center','bike-rental-services')
        ),
    ) );

	/*Footer Copyright Text Enable*/
	$wp_customize->add_setting(
		'bike_rental_services_copyright_option',
		array(
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'bike_rental_services_copyright_option',
		array(
			'label'       => __('Edit Copyright Text', 'bike-rental-services'),
			'description' => __('Edit the Footer Copyright Section.', 'bike-rental-services'),
			'section'     => 'bike_rental_services_footer_section',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'bike_rental_services_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function bike_rental_services_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function bike_rental_services_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bike_rental_services_customize_preview_js() {
	wp_enqueue_script( 'bike-rental-services-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), BIKE_RENTAL_SERVICES_VERSION, true );
}
add_action( 'customize_preview_init', 'bike_rental_services_customize_preview_js' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Bike_Rental_Services_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $bike_rental_services_instance = null;

		if ( is_null( $bike_rental_services_instance ) ) {
			$bike_rental_services_instance = new self;
			$bike_rental_services_instance->setup_actions();
		}

		return $bike_rental_services_instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/revolution/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Bike_Rental_Services_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section( new Bike_Rental_Services_Customize_Section_Pro( $manager,'bike_rental_services_go_pro', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Bike Rental Services', 'bike-rental-services' ),
			'pro_text' => esc_html__( 'Buy Pro', 'bike-rental-services' ),
			'pro_url'    => esc_url( BIKE_RENTAL_SERVICES_BUY_NOW ),
		) )	);

		// Register sections.
		$manager->add_section( new Bike_Rental_Services_Customize_Section_Pro( $manager,'bike_rental_services_lite_documentation', array(
			'priority'   => 1,
			'title'    => esc_html__( 'Lite Documentation', 'bike-rental-services' ),
			'pro_text' => esc_html__( 'Instruction', 'bike-rental-services' ),
			'pro_url'    => esc_url( BIKE_RENTAL_SERVICES_LITE_DOC ),
		) )	);

		$manager->add_section( new Bike_Rental_Services_Customize_Section_Pro( $manager, 'bike_rental_services_live_demo', array(
		    'priority'   => 1,
		    'title'      => esc_html__( 'Pro Theme Demo', 'bike-rental-services' ),
		    'pro_text'   => esc_html__( 'Live Preview', 'bike-rental-services' ),
		    'pro_url'    => esc_url( BIKE_RENTAL_SERVICES_LIVE_DEMO ),
		) ) );

		// Register sections.
		$manager->add_section( new Bike_Rental_Services_Customize_Section_Pro( $manager, 'bike_rental_services_bundle', array(
			'priority'   => 1,
			'title'      => esc_html__( 'Theme Bundle', 'bike-rental-services' ),
			'pro_text'   => esc_html__( 'Get Bundle', 'bike-rental-services' ),
			'pro_url'    => esc_url( BIKE_RENTAL_SERVICES_BUNDLE ),
		) ) );	
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'bike-rental-services-customize-controls', trailingslashit( get_template_directory_uri() ) . '/revolution/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'bike-rental-services-customize-controls', trailingslashit( get_template_directory_uri() ) . '/revolution/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Bike_Rental_Services_Customize::get_instance();
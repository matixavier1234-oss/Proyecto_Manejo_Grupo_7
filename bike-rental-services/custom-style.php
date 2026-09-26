<?php 
	$bike_rental_services_custom_css ='';

/*----------------Related Product show/hide -------------------*/

$bike_rental_services_enable_related_product = get_theme_mod('bike_rental_services_enable_related_product',1);

	if($bike_rental_services_enable_related_product == 0){
		$bike_rental_services_custom_css .='.related.products{';
			$bike_rental_services_custom_css .='display: none;';
		$bike_rental_services_custom_css .='}';
	}

/*----------------blog post content alignment -------------------*/

$bike_rental_services_blog_Post_content_layout = get_theme_mod( 'bike_rental_services_blog_Post_content_layout','Left');
    if($bike_rental_services_blog_Post_content_layout == 'Left'){
		$bike_rental_services_custom_css .='.ct-post-wrapper .card-item {';
			$bike_rental_services_custom_css .='text-align:start;';
		$bike_rental_services_custom_css .='}';
	}else if($bike_rental_services_blog_Post_content_layout == 'Center'){
		$bike_rental_services_custom_css .='.ct-post-wrapper .card-item {';
			$bike_rental_services_custom_css .='text-align:center;';
		$bike_rental_services_custom_css .='}';
	}else if($bike_rental_services_blog_Post_content_layout == 'Right'){
		$bike_rental_services_custom_css .='.ct-post-wrapper .card-item {';
			$bike_rental_services_custom_css .='text-align:end;';
		$bike_rental_services_custom_css .='}';
	}

	/*--------------------------- Footer background image -------------------*/

    $bike_rental_services_footer_bg_image = get_theme_mod('bike_rental_services_footer_bg_image');
    if($bike_rental_services_footer_bg_image != false){
        $bike_rental_services_custom_css .='.footer-top{';
            $bike_rental_services_custom_css .='background: url('.esc_attr($bike_rental_services_footer_bg_image).');';
        $bike_rental_services_custom_css .='}';
    }

	/*--------------------------- Go to top positions -------------------*/

    $bike_rental_services_go_to_top_position = get_theme_mod( 'bike_rental_services_go_to_top_position','Right');
    if($bike_rental_services_go_to_top_position == 'Right'){
        $bike_rental_services_custom_css .='.footer-go-to-top{';
            $bike_rental_services_custom_css .='right: 20px;';
        $bike_rental_services_custom_css .='}';
    }else if($bike_rental_services_go_to_top_position == 'Left'){
        $bike_rental_services_custom_css .='.footer-go-to-top{';
            $bike_rental_services_custom_css .='left: 20px;';
        $bike_rental_services_custom_css .='}';
    }else if($bike_rental_services_go_to_top_position == 'Center'){
        $bike_rental_services_custom_css .='.footer-go-to-top{';
            $bike_rental_services_custom_css .='right: 50%;left: 50%;';
        $bike_rental_services_custom_css .='}';
    }

    /*--------------------------- Woocommerce Product Sale Positions -------------------*/

    $bike_rental_services_product_sale = get_theme_mod( 'bike_rental_services_woocommerce_product_sale','Right');
    if($bike_rental_services_product_sale == 'Right'){
        $bike_rental_services_custom_css .='.woocommerce ul.products li.product .onsale{';
            $bike_rental_services_custom_css .='left: auto; ';
        $bike_rental_services_custom_css .='}';
    }else if($bike_rental_services_product_sale == 'Left'){
        $bike_rental_services_custom_css .='.woocommerce ul.products li.product .onsale{';
            $bike_rental_services_custom_css .='right: auto;left:0;';
        $bike_rental_services_custom_css .='}';
    }else if($bike_rental_services_product_sale == 'Center'){
        $bike_rental_services_custom_css .='.woocommerce ul.products li.product .onsale{';
            $bike_rental_services_custom_css .='right: 50%; left: 50%; ';
        $bike_rental_services_custom_css .='}';
    }
    
    /*-------------------- Primary Color -------------------*/

	$bike_rental_services_primary_color = get_theme_mod('bike_rental_services_primary_color', '#fd1717'); // Add a fallback if the color isn't set

	if ($bike_rental_services_primary_color) {
		$bike_rental_services_custom_css .= ':root {';
		$bike_rental_services_custom_css .= '--secondary-color: ' . esc_attr($bike_rental_services_primary_color) . ';';
		$bike_rental_services_custom_css .= '}';
	}

    /*----------------Enable/Disable Breadcrumbs -------------------*/

    $bike_rental_services_enable_breadcrumbs = get_theme_mod('bike_rental_services_enable_breadcrumbs',1);

    if($bike_rental_services_enable_breadcrumbs == 0){
        $bike_rental_services_custom_css .='.bike-rental-services-breadcrumbs, nav.woocommerce-breadcrumb{';
            $bike_rental_services_custom_css .='display: none;';
        $bike_rental_services_custom_css .='}';
    }
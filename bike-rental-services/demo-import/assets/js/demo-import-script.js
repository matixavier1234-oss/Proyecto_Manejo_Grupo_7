var Whizzie = (function($){

    var t;
	var current_step = '';
	var step_pointer = '';
    var demo_import_type = '';

    // callbacks from form button clicks.
    var callbacks = {
		do_next_step: function( btn ) {
			do_next_step( btn );
		},
		install_widgets: function( btn ) {
            demo_import_type="customize";
			var widgets = new WidgetManager(demo_import_type);
			widgets.init( btn );
		},
        install_content: function(btn){
            var content = new ContentManager();
            content.init( btn );
        }
    };

    function window_loaded() {
		var maxHeight = 0;

		$( '.whizzie-menu li.step' ).each( function( index ) {
			$(this).attr( 'data-height', $(this).innerHeight() );
			if( $(this).innerHeight() > maxHeight ) {
				maxHeight = $(this).innerHeight();
			}
		});

		$( '.whizzie-menu li .detail' ).each( function( index ) {
			$(this).attr( 'data-height', $(this).innerHeight() );
			$(this).addClass( 'scale-down' );
		});


		$( '.whizzie-menu li.step' ).css( 'height', '100%' );
		$( '.whizzie-menu li.step:first-child' ).addClass( 'active-step' );
		$( '.whizzie-nav li:first-child' ).addClass( 'active-step' );

		$( '.whizzie-wrap' ).addClass( 'loaded' );

        // init button clicks:
        $('.do-it').on( 'click', function(e) {
			e.preventDefault();
			step_pointer = $(this).data('step');
			current_step = $('.step-' + $(this).data('step'));
			$('.whizzie-wrap').addClass( 'spinning' );
            if($(this).data('callback') && typeof callbacks[$(this).data('callback')] != 'undefined'){
                callbacks[$(this).data('callback')](this);
                return false;
            } else {
                loading_content();
                return true;
            }
        });
    }

    function loading_content(){}

    function do_next_step( btn ) {
        $('.nav-step-plugins').attr('data-enable',1);
		current_step.removeClass( 'active-step' );
		$( '.nav-step-' + step_pointer ).removeClass( 'active-step' );
		current_step.addClass( 'done-step' );
		$( '.nav-step-' + step_pointer ).addClass( 'done-step' );
		current_step.fadeOut( 500, function() {
			current_step = current_step.next();
			step_pointer = current_step.data( 'step' );
			current_step.fadeIn();
			current_step.addClass( 'active-step' );
			$( '.nav-step-' + step_pointer ).addClass( 'active-step' );
			$('.whizzie-wrap').removeClass( 'spinning' );
		});
    }


	function WidgetManager(demo_type) {
        $('.step-loading').css('display','block');
        var demo_action = '';
        if(demo_type == 'builder'){
            jQuery('.setup-finish .wz-btn-customizer').css('display','none');
            jQuery('.setup-finish .wz-btn-builder').css('display','inline-block');
    		function import_widgets(){
                jQuery.post(
    				bike_rental_services_whizzie_params.ajaxurl,
    				{
    					wpnonce: bike_rental_services_whizzie_params.wpnonce
    				}, ajax_callback).fail(ajax_callback);
    		}
            $('.nav-step-done').attr('data-enable',1);
        }else{
            jQuery('.setup-finish .wz-btn-customizer').css('display','inline-block');
            jQuery('.setup-finish .wz-btn-builder').css('display','none');
            function import_widgets(){
                jQuery.post(
                    bike_rental_services_whizzie_params.ajaxurl,
                    {
                        action: 'setup_widgets',
                        wpnonce: bike_rental_services_whizzie_params.wpnonce
                    }, ajax_callback_customizer).fail(ajax_callback_customizer);
            }
            $('.nav-step-done').attr('data-enable',1);
        }
		return {
			init: function( btn ) {
				ajax_callback = function(response) {
                    var obj = JSON.parse(response);
                    if(obj.home_page_url !=""){
                        jQuery('.wz-btn-builder').attr('href',obj.home_page_url);
                    }
					do_next_step();
				}
                ajax_callback_customizer = function() {
                    do_next_step();
                }

				import_widgets();
			}
		}
	}

    function ContentManager(){
        var complete;
        var items_completed = 0;
        var current_item = '';
        var $current_node;
        var current_item_hash = '';

        function ajax_callback(response) {
            if(typeof response == 'object' && typeof response.message != 'undefined'){
                $current_node.find('span').text(response.message);
                if(typeof response.url != 'undefined'){
                    // we have an ajax url action to perform.
                    if(response.hash == current_item_hash){
                        $current_node.find('span').text("failed");
                        find_next();
                    }else {
                        current_item_hash = response.hash;
                        jQuery.post(response.url, response, ajax_callback).fail(ajax_callback); // recuurrssionnnnn
                    }
                }else if(typeof response.done != 'undefined'){
                    // finished processing this plugin, move onto next
                    find_next();
                }else{
                    // error processing this plugin
                    find_next();
                }
            }else{
                // error - try again with next plugin
                $current_node.find('span').text("ajax error");
                find_next();
            }
        }
    }

    return {
        init: function(){
			t = this;
			$(window_loaded);
        },
        callback: function(func){
        }
    }

})(jQuery);

Whizzie.init();

jQuery(document).ready(function(){

    var current_menu = '';
    var current_icon_step = '';

    current_menu = parseInt(jQuery('.wizard-menu-page').length);
    if(current_menu == 1){
        jQuery('#adminmenu li').removeClass('current');
        jQuery('#adminmenu li a').removeClass('wp-has-current-submenu');
        jQuery('#toplevel_page_bikerentalservices-wizard').addClass('current');
    }

    jQuery('.setup-finish .finish-btn a').click(function(){
        jQuery('.tab-sec button.tablinks:nth-child(2)').addClass('active');
    });

    jQuery('.wizard-icon-nav li').click(function(){

        var tabenable= jQuery(this).attr('data-enable');
        if(tabenable==1){
            current_icon_step = jQuery(this).attr('wizard-steps');
            jQuery('.wizard-menu-page li.step').removeClass('active-step');
            jQuery('.wizard-menu-page li.step').css('display','none');
            jQuery('.wizard-icon-nav li').removeClass('active-step');
            jQuery('.wizard-menu-page .' + current_icon_step).addClass('active-step');
            jQuery('.wizard-menu-page .' + current_icon_step).css('display','block');
            jQuery(this).addClass('active-step');
        }
    });
});
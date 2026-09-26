jQuery(document).ready(function ($) {

    //Preloader
    jQuery('#preloader').delay(1500).fadeOut();
    jQuery('#loader').delay(1500).fadeOut("slow");

    if ($('.go-to-top').length) {
        var scrollTrigger = $('body').position(); // px
        goToTop = function () {

            var scrollTop = $(window).scrollTop();
            if (scrollTop > 150) {
                $('.footer-go-to-top').addClass('show');
            } else {
                $('.footer-go-to-top').removeClass('show');
            }
        };
        goToTop();
        $(window).on('scroll', function () {
            goToTop();
        });
        $('.go-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: scrollTrigger.top
            }, 700);
        });
    }

    if ($('.go-to-top').length) {
        var scrollTrigger = $('body').position(); // px
        goToTop = function () {

            var scrollTop = $(window).scrollTop();
            if (scrollTop > 150) {
                $('.footer-go-to-top').addClass('show');
            } else {
                $('.footer-go-to-top').removeClass('show');
            }
        };
        goToTop();
        $(window).on('scroll', function () {
            goToTop();
        });
        $('.go-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: scrollTrigger.top
            }, 700);
        });
    }

    // Mobile Menu Focus
    $(window).resize(bike_rental_services_navTrapp)

    function bike_rental_services_navTrapp() {
        var width = $(window).width();
        if (width < 992) {
            $('.main-navigation').on('keydown', function (e) {
                if ($('.main-navigation').hasClass('toggled')) {
                    var focusableEls = $('.main-navigation a[href]:not([disabled]), .main-navigation button');
                    var firstFocusableEl = focusableEls[0];
                    var lastFocusableEl = focusableEls[focusableEls.length - 1];
                    var KEYCODE_TAB = 9;
                    var KEYCODE_ESC = 27;
                    if (e.key === 'Tab' || e.keyCode === KEYCODE_TAB) {
                        if (e.shiftKey) /* shift + tab */ {
                            if (document.activeElement === firstFocusableEl) {
                                lastFocusableEl.focus();
                                e.preventDefault();
                            }
                        }
                        else /* tab */ {
                            if (document.activeElement === lastFocusableEl) {
                                firstFocusableEl.focus();
                                e.preventDefault();
                            }
                        }
                    }
    
                    if (e.keyCode === KEYCODE_ESC) {
                        console.log(e.keyCode);
                        $('.main-navigation').removeClass('toggled');
                        return;
                    }
                }
                
            });
        }
    }
   
    bike_rental_services_navTrapp()
    var owl = jQuery('#main-slider-wrap .owl-carousel');
    owl.owlCarousel({
        margin:20,
        nav: true,
        autoplay : true,
        lazyLoad: true,
        autoplayTimeout: 3000,
        loop: true,
        dots: false,
        rtl: $('html').attr('dir') === 'rtl',  // Set RTL based on HTML direction
        navText : ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i> '],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        },
        autoplayHoverPause : true,
        mouseDrag: true
    });
});

jQuery(document).ready(function () {
      function bike_rental_services_search_loop_focus(element) {
      var bike_rental_services_focus = element.find('select, input, textarea, button, a[href]');
      var bike_rental_services_firstFocus = bike_rental_services_focus[0];  
      var bike_rental_services_lastFocus = bike_rental_services_focus[bike_rental_services_focus.length - 1];
      var KEYCODE_TAB = 9;

      element.on('keydown', function bike_rental_services_search_loop_focus(e) {
        var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

        if (!isTabPressed) { 
          return; 
        }

        if ( e.shiftKey ) /* shift + tab */ {
          if (document.activeElement === bike_rental_services_firstFocus) {
            bike_rental_services_lastFocus.focus();
              e.preventDefault();
            }
          } else /* tab */ {
          if (document.activeElement === bike_rental_services_lastFocus) {
            bike_rental_services_firstFocus.focus();
              e.preventDefault();
            }
          }
      });
    }
    jQuery('.search-box span a').click(function(){
        jQuery(".serach_outer").slideDown(1000);
        bike_rental_services_search_loop_focus(jQuery('.serach_outer'));
    });

    jQuery('.closepop a').click(function(){
        jQuery(".serach_outer").slideUp(1000);
    });


    //tab.js
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const activeTab = tab.getAttribute('data-tab');
            contents.forEach(content => {
                if (content.id === activeTab) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        });
    });
    var selector = '.tab';

    jQuery(selector).on('click', function(){
        jQuery(selector).removeClass('active');
        jQuery(this).addClass('active');
    });
});

jQuery(function($) {
    $('#myTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.sticky-header');
    if (header) { // Check if header exists
        window.addEventListener('scroll', function() {
        if (window.scrollY > 0) {
            header.classList.add('stickyon');
        } else {
            header.classList.remove('stickyon');
        }
        });
    }
});
/*=========================================

TTemplate Name: rocky - One Page Personal Portfolio Template
Author: zebtheme
Version: 1.0
Design and Developed by: zwebtheme

NOTE: This is the custom jQuery file for the template

=========================================*/
(function ($) {
    "use strict";
    var $window = $(window)
        , $body = $('body');
    
    /*=======================================
           Scroll Top button
    =======================================*/
    var scrollTopBtn = $("#scroll-top-area");
    scrollTopBtn.on("click", function () {
        $('html, body').animate({
            scrollTop: 0
        }, 2000);
    });
    $(window).on("scroll", function () {
        var top2 = $(window).scrollTop();
        if (top2 < 150) {
            $("#scroll-top-area").css('display', 'none');
        }
        else if (top2 >= 150) {
            $("#scroll-top-area").css('display', 'block');
        }
    });

    /*=============================
                Sticky header
    ==============================*/
    // $('.navbar-collapse a').on('click', function () {
    //     $(".navbar-collapse").collapse('hide');
    // });
    $window.on('scroll', function () {
        if($(window).scrollTop() > 100) {
            $(".custom-navbar").addClass("is_sticky");
        }else{
            $(".custom-navbar").removeClass("is_sticky");
        }
    });
    
    
   
    
    /*=============================
            WOW js
    ==============================*/
    new WOW({
        mobile: false
    }).init();
    
    
    /*=============================
                Preloder
    ==============================*/
    $window.load(function () {
        //$('.spinner').fadeOut();
        $('.preloader').delay(350).fadeOut(500);
        $body.delay(350).css({
            'overflow': 'visible'
        });
    });
})(jQuery);
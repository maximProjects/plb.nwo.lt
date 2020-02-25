var selectedMenu = false;
var forceScroll = false;
var currentHash;
var show_scroll_top = false;
var options = {
    'markup': '<div class="container popup-container"><div class="popup"><div class="popup_content"/></div></div>',
    'beforeOpen': function () {
        jQuery('.main-container').toggleClass('hidden');
    },
    'beforeClose': function () {
        jQuery('.main-container').toggleClass('hidden');
    }
};


(function ($) {

    var focused_on_search = false;
    var focused_on_ajax_search = false;

    $('.search-input').on('focus', function(){
        if(!focused_on_search)
        {
            $(this).val('');
        }
        focused_on_search = true;
    });

    $('.ajax-search-input').on('focus', function(){
        if(!focused_on_ajax_search)
        {
            $(this).val('');
        }
        focused_on_ajax_search = true;
    });

    $(window).load(function () {
        $(".scrollable").mCustomScrollbar({
            theme: "scandagra-dark",
            //mouseWheel: true,
        });
        $(".scrollablex").mCustomScrollbar({
            theme: "scandagra-dark",
            axis: "x"
        });
    });


    var iScrollPos = 0;

    $(window).scroll(function () {
        if ($(document).width() < 992) {
            var iCurScrollPos = $(this).scrollTop();

            if($('.main-navbar').hasClass('dynamic'))
            {
                if (iCurScrollPos > iScrollPos) {
                    if ((iCurScrollPos - iScrollPos) > 1) {
                        $('.main-navbar').css('position', 'absolute');
                    }
                } else {
                    if ((iScrollPos - iCurScrollPos) > 1) {

                        //$('.main-navbar').css('position', 'fixed');
                    }
                }
            }


            iScrollPos = iCurScrollPos;
        }else{

            var iCurScrollPos = $(this).scrollTop();

            if(iCurScrollPos > parseInt($('.main-container').css('margin-top')))
            {
                $('body').addClass('small-header');
            }else{
                $('body').removeClass('small-header');
            }

        }

        if(iCurScrollPos > 20)
        {
            $('.scroll_pointer').removeClass('active');
        }else{
            $('.scroll_pointer').addClass('active');
        }
    });


    $('#main-navbar-collapse').on('show.bs.collapse', function () {
        $('.main-navbar').addClass('dynamic');
        //$('.main-container').css('display', 'none');
        //$('footer').css('display', 'none');

    });

    $('#main-navbar-collapse').on('hide.bs.collapse', function () {
        $('.main-navbar').removeClass('dynamic');
        //$('.main-container').css('display', 'block');
        //$('footer').css('display', 'block');
    });


    $(window).load(function(){
        jQuery('img').filter(function() {
            return this.src.match(/.*\.svg$/);
        }).each(function(){
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');

                // Replace image with new SVG
                $img.replaceWith($svg);

            }, 'xml');
        });
    });

    jQuery("document").ready(function () {


        var movementStrength = 25;
        var height = movementStrength / $(window).height();
        var width = movementStrength / $(window).width();
        //$(document).mousemove(function(e){
        //    var pageX = e.pageX - ($(window).width() / 2);
        //    var pageY = e.pageY - ($(window).height() / 2);
        //    var newvalueX = (width * pageX * -1 - 25) / 2;
        //    var newvalueY = (height * pageY * -1 - 50) / 2;
        //    $('.paral-top').css("background-position", newvalueX+"px     "+newvalueY+"px");
        //});

        $(document).scroll(function(e){
            var pageX = e.pageX - ($(window).width() / 2);
            var pageY = e.pageY - ($(window).height() / 2);
            var newvalueX = (width * pageX * -1 - 25) / 2;
            var newvalueY = (height * pageY * -1 - 50) / 2;
            $('.paral-top').css("background-position", newvalueX+"px     "+newvalueY+"px");
        });


        $('.navbar-mobile a').click(function () {

            if(!$(this).hasClass('dropdown-toggle'))
            {
                $('.navbar-mobile .navbar-collapse').collapse('hide');
            }
        });

        $('.nav a:not(.dropdown-toggle)').click(function(e) {
            var el = $(this);
            var link = el.attr('href');
            if(link)
            {
                window.location = link;
            }
        });

        //$('.nav a.dropdown-toggle').on('click touchend', function(e) {
        //
        //});

        //====INITIALIZATION


        //Animation activate
        $('.animation').hover(function(){
            $(this).addClass('animate');
        },
        function(){
            $(this).removeClass('animate');
        });

        //Collapsible list init
        if($('.collapsibleList').length)
        {
            CollapsibleLists.apply();
        }

        var collapse_hash = window.location.hash.substr(1);
        var collapse_elem = $('#' + collapse_hash);
        if(collapse_hash && $('.collapsibleList').length)
        {
            CollapsibleLists.toggle(collapse_elem[0]);
        }


        // Lazy load
        $("img.lazy").lazyload();

        //Mobile menu
        $('#dl-menu').dlmenu();


        if($(document).width() > 480)
        {
            $('.collapse-mobile').collapse();
        }

        $('.collapse-mobile').on('hide.bs.collapse', function () {
            if($(document).width() >= 768)
            {
                return false;
            }
        });

        //Bug fix for iphone/ipad
        $('footer .heading').click(function(){
            return true;
        });

        //Readmore init

        //$('.readmore-container').readmore({
        //    speed: 75,
        //    lessLink: '<a href="#" class="readmore">' + translations.close + '</a>',
        //    moreLink: '<a href="#" class="readmore">' + translations.readmore + '</a>'
        //});


        //Slick slider
        var slick_autoplay_speed = 5000;

        $('.main-slider').on('init', function(event, slick){
            $(this).find('.slick-arrow.next').html($(this).find('.slick-active').next().data('title'));
            $(this).find('.slick-arrow.prev').html($(this).find('.slick-track .slide:last-child').data('title'));
            slickLoaderStart('main-slider');
        });


        $('.main-slider').slick({
            arrows: false,
            slidesToShow: 1,
            slide: ".slide",
            centerPadding: '0px',
            //appendArrows: "#" + carouselId + " .prev_next",
            prevArrow: '<span class="prev"></span>',
            nextArrow: '<span class="next"></span>',
            cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
            speed: 700,
            fade: false,
            infinite: true,
            draggable: true,
            //pauseOnHover: false,
            dots: false,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: slick_autoplay_speed,
            responsive: [
                {
                    breakpoint: 769,
                    settings: {
                        arrows: true,
                        dots: true,
                    }
                },
                {
                    breakpoint: 736,
                    settings: {
                        arrows: false,
                        dots: true,
                    }
                }
            ]
        });


        $('nav.main-slider-nav ul > li').click(function(){
            //$('.main-slider').slick('slickGoTo', $(this).data('slide'));
            var link = $(this).data('href');
            if(link)
            {
                window.location.href = link;
            }
        });

        var hoverSlide = false;

        $('nav.main-slider-nav ul > li').hover(function(){

                hoverSlide = this;
                var obj = this;

                setTimeout(function(){
                    if(hoverSlide === obj)
                    {
                        $('.main-slider').slick('slickGoTo', $(obj).data('slide'));
                    }
                }, 500);

        },
        function(){
            hoverSlide = false;
        });

        $('.main-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){

            slickLoaderStart('main-slider');

            $('nav.main-slider-nav ul > li').eq(currentSlide).removeClass('active')
            $('nav.main-slider-nav ul > li').eq(nextSlide).addClass('active')

        });


        //Slider tablet arrows
        $('.main-slider').on('afterChange', function(event, slick, currentSlide){


            if($('.main-slider .slick-track .slide').eq(currentSlide + 1).length)
            {
                $('.slick-arrow.next').html($('.main-slider .slick-track .slide').eq(currentSlide + 1).data('title'));
            }

            if($('.main-slider .slick-track .slide').eq(currentSlide - 1).length){
                $('.slick-arrow.prev').html($('.main-slider .slick-track .slide').eq(currentSlide - 1).data('title'));
            }
        });




        $('.block-carousel').each(function (idx, item) {
            var carouselId = "carousel" + idx;
            this.id = carouselId;
            $(this).slick({
                arrows: false,
                slidesToShow: 2,
                centerMode: true,
                slide: "#" + carouselId +" .slide",
                centerPadding: '0px',
                //appendArrows: "#" + carouselId + " .prev_next",
                //prevArrow: '<span class="prev"></span>',
                //nextArrow: '<span class="next"></span>',
                //cssEase: 'ease-out',
                //speed: 800,
                //fade: true,
                infinite: true,
                draggable: true,
                dots: true,
                //adaptiveHeight: true,
                //autoplay: true,
                responsive: [
                    {
                        breakpoint: 769,
                        settings: {
                            centerMode: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });


        $('.gallery-carousel').each(function (idx, item) {
            var carouselId = "carousel" + idx;
            this.id = carouselId;
            $(this).slick({
                arrows: true,
                slidesToShow: 3,
                slide: "#" + carouselId +" .slide",
                centerPadding: '0px',
                //appendArrows: "#" + carouselId + " .prev_next",
                prevArrow: '<span class="prev"></span>',
                nextArrow: '<span class="next"></span>',
                cssEase: 'ease-out',
                //speed: 800,
                //fade: true,
                infinite: false,
                draggable: true,
                dots: false,
                //adaptiveHeight: true,
                autoplay: true,
                responsive: [
                    {
                        breakpoint: 480,
                        settings: {
                            centerMode: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });


        // Owl slider

        var owl = $('.thumb-slider').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            navText: ['<div class="owl-nav-next"><div></div>', '<div class="owl-nav-prev"></div>'],
            responsive:{
                0:{
                    items:1
                },
                400:{
                    items: 2,
                },
                600:{
                    items:4
                }
            }
        });

        var owl_product_slider = $('.products-slider').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ['<div class="owl-nav-next arrow-circle"><div></div>', '<div class="owl-nav-prev arrow-circle"></div>'],
            responsive:{
                0:{
                    items:1
                },
                400:{
                    items: 2,
                },
                600:{
                    items:3
                },
                1000:{
                    items:4
                }
            }
        });



        //Price table styles

        $('.table-responsive table td[colspan]').each(function(){

            $(this).css({
                'background-color': '#e1e3e6',
                'color': '#333333',
                'font-size': '16px',
                'font-weight': '700'
            });
        });


        // Popup js
        var form_popup;
        $('.html_popup').popup({
            content : function(e){

                return $('.popup_content').html();
            },
            type : 'html',
            closeContent: '<div class="popup_close">Х</div>',
            afterOpen: function(){
                form_popup = this;
                $('form').wpcf7InitForm(); // Initialize form for AJAX
                return;
            }
        });


        $(".wpcf7").on('wpcf7:mailsent', function(event){

            setTimeout(function(){
                $('#requestModal').modal('hide');
            }, 2000);
        });


        //init youtube
        $('.img-placeholder').click(function (ev) {

            var video_iframe = $('#'+$(this).data('target')).find('iframe');

            video_iframe[0].src += "&autoplay=1";
            ev.preventDefault();

            $(this).hide();
            video_iframe.show();

        });


        //toggle full text
        $('.toggle').click(function () {

            $(this).parent().parent().find('.excerpt').toggleClass('show');
            $(this).parent().parent().find('.full').toggleClass('show');
            $(this).find('span').toggleClass('show');

        });


        //JS selector
        $('.js-select').change(function(){
            window.location.href = $(this).val();
        });

        //====INITIALIZATION END


        //Fixed side menu
        if($('.side-menu').length)
        {
            var is_iPad = navigator.userAgent.match(/iPad/i) != null;

            $(document).scroll(function(){
                if($(document).width() > 992 && !is_iPad)
                {
                    var scrollTop     = $(window).scrollTop(),
                        elementOffset = $('.center-content').offset().top,
                        distance      = (elementOffset - scrollTop);


                    //if(Math.abs(distance) < $('.main-navbar').outerHeight() || distance < 0)
                    //{
                    //    $('.main-content').addClass('fixed-menu');
                    //    var menu_bottom   = $('.side-menu').offset().top + $('.side-menu').height(),
                    //        center_bottom = $('.center-content').offset().top + $('.center-content').height();
                    //
                    //    if( menu_bottom > center_bottom)
                    //    {
                    //        $('.main-content').removeClass('fixed-menu');
                    //
                    //    }else{
                    //        $('.main-content').addClass('fixed-menu');
                    //    }
                    //
                    //}else{
                    //    $('.main-content').removeClass('fixed-menu');
                    //
                    //}
                }
            });
        }


        // Scroll animation to element in data attribute
        $('a[data-scroll]').click(function () {

            if ($(this).data('scroll')) {
                $('html, body').animate({
                    scrollTop: $($(this).data('scroll')).offset().top - $('.main-navbar').height()
                }, 2000);
            }

            return false;
        });


        //Lazy load init on button click
        $(".trigger-lazy").on("click", function () {

            $('.logos-container').removeClass('limit');
            $('.slide').each(function () {
                $(this).removeClass('hidden');
            });
            $("img.lazy-trigger").lazyload();
            $(this).addClass('hidden');
            $('.disable-lazy').removeClass('hidden');
        });

        $('.disable-lazy').toggle(function () {
                $('.logos-container').addClass('limit');
                $(this).addClass('hidden');
                $('.trigger-lazy').removeClass('hidden');
                $('html, body').animate({
                    scrollTop: 0
                }, 1);
        },
        function(){
            $('.logos-container').removeClass('limit');
        });




        $('.category-slider .categories-list .nav-item a').click(function () {
            var target = $(this).data('control');
            var current_category_block = $(this).closest('.category-slider');
            var current_slider = $(current_category_block).find('.paged-slider');

            if (current_slider) {
                var owl = window['owl_' + $(current_slider).data('slider')];
                owl.trigger('to.owl.carousel', $(this).parent().index());
            }

            var current = $(this).parent().parent().find('li.active');
            $(current).toggleClass('active');
            $(this).parent().toggleClass('active');

            $(current_category_block).find('.more').attr('href', $(this).data('category'));
            return false;
        });


        //Gallery slider
        //$(document).on('click', '.gallery-slider .slide a', function(){
        //    $(this).hide();
        //});


        //Tabs hash
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        if(hash && $('.product-tabs').length)
        {
            $('html, body').animate({
                scrollTop: $('.product-tabs').offset().top - $('.main-navbar').outerHeight() - 25
            }, 1000);
        }

        if(hash && $('.collapsible').length)
        {
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        }

        $(window).on('hashchange', function (e) {

            window.location.hash && $('ul.nav a[href="' + window.location.hash + '"]').tab('show');

            var collapse_hash = window.location.hash.substr(1);
            var collapse_elem = $('#' + collapse_hash);
            if(collapse_hash && $('.collapsible').length)
            {
                e.preventDefault();
                CollapsibleLists.toggle(collapse_elem[0]);

                $('html, body').animate({
                    scrollTop: $('.collapsibleListOpen').offset().top - $('.main-navbar').outerHeight() - 15
                }, 1000);
            }

        });

        $('.nav-tabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
            var scrollmem = $('.product-tabs').offset().top - $('.main-navbar').outerHeight() - 25;
            if(history.pushState) {
                history.pushState(null, null, this.hash);
            }
            else {
                location.hash = this.hash;
            }

            $('html, body').animate({
                scrollTop: scrollmem
            }, 1000);
            return false;
        });


        //Accordion hash
        //var hash = window.location.hash.substr(1);

        //
        //var collps_id = $('.' + hash).closest('.panel-collapse').attr('id');
        //
        //$('#' + collps_id).collapse('show');
        //
        //$('html, body').animate({
        //    scrollTop: $('#'+collps_id).offset().top - 50
        //}, 2000);


        //WPCF File upload*******************************************
        jQuery(document).on('change', '.fileUpload :file', function () {
            var input = jQuery(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
            jQuery('.uploaded-files').attr('value', label);
            jQuery('<i class="del_attach"></i>').appendTo('.uploaded-files');
            jQuery('.uploaded-files').show();
            //jQuery('.uploaded-files').append(label);
        });

        jQuery('.fileUpload :file').on('fileselect', function (event, numFiles, label) {

            var button = jQuery('.fileUpload').find("span").first();
            button.parent('.fileUpload').addClass('selected-file');
            //button.html('Pridėtas');
        });

        jQuery(document).on('click', '.del_attach', function () {
            var file_input = $(this).closest('input:file');
            var filename = $(this).closest('.uploaded-files');
            filename.html('').hide();
            file_input.reset();

        });

        jQuery(".wpcf7").on('invalid.wpcf7', function (e) {

            var error_tips = jQuery(document.createElement('div'));
            error_tips.addClass('error-tips');
            jQuery('.wpcf7-validation-errors').prepend(error_tips);

            jQuery('.wpcf7-not-valid-tip').each(function () {
                jQuery(error_tips).append(this);
            });
        });

        //END**********************************************************

        //Search page filter controller
        $('.search-filter').each(function (index, value) {

            var qw = $.getQueryParameters();
            var str = $(value).data('query').toString();

            if (typeof qw['post_type'] != 'undefined') {
                var res = qw['post_type'].search(str);

                if (res !== -1) {
                    $(this).addClass('active');
                }
            }

        });

        //Search filter logick
        $('.search-filter').on('click', function () {

            //var s = getQueryVariable(url, 's');
            var post_type = getQueryVariable(window.location.href, 'post_type');

            if ($(this).hasClass('active')) {
                var new_url = updateQueryStringParameter(window.location.href, 'post_type', post_type.replace($(this).data('query').toString(), ''));

            } else {
                if (post_type) {
                    var new_url = updateQueryStringParameter(window.location.href, 'post_type', post_type + ',' + $(this).data('query').toString())

                } else {
                    var params = {'post_type': $(this).data('query').toString()};
                    var new_url = window.location.href + '&' + jQuery.param(params);
                }
            }

            new_url = new_url.replace(',,', ',');
            new_url = new_url.replace('=,', '=');
            window.location.href = new_url;
        });


        //Offcanvas
        $('[data-toggle="offcanvas"]').click(function () {
            $('.row-offcanvas').toggleClass('active')
        });


    });


    function parallax(e, target, layer) {
        var layer_coeff = 10 / layer;
        var x = ($(window).width() - target.offsetWidth) / 2 - (e.pageX - ($(window).width() / 2)) / layer_coeff;
        var y = ($(window).height() - target.offsetHeight) / 2 - (e.pageY - ($(window).height() / 2)) / layer_coeff;
        $(target).offset({ top: y ,left : x });
    };


    function slickLoaderStart(element_class){

        $('.' + element_class + ' .loader').removeClass('loaded');
        setTimeout(function(){
            $('.' + element_class + ' .loader').addClass('loaded');
        }, 10);

    }

})(jQuery);


function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        if (value !== '') {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri.replace(re, '');
        }
    }
    else {
        return uri + separator + key + "=" + value;
    }
}


function getQueryVariable(url, variable) {
    var query = url.substring(0);
    var vars = query.split(/[?|&]/);

    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (pair[0] == variable) {
            return pair[1];
        }
    }

    return false;
}


var google_maps_style = [
        {
            "featureType": "all",
            "elementType": "labels.text",
            "stylers": [
                {
                    "saturation": "12"
                },
                {
                    "color": "#002544"
                },
                {
                    "lightness": "-5"
                },
                {
                    "gamma": "7.71"
                },
                {
                    "weight": "10.00"
                },
                {
                    "invert_lightness": true
                }
            ]
        },
        {
            "featureType": "all",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#1fb5cc"
                }
            ]
        },
        {
            "featureType": "all",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#1fb5cc"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative.country",
            "elementType": "labels.text",
            "stylers": [
                {
                    "color": "#1fb5cc"
                }
            ]
        },
        {
            "featureType": "administrative.country",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#002544"
                }
            ]
        },
        {
            "featureType": "administrative.country",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative.province",
            "elementType": "labels.text",
            "stylers": [
                {
                    "color": "#1fb5cc"
                }
            ]
        },
        {
            "featureType": "administrative.province",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#002544"
                }
            ]
        },
        {
            "featureType": "administrative.province",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#ffffff"
                },
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative.locality",
            "elementType": "labels.text",
            "stylers": [
                {
                    "color": "#1fb5cc"
                }
            ]
        },
        {
            "featureType": "administrative.locality",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#002544"
                }
            ]
        },
        {
            "featureType": "administrative.locality",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative.neighborhood",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#002544"
                }
            ]
        },
        {
            "featureType": "administrative.neighborhood",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#1fb5cc"
                }
            ]
        },
        {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [
                {
                    "color": "#f2f2f2"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "labels.text",
            "stylers": [
                {
                    "color": "#002544"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#1fb5cc"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#002544"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "all",
            "stylers": [
                {
                    "saturation": -100
                },
                {
                    "lightness": 45
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#c1b6a5"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#002544"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "simplified"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#1fb5cc"
                }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "all",
            "stylers": [
                {
                    "color": "#ffffff"
                },
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#265c88"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#ffffff"
                }
            ]
        }
    ];


jQuery.extend({

    getQueryParameters: function (str) {
        return (str || document.location.search).replace(/(^\?)/, '').split("&").map(function (n) {
            return n = n.split("="), this[n[0]] = n[1], this
        }.bind({}))[0];
    }

});


jQuery.extend({
    stripslashes : function (str) {

        return str.replace(/\\'/g,'\'').replace(/\"/g,'"').replace(/\\\\/g,'\\').replace(/\\0/g,'\0').replace(/\\/g, '');


    }
});
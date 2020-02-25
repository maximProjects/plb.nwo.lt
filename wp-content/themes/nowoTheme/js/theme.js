jQuery(function($) {
    $("form").attr('novalidate', 'novalidate');
    var slidesShow = 3;
    if(isMobile()) {
        slidesShow = 1;
    }
    $('#history-slider').slick({
        centerMode: true,
        centerPadding: '0px',
        infinite: true,
        slidesToShow: slidesShow,
        slidesToScroll: 1
    });

    $('body').on('click', '.search-box svg', function (e) {
        var s = $('.search-box #search').val();
        var cat_url = $('.search-box #search-url').val();
        if(s) {
            var url = cat_url + '?s=' + s;
            window.location.href = url;
        } else {
            window.location.href = cat_url;
        }
    });

    $('#history-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        console.log('beforeChange', currentSlide, nextSlide);
    });
    $('#history-slider').on('afterChange', function (event, slick, currentSlide) {
        console.log('afterChange', currentSlide);
    });

    $('body').on('click', '.actual', function (e) {
       e.preventDefault();
       $('#paypal-box form').submit();
    });
    $('.employee-info .email-link').on('click', function (e) {
        e.preventDefault();
        var hasClass = $(this).closest('.employee-info').hasClass('active');
        $('.employee-info').removeClass('active');
        if (hasClass) {
            $(this).closest('.employee-info').removeClass('active');
        } else {
            $(this).closest('.employee-info').addClass('active');
        }

    });

    function setSubMenuActive() {
        var countSubMenu = $('.sub-menu.dropdown-menu > a.active').length;
        if(countSubMenu > 1) {
            $.each($('.sub-menu.dropdown-menu > a.active'), function (key, value) {
                var hr = $(this).attr('href');

                var hash = hr.substring(hr.indexOf("#"));
                var hashOrg = $(location).attr('hash');
                if(hashOrg != hash) {
                    $(this).removeClass('active');
                }

            });
        }
    }

    setSubMenuActive();

    $('body').on('click', '.sub-menu.dropdown-menu > a', function (e) {
        $('.sub-menu.dropdown-menu > a').removeClass('active');
        $(this).addClass('active');
    });



    // $(".link-block").click(function(e) {
    //     e.preventDefault();
    //     history.back(1);
    // });

    $('.contacts .email-link').on('click', function (e) {
       e.preventDefault();
        var hasClass = $(this).closest('.row').hasClass('active');
       $('.contacts .row').removeClass('active');
        if (hasClass) {
            $(this).closest('.row').removeClass('active');
        } else {
            $(this).closest('.row').addClass('active');
        }
    });

    var max_height = $(window).height() - 285;
    $('#map-container svg#map-svg').css("max-height", max_height);

    $('#map-container path').on('hover', function (e) {
        if(!$(this).hasClass('people-path')) {
            $("svg path").removeClass('filled-hover');
            $("svg path").removeClass('filled-people-hover');
        }
       //
        var id = $(this).attr('id');

        $('path#p-'+id).addClass('filled-people-hover');
        $(this).addClass('filled-hover');

    });

    $('#map-container svg').on('mouseleave', function (e) {
        $("svg path").removeClass('filled-hover');
         $("svg path").removeClass('filled-people-hover');
        if(!$(this).hasClass('people-path')) {
            // $('body').mousemove(function(evt){
            //     console.log(evt.target);
            //     if(!$(evt.target).hasClass('people-path')) {
            //         alert('remove');
            //     }
            // });
            // $("svg path").removeClass('filled-hover');
            // $("svg path").removeClass('filled-people-hover');

        }
    });

    $('#map-container path').on('click', function (e) {
        var id = $(this).attr('id');
        var top = $('path#p-'+id).offset().top + 40;
        var left = $('path#p-'+id).offset().left;

        var height = $(window).height();
        var blockH = 350;

        var h = height - blockH;

        $('#map-container path').removeClass('filled');
        $('#map-container path').removeClass('filled-people');
        $('path#p-'+id).addClass('filled-people');
        $(this).addClass('filled');

        $("body").find('.community-box').removeClass('active');

        $("body").find('.community-box').css({top: -370, left: -250});

        if (h > top) {
            $("body").find('[data-cat-id="' + id + '"]').css({top: top, left: left});
        } else {
            var thisTop = h;
            $("body").find('[data-cat-id="' + id + '"]').css({top: h, left: left+40});
        }

        $("body").find('[data-cat-id="' + id + '"]').addClass('active');
    });

    $('.community-box a.close').on('click', function (e) {

        $(this).closest('.community-box').removeClass('active');
        $('#map-container path').removeClass('filled');
        $('#map-container path').removeClass('filled-people');
    });


    $('.email-form a.close').on('click', function (e) {
        e.preventDefault();
        $(this).closest('.active').removeClass('active');
    });


    // $("body").on('click', '.navbar a', function (e) {
        //e.preventDefault();
        // console.log('return false');
        // return false;
    // });

    if(isMobile()) {


        // $(document).on('click', function (e) {
        //     if ($(e.target).closest(".sub-box").length === 0) {
        //
        //         $(".sub-box .sub-menu").removeClass('show');
        //     }
        // });

        $('body').on('click', '#filter-menu .menu-item-has-children > a', function (e) {
            var left = $(this).offset().left;
            var w = $(window).width();
            var dif = w - left;
            if(dif < 175) {
                left = 175;
            }
            $('.sub-box .sub-menu').css({top: 30, left: left});
            if($('.sub-box .sub-menu').hasClass('show')) {
                $('.sub-box .sub-menu').removeClass('show');
            } else {
                $('.sub-box .sub-menu').addClass('show');
            }

        });


        // $('body').on('click', '#filter-menu li.show', function (e) {
        //     alert('dgvbv');
        // });

        $.each($('#menu-main_menu .sub-menu'), function (key, value) {
            $(this).prepend("<span class='close'></span>");
        });
        //
        // var menuH = $('#menu-main_menu').height() - 20;
        //
        // $('#menu-main_menu .sub-menu').height(menuH);

        $('body').on('click', '#menu-main_menu li.menu-item-has-children', function (e) {

            $('#menu-main_menu li').removeClass('active');
            if(!$(e.target).hasClass('close')) {
                $(this).closest('li').addClass('active');

                var menuH = $('#menu-main_menu').height() - 20;

                $('#menu-main_menu .sub-menu').height(menuH);


            }

        });
        // $('body').on('click', '.sub-menu.dropdown-menu a', function(e) {
        //     alert('fvsa');
        //     $(this).closest('li').removeClass('active');
        // });

        // $('body').on('click', '#menu-main_menu .close', function (e) {
        //     e.preventDefault();
        //     $('body').find('#menu-main_menu li').removeClass('active');
        // });

       $('#menu-main_menu a.dropdown-toggle').addClass('disabled');
        $.each($('#menu-main_menu a.disabled'), function (key, value) {
            var dropdown = $(this).closest('li').find('div');
            var url = $(this).attr('href');
            var txt = $(this).text();
            dropdown.prepend('<a href="'+url+'" class="dropdown-item">'+txt+'</a>');
        });
    }

    $('.navbar .dropdown').hover(function () {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();

    }, function () {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();

    });

    $('.navbar .dropdown > a').click(function () {
        location.href = this.href;
    });


    //calendar
    moment.locale('lt');
    moment.lang('lt');
    // Here's some magic to make sure the dates are happening this month.


    var thisMonth = moment().format('YYYY-MM');
    // Events to load into calendar
    var eventArrayOld = [
        {
            title: 'Multi-Day Event',
            endDate: thisMonth + '-14',
            startDate: thisMonth + '-10'
        }, {
            endDate: thisMonth + '-23',
            startDate: thisMonth + '-21',
            title: 'Another Multi-Day Event'
        }, {
            date: thisMonth + '-27',
            title: 'Single Day Event',
            url: "/#123"
        }
    ];

    var ev = getEvents();
    var eventArray = ev.events;
    if($('.cal1').length > 0) {
    calendar = $('.cal1').clndr({
        events: eventArray,
        // startWithMonth: moment("2020-09-25"),
        clickEvents: {
            click: function (target) {
                $(target.element).addClass('active');

                //  console.log('Cal-1 clicked: ', target);
                // var eventsHtml =  getEventList(target.events);
                var events = [];

                $.each(target.events, function (key, value) {
                    events.push(value.id);
                });
                if (events.length) {
                    var html = getEventList(events);
                    $('.events-box').html(html);
                }
            },
            today: function () {
                console.log('Cal-1 today');
            },
            nextMonth: function () {
                console.log('Cal-1 next month');
            },
            previousMonth: function () {
                console.log('Cal-1 previous month');
            },
            onMonthChange: function () {
                console.log('Cal-1 month changed');
            },
            nextYear: function () {
                console.log('Cal-1 next year');
            },
            previousYear: function () {
                console.log('Cal-1 previous year');
            },
            onYearChange: function () {
                console.log('Cal-1 year changed');
            },
            nextInterval: function () {
                console.log('Cal-1 next interval');
            },
            previousInterval: function () {
                console.log('Cal-1 previous interval');
            },
            onIntervalChange: function () {
                console.log('Cal-1 interval changed');
            }
        },
        multiDayEvents: {
            singleDay: 'date',
            endDate: 'endDate',
            startDate: 'startDate'
        },
        showAdjacentMonths: true,
        adjacentDaysChangeMonth: false
    });

}

    if(!isMobile()) {
        $(".events-box").niceScroll(
            {
                autohidemode: false,
                cursorwidth: "5px",
                cursorcolor: "#04D177",
                cursorfixedheight: "215",
                railalign: "left", // alignment of vertical rail

            }
        );
    }

    function getEvents() {
        var res = "";
        $.ajax({
            url: params.ajax_url,
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {action: 'get_events'},
            success: function (data) {
                res = data;
            }
        });

        return res;
    }

    function getEvent(post_id) {
        var html = '';
        $.ajax({
            url: params.ajax_url,
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {action: 'get_event', post_id: post_id},
            success: function (data) {

                html =  data.html;

            }
        });
        return html;
    }

    function getEventList(events) {
        var html = "";
        $.ajax({
            url: params.ajax_url,
            type: 'POST',
            async: false,
            dataType: 'json',
            data: {action: 'get_events_list', events: events},
            success: function (data) {
                html = data.html;
            }
        });
        return html;
    }

    if($('.calculator-box').length > 0 ) {
        var hashOrg =  window.location.hash.substr(1);
        if(hashOrg) {
          var event = $("body").find(".news-vertical-box[data-id='"+hashOrg+"']");

            var post_id = $(event).data('id');
            var post_date = $(event).data('date');
            var date =  new Date($(event).data('date'));

            $('.events .news-vertical-box').removeClass('active');
            $(event).addClass('active');
            var html = getEvent(post_id);

            location.hash = post_id;

            if(!isMobile()) {
                $("#single-event").html(html);
                $('html, body').animate({
                    scrollTop: $("#single-event").offset().top-100
                }, 1000);
            } else {

                $('.events .news-vertical-box').find('.thmb').show();
                $('.events .news-vertical-box').find('.content').show();
                $('.events .news-vertical-box').removeClass('load');
                $(event).find('.thmb').hide();
                $(event).find('.content').hide();
                $(event).find('.thmb').addClass('off');
                $(event).addClass('load');
                $('.events .news-vertical-box .project-content').remove();

                $(event).append(html);
                $('html, body').animate({
                    scrollTop: $(event).offset().top-100
                }, 1000);
            }
            // set calendar to month
            calendar.setMonth(date.getMonth());
            $('.clndr-table td.calendar-day-'+post_date).removeClass('active');
            $('.clndr-table td.calendar-day-'+post_date).addClass('active');
        }

    }

    // load post
    $('body').on('click', '.events .news-vertical-box', function (e) {
        e.preventDefault();
        var post_id = $(this).data('id');
        var post_date = $(this).data('date');
        var date =  new Date($(this).data('date'));
        $('.events .news-vertical-box').removeClass('active');
        $(this).addClass('active');
        var html = getEvent(post_id);

        location.hash = post_id;

        if(!isMobile()) {
            $("#single-event").html(html);
            $('html, body').animate({
                scrollTop: $("#single-event").offset().top-100
            }, 1000);
        } else {

            $('.events .news-vertical-box').find('.thmb').show();
            $('.events .news-vertical-box').find('.content').show();
            $('.events .news-vertical-box').removeClass('load');
            $(this).find('.thmb').hide();
            $(this).find('.content').hide();
            $(this).find('.thmb').addClass('off');
            $(this).addClass('load');
            $('.events .news-vertical-box .project-content').remove();

            $(this).append(html);
            $('html, body').animate({
                scrollTop: $(this).offset().top-100
            }, 1000);
        }
        // set calendar to month
        calendar.setMonth(date.getMonth());
        $('.clndr-table td.calendar-day-'+post_date).removeClass('active');
        $('.clndr-table td.calendar-day-'+post_date).addClass('active');

    });
    var wpcf7Elms = document.querySelectorAll( '.wpcf7' );

    wpcf7Elms.forEach(function(wpcf7Elm) {
        wpcf7Elm.addEventListener( 'wpcf7mailsent', function( event ) {
            var container = $(this).closest('.email-form');
            container.find('.success').addClass('active');
            setTimeout(function(contaner){
                container.find('.success').removeClass('active');
            }, 3000);
        }, false );
        wpcf7Elm.addEventListener( 'wpcf7invalid', function( event ) {
            var container = $(this).closest('.email-form');
            container.find('.error').addClass('active');
            setTimeout(function(contaner){
                container.find('.error').removeClass('active');
            }, 3000);
        }, false );

    });

    $(".wpcf7").on('wpcf7:mailsend', function(event){
        alert('something send');
    });

    $('body').on('click', '.scroll-top', function (e) {
       e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    $(window).scroll(function() {


        if($(window).scrollTop() > 50 ) {
            $('.header-box').addClass('active');
        } else {
            $('.header-box').removeClass('active');
        }

        if($(window).scrollTop() > 100 ) {
            $('.scroll-top').addClass('active');
        } else {
            $('.scroll-top').removeClass('active');
        }
    });

    // $(".wpcf7").on('wpcf7:invalid', function(event){
    //     alert('something wrong');
    // });
    //
    // document.addEventListener( 'wpcf7mailsent', function( event ) {
    //    alert('send');
    // }, false );

    // $(".wpcf7").on('wpcf7:mailsend', function(event){
    //     alert('something send');
    // });
    function  isMobile(m = 1200) {

       var w = $(window).width();
       if(w < m) {
           return true;
       } else {
           return false;
       }
    }



});

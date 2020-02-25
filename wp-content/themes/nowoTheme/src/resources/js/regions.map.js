(function ($) {


    var current;
    var $popup_div;
    var _ajax;
    var cache_regions;
    var map_left, map_right, map_top, map_bottom;


    var regionMap = {

        selector: '.regionsMap',
        path : '',
        path_id : '',
        path_name : '',
        regions : [],

        init: function () {

            var self = regionMap;

            map_top = $('.regionsMap > svg').offset().top;
            map_left = $('.regionsMap > svg').offset().left;
            map_bottom = map_top + $('.regionsMap > svg').height();
            map_right = map_left + $('.regionsMap > svg').width();


            self.getRegionsInfo();
            $(regionMap.selector + ' svg > g').hover(
                function (e)
                {
                    current = this;
                    self.toggleRegion(e, current, '#03356A', '#fff');
                    regionMap.getRegionInfo(e, current);
                },
                function (e) {
                    if($(e.toElement).attr('class') != 'map-tooltip')
                    {
                        self.toggleRegion(e, current, '#E5E5E5', '#787878');
                        if($popup_div)
                        {
                            $popup_div.hide();
                        }
                    }
                });

            $(document).on('mouseleave', '.map-tooltip',function(e){
                self.toggleRegion(e, current, '#E5E5E5', '#000');
                if($popup_div)
                {
                    $popup_div.hide();
                }
            });
        },


        toggleRegion: function(e, region, path_fill, text_fill){



            self.path = $(region).find('path');



            self.path = !jQuery(self.path).is('path') ? $(region).find('polyline') : self.path;

            self.path_id = $(region).attr('id');
            self.path_name = $(region).find('text').html();
            self.path_text = $(region).find('text');
            self.path_tspan = $(region).find('tspan');


            $(path).css('fill', path_fill);
            $(path_text).css('fill', text_fill);
            $(path_tspan).each(function(){
                $(this).css('fill', text_fill);
            });
        },


        getRegionsInfo: function () {

            var regions_ids = [];
            $(regionMap.selector + ' svg > g').each(function(){
                regions_ids.push($(this).attr('id'));
            });

            if(regions_ids.length > 0)
            {
                _ajax = $.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: {'action': 'map_regions_info', path_ids: regions_ids},
                    success: function(response){

                        var res = JSON.parse(response);

                        $(res).each(function(index, value){

                            cache_regions = value;
                        });
                    }
                });
            }
        },

        getRegionInfo: function(event, region){

            if(cache_regions)
            {
                var response = cache_regions[self.path_id];

                if(response)
                {
                    if(!$popup_div || $popup_div == 'undefined')
                        $popup_div = $('<div />').appendTo('body');

                    $($popup_div).html(
                        '<div class="img"><img src="'+response.employee_image+'"/></div>' +
                        '<div class="info">' +
                        '<h5 class="company">'+response.company_name +'</h5>' +
                        '<h3 class="title">'+response.employee_name+' '+ response.employee_surname +'</h2>' +
                        '<hr/>' +
                        //'<p class="position">'+response.employee_position+'</p>' +
                        '<p class="phone">'+response.employee_phone+'</p>' +
                        '<p><a class="email" href="mailto:'+response.employee_email+'">'+response.employee_email+'</a></p>' +
                        '</div>'
                    );

                    this.calcPosition(event);
                }
            }

        },
        calcPosition: function(event){

            //console.log('Hover');
            //console.log(current);
            //console.log(current.getBBox().x);
            //console.log(current.getBBox().y);
            //console.log('---');

            var offsetTop = $('.regionsMap ').offset().top;
            var offsetLeft = $('.regionsMap ').offset().left;



            $popup_div.attr('class', 'map-tooltip');
            //
            //if(event.pageY + 170 < map_bottom)
            //{
            //    $popup_div.css('top', event.pageY  + 'px');
            //}else{
            //    $popup_div.css('top', event.pageY - 170  + 'px');
            //}
            //
            //if(event.pageX + 320 < map_right)
            //{
            //    $popup_div.css('left', event.pageX + 'px');
            //}else{
            //
            //    $popup_div.css('left', event.pageX - 320 + 'px');
            //}

            $popup_div.css('top', offsetTop + 20 + 'px');
            $popup_div.css('left', offsetLeft + 20 + 'px');

            $popup_div.show();

        },


    }


    $(document).ready(function(){

        if($('.regionsMap svg').length)
        {
            regionMap.init();
        }
    });

})(jQuery);

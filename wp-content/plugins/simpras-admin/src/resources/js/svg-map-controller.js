(function ($) {

    var self, path, path_id, path_name,
        regions;

    var SvgMapController = {

        init: function(){


            self = SvgMapController;

            self.getRegions();

            $('svg > g').toggle(function () {

                    path = $(this).find('path');
                    path_id = $(this).attr('id');
                    path_name = $(this).find('text').html();
                    path_text = $(this).find('tspan');

                    var index = self.arrayObjectIndexOf(regions, path_id, 'path_id');

                    if (index == -1) {
                        regions.push({path_id : path_id, path_name : path_name});
                    }
                    $(path).css('fill', '#ffca28');
                    $(path_text).each(function () {
                        $(this).css('fill', '#fff')
                    });


                    $('#employee_regions').val(JSON.stringify(regions));
                },
                function () {

                    path = $(this).find('path');
                    path_id = $(this).attr('id');
                    path_name = $(this).find('text').html();
                    path_text = $(this).find('tspan');

                    var index = self.arrayObjectIndexOf(regions, path_id, 'path_id');
                    if (index > -1) {
                        regions.splice(index, 1);
                    }

                    $(path).css('fill', '#E5E5E5');
                    $(path_text).each(function () {
                        $(this).css('fill', '#000')
                    });
                    $('#employee_regions').val(JSON.stringify(regions));
                }
            );
        },

        getRegions: function(){

            var _ajax = $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {'action': 'map_regions_list', post_id: admin_post.post_id},
                success: function(response){

                    var res = JSON.parse(response);

                    regions = res;
                    self.toggleRegion(regions);
                }
            });
        },

        arrayObjectIndexOf: function(myArray, searchTerm, property){

            for(var i = 0, len = myArray.length; i < len; i++) {

                if (myArray[i][property] === searchTerm){

                    return i;
                }
            }
            return -1;
        },

        toggleRegion: function(){
            setTimeout(function(){

                $(regions).each(function(index, value){

                    var region = document.getElementById(value.path_id);
                    $(region).trigger('click');

                });

            }, 100);
        }
    }


    $(document).ready(function(){

        SvgMapController.init();
    });

})(jQuery);
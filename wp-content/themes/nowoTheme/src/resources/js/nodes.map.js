(function ($) {


    var current_marker;

    var NodesMap = {

        /**
         * Initiates plugin
         */
        init: function(){


            NodesMap.markerEvents();

            $('.node-category a').click(function(e){

                NodesMap.selectCategory(this);
            });

            $('.marker').click(function(e){

                NodesMap.selectCategory(this);
            });
        },

        /**
         * Initiates map object
         */
        initMap: function () {



        },

        /**
         * Adds markers events
         */
        markerEvents : function(){



        },

        /**
         * Get cities data JSON
         */
        selectCategory : function(e){

            if(current_marker)
                $('.marker[data-marker-control="'+current_marker+'"]').removeClass('active');

            current_marker =  $(e).data('marker-control');


            $('.marker[data-marker-control="'+current_marker+'"]').addClass('active');

            var current = $('.node-category').find('a.selected');
            $(current).toggleClass('selected');
            $('.node-category a[data-marker-control="'+current_marker+'"]').toggleClass('selected');

            NodesMap.getCategoryOptions(current_marker);
        },


        /**
         * Get countries data JSON
         */
        getCategoryOptions : function(category_id){

            var ajax = $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {'action': 'get_node_elements', 'term_id': category_id},
                success: function(res){

                    if(res)
                    {
                        var response = JSON.parse(res);
                        //console.log(response);
                        NodesMap.populateTable(response);
                    }
                }
            })
        },


        /**
         * Push cities data to map
         */
        populateTable : function(response){

            $(".node-elements table tbody").empty();

            $(".node-elements table thead .node-name").html(response.node.node_title);
            $(response.node.node_elements).each(function(){

                var node = $.map(this, function(el){
                    return el;
                });

                var tableRow = NodesMap.makeTableRow(node);

                $(".node-elements table tbody").append(tableRow);
            });


            $(".node-elements").removeClass('hidden');
            $('html, body').animate({
                scrollTop: $(".node-elements").offset().top - $('.main-navbar').height()
            }, 2000);

        },

        /**
         * Show current marker info
         */
        selectMarker : function(marker) {

        },

        makeTableRow : function(element) {

            //console.log(arguments);
            var s = "<tr><td>{0}</td><td>" +
                "<a href='{1}'><img src='../img/pdf_icon.png' alt=''></a>" +
                "</td><td>" +
                "<a href='{2}'><img src='../img/pdf_icon.png' alt=''></a>" +
                "</td><td></td></tr>";

            for (var i = 0; i <= element.length - 1; i++) {
                var reg = new RegExp("\\{" + i + "\\}", "gm");
                if(element[i])
                {
                    s = s.replace(reg, element[i]);
                }else{
                    s = s.replace(reg, '');
                }
            }

            return s;
        }


    };


    $(document).ready(function(){

        NodesMap.init();

    });



})(jQuery);


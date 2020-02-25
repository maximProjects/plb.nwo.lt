(function ($) {


    var self, current_filter;

    var CatalogControls = {

        /**
         * Initiates plugin
         */
        init: function(){

            self = CatalogControls;


            $('.order_by').on('change', function (e) {

                current_filter = this;
                CatalogControls.updateQuery('order_by');

            });
            //
            $('.per_page').on('change', function (e) {

                current_filter = this;
                CatalogControls.updateQuery('per_page');

            });

            $('.grid_view').on('click', function (e) {

                current_filter = this;
                CatalogControls.updateQuery('view', 'grid');

            });

            $('.list_view').on('click', function (e) {

                current_filter = this;
                CatalogControls.updateQuery('view', 'list');

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


        },


        /**
         * Get countries data JSON
         */
        getCategoryOptions : function(){

        },


        /**
         * Push cities data to map
         */
        updateQuery : function(variable, value){

            var param = getQueryVariable(window.location.href, variable);

            if(param)
            {
                var new_url = updateQueryStringParameter(window.location.href, variable, value ? value : current_filter.value)

            }else{

                var params = {};
                params[variable] = value ? value : current_filter.value;
                if(window.location.href.indexOf('?') > 0)
                {
                    var new_url = window.location.href + '&' +jQuery.param(params);
                }else{
                    var new_url = window.location.href + '?' +jQuery.param(params);
                }

            }

            new_url = new_url.replace(',,', ',');
            new_url = new_url.replace('=,', '=');

            window.location.href = new_url;

        },

        /**
         * Show current marker info
         */
        selectMarker : function(marker) {

        },

        makeTableRow : function(element) {

        }

    };


    $(document).ready(function(){

        CatalogControls.init();

    });



})(jQuery);


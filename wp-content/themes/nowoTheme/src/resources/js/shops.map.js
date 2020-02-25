(function ($) {

    var map, def_lat, def_lng, def_country, countries, arrCountries, arrCities = [], theCountry, theCity, mapElement, markerCluster, clusterClicked, currentMarker,
        markers = [], sudgestions = [];



    var ShopsMap = {

        /**
         * Initiates plugin
         */
        init: function(){

            //Getting ajax map data
            ShopsMap.getCountriesOptions();


            $(document).on('click touchstart', 'li[data-index]', function(){
                var value = $(this).data('index');

                ShopsMap.hideMarkerInfo();
                
                ShopsMap.showCityShops(value);

            });

            $(document).on('click touchstart', 'li[data-country]:not(.disabled)', function(){
                ShopsMap.hideMarkerInfo();
                ShopsMap.selectCountry($(this).data('country'));
            });



            $('body').on('focus', 'input[name=city_name]', function(){
                ShopsMap.searchCities(this);
            });

        },

        /**
         * Initiates map object
         */
        initMap: function () {


            if(def_lat && def_lng)
            {
                var lat = def_lat;
                var lng = def_lng;
            }else if(def_country){

                var lat = arrCities[0].city_lat;
                var lng = arrCities[0].city_lon;
            }else{
                var lat = '56.0018287';
                var lng = '22.0914123';
            }


            var mapOptions = {
                center: new google.maps.LatLng(lat,lng),
                zoom: 6,
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.DEFAULT,
                },
                disableDoubleClickZoom: true,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                },
                scaleControl: true,
                scrollwheel: true,
                panControl: false,
                streetViewControl: false,
                draggable : true,
                overviewMapControl: false,
                overviewMapControlOptions: {
                    opened: false,
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [
                    {
                        "featureType": "all",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#919191"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "invert_lightness": true
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#0f263c"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "weight": "1.15"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "weight": "1.76"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.locality",
                        "elementType": "all",
                        "stylers": [
                            {
                                "hue": "#2c2e33"
                            },
                            {
                                "saturation": 7
                            },
                            {
                                "lightness": 19
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.neighborhood",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.land_parcel",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "saturation": "-2"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [
                            {
                                "hue": "#ffffff"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 100
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#eff0f0"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.man_made",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#dbdbdb"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [
                            {
                                "hue": "#ffffff"
                            },
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 100
                            },
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "hue": "#bbc0c4"
                            },
                            {
                                "saturation": -93
                            },
                            {
                                "lightness": 31
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#325b92"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "hue": "#bbc0c4"
                            },
                            {
                                "saturation": -93
                            },
                            {
                                "lightness": 31
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "hue": "#bbc0c4"
                            },
                            {
                                "saturation": -93
                            },
                            {
                                "lightness": -2
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "hue": "#e9ebed"
                            },
                            {
                                "saturation": -90
                            },
                            {
                                "lightness": -8
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [
                            {
                                "hue": "#e9ebed"
                            },
                            {
                                "saturation": 10
                            },
                            {
                                "lightness": 69
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#a2a2a2"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [
                            {
                                "hue": "#e9ebed"
                            },
                            {
                                "saturation": -78
                            },
                            {
                                "lightness": 67
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#6ea0d5"
                            }
                        ]
                    }
                ]
            }

            mapElement = document.getElementById('shop-maps-container');
            map = new google.maps.Map(mapElement, mapOptions);



            $(arrCities).each(function(index, city){

                if(city.city_shops)
                {
                    var city_shops = $.map(city.city_shops, function(el){
                        return el;
                    });

                    $(city_shops).each(function(index_shop, shop){

                        if(typeof shop._city_shop_hide === 'undefined')
                        {
                            var marker = new google.maps.Marker({
                                icon: shop._city_shop_file ? shop._city_shop_file :'http://simpras.nwagencytalpinimas.eu/wp-content/themes/simpras/img/icons/marker.png',
                                position: new google.maps.LatLng(shop._city_shop_lat, shop._city_shop_lon),
                                map: map,
                                title: shop._city_shop_title,
                                desc: '',
                                tel: '',
                                email: '',
                                web: ''
                            });


                            marker.metadata = {type: "point", city_id: index, id: index_shop};

                            marker.addListener('click', function(){
                                ShopsMap.selectMarker(this);
                            });

                            markers.push(marker);
                        }

                    });
                }
            });

            var h = 68;
            var w = 68;
            var font = 17;

            var mcOptions = {
                maxZoom: 11,
                styles: [{
                    fontFamily: 'PT Sans',
                    textSize: font,
                    height: h,
                    url: "/wp-content/themes/simpras/img/icons/marker_cluster_1.png",
                    width: w
                },
                    {
                        fontFamily: 'PT Sans',
                        textSize: font,
                        height: h,
                        url: "/wp-content/themes/simpras/img/icons/marker_cluster_1.png",
                        width: w
                    },
                    {
                        fontFamily: 'PT Sans',
                        textSize: font,
                        height: h,
                        url: "/wp-content/themes/simpras/img/icons/marker_cluster_1.png",
                        width: w
                    },
                    {
                        fontFamily: 'PT Sans',
                        textSize: font,
                        height: h,
                        url: "/wp-content/themes/simpras/img/icons/marker_cluster_1.png",
                        width: w
                    },
                    {
                        fontFamily: 'PT Sans',
                        textSize: font,
                        height: h,
                        url: "/wp-content/themes/simpras/img/icons/marker_cluster_1.png",
                        width: w
                    }]
            };

            //markerCluster = new MarkerClusterer(map, markers, mcOptions);
            //ShopsMap.markerEvents();


        },

        /**
         * Adds markers events
         */
        markerEvents : function(){


            google.maps.event.addListener(markerCluster, "clusterclick", function (cluster) {
                clusterClicked = true;
                ShopsMap.hideMarkerInfo();
            });

            google.maps.event.addListener(map, 'click', function (event) {
                setTimeout(function () {
                    if (!clusterClicked) {
                        ShopsMap.hideMarkerInfo();
                    }
                    else {
                        clusterClicked = false;
                        //alert('ClusterClicked map click not executed');
                    }
                }, 0);
            });

        },

        /**
         * Get cities data JSON
         */
        selectCountry : function(country){

            markers = [];

            if(countries[country] == 'undefined')
                return false;

            theCountry = country;

            $('li[data-country].selected').toggleClass('selected disabled');
            $('li[data-country='+country+']').toggleClass('selected disabled');

            arrCities = $.map(countries[country].cities, function(el){
                return el;
            });

            $('#map_cities').html('');
            $(arrCities).each(function(index, city){

                $('#map_cities').append($("<li></li>")
                    .attr("data-index",index)
                    .html(city.city_name));
            });

            if(theCountry)
            {
                //ShopsMap.getGeocodedPosition();
                ShopsMap.initMap();
            }
        },


        /**
         * Get countries data JSON
         */
        getCountriesOptions : function(){

            var ajax = $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {'action': 'cities_info'},
                success: function(res){

                    var response = JSON.parse(res);
                    ShopsMap.populateFilter(response);
                }
            })
        },

        /**
         * Get countries data JSON
         */
        getGeocodedPosition : function(){

            var ajax = $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {'action': 'get_geocode_result', address_string: theCountry},
                success: function(res){

                    var response = JSON.parse(res);
                    def_lat = response.results[0].geometry.location.lat;
                    def_lng = response.results[0].geometry.location.lng;

                    //ShopsMap.initMap();
                }
            })
        },


        /**
         * Push cities data to map
         */
        populateFilter : function(response){

            if(!response){

                ShopsMap.initMap();
                return false;
            }

            countries = response.countries;

            arrCountries = $.map(response.countries, function(el){
                return el;
            });

            $(arrCountries).each(function(index, country){

                $('#map_countries').append($("<li id='"+country.title+"'></li>")
                    .attr("data-country",country.title)
                    .html(country.title));


                var cities = $.map(country.cities, function(el){
                    sudgestions.push({label: el.city_name, index: country.title});
                    //console.log(el);
                    return el;
                });

                //console.log(sudgestions);


            });

            if(!def_country)
            {
                ShopsMap.defaultSelection();
                //$('li[data-country='+country.title+']').toggleClass('selected disabled');
                //ShopsMap.selectCountry(country.title);
                def_country = true;
            }
        },

        /**
         * Show current marker info
         */
        selectMarker : function(marker){
            var city_id = marker.metadata.city_id;
            var marker_id = marker.metadata.id;

            var arrShops = $.map(arrCities[city_id].city_shops, function(el){
                return el;
            });

            if(currentMarker == arrShops[marker_id])
            {
                ShopsMap.hideMarkerInfo();
                return false;
            }
            currentMarker = arrShops[marker_id];


            $('.map-filter .current').html(
                ShopsMap.makeMapTableRow(
                    currentMarker._city_shop_title,
                    currentMarker._city_shop_address,
                    currentMarker._city_shop_phone,
                    currentMarker._city_shop_working_hours.replace(/(?:\\r\\n|\\r|\n|rn)/g, '<br\/>')
                ));
            ShopsMap.showMarkerInfo();
        },

        showMarkerInfo: function()
        {
            $('.map-filter .current').removeClass('hidden');
        },

        hideMarkerInfo: function () {
            $('.map-filter .current').addClass('hidden');
            currentMarker = false;
        },
        showCityShops : function (index) {

            $('li[data-index].selected').toggleClass('selected disabled');
            $("li[data-index="+index+"]").toggleClass('selected disabled');

            map.setCenter({
                lat : parseFloat(arrCities[index].city_lat),
                lng : parseFloat(arrCities[index].city_lon)
            });
            map.setZoom(11);

            var table_container = '.city-shops';

            if(!$(table_container).length)
                return false;

            $(table_container + " table tbody").empty();

            var arrShop = $.map(arrCities[index].city_shops, function(el){

                var arr_el = $.map(el, function(el){
                    return el;
                });

                    if(typeof el._city_shop_hide === 'undefined')
                    {
                        var tableRow = ShopsMap.makeShopsTableRow(
                            el._city_shop_title,
                            el._city_shop_address,
                            el._city_shop_phone,
                            el._city_shop_working_hours.replace(/(?:\\r\\n|\\r|\n|rn)/g, '<br\/>')
                        );

                        $(".city-shops table tbody").append(tableRow);

                        //console.log(el);
                        return el;
                    }
            });

            $(table_container).removeClass('hidden');
            if(!$(table_container).hasClass('no-scroll') || $('body').width() < 752)
            {
                if($(document).width() > 480)
                {
                    $('html, body').animate({
                        scrollTop: $(table_container).offset().top - $('.main-navbar').height() - 400
                    }, 1000);
                }else{
                    $('html, body').animate({
                        scrollTop: $(table_container).offset().top - $('.main-navbar').height()
                    }, 1000);
                }
            }
        },
        makeMapTableRow : function() {

            var s = "<div class='block'><h4 class='heading'>Pavadinimas</h4>" +
                "<div>{0}</div></div>" +
                "<div class='block'><h4 class='heading'>Kontaktai</h4>" +
                "<div>{1}</div>" +
                "<div>{2}</div>" +
                "<div>{3}</div></div>";

            for (var i = 0; i <= arguments.length - 1; i++) {
                var reg = new RegExp("\\{" + i + "\\}", "gm");
                if(arguments[i])
                {
                    s = s.replace(reg, $.stripslashes(arguments[i]));
                }else{
                    s = s.replace(reg, '');
                }
            }

            return s;
        },
        makeShopsTableRow : function() {

            //console.log(arguments);
            var s = "<tr>" +
                "<td>{0}</td>" +
                "<td>{1}</td>" +
                "<td>{2}</td>" +
                "<td>{3}</td>" +
                "</tr>";

            for (var i = 0; i <= arguments.length - 1; i++) {
                var reg = new RegExp("\\{" + i + "\\}", "gm");
                if(arguments[i])
                {
                    s = s.replace(reg, $.stripslashes(arguments[i]));
                }else{
                    s = s.replace(reg, '');
                }
            }

            return s;
        },

        searchCities: function (input) {


            current_input = $(input);

            $(current_input).autocomplete({
                source: sudgestions,

                select: function( event, ui ) {

                    focused_on_ajax_search = true;
                    ShopsMap.selectCountry(ui.item.index);

                    $(arrCities).each(function (index) {


                        if(this.city_name == ui.item.label)
                        {

                            ShopsMap.showCityShops(index);
                            $('.cities-list').mCustomScrollbar("scrollTo", $('li[data-index='+index+']'));

                        }
                    });

                    return true;
                }
            })
                .autocomplete( "instance")._renderItem = function(ul, item) {

                return $( "<li>" )
                    .append( "<a>" + item.value + "</a>" )
                    .appendTo( ul );
            };
        },

        defaultSelection: function(){

            markers = [];

            if(arrCountries == 'undefined')
                return false;

            $(arrCountries).each(function () {
                $.map(this.cities, function(el){

                    arrCities.push(el);
                });
            });

            $('#map_cities').html('');
            $(arrCities).each(function(index, city){

                $('#map_cities').append($("<li></li>")
                    .attr("data-index",index)
                    .html(city.city_name));
            });

            ShopsMap.initMap();

        }
    };


    $(document).ready(function(){

        if($('#shop-maps-container').length)
        {
            ShopsMap.init();
        }

    });




})(jQuery);


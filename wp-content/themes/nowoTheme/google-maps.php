<script>
    jQuery(document).ready(function(){
        google.maps.event.addDomListener(window, 'load', init);
        var map;
        function init() {

            var lat = '54.707054';
            var lng = '25.2971352';
            var mapOptions = {
                center: new google.maps.LatLng(lat,lng),
                zoom: 13,
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
                scrollwheel: false,
                panControl: false,
                streetViewControl: false,
                draggable : true,
                overviewMapControl: false,
                overviewMapControlOptions: {
                    opened: false,
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: google_maps_style,

            }
            var mapElement = document.getElementById('map_container');
            var map = new google.maps.Map(mapElement, mapOptions);


            var contentString = '<div id="content">'+
                    '<b>UAB "Tarandės šeimos klinika" </b><br/>' +
                    'Pagrandos g. 3, Vilnius'
                '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({
                icon: '/wp-content/themes/nowoTheme/img/icons/svg/marker.svg',
                position: new google.maps.LatLng(lat, lng),
                map: map,
                title: 'UAB "Tarandės šeimos klinika"',
            });

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        }
    });
</script>
<style>
    #map_container {
        height: 220px;
        width: 100%;
    }
    .gm-style-iw * {
        display: block;
        width: 100%;
    }
    .gm-style-iw h4, .gm-style-iw p {
        margin: 0;
        padding: 0;
    }
    .gm-style-iw a {
        color: #4272db;
    }
</style>
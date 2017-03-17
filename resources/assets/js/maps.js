function getMapStyle() {
    return [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#eeeeee"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#98ca7a"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#c7e3f6"}]}];
}

function mapInitialize() {

    // Initialise map object
    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
        center: new google.maps.LatLng(41.0686, 29.0285),
        maxZoom: 18,
        zoom: 11,
        disableDefaultUI: false,
        scrollwheel: false,
        mapTypeControl: false,
        panControl: false,
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(mapCanvas, mapOptions);


    // Adding predefined map styles to map
    var styledMapType = new google.maps.StyledMapType( getMapStyle(), {name: 'Styled Map'});
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');


    // building map JSON request url
    $json_for_map_url = updateQueryStringParameter(window.location.href, 'map', 1);


    // Declare your bounds
    var bounds = new google.maps.LatLngBounds();
    $.getJSON($json_for_map_url, {}, function (data) {
        $.each(data.features, function (i, marker) {
            // Get coordinates from json object
            var item = marker.geometry.coordinates;
            // Declare lat/long 
            var latlng = new google.maps.LatLng(item[1], item[0]);
            // Add lat/long to bounds
            bounds.extend(latlng);
        });
    });


    // Determining icon size for markers
    icon_scaledwidth = 46;
    icon_scaledheight = 41;
    icon_density = 1;
    if (window.devicePixelRatio > 1) {
        icon_density = 2;
    }
    if (window.devicePixelRatio > 2) {
        icon_density = 3;
    }


    // Load markers to map
    map.data.loadGeoJson($json_for_map_url);
    map.data.setStyle(function(feature) {
        var status = 'new';
        if (feature.getProperty('status') == 'in-progress') {
            status = 'in-progress';
        } else if (feature.getProperty('status') == 'solved') {
            status = 'solved';
        }
        return /** @type {google.maps.Data.StyleOptions} */({
            clickable: true,
            icon: {
                url: '/images/map-icons/marker_' + status + '@' + icon_density + 'x.png',
                size: new google.maps.Size( icon_scaledwidth * icon_density, icon_scaledheight * icon_density ),
                scaledSize: new google.maps.Size( icon_scaledwidth, icon_scaledheight ),
                anchor: new google.maps.Point( icon_scaledwidth/2, icon_scaledheight )
            }
        });
    });


    // Fit map to bounds once markers are loaded
    map.data.addListener('addfeature', function(feature) {
        map.fitBounds(bounds);
    });

    map.data.addListener('click', function(event) {
        window.location.href = '/issues/view/' + event.feature.getProperty('id');
    });
}

function mapInitializeForIssue(lon, lan, status) {
    var issue_status = (status) ? status : 'new';
    var mapCanvas = document.getElementById('map-canvas');
    var LtLng = new google.maps.LatLng(lon, lan);
    var mapOptions = {
        center: LtLng,
        // minZoom: 8,
        zoom: 13,
        disableDefaultUI: false,
        scrollwheel: false,
        mapTypeControl: false,
        panControl: false,
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(mapCanvas, mapOptions);

    // Adding predefined map styles to map
    var styledMapType = new google.maps.StyledMapType( getMapStyle(), {name: 'Styled Map'});
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');

    var marker = new google.maps.Marker({
        position: LtLng,
        map: map,
        animation: google.maps.Animation.DROP,
        icon: '/images/map-icons/marker_' + issue_status + '@1x.png',
    });
}

// from http://stackoverflow.com/questions/5999118/add-or-update-query-string-parameter
function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}


$(document).on('click', '#map_redraw', function(event){
    mapInitialize();
});

$(document).on('change', '#current_location', function(event){
    if(this.checked) {
        // google api & html5 location api based on location guessing
        var original_placeholder = $("#location_string").attr('placeholder');
        $("#location_string").val('').attr('placeholder', 'Yerinizi belirlemeye çalışıyorum...');
        $("#location_string").closest('.form-group').attr('data-form-state','is-busy');

        var map;
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;

                var geocoder = new google.maps.Geocoder();
                var latlng = new google.maps.LatLng(lat, lon);

                geocoder.geocode({'location': latlng}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            var hood, district, city;
                            var add = results[0];
                            if (add.address_components) {
                                for (var i = 0, l = add.address_components.length; i < l; i ++) {
                                    var a = add.address_components[i];
                                    if (a.types[0]) {
                                        if (a.types[0] === "administrative_area_level_1") {
                                            city = a.long_name;    
                                        }
                                        if (a.types[0] === "administrative_area_level_2") {
                                            district = a.long_name;    
                                        }
                                        if (a.types[0] === "administrative_area_level_4") {
                                            hood = a.long_name;    
                                        }
                                    }
                                }
                            }
                            // visible data
                            $("#hood").val(hood);
                            $("#district").html(district+", "+city);
                            // backend data
                            $("#coordinates").val(lat + ", " + lon);
                            $("#location_string").val(hood+", "+district+", "+city);
                            $("#location_string").closest('.form-group').attr('data-form-state','is-current');
                            // map.setCenter({lat: lat, lng: lon});

                            //do we need to do something? 
                            if ($("#redir").size() > 0) {
                                var redir = $("#redir").val();
                                var loca = hood+", "+district+", "+city
                                    if (redir == 'list') {
                                        window.location = '/fikirler?location='+loca;
                                        $.ajax({
                                            url: '/fikirler',
                                            method: 'post',
                                            data: 'location='+loca,
                                            success: function(r){
                                                $("#issueListContainer").html(r);
                                            }
                                        });
                                    }
                            }
                        } else {
                            window.alert('Yerinizi belirleyemedim, elle girsek?');

                        }

                    } else {
                        window.alert('Yerinizi belirleyemedim, elle girsek? ');

                    }

                });

            }, function() {
                alert('Yerinizi belirleyemedim, elle girsek?');
            });

        } else {
            // Browser doesn't support Geolocation
            alert('Yerinizi belirleyemedim, elle girsek?');
        }
    } else {
        // $fallback = ($('#home_location').attr('data-val')) ? $('#home_location').attr('data-val') : '';
        //$("#location_string").val('');
    }
});

$(document).ready(function(){
    // google places autocomplete
    if($('#hood').size() > 0) {
        var input = (document.getElementById('hood'));
        var autocomplete = new google.maps.places.Autocomplete(
                input, 
                {
                    types: ['geocode'],
                    componentRestrictions: { country: 'tr' }, 
                }
                );
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Aradığın kriterleri mahalle ismi olmalıdır");
                return;
            }

            if (place.address_components) {
                hood = district = city = $first_valid_type = $sublocality = null;
                $.each(place.address_components, function(i,j) {
                    if (j.types[0]) {

                        // set city, district & hood values
                        if (j.types[0] === "administrative_area_level_1") {
                            city = j.long_name;
                        }
                        if (j.types[0] === "administrative_area_level_2") {
                            district = j.long_name;
                            if($first_valid_type == null || $sublocality == j.long_name) { $first_valid_type = i; }
                        }
                        if (j.types[0] === "sublocality_level_1") {
                            district = j.long_name;
                            if($first_valid_type == null) { $first_valid_type = i; $sublocality = j.long_name; }
                        }
                        if ($first_valid_type == null && j.types[0] === "administrative_area_level_4") {
                            hood = j.long_name;
                            if($first_valid_type == null) { $first_valid_type = i; }
                        }

                    }
                });

                if($first_valid_type !== null) {

                    // hiding form message
                    $("#location_form_message").hide().find('.message').html('');

                    // assigning found location data to input fields
                    $input_val = (hood !== null) ? hood : district;
                    $("#hood").val($input_val);
                    $("#district, #city").html('');
                    if($("#district").length > 0 && district.length > 0 && hood !== null) {
                        $("#district").show().html(district + ', ');
                    }
                    if($("#city").length > 0 && city.length > 0) {
                        $("#city").show().html(city);
                    }

                    // backend data
                    var lat = place.geometry.location.lat();
                    var lon = place.geometry.location.lng();
                    $("#coordinates").val(lat + ", " + lon);
                    $("#location_string").val(hood+", "+district+", "+city);

                    $("#hood").closest('.form-group').attr('data-form-state','is-busy');

                    //do we need to do something? 
                    if ($("#redir").size() > 0 && $("#redir").val() == 'list') {

                        query = (hood !== null) ? '?location=' + hood + ", " + district + ", " + city : '?district=' + district + ", " + city;
                        window.location = '/fikirler' + query;
                    }


                } else {
                    $("#hood").val('');
                    $("#district, #city").html('');
                    $("#location_form_message").show().find('.message').html('Aradığın kriterleri mahalle/ilçe ismi olmalıdır.');
                }

            }
        });
    }
});

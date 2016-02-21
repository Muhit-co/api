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
                    componentRestrictions: {country: 'tr'}, 
                }
                );
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Aradığın kriterleri mahalle ismi olmalıdır");
                return;
            }

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')

                ].join(' ');
                for (var i = 0, l = place.address_components.length; i < l; i ++) {
                    var a = place.address_components[i];
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

                // evaluating if correct mahalle or not
                if($("#hood").length > 0 && hood.length > 0) {
                    // hiding form message
                    $("#location_form_message").hide().find('.message').html('');
                    // assigning found location data to input fields
                    $("#hood").val(hood);
                    if($("#district").length > 0 && district.length > 0) {
                        if(!city) { city = '' }
                        $("#district").show().find('.text').html(district+", "+city);
                    }

                    $("#hood").val(hood);
                    $("#district").html(district+", "+city);
                    // backend data
                    var lat = place.geometry.location.lat();
                    var lon = place.geometry.location.lng();
                    $("#coordinates").val(lat + ", " + lon);
                    $("#location_string").val(hood+", "+district+", "+city);
                    $("#location_string").closest('.form-group').attr('data-form-state','is-current');

                    //do we need to do something? 
                    if ($("#redir").size() > 0) {
                        var redir = $("#redir").val();
                        var loca = hood+", "+district+", "+city

                            if (redir == 'list') {
                                window.location = '/fikirler?location='+loca;
                                
                            }
                    }

                } else {
                    $("#hood").val('');
                    $("#district").hide();
                    $("#location_form_message").show().find('.message').html('Aradığın kriterleri mahalle ismi olmalıdır.');
                }
            }
            $("#location_string").closest('.form-group').attr('data-form-state','is-static');
            $("#current_location").attr('checked', false);
        });
    }
});

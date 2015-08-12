function mapInitialize() {
    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
      center: new google.maps.LatLng(41.0686, 29.0285),
      // minZoom: 8,
      zoom: 11,
      disableDefaultUI: false,
      scrollwheel: false,
      mapTypeControl: false,
      panControl: false,
      streetViewControl: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(mapCanvas, mapOptions);
    map.data.loadGeoJson('/mapdata.json');
    map.data.setStyle({
        clickable: true,
        icon: { url: '/images/map-icons/marker_new.png', size: new google.maps.Size(29, 41) }
    });
    map.data.addListener('click', function(event) {
        window.location.href = '/issues/view/3';
    });
}

function mapInitializeForIssue(lon, lan) {
    var mapCanvas = document.getElementById('map-canvas');
    var LtLng = new google.maps.LatLng(lon, lan);
    var mapOptions = {
      center: LtLng,
      // minZoom: 8,
      zoom: 11,
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
        title: "Test"
    });
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
                window.alert("Autocomplete's returned place contains no geometry");
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
                    $("#location_string").val(hood+", "+district+", "+city);
                    $("#location_string").closest('.form-group').attr('data-form-state','is-current');

                    //do we need to do something? 
                    if ($("#redir").size() > 0) {
                        var redir = $("#redir").val();
                        var loca = hood+", "+district+", "+city
                        if (redir == 'list') {
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
                    $("#hood").val('');
                    $("#district").hide();
                    $("#location_form_message").show().find('.message').html('Aradığınız kriterleri mahalle değildir.');
                }
            }
            $("#location_string").closest('.form-group').attr('data-form-state','is-static');
            $("#current_location").attr('checked', false);
        });
    }
});



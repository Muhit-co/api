$(document).on('click', '#location', function(event){
    // google api & html5 location api based on location guessing
    var map;
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            var geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(lat, lon);

            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        //console.log(results[1].address_components);
                        $("#location_string").val(results[1].formatted_address);
                    } else {
                        window.alert('No results found');

                    }

                } else {
                    window.alert('Geocoder failed due to: ' + status);

                }

            });

        }, function() {
            alert('No geo location provided.');
        });

    } else {
        // Browser doesn't support Geolocation
        alert('Browser is not supported.');
    }
});

$(document).ready(function(){
    // google places autocomplete
    var input = (document.getElementById('location_string'));
    var autocomplete = new google.maps.places.Autocomplete(input);
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

        }
        console.log(place.name);
        console.log(address);
    });
});

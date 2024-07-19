function getTrafficUpdates() {
    var startLocation = document.getElementById('start-location').value;
    var endLocation = document.getElementById('end-location').value;

    if (startLocation && endLocation) {
        // Initialize the map
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: { lat: -1.286389, lng: 36.817223 } // Default to Nairobi
        });

        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);

        var request = {
            origin: startLocation,
            destination: endLocation,
            travelMode: 'DRIVING'
        };

        directionsService.route(request, function(result, status) {
            if (status == 'OK') {
                directionsRenderer.setDirections(result);
            } else {
                alert('Could not get traffic updates: ' + status);
            }
        });
    } else {
        alert('Please enter both start and end locations.');
    }
}

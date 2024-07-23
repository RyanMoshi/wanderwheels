document.addEventListener('DOMContentLoaded', function() {
    const logo = document.querySelector('.logo');

    function animateLogo() {
        logo.style.position = 'relative';
        let position = 0;
        let direction = 1;

        function bounce() {
            position += direction;
            logo.style.top = position + 'px';

            if (position > 20 || position < 0) {
                direction *= -1;
            }

            requestAnimationFrame(bounce);
        }

        bounce();
    }

    animateLogo();

    // Initialize map
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -1.286389, lng: 36.817223},
            zoom: 12
        });

        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);

        document.getElementById('trip-form').addEventListener('submit', function(event) {
            event.preventDefault();
            calculateAndDisplayRoute(directionsService, directionsRenderer);
        });
    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        var origin = document.getElementById('origin').value;
        var destination = document.getElementById('destination').value;

        directionsService.route({
            origin: origin,
            destination: destination,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsRenderer.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }

    initMap();

    // Load trips
    function loadTrips() {
        fetch('php\gettrip.php')
            .then(response => response.json())
            .then(data => {
                const tripList = document.getElementById('trip-list');
                tripList.innerHTML = '';
                data.forEach(trip => {
                    const tripItem = document.createElement('div');
                    tripItem.className = 'trip-item';
                    tripItem.innerHTML = `
                        <p>Trip ID: ${trip.id}</p>
                        <p>Origin: ${trip.origin}</p>
                        <p>Destination: ${trip.destination}</p>
                        <p>Date: ${trip.date}</p>
                    `;
                    tripList.appendChild(tripItem);
                });
            });
    }

    loadTrips();

    const bookTripForm = document.getElementById('trip-form');
    const cancelTripForm = document.getElementById('cancel-trip-form');

    if (bookTripForm) {
        bookTripForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(bookTripForm);

            fetch('php\booktrip.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result); // Display success or error message
                if (result.includes("success")) {
                    bookTripForm.reset(); // Reset form fields
                    loadTrips(); // Optionally, reload trip list
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    if (cancelTripForm) {
        cancelTripForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(cancelTripForm);

            fetch('php\canceltrip.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                alert(result); // Display success or error message
                if (result.includes("success")) {
                    cancelTripForm.reset(); // Reset form fields
                    loadTrips(); // Optionally, reload trip list
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
});

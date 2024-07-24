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

    function showTrafficUpdate() {
        const location = document.getElementById('location').value;
        const trafficInfoDiv = document.getElementById('traffic-info');
        trafficInfoDiv.innerHTML = ''; // Clear previous traffic info

        if (!location) {
            trafficInfoDiv.innerHTML = 'Please enter a location.';
            return;
        }

        // Use template literals and correct URL parameter
        const mapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${encodeURIComponent(location)}&travelmode=driving&layer=traffic`;

        trafficInfoDiv.innerHTML = `
            <p><strong>Traffic information for ${location}:</strong></p>
            <p><a href="${mapsUrl}" target="_blank">View Traffic Updates on Google Maps</a></p>
        `;
    }

    function loadTrips() {
        fetch('php/gettrip.php')
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
            })
            .catch(error => {
                console.error('Error loading trips:', error);
            });
    }

    loadTrips();

    const bookTripForm = document.getElementById('trip-form');
    const cancelTripForm = document.getElementById('cancel-trip-form');
    const trafficForm = document.getElementById('traffic-form');

    if (bookTripForm) {
        bookTripForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(bookTripForm);

            fetch('php/booktrip.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                if (result.trim().toLowerCase() === "success") {
                    alert("Booking confirmed!"); // Display confirmation message
                    bookTripForm.reset(); // Reset form fields
                    loadTrips(); // Reload trip list
                } else {
                    alert("Booking failed: " + result); // Display error message
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred while booking the trip.");
            });
        });
    }

    if (cancelTripForm) {
        cancelTripForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(cancelTripForm);

            fetch('php/canceltrip.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                if (result.trim().toLowerCase() === "success") {
                    alert("Trip cancelled successfully!"); // Display confirmation message
                    cancelTripForm.reset(); // Reset form fields
                    loadTrips(); // Reload trip list
                } else {
                    alert("Cancellation failed: " + result); // Display error message
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred while cancelling the trip.");
            });
        });
    }

    if (trafficForm) {
        trafficForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            showTrafficUpdate(); // Show traffic update based on entered location
        });
    }
});

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
<<<<<<< HEAD
        fetch('php/gettrip.php')
=======
        fetch('php\gettrip.php')
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
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
<<<<<<< HEAD
    const trafficForm = document.getElementById('traffic-form');
=======
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac

    if (bookTripForm) {
        bookTripForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(bookTripForm);

<<<<<<< HEAD
            fetch('php/booktrip.php', {
=======
            fetch('php\booktrip.php', {
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
<<<<<<< HEAD
                if (result.trim().toLowerCase() === "success") {
                    alert("Booking confirmed!"); // Display confirmation message
                    bookTripForm.reset(); // Reset form fields
                    loadTrips(); // Reload trip list
                } else {
                    alert("Booking failed: " + result); // Display error message
=======
                alert(result); // Display success or error message
                if (result.includes("success")) {
                    bookTripForm.reset(); // Reset form fields
                    loadTrips(); // Optionally, reload trip list
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
                }
            })
            .catch(error => {
                console.error('Error:', error);
<<<<<<< HEAD
                alert("An error occurred while booking the trip.");
=======
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
            });
        });
    }

    if (cancelTripForm) {
        cancelTripForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(cancelTripForm);

<<<<<<< HEAD
            fetch('php/canceltrip.php', {
=======
            fetch('php\canceltrip.php', {
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
<<<<<<< HEAD
                if (result.trim().toLowerCase() === "success") {
                    alert("Trip cancelled successfully!"); // Display confirmation message
                    cancelTripForm.reset(); // Reset form fields
                    loadTrips(); // Reload trip list
                } else {
                    alert("Cancellation failed: " + result); // Display error message
=======
                alert(result); // Display success or error message
                if (result.includes("success")) {
                    cancelTripForm.reset(); // Reset form fields
                    loadTrips(); // Optionally, reload trip list
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
                }
            })
            .catch(error => {
                console.error('Error:', error);
<<<<<<< HEAD
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
=======
            });
        });
    }
>>>>>>> 0a0202ec7c37893e352786ef9a25d3cf2b09d8ac
});

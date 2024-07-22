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

        var trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map);
    }

    initMap();

    // Load users
    function loadUsers() {
        fetch('php/get_users.php')
            .then(response => response.json())
            .then(data => {
                const userList = document.getElementById('user-list');
                userList.innerHTML = '';
                data.forEach(user => {
                    const userItem = document.createElement('div');
                    userItem.className = 'user-item';
                    userItem.innerHTML = `
                        <p>User ID: ${user.id}</p>
                        <p>Name: ${user.name}</p>
                        <p>Email: ${user.email}</p>
                        <button onclick="deleteUser(${user.id})">Delete User</button>
                    `;
                    userList.appendChild(userItem);
                });
            });
    }

    loadUsers();

    // Load trips
    function loadTrips() {
        fetch('php/get_trips.php')
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

    // Delete user
    window.deleteUser = function(userId) {
        fetch('php/delete_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadUsers();
            } else {
                alert('Failed to delete user.');
            }
        });
    };

    // Authorize trip
    document.getElementById('authorize-trip-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const tripId = document.getElementById('trip-id').value;
        fetch('php/authorize_trip.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ trip_id: tripId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTrips();
            } else {
                alert('Failed to authorize trip.');
            }
        });
    });

    // Reschedule trip
    document.getElementById('reschedule-trip-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const tripId = document.getElementById('trip-id-reschedule').value;
        const newDate = document.getElementById('new-date').value;
        fetch('php/reschedule_trip.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ trip_id: tripId, new_date: newDate })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTrips();
            } else {
                alert('Failed to reschedule trip.');
            }
        });
    });

    // Delete trip
    document.getElementById('delete-trip-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const tripId = document.getElementById('trip-id-delete').value;
        fetch('php/delete_trip.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ trip_id: tripId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadTrips();
            } else {
                alert('Failed to delete trip.');
            }
        });
    });
});

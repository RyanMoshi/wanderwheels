document.addEventListener('DOMContentLoaded', function() {
    const logo = document.querySelector('.logo');

    // Animation for the logo
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

    // Load bookings
    function loadBookings() {
        fetch('php/get_bookings.php')
            .then(response => response.json())
            .then(data => {
                const bookingList = document.getElementById('booking-list');
                bookingList.innerHTML = '';
                if (data.length === 0) {
                    bookingList.innerHTML = '<p>No bookings found.</p>';
                } else {
                    const table = document.createElement('table');
                    table.innerHTML = `
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Driver ID</th>
                                <th>Origin</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.map(booking => `
                                <tr>
                                    <td>${booking.id}</td>
                                    <td>${booking.user_id}</td>
                                    <td>${booking.driver_id}</td>
                                    <td>${booking.origin}</td>
                                    <td>${booking.destination}</td>
                                    <td>${booking.date}</td>
                                    <td>${booking.status}</td>
                                    <td>
                                        <button onclick="authorizeBooking(${booking.id})">Authorize</button>
                                        <button onclick="rescheduleBooking(${booking.id})">Reschedule</button>
                                        <button onclick="deleteBooking(${booking.id})">Delete</button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    `;
                    bookingList.appendChild(table);
                }
            })
            .catch(error => {
                console.error('Error fetching bookings:', error);
                document.getElementById('booking-list').innerHTML = '<p>Error loading bookings. Please try again later.</p>';
            });
    }

    loadBookings();

    // Load users
    function loadUsers() {
        fetch('php/get_users.php')
            .then(response => response.json())
            .then(data => {
                const userList = document.getElementById('user-list');
                userList.innerHTML = '';
                if (data.length === 0) {
                    userList.innerHTML = '<p>No users found.</p>';
                } else {
                    const table = document.createElement('table');
                    table.innerHTML = `
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.map(user => `
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>${user.role}</td>
                                    <td><button onclick="deleteUser(${user.id})">Delete User</button></td>
                                </tr>
                            `).join('')}
                        </tbody>
                    `;
                    userList.appendChild(table);
                }
            })
            .catch(error => {
                console.error('Error fetching users:', error);
                document.getElementById('user-list').innerHTML = '<p>Error loading users. Please try again later.</p>';
            });
    }

    // Show and hide user list
    document.getElementById('show-users-btn').addEventListener('click', function() {
        document.getElementById('user-list-container').style.display = 'block';
        loadUsers();
    });

    document.getElementById('hide-users-btn').addEventListener('click', function() {
        document.getElementById('user-list-container').style.display = 'none';
    });

    // Load trips
    function loadTrips() {
        fetch('php/get_trips.php')
            .then(response => response.json())
            .then(data => {
                const tripList = document.getElementById('trip-list');
                tripList.innerHTML = '';
                if (data.length === 0) {
                    tripList.innerHTML = '<p>No trips found.</p>';
                } else {
                    const table = document.createElement('table');
                    table.innerHTML = `
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Driver ID</th>
                                <th>Origin</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.map(trip => `
                                <tr>
                                    <td>${trip.id}</td>
                                    <td>${trip.user_id}</td>
                                    <td>${trip.driver_id}</td>
                                    <td>${trip.origin}</td>
                                    <td>${trip.destination}</td>
                                    <td>${trip.date}</td>
                                    <td>${trip.status}</td>
                                    <td><button onclick="authorizeTrip(${trip.id})">Authorize</button></td>
                                </tr>
                            `).join('')}
                        </tbody>
                    `;
                    tripList.appendChild(table);
                }
            })
            .catch(error => {
                console.error('Error fetching trips:', error);
                document.getElementById('trip-list').innerHTML = '<p>Error loading trips. Please try again later.</p>';
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

    // Authorize booking
    window.authorizeBooking = function(bookingId) {
        fetch('php/authorize_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ booking_id: bookingId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadBookings();
            } else {
                alert('Failed to authorize booking.');
            }
        });
    };

    // Reschedule booking
    document.getElementById('reschedule-booking-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const bookingId = document.getElementById('booking-id-reschedule').value;
        const newDate = document.getElementById('new-date-reschedule').value;
        fetch('php/reschedule_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ booking_id: bookingId, new_date: newDate })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadBookings();
            } else {
                alert('Failed to reschedule booking.');
            }
        });
    });

    // Delete booking
    document.getElementById('delete-booking-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const bookingId = document.getElementById('booking-id-delete').value;
        fetch('php/delete_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ booking_id: bookingId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadBookings();
            } else {
                alert('Failed to delete booking.');
            }
        });
    });

    // Authorize trip
    window.authorizeTrip = function(tripId) {
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
    };
});

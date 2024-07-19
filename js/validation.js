document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const origin = document.getElementById('origin').value;
        const destination = document.getElementById('destination').value;
        const departureTime = document.getElementById('departure_time').value;

        if (!origin || !destination || !departureTime) {
            alert('Please fill in all fields.');
            event.preventDefault();
        }
    });
});

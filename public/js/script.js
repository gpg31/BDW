// Simple form validation
document.getElementById('feedback-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;

    if (name && email && message) {
        document.getElementById('feedback-message').style.display = 'block';
        document.getElementById('error-message').style.display = 'none';

        // Reset the form fields
        document.getElementById('feedback-form').reset();
    } else {
        document.getElementById('error-message').style.display = 'block';
        document.getElementById('feedback-message').style.display = 'none';
    }
});

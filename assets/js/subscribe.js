document.getElementById('subscribe-button').addEventListener('click', function (event) {
    event.preventDefault();

    var emailInput = document.getElementById('newsletter-sign-up');
    var email = emailInput.value.trim();

    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    document.getElementById('notificationSuccess').style.display = 'none';
    document.getElementById('notificationError').style.display = 'none';

    if (email === "" || !emailRegex.test(email)) {
        var newsletterInput = document.getElementById('newsletter-sign-up');
        var errorNotification = document.getElementById('notificationError');
        errorNotification.style.display = 'block';
        newsletterInput.style.borderColor = 'red';

        // Hide the notification after 5 seconds
        setTimeout(function () {
            errorNotification.style.display = 'none';
            newsletterInput.style.borderColor = '#595959';
        }, 5000);
    } else {
        var successNotification = document.getElementById('notificationSuccess');
        // var a = document.getElementById('subcontainer');
        successNotification.style.display = 'block';
        // a.style.display = 'none';

        // Clear the email input field
        emailInput.value = '';

        // Hide the success message after 5 seconds
        setTimeout(function () {
            successNotification.style.display = 'none';
        }, 5000);
    }
});

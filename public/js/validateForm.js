$(document).ready(function () {
    $('form').on('submit', function (event) {
        // Prevent the form from submitting immediately
        event.preventDefault();

        // Validate form fields
        var companySymbol = $('#companySymbol').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var email = $('#email').val();

        // Implement your validation logic here
        var isValid = true;

        // Example validation for a required field and email format
        if (!companySymbol) {
            isValid = false;
            alert('Company Symbol is required.');
        }

        if (!email || !isValidEmail(email)) {
            isValid = false;
            alert('Email is required and must be a valid email address.');
        }

        if (!startDate || !isValidDate(startDate)) {
            isValid = false;
            alert('Start Date is required and must be a valid date.');
        }

        if (!endDate || !isValidDate(endDate)) {
            isValid = false;
            alert('End Date is required and must be a valid date.');
        }

        // If the form is valid, submit it
        if (isValid) {
            this.submit();
        }
    });
});

function isValidEmail(email) {
    // Implement email validation logic (e.g., using regex)
    // Return true if the email is valid, otherwise false
}

function isValidDate(date) {
    // Implement date validation logic (e.g., using regex)
    // Return true if the date is valid, otherwise false
}

$(document).ready(function() {
    // Handle form submission using AJAX
    $('#registerStudent').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        // Clear previous error messages
        $('#registerStudent .text-danger').text('');

        // Validate form fields
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var dbirth = $('#dbirth').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var errors = {};

        // Validate first name
        if (!fname.trim()) {
            errors['fname'] = "First Name is required";
        } else if (!/^[a-zA-Z-' ]*$/.test(fname)) {
            errors['fname'] = "Only letters, dashes, apostrophes, and spaces allowed";
        }

        // Validate last name
        if (!lname.trim()) {
            errors['lname'] = "Last Name is required";
        } else if (!/^[a-zA-Z-' ]*$/.test(lname)) {
            errors['lname'] = "Only letters, dashes, apostrophes, and spaces allowed";
        }

        // Validate date of birth
        if (!dbirth.trim()) {
            errors['dbirth'] = "Birthdate is required";
        }

        // Validate username
        if (!username.trim()) {
            errors['username'] = "Username is required";
        } else if (!/^[a-zA-Z0-9]*$/.test(username)) {
            errors['username'] = "Username can only contain alphanumeric characters";
        }

        // Validate password
        if (!password.trim()) {
            errors['password'] = "Password is required";
        } else if (password.length < 8) {
            errors['password'] = "Password must be at least 8 characters long";
        }

        // If there are validation errors, display them
        if (Object.keys(errors).length > 0) {
            displayErrors(errors);
        } else {
            // If no validation errors, submit the form via AJAX
            $.ajax({
                type: 'POST',
                url: 'student-registration-process.php', // PHP script for form handling
                data: $(this).serialize(), // Serialize form data
                dataType: 'json', // Expect JSON response from the server
                success: function(response) {
                    // Handle success response
                    // Display success message below the password field
                    $('#password-error').html("<div class='text-success text-center mt-3'>Registration successful!</div>");

                    // Optionally, redirect after success
                    setTimeout(function() {
                        window.location.href = 'success.php'; // Redirect to success page
                    }, 1000); // 1000 milliseconds = 1 second
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    var response = xhr.responseJSON;
                    if (response) {
                        displayErrors(response);
                    } else {
                        console.error('Error:', error);
                        $('#password-error').html("<div class='text-danger text-center mt-3'>Error: Registration failed.</div>");
                    }
                }
            });
        }
    });
});

// Function to display validation errors
function displayErrors(errors) {
    $.each(errors, function(key, value) {
        $('#' + key + '-error').text(value);
    });
}

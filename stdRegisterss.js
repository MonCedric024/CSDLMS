function capitalizeInput(inputId) {
    var inputElement = document.getElementById(inputId);
    inputElement.value = inputElement.value.charAt(0).toUpperCase() + inputElement.value.slice(1);
}

function formatContactNo() {
    var contactNoInput = document.getElementById('contact_no');
    contactNoInput.value = contactNoInput.value.replace(/\D/g, '').substring(0, 12);
}

// Function to check password strength and display indicator
function checkPasswordStrength(password) {
    var passwordLengthIndicator = document.getElementById('password_length_indicator');
    if (password.length >= 8) {
        passwordLengthIndicator.textContent = "Password length is sufficient";
        passwordLengthIndicator.style.color = "green";
    } else {
        passwordLengthIndicator.textContent = "Password must be at least 8 characters";
        passwordLengthIndicator.style.color = "red";
    }
}

function validateForm() {
    var isValid = true;

    // Age validation
    var dobInput = document.getElementById('dob');
    var dob = new Date(dobInput.value);
    var today = new Date();
    var age = today.getFullYear() - dob.getFullYear();
    var m = today.getMonth() - dob.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    if (age < 17) {
        // Use SweetAlert2 for displaying alert
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'You must be at least 18 years old to register!',
            confirmButtonText: 'OK'
        });
        return false;
    }

    function validateForm() {
        var isValid = true;
    
        // Email validation
        var emailInput = document.getElementById('email_id').value;
        var emailExists = checkIfEmailExists(emailInput);
        if (emailExists) {
            // Use SweetAlert2 for displaying alert
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email already exists! Please use a different email address.',
                confirmButtonText: 'OK'
            });
            isValid = false;
        }
    
        // Other form validations...
    
        return isValid;
    }

    // Field validations
    function validateForm() {
        var isValid = true;
    
        // Age validation and other validations...
    
        // Display error messages if fields are not filled out properly
        if (fullname === "") {
            document.getElementById('fullname_error').textContent = "*Full Name is required";
            isValid = false;
        } else {
            document.getElementById('fullname_error').textContent = "";
        }
    
        // Repeat the same for other fields...
    
        return isValid;
    }

    var category = document.getElementById('category').value;
    if (category === "select") {
        document.getElementById('category_error').textContent = "*Course selection is required";
        isValid = false;
    } else {
        document.getElementById('category_error').textContent = "";
    }

    var studentId = document.getElementById('student_id').value;
    if (studentId === "") {
        document.getElementById('student_id_error').textContent = "*Student ID is required";
        isValid = false;
    } else {
        document.getElementById('student_id_error').textContent = "";
    }

    var contactNo = document.getElementById('contact_no').value;
    if (contactNo === "") {
        document.getElementById('contact_no_error').textContent = "*Contact number is required";
        isValid = false;
    } else {
        document.getElementById('contact_no_error').textContent = "";
    }

    var address = document.getElementById('address').value;
    if (address === "") {
        document.getElementById('address_error').textContent = "*Address is required";
        isValid = false;
    } else {
        document.getElementById('address_error').textContent = "";
    }

    var dob = document.getElementById('dob').value;
    if (dob === "") {
        document.getElementById('dob_error').textContent = "*Date of Birth is required";
        isValid = false;
    } else {
        document.getElementById('dob_error').textContent = "";
    }

    var email = document.getElementById('email_id').value;
    if (email === "") {
        document.getElementById('email_id_error').textContent = "*Email is required";
        isValid = false;
    } else {
        document.getElementById('email_id_error').textContent = "";
    }

    var password = document.getElementById('password').value;
    if (password === "") {
        document.getElementById('password_error').textContent = "*Password is required";
        isValid = false;
    } else {
        if (password.length < 8) {
            document.getElementById('password_error').textContent = "*Password must be at least 8 characters";
            isValid = false;
        } else if (password.length > 15) {
            document.getElementById('password_error').textContent = "*Password must be less than 15 characters";
            isValid = false;
        } else {
            document.getElementById('password_error').textContent = "";
        }
    }
    
    var gender = document.querySelector('input[name="gender"]:checked');
    if (!gender) {
        document.getElementById('gender_error').textContent = "*Gender is required";
        isValid = false;
    } else {
        document.getElementById('gender_error').textContent = "";
    }

    return isValid;
}

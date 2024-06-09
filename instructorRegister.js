function formatContactNo() {
    var contactNoInput = document.getElementById('contact_no');
    contactNoInput.value = contactNoInput.value.replace(/\D/g, '').substring(0, 12);
}

function validateForm() {
    var isValid = true;

    var fullname = document.getElementById('fullname').value;
    if (fullname === "") {
        document.getElementById('fullname_error').textContent = "*Full Name is required";
        isValid = false;
    } else {
        document.getElementById('fullname_error').textContent = "";
    }

    var contactNo = document.getElementById('contact_no').value;
    if (contactNo === "") {
        document.getElementById('contact_no_error').textContent = "*Contact number is required";
        isValid = false;
    } else {
        document.getElementById('contact_no_error').textContent = "";
    }

    var instructorId = document.getElementById('instructor_id').value;
    if (instructorId === "") {
        document.getElementById('instructor_id_error').textContent = "*Instructor ID is required";
        isValid = false;
    } else {
        document.getElementById('instructor_id_error').textContent = "";
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
        document.getElementById('password_error').textContent = "";
    }

    return isValid;
}
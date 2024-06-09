function capitalizeInput(inputId) {
    var inputElement = document.getElementById(inputId);
    inputElement.value = inputElement.value.charAt(0).toUpperCase() + inputElement.value.slice(1);
}

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
        document.getElementById('password_error').textContent = "";
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
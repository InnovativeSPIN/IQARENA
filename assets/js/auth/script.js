// Password show/hide toggle
function togglePassword(fieldId, eyeId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(eyeId);
    if (field.type === "password") {
        field.type = "text";
        eye.classList.remove("fa-eye");
        eye.classList.add("fa-eye-slash");
    } else {
        field.type = "password";
        eye.classList.remove("fa-eye-slash");
        eye.classList.add("fa-eye");
    }
}

// Password strength checker
function checkPasswordStrength() {
    const password = document.getElementById("registerPassword").value;
    const strengthBar = document.getElementById("strengthBar");
    const hint = document.getElementById("passwordHint");
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    strengthBar.style.width = (strength * 25) + "%";

    switch(strength) {
        case 0:
        case 1:
            strengthBar.style.background = "red";
            hint.textContent = "Weak";
            break;
        case 2:
            strengthBar.style.background = "orange";
            hint.textContent = "Medium";
            break;
        case 3:
            strengthBar.style.background = "blue";
            hint.textContent = "Strong";
            break;
        case 4:
            strengthBar.style.background = "green";
            hint.textContent = "Very Strong";
            break;
    }
}
<?php

include("./resource/conn.php");

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();


if (isset($_SESSION['role_id'])) {
    switch ($_SESSION['role_id']) {
        case 1: // student
            header("Location: ./student");
            exit;
        case 2: // Faculty
            header("Location: ./faculty");
            exit;
        case 3: // Hod
            header("Location: ./hod");
            exit;
        default:
            header("Location: ./main.php");
            exit;
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Arena Portal -  Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/auth/register.css">
</head>

<body>
    <!-- Wave Background Section -->
    <section>
        <div class="wave">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </section>

    <div class="w-full max-w-4xl mx-auto relative z-10">
        <!-- Toggle Buttons -->
        <div class="flex mb-8 mt-5 rounded-full bg-white shadow-md overflow-hidden w-fit mx-auto">
            <a href="./login.php"><button id="loginToggle" class="toggle-btn  px-6 py-2 font-medium rounded-full transition-all duration-300">Login</button></a>
            <a href="./register.php"><button id="registerToggle" class="toggle-btn active px-6 py-2 font-medium rounded-full transition-all duration-300">Register</button></a>
        </div>

        <!-- Register Form  -->
        <div id="registerForm" class="form-container rounded-2xl shadow-xl p-8 animate-fade">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-[var(--color-primary)] mb-2">Create Account</h1>
            </div>


            <form class="space-y-6">
                <div class="grid-form">
                    <div>
                        <label for="departmentId" class="block text-sm font-medium text-gray-700 mb-1" >User ID*</label>
                        <input type="text" id="departmentId" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="921022205011" onblur="fetchUserDetails(this.value)" required>
                    </div>
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                        <input type="text" id="firstName" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="John" required disabled>
                    </div>


                    <div>
                        <label for="registerEmail" class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                        <input type="email" id="registerEmail" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="student@university.edu" required disabled>
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department*</label>
                        <input type="text" id="department" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="department" required disabled>
                    </div>
            </form>
            <form id="updatePasswordForm">
                <div>
                    <label for="registerPassword" class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                    <div class="relative">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input type="password" id="registerPassword" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="••••••••" required oninput="checkPasswordStrength()">
                        <button type="button" class="password-toggle absolute inset-y-0 right-0 flex items-center pr-3" onclick="togglePassword('registerPassword', 'registerEyeIcon')">
                            <i id="registerEyeIcon" class="fas fa-eye text-gray-400 hover:text-[var(--color-primary)]"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div id="strengthBar" class="strength-bar"></div>
                    </div>
                    <p id="passwordHint" class="text-xs text-gray-500 mt-1"></p>
                </div>


        </div>



        <div class="flex justify-center">
            <button type="submit" class="btn-primary py-3 px-4 rounded-lg text-white font-semibold shadow-md transition-all duration-300">
                Create Account
            </button>
        </div>

        </form>

    </div>
    </div>




<script>
function fetchUserDetails(rollNo) {
    if (!rollNo) return;

    fetch("./backend/auth/get_users.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "roll_no=" + encodeURIComponent(rollNo)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            document.getElementById("firstName").value = "";
            document.getElementById("registerEmail").value = "";
            document.getElementById("department").value = "";
            document.getElementById("user_id").value = "";
        } else {
            document.getElementById("firstName").value = data.name;
            document.getElementById("registerEmail").value = data.email;
            document.getElementById("department").value = data.department;
            document.getElementById("user_id").value = data.id;
        }
    })
    .catch(err => console.error(err));
}


document.getElementById("updatePasswordForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const userId = document.getElementById("user_id").value;
    const password = document.getElementById("registerPassword").value;

    if (!userId) {
        alert("Please enter a valid roll number first.");
        return;
    }

    fetch("./backend/auth/update_pass.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "user_id=" + encodeURIComponent(userId) + "&new_password=" + encodeURIComponent(password)
    })
    .then(res => res.text())
    .then(msg => {
        alert(msg);
        if (msg.includes("successfully")) {
            document.getElementById("registerPassword").value = "";
            window.location.href = "./login.php";
        }
        
    })
    .catch(err => console.error("Update error:", err));
});


</script>
<script src="./assets/js/auth/script.js"></script>


</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Portal - Login & Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-orange: #FF6B35;
            --light-orange: #FFB347;
        }

        body {
            font-family: 'Poppins', sans-serif;
            position: relative;
            overflow-x: hidden;
            background-color: #f3f4f6;
        }

        .form-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .toggle-btn {
            background-color: transparent;
            color: var(--primary-orange);
        }

        .toggle-btn.active {
            background-color: var(--primary-orange);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), var(--light-orange));
            background-size: 200% auto;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-position: right center;
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
            transform: translateY(-2px);
        }

        .input-field {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .input-field:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }

        .animate-fade {
            animation: fadeIn 0.5s ease-in-out;
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .toggle-btn { padding: 0.75rem 1rem; font-size: 0.875rem; }
        }
    </style>
</head>

<body>
    <div class="w-full max-w-4xl mx-auto relative z-10 mt-10">
        <!-- Toggle Buttons -->
        <div class="flex mb-8 mt-5 rounded-full bg-white shadow-md overflow-hidden w-fit mx-auto">
             <a href="./">
             <button id="loginToggle" class="toggle-btn active px-6 py-2 font-medium rounded-full transition-all duration-300">Login</button>
           </a>
            <a href="./register.php">
                <button id="registerToggle" class="toggle-btn px-6 py-2 font-medium rounded-full transition-all duration-300">Register</button>
            </a>
        </div>

        <!-- Login Form -->
        <div id="loginForm" class="form-container rounded-2xl shadow-xl p-8 animate-fade w-full max-w-md mx-auto">
            <div class="text-center mb-8 animate-fade-in">
                <h1 class="text-3xl font-bold text-[var(--primary-orange)] mb-2">Welcome Back!</h1>
            </div>
            <form id="loginFormElement" class="space-y-6 group" onsubmit="return false;">
               <div>
                    <label for="registerDepartment" class="block text-sm font-medium text-gray-700 mb-1">Department ID</label>
                    <input type="number" id="departmentId" class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                        placeholder="Department ID" required>
                </div>

                <div>
                    <label for="loginPassword" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="loginPassword" class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                        placeholder="••••••••" required>
                </div>

                <div>
                    <label for="user_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                     <input type="text" id="role_name" class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
                        placeholder="your role" required disabled>
                </div>

                <button type="button" id="loginBtn" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold shadow-md">Login</button>
            </form>
        </div>

        
    </div>


<?php include('./resource/api.php') ?>

    <script>
        const loginToggle = document.getElementById('loginToggle');
        const registerToggle = document.getElementById('registerToggle');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const loginBtn = document.getElementById('loginBtn');
        const registerBtn = document.getElementById('registerBtn');

        // Toggle forms
        loginToggle.addEventListener('click', () => {
            loginToggle.classList.add('active');
            registerToggle.classList.remove('active');
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
        });

        registerToggle.addEventListener('click', () => {
            registerToggle.classList.add('active');
            loginToggle.classList.remove('active');
            registerForm.style.display = 'block';
            loginForm.style.display = 'none';
        });

        // Check session
        window.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch('<?php echo $api ?>helpers/check_session.php', 
                { credentials: 'include' });
                const data = await res.json();
               
                if (data.logged_in) {
                    let redirectUrl = '';   
                    switch (data.role) {
                        case 'faculty': redirectUrl = './staff/'; break;
                        case 'hod': redirectUrl = './hod/panel.html'; break;
                        case 'vice_principal': redirectUrl = './vp/review.html'; break;
                        case 'principal': redirectUrl = './principal/report.html'; break;
                        default: return;
                    }
                    window.location.href = redirectUrl;
                }
            } catch (err) {
                console.error('Session check failed', err);
            }
        });

        // Login
        loginBtn.addEventListener('click', async () => {
            const roll_no = document.getElementById('departmentId').value.trim();
            const password = document.getElementById('loginPassword').value;
            const role = document.getElementById('role_name').value;

            if (!roll_no || !password || !role) {
                alert("Please fill all fields including role.");
                return;
            }

            try {
                const response = await fetch('<?php echo $api ?>auth/authRoutes.php?route=login', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ roll_no, password })
                });
                const data = await response.json();
                if (data.user) {
                    if (data.user.role !== role) {
                        alert("Selected role does not match your account role.");
                        return;
                    }
          
                    let redirectUrl = '';
                    switch (data.user.role) {
                        case 'faculty': redirectUrl = './staff/'; break;
                        case 'hod': redirectUrl = './hod/panel.html'; break;
                        case 'vice_principal': redirectUrl = './vp/review.html'; break;
                        case 'principal': redirectUrl = './principal/report.html'; break;
                        default: alert("Unknown role."); return;
                    }
                    window.location.href = redirectUrl;
                } else {
                    alert(data.error || "Login failed.");
                }
            } catch (err) {
                console.error(err);
                alert("Unexpected error occurred.");
            }
        });

       
    </script>

    <script>
        document.getElementById('departmentId').addEventListener('blur', async () => {
            const rollNo = document.getElementById('departmentId').value.trim();
          console.log(rollNo)
            if (!rollNo) return;

            try {
                const response = await fetch('<?php echo $api; ?>auth/authRoutes.php?route=get-user-by-roll-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        roll_no: rollNo
                    })
                });

                const result = await response.json();

                if (result && result.role_name) {
                    document.getElementById('role_name').value = result.role_name || '';
                   
                } else {
                    alert("No user found for this roll number.");
                }
            } catch (error) {
                console.error(error);
                alert("Error fetching user details.");
            }
        });
    </script>
</body>

</html>

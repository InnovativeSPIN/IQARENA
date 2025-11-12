<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Login & Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        :root {
            --primary-orange: #FF6B35;
            --secondary-orange: #FF9A3C;
            --dark-orange: #E05D2E;
            --light-orange: #FFB347;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-blend-mode: overlay;
            position: relative;
            overflow-x: hidden;
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

        .grid-form {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
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
            .grid-form { grid-template-columns: 1fr; }
            .toggle-btn { padding: 0.75rem 1rem; font-size: 0.875rem; }
        }
    </style>
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
            <a href="./"><button id="loginToggle" class="toggle-btn active px-6 py-2 font-medium rounded-full transition-all duration-300">Login</button></a>
            <a href="./register.php"><button id="registerToggle" class="toggle-btn px-6 py-2 font-medium rounded-full transition-all duration-300">Register</button></a>
        </div>

        <!-- Login Form -->
        <div id="loginForm" class="form-container rounded-2xl shadow-xl p-8 animate-fade w-full max-w-md mx-auto transform transition-all duration-500 hover:scale-[1.01] hover:shadow-2xl">
            <div class="text-center mb-8 animate-fade-in">
                <h1 class="text-3xl font-bold text-[var(--primary-orange)] mb-2">Welcome Back!</h1>
            </div>

            <form id="loginFormElement" class="space-y-6 group">
                <div>
                    <label for="loginEmail" class="block text-sm font-medium text-gray-700 mb-1">Roll No </label>
                    <div class="relative">
                        <input type="text" id="loginEmail" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="921022205011" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="loginPassword" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="loginPassword" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="••••••••" required>
                        <button type="button" class="password-toggle absolute inset-y-0 right-0 flex items-center pr-3" onclick="togglePassword('loginPassword', 'loginEyeIcon')">
                            <i id="loginEyeIcon" class="fas fa-eye text-gray-400 hover:text-[var(--primary-orange)]"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="forgot-password.php" class="text-sm font-medium text-[var(--primary-orange)] hover:text-[var(--secondary-orange)]">Forgot password?</a>
                </div>

                <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold shadow-md transition-all duration-300 hover:-translate-y-1 active:translate-y-0 active:scale-95">
                    <span class="inline-block transition-transform duration-300 group-hover:translate-x-1">
                        Login <i class="fas fa-arrow-right ml-2 transition-all duration-300 opacity-0 group-hover:opacity-100"></i>
                    </span>
                </button>
            </form>
        </div>
    </div>

<?php include("../resource/api.php") ?>


    <script>
  window.addEventListener('DOMContentLoaded', async () => {
            try {
                const res = await fetch('<?php echo $api ?>helpers/student_session.php', 
                { credentials: 'include' });
                const data = await res.json();
               
                if (data.logged_in) {
                    let redirectUrl = '';   
                    switch (data.role) {
                        case 'student': redirectUrl = './dashboard.php'; break;
                        default: return;
                    }
                    window.location.href = redirectUrl;
                }
            } catch (err) {
                console.error('Session check failed', err);
            }
        });


        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
// login 
        document.getElementById('loginFormElement').addEventListener('submit', async (e) => {
            e.preventDefault();
            const roll_no = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value;

            if (!roll_no || !password) {
                alert("Please fill in all fields.");
                return;
            }

            try {
                const res = await fetch('<?php echo $api; ?>auth/authRoutes.php?route=student-login', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ roll_no, password })
                });

                const data = await res.json();
                

                if (res.ok && data.user) {
                    window.location.href = './dashboard.php';
                } else {
                    alert(data.error || "Login failed.");
                }
            } catch (error) {
                console.error("Login error:", error);
                alert("An unexpected error occurred.");
            }
        });
    </script>
</body>
</html>

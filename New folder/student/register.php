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

        .avatar-container {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
            border: 3px solid var(--primary-orange);
            position: relative;
            cursor: pointer;
        }

        .avatar-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            font-size: 2.5rem;
            color: var(--primary-orange);
        }

        .avatar-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-orange);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .animate-fade {
            animation: fadeIn 0.5s ease-in-out;
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(255, 107, 53, 0.2), 0 2px 4px -1px rgba(255, 107, 53, 0.1);
        }

        .password-strength {
            height: 4px;
            background: #e5e7eb;
            margin-top: 0.5rem;
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .grid-form {
                grid-template-columns: 1fr;
            }

            .toggle-btn {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
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
            <a href="./"><button id="loginToggle" class="toggle-btn  px-6 py-2 font-medium rounded-full transition-all duration-300">Login</button></a>
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
                        <label for="studentId" class="block text-sm font-medium text-gray-700 mb-1">Roll No*</label>
                        <input type="text" id="studentId" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="921022205011" required>
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
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year*</label>
                        <input type="text" id="year" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="year" required disabled>
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


    <?php include('../resource/api.php') ?>
    <!-- fetch students -->
    <script>
        document.getElementById('studentId').addEventListener('blur', async () => {
            const rollNo = document.getElementById('studentId').value.trim();
            if (!rollNo) return;

            try {
                const response = await fetch('<?php echo $api; ?>auth/authRoutes.php?route=get-user-by-roll-student', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        roll_no: rollNo
                    })
                });

                const result = await response.json();
              

                if (result && result.name) {
                    document.getElementById('firstName').value = result.name || '';
                    document.getElementById('user_id').value = result.user_id || '';
                    document.getElementById('registerEmail').value = result.email || '';
                    document.getElementById('year').value = result.year || '';
                    document.getElementById('department').value = result.department_name || '';
                } else {
                    alert("No user found for this roll number.");
                }
            } catch (error) {
                console.error(error);
                alert("Error fetching user details.");
            }
        });
    </script>
    <!-- update password -->
    <script>
        document.getElementById('updatePasswordForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const userId = document.getElementById('user_id').value;
            const newPassword = document.getElementById('registerPassword').value;

            const response = await fetch('<?php echo $api; ?>auth/authRoutes.php?route=register-student', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    new_password: newPassword
                })
            });

            const result = await response.json();
           
            if (result.success) {
                alert('Password updated successfully');
                window.location.href = "./";
            } else {
                alert('Failed to update password: ');
            }
        });
    </script>
</body>

</html>
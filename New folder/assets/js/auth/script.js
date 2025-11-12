   function showRegister() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('registerForm').classList.remove('hidden');
            document.getElementById('loginToggle').classList.remove('active');
            document.getElementById('registerToggle').classList.add('active');
        }

        function showLogin() {
            document.getElementById('registerForm').classList.add('hidden');
            document.getElementById('loginForm').classList.remove('hidden');
            document.getElementById('registerToggle').classList.remove('active');
            document.getElementById('loginToggle').classList.add('active');
        }


        document.getElementById('loginToggle').addEventListener('click', showLogin);
        document.getElementById('registerToggle').addEventListener('click', showRegister);


        function togglePassword(inputId, eyeIconId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(eyeIconId);

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }


            if (inputId === 'confirmPassword' || inputId === 'registerPassword') {
                checkPasswordMatch();
            }
        }





        function checkPasswordStrength() {
            const password = document.getElementById('registerPassword').value;
            const strengthBar = document.getElementById('strengthBar');
            const hint = document.getElementById('passwordHint');


            strengthBar.style.width = '0%';
            strengthBar.style.backgroundColor = '';
            hint.textContent = '';

            if (!password) return;


            let strength = 0;
            let messages = [];

            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 15;

            if (/[A-Z]/.test(password)) strength += 15;
            if (/[a-z]/.test(password)) strength += 15;
            if (/[0-9]/.test(password)) strength += 15;
            if (/[^A-Za-z0-9]/.test(password)) strength += 15;

            strength = Math.min(strength, 100);

            strengthBar.style.width = strength + '%';

            if (strength < 40) {
                strengthBar.style.backgroundColor = '#ef4444';
                hint.textContent = 'Weak password';
                hint.className = 'text-xs text-red-500 mt-1';
            } else if (strength < 70) {
                strengthBar.style.backgroundColor = '#f59e0b';
                hint.textContent = 'Moderate password';
                hint.className = 'text-xs text-amber-500 mt-1';
            } else {
                strengthBar.style.backgroundColor = '#10b981';
                hint.textContent = 'Strong password';
                hint.className = 'text-xs text-emerald-500 mt-1';
            }


            checkPasswordMatch();
        }


        function checkPasswordMatch() {
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const match = document.getElementById('passwordMatch');
            const mismatch = document.getElementById('passwordMismatch');

            if (!password || !confirmPassword) {
                match.classList.add('hidden');
                mismatch.classList.add('hidden');
                return;
            }

            if (password === confirmPassword) {
                match.classList.remove('hidden');
                mismatch.classList.add('hidden');
            } else {
                match.classList.add('hidden');
                mismatch.classList.remove('hidden');
            }
        }


        document.getElementById('confirmPassword').addEventListener('input', checkPasswordMatch);


        document.querySelector('#loginForm form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            if (!email || !password) {
                alert('Please fill in all fields');
                return;
            }


            alert('Login successful! Redirecting to dashboard...');

        });

        document.querySelector('#registerForm form').addEventListener('submit', function(e) {
            e.preventDefault();
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const termsChecked = document.getElementById('terms').checked;
            const year = document.getElementById('year').value;
            const department = document.getElementById('department').value;

            const requiredFields = ['firstName', 'lastName', 'studentId', 'dob', 'registerEmail'];
            for (const fieldId of requiredFields) {
                if (!document.getElementById(fieldId).value) {
                    alert(`Please fill in the ${fieldId.replace(/([A-Z])/g, ' $1').toLowerCase()} field`);
                    return;
                }
            }

            if (!year) {
                alert('Please select your academic year');
                return;
            }

            if (!department) {
                alert('Please select your department');
                return;
            }

            if (!termsChecked) {
                alert('Please agree to the terms and conditions');
                return;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            const strengthBar = document.getElementById('strengthBar');
            const strength = parseInt(strengthBar.style.width) || 0;

            if (strength < 40) {
                if (!confirm('Your password is weak. Are you sure you want to proceed?')) {
                    return;
                }
            }


            alert('Registration successful! Please check your email for verification.');
            showLogin();
        });
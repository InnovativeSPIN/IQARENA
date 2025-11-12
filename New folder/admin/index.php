<!DOCTYPE >
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeLhtmlearn - Admin Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.9), rgba(247, 147, 30, 0.85), rgba(255, 140, 66, 0.9)),
                        url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.8), rgba(247, 147, 30, 0.75), rgba(255, 140, 66, 0.8));
            z-index: -1;
        }

        .container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(25px);
            border-radius: 25px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 480px;
            padding: 50px 45px 45px;
            position: relative;
            overflow: visible;
            border: 1px solid rgba(255, 255, 255, 0.4);
            margin-top: 60px;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #ff6b35, #f7931e, #ff8c42, #ff6b35);
            border-radius: 25px 25px 0 0;
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .admin-avatar {
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            border: 5px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px rgba(255, 107, 53, 0.4);
            z-index: 10;
        }

        .admin-avatar::before {
            content: '👨‍💼';
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
            margin-top: 25px;
        }

        .header h1 {
            color: #ff6b35;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .header .subtitle {
            color: #666;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .security-badge {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(247, 147, 30, 0.1));
            border: 2px solid rgba(255, 107, 53, 0.2);
            border-radius: 25px;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            font-size: 0.8rem;
            color: #ff6b35;
            font-weight: 600;
        }

        .form-container {
            position: relative;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 18px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
            font-weight: 500;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff6b35;
            background: white;
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
            transform: translateY(-1px);
        }

        .form-group input:valid {
            border-color: #4caf50;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #ff6b35;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #ff6b35;
        }

        .forgot-password {
            color: #ff6b35;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #f7931e;
        }

        .btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 107, 53, 0.4);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .security-features {
            background: rgba(255, 107, 53, 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-top: 25px;
        }

        .security-features h3 {
            color: #ff6b35;
            font-size: 1rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-list {
            list-style: none;
            color: #666;
            font-size: 0.85rem;
        }

        .security-list li {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .security-list li::before {
            content: '✓';
            color: #4caf50;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .error-message {
            color: #f44336;
            font-size: 0.85rem;
            margin-top: 8px;
            display: none;
            padding: 10px;
            background: rgba(244, 67, 54, 0.1);
            border-radius: 8px;
            border-left: 4px solid #f44336;
        }

        .success-message {
            color: #4caf50;
            font-size: 0.85rem;
            margin-top: 8px;
            display: none;
            padding: 10px;
            background: rgba(76, 175, 80, 0.1);
            border-radius: 8px;
            border-left: 4px solid #4caf50;
        }

        .login-attempts {
            text-align: center;
            color: #999;
            font-size: 0.8rem;
            margin-top: 20px;
        }

        .two-factor-section {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: rgba(255, 107, 53, 0.05);
            border-radius: 12px;
            border: 2px solid rgba(255, 107, 53, 0.1);
        }

        .two-factor-section.active {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .code-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 15px 0;
        }

        .code-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            background: white;
            transition: all 0.3s ease;
        }

        .code-input:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
            outline: none;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                padding: 40px 25px 30px;
                margin: 15px;
                margin-top: 50px;
            }

            .admin-avatar {
                width: 80px;
                height: 80px;
                top: -45px;
                font-size: 2rem;
            }

            .header h1 {
                font-size: 1.9rem;
            }

            .form-group input {
                padding: 15px 18px;
            }

            .btn {
                padding: 15px;
                font-size: 1rem;
            }

            .remember-forgot {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .code-inputs {
                gap: 8px;
            }

            .code-input {
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }
        }

        @media (max-width: 320px) {
            .container {
                padding: 35px 20px 25px;
            }

            .admin-avatar {
                width: 70px;
                height: 70px;
                top: -40px;
                font-size: 1.8rem;
            }

            .header h1 {
                font-size: 1.7rem;
            }

            .code-input {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }

        /* Loading animation */
        .loading-spinner {
            border: 3px solid rgba(255, 107, 53, 0.3);
            border-radius: 50%;
            border-top: 3px solid #ff6b35;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="admin-avatar"></div>
        
        <div class="header">
            <h1>Admin Portal</h1>
            <p class="subtitle">Secure Administrator Access</p>
            <div class="security-badge">
                🔒 Encrypted Connection
            </div>
        </div>

        <div class="form-container">
            <form id="adminLoginForm">
                <div class="form-group">
                    <label for="adminEmail">
                        📧 Administrator Email
                    </label>
                    <input type="email" id="adminEmail" name="email" required autocomplete="username">
                    <div class="error-message" id="adminEmailError"></div>
                </div>

                <div class="form-group">
                    <label for="adminPassword">
                        🔑 Password
                    </label>
                    <input type="password" id="adminPassword" name="password" required autocomplete="current-password">
                    <span class="password-toggle" onclick="togglePassword('adminPassword')">👁️</span>
                    <div class="error-message" id="adminPasswordError"></div>
                </div>

                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" id="rememberMe" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-password" onclick="showForgotPassword()">Forgot Password?</a>
                </div>

                <button type="submit" class="btn" id="loginBtn">
                    <span id="loginBtnText">Secure Login</span>
                </button>

                <div class="two-factor-section" id="twoFactorSection">
                    <h3 style="color: #ff6b35; text-align: center; margin-bottom: 10px;">
                        🛡️ Two-Factor Authentication
                    </h3>
                    <p style="text-align: center; color: #666; font-size: 0.9rem; margin-bottom: 15px;">
                        Enter the 6-digit code from your authenticator app
                    </p>
                    <div class="code-inputs">
                        <input type="text" class="code-input" maxlength="1" pattern="[0-9]" onkeyup="moveToNext(this, 0)">
                        <input type="text" class="code-input" maxlength="1" pattern="[0-9]" onkeyup="moveToNext(this, 1)">
                        <input type="text" class="code-input" maxlength="1" pattern="[0-9]" onkeyup="moveToNext(this, 2)">
                        <input type="text" class="code-input" maxlength="1" pattern="[0-9]" onkeyup="moveToNext(this, 3)">
                        <input type="text" class="code-input" maxlength="1" pattern="[0-9]" onkeyup="moveToNext(this, 4)">
                        <input type="text" class="code-input" maxlength="1" pattern="[0-9]" onkeyup="moveToNext(this, 5)">
                    </div>
                    <button type="button" class="btn" onclick="verifyTwoFactor()" style="margin-top: 15px;">
                        Verify & Continue
                    </button>
                </div>

                <div class="login-attempts">
                    <span id="attemptCounter">Login attempts remaining: 3</span>
                </div>
            </form>

            <div class="security-features">
                <h3>🔐 Security Features</h3>
                <ul class="security-list">
                    <li>End-to-end encryption</li>
                    <li>Two-factor authentication</li>
                    <li>Session timeout protection</li>
                    <li>IP address monitoring</li>
                    <li>Audit trail logging</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        let loginAttempts = 3;
        let isLocked = false;

        // Password visibility toggle
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = input.nextElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                toggle.textContent = '🙈';
            } else {
                input.type = 'password';
                toggle.textContent = '👁️';
            }
        }

        // Form validation
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showError(inputId, message) {
            const errorElement = document.getElementById(inputId + 'Error');
            errorElement.innerHTML = `<strong>Error:</strong> ${message}`;
            errorElement.style.display = 'block';
            document.getElementById(inputId).style.borderColor = '#f44336';
        }

        function showSuccess(inputId, message) {
            const errorElement = document.getElementById(inputId + 'Error');
            errorElement.innerHTML = `<strong>Success:</strong> ${message}`;
            errorElement.style.display = 'block';
            errorElement.className = 'success-message';
            errorElement.style.display = 'block';
        }

        function clearErrors() {
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(error => {
                error.style.display = 'none';
                error.className = 'error-message';
            });
            
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.style.borderColor = '#e0e0e0';
            });
        }

        // Two-factor authentication input handling
        function moveToNext(current, index) {
            const inputs = document.querySelectorAll('.code-input');
            
            if (current.value.length === 1 && index < 5) {
                inputs[index + 1].focus();
            }
            
            if (current.value.length === 0 && index > 0) {
                inputs[index - 1].focus();
            }

            // Auto-verify when all fields are filled
            let allFilled = true;
            inputs.forEach(input => {
                if (input.value.length === 0) allFilled = false;
            });
            
            if (allFilled) {
                setTimeout(() => verifyTwoFactor(), 500);
            }
        }

        // Simulate two-factor verification
        function verifyTwoFactor() {
            const inputs = document.querySelectorAll('.code-input');
            let code = '';
            inputs.forEach(input => code += input.value);
            
            if (code.length !== 6) {
                alert('Please enter the complete 6-digit code');
                return;
            }

            // Simulate verification
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<div class="loading-spinner"></div>Verifying...';
            btn.disabled = true;

            setTimeout(() => {
                // Simulate successful verification
                alert('Login successful! Welcome to the Admin Dashboard.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 2000);
        }

        // Show forgot password
        function showForgotPassword() {
            const email = prompt('Enter your admin email address for password reset:');
            if (email && validateEmail(email)) {
                alert('Password reset instructions have been sent to your email.');
            } else if (email) {
                alert('Please enter a valid email address.');
            }
        }

        // Main login form submission
        document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (isLocked) {
                alert('Account is temporarily locked. Please try again later.');
                return;
            }

            clearErrors();
            
            const email = document.getElementById('adminEmail').value;
            const password = document.getElementById('adminPassword').value;
            let isValid = true;
            
            if (!email) {
                showError('adminEmail', 'Administrator email is required');
                isValid = false;
            } else if (!validateEmail(email)) {
                showError('adminEmail', 'Please enter a valid administrator email address');
                isValid = false;
            } else if (!email.includes('admin') && !email.includes('codelearn.com')) {
                showError('adminEmail', 'Please use your official administrator email');
                isValid = false;
            }
            
            if (!password) {
                showError('adminPassword', 'Password is required');
                isValid = false;
            } else if (password.length < 8) {
                showError('adminPassword', 'Administrator password must be at least 8 characters');
                isValid = false;
            }
            
            if (isValid) {
                // Simulate login process
                const btn = document.getElementById('loginBtn');
                const btnText = document.getElementById('loginBtnText');
                
                btnText.innerHTML = '<div class="loading-spinner"></div>Authenticating...';
                btn.disabled = true;
                
                setTimeout(() => {
                    // Simulate successful first-factor authentication
                    if (email === 'admin@codelearn.com' && password === 'Admin@123') {
                        btnText.textContent = 'Secure Login';
                        btn.disabled = false;
                        
                        // Show two-factor authentication
                        document.getElementById('twoFactorSection').classList.add('active');
                        document.querySelector('.code-input').focus();
                        
                        showSuccess('adminPassword', 'First factor authenticated. Please complete 2FA.');
                        
                    } else {
                        // Failed login
                        loginAttempts--;
                        document.getElementById('attemptCounter').textContent = 
                            `Login attempts remaining: ${loginAttempts}`;
                        
                        if (loginAttempts <= 0) {
                            isLocked = true;
                            showError('adminPassword', 'Account locked due to multiple failed attempts');
                            btnText.textContent = 'Account Locked';
                            btn.style.background = '#f44336';
                            
                            setTimeout(() => {
                                isLocked = false;
                                loginAttempts = 3;
                                document.getElementById('attemptCounter').textContent = 
                                    'Login attempts remaining: 3';
                                btnText.textContent = 'Secure Login';
                                btn.style.background = 'linear-gradient(135deg, #ff6b35, #f7931e)';
                            }, 30000); // 30 second lockout
                            
                        } else {
                            showError('adminPassword', 'Invalid credentials. Please try again.');
                        }
                        
                        btnText.textContent = 'Secure Login';
                        btn.disabled = false;
                    }
                }, 2000);
            }
        });

        // Auto-focus first input on page load
        window.addEventListener('load', function() {
            document.getElementById('adminEmail').focus();
        });

        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+Enter to submit form
            if (e.ctrlKey && e.key === 'Enter') {
                document.getElementById('adminLoginForm').dispatchEvent(new Event('submit'));
            }
        });

        // Session timeout warning (demo)
        setTimeout(() => {
            if (!document.getElementById('twoFactorSection').classList.contains('active')) {
                alert('Session will expire in 2 minutes due to inactivity.');
            }
        }, 60000); // 1 minute demo timeout warning
    </script>
</body>
</html>
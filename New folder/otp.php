<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification & Password Reset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.2rem;
            margin: 0 5px;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .otp-input:focus {
            border-color: #f97316;
            outline: none;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }

        .otp-input.filled {
            border-color: #10b981;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
        }

        .progress-bar {
            height: 4px;
            background-color: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: #f97316;
            transition: width 0.3s;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden w-full max-w-md">
        <div class="bg-gradient-to-r from-orange-500 to-amber-600 p-6 text-white">
            <h1 class="text-2xl font-bold">Reset Your Password</h1>
            <p class="text-blue-100 mt-1">Enter the OTP sent to your email</p>
        </div>

        <div class="p-6">
            <!-- OTP Verification Section -->
            <div id="otpSection">
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-orange-500 text-4xl"></i>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <p class="text-gray-600">We've sent a 6-digit code to your registered email</p>
                    <button class="text-orange-500 hover:text-orange-700 text-sm font-medium mt-2">Resend OTP</button>
                </div>

                <div class="flex justify-center mb-8">
                    <input type="text" maxlength="1" class="otp-input" data-index="0" autofocus>
                    <input type="text" maxlength="1" class="otp-input" data-index="1">
                    <input type="text" maxlength="1" class="otp-input" data-index="2">
                    <input type="text" maxlength="1" class="otp-input" data-index="3">
                    <input type="text" maxlength="1" class="otp-input" data-index="4">
                    <input type="text" maxlength="1" class="otp-input" data-index="5">
                </div>

                <div class="progress-bar mb-2">
                    <div id="otpProgress" class="progress-fill" style="width: 0%"></div>
                </div>
                <p class="text-xs text-gray-500 text-center mb-6">Verifying OTP...</p>

                <button id="verifyBtn" class="w-full bg-gray-300 text-white py-3 rounded-lg font-medium cursor-not-allowed" disabled>
                    Verify OTP
                </button>
            </div>

            <!-- Password Reset Section (hidden initially) -->
            <div id="passwordSection" class="hidden">
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">OTP Verified!</h2>
                    <p class="text-gray-600 mt-1">Now set your new password</p>
                </div>

                <div class="space-y-4 mb-6">
                    <div class="relative">
                        <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" id="newPassword" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" placeholder="Enter new password">
                        <i class="fas fa-eye-slash password-toggle" onclick="togglePassword('newPassword', this)"></i>
                    </div>

                    <div class="relative">
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" placeholder="Confirm new password">
                        <i class="fas fa-eye-slash password-toggle" onclick="togglePassword('confirmPassword', this)"></i>
                    </div>
                </div>

                <button id="resetBtn" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-medium transition">
                    Reset Password
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const verifyBtn = document.getElementById('verifyBtn');
            const otpProgress = document.getElementById('otpProgress');
            const otpSection = document.getElementById('otpSection');
            const passwordSection = document.getElementById('passwordSection');
            const resetBtn = document.getElementById('resetBtn');

            let otp = '';
            let verificationInProgress = false;

            // OTP input handling
            otpInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const index = parseInt(this.dataset.index);
                    const value = this.value;

                    if (value.length === 1) {
                        this.classList.add('filled');
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    } else {
                        this.classList.remove('filled');
                    }

                    otp = Array.from(otpInputs).map(i => i.value).join('');

                    if (otp.length === 6) {
                        verifyBtn.disabled = false;
                        verifyBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                        verifyBtn.classList.add('bg-orange-500', 'hover:bg-orange-600', 'cursor-pointer');
                    } else {
                        verifyBtn.disabled = true;
                        verifyBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                        verifyBtn.classList.remove('bg-orange-500', 'hover:bg-orange-600', 'cursor-pointer');
                    }
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            // ✅ Verify OTP button
            verifyBtn.addEventListener('click', async function() {
                if (verificationInProgress) return;
                verificationInProgress = true;
                verifyBtn.disabled = true;
                verifyBtn.textContent = 'Verifying...';

                const otpEntered = Array.from(otpInputs).map(i => i.value).join('');

                try {
                    const response = await fetch('http://localhost/CODING-QUIZ-APP/server/routes/auth/authRoutes.php?route=verify_otp', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            roll_no: localStorage.getItem('roll_no'), // saved earlier
                            otp: otpEntered
                        })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        otpSection.classList.add('hidden');
                        passwordSection.classList.remove('hidden');
                    } else {
                        alert(data.error || 'Invalid OTP');
                        verifyBtn.disabled = false;
                        verifyBtn.textContent = 'Verify OTP';
                    }
                } catch (err) {
                    alert('Error verifying OTP');
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'Verify OTP';
                }
            });
        });

        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
    <!-- otp script -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---- 1) Read/store reset token early ------------------------------------
            const urlParams = new URLSearchParams(window.location.search);
            let resetToken = urlParams.get('token') || localStorage.getItem('reset_token') || '';

            // ---- 2) Cache DOM elements ----------------------------------------------
            const otpInputs = document.querySelectorAll('.otp-input');
            const verifyBtn = document.getElementById('verifyBtn');
            const otpSection = document.getElementById('otpSection');
            const passwordSection = document.getElementById('passwordSection');
            const resetBtn = document.getElementById('resetBtn');

            let verificationInProgress = false;

            // ---- 3) OTP input UX -----------------------------------------------------
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                    const otp = Array.from(otpInputs).map(i => i.value).join('');
                    verifyBtn.disabled = otp.length !== 6;
                    verifyBtn.classList.toggle('bg-orange-500', otp.length === 6);
                    verifyBtn.classList.toggle('bg-gray-300', otp.length !== 6);
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            // ---- 4) Verify OTP -------------------------------------------------------
            verifyBtn.addEventListener('click', async function() {
                if (verificationInProgress) return;
                verificationInProgress = true;

                verifyBtn.textContent = 'Verifying...';
                verifyBtn.disabled = true;

                const otpEntered = Array.from(otpInputs).map(i => i.value).join('');
                const roll_no = localStorage.getItem('roll_no'); // keep if your verify API needs it

                try {
                    const res = await fetch(
                        'http://localhost/CODING-QUIZ-APP/server/routes/auth/authRoutes.php?route=verify_otp', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                roll_no,
                                otp: otpEntered
                                // If your verify API expects a token, include it here; otherwise omit.
                                // token: resetToken
                            })
                        }
                    );
                    const data = await res.json();

                    if (res.ok && data.success) {
                        // If backend returns a token for the reset step, use it; otherwise reuse OTP.
                        if (data.token) {
                            resetToken = data.token;
                        } else {
                            resetToken = otpEntered; // backend uses password_resets.otp as the token
                        }
                        localStorage.setItem('reset_token', resetToken);

                        otpSection.classList.add('hidden');
                        passwordSection.classList.remove('hidden');
                    } else {
                        throw new Error(data.error || 'Invalid OTP');
                    }
                } catch (err) {
                    alert(err.message);
                    verifyBtn.textContent = 'Verify OTP';
                    verifyBtn.disabled = false;
                    verificationInProgress = false;
                }
            });

            // ---- 5) Reset Password ---------------------------------------------------
            resetBtn.addEventListener('click', async function() {
                const newPassword = document.getElementById('newPassword').value.trim();
                const confirmPassword = document.getElementById('confirmPassword').value.trim();

                if (!newPassword || !confirmPassword) {
                    return alert('Please fill both password fields');
                }
                if (newPassword !== confirmPassword) {
                    return alert('Passwords do not match');
                }

                // Ensure token exists (load from URL/localStorage if needed)
                if (!resetToken) {
                    resetToken = urlParams.get('token') || localStorage.getItem('reset_token') || '';
                    if (!resetToken) {
                        return alert('Missing reset token. Please use the password reset link again.');
                    }
                }

                // Debug (optional): verify payload before sending
                // console.log({ token: resetToken, password: newPassword });

                try {
                    const res = await fetch(
                        'http://localhost/CODING-QUIZ-APP/server/routes/auth/authRoutes.php?route=reset_password', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                token: resetToken, // MUST be present; backend checks isset($input['token'])
                                password: newPassword // MUST be named 'password'; backend checks isset($input['password'])
                            })
                        }
                    );
                    const data = await res.json();

                    if (res.ok && data.message) {
                        alert('Password updated successfully');
                        localStorage.removeItem('reset_token');
                        window.location.href = 'index.php';
                    } else {
                        throw new Error(data.error || 'Failed to reset password');
                    }
                } catch (err) {
                    alert(err.message);
                }
            });
        });

        // ---- 6) Toggle password visibility ----------------------------------------
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>


</body>

</html>
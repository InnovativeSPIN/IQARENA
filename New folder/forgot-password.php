<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Coding Quiz App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-orange-600 mb-6">Forgot Password</h2>
        <p class="text-gray-600 text-center mb-4">Enter your Roll Number to receive an OTP in your registered email</p>
        
        <form id="forgotPasswordForm" class="space-y-4">
            <div>
                <label for="roll_no" class="block text-sm font-medium text-gray-700 mb-1">Roll Number</label>
                <input type="text" id="roll_no" name="roll_no" placeholder="Enter your roll number"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-lg font-medium transition">
                Send OTP
            </button>
        </form>

        <p id="message" class="text-center text-sm mt-4"></p>
    </div>

    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const roll_no = document.getElementById('roll_no').value;
            const messageEl = document.getElementById('message');

            messageEl.textContent = "Sending OTP...";
            messageEl.className = "text-center text-blue-500 text-sm mt-4";

            try {
                const res = await fetch('http://localhost/CODING-QUIZ-APP/server/routes/auth/authRoutes.php?route=forgot_password', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ roll_no })
                });

                const data = await res.json();

                if (res.ok && data.message) {
                    messageEl.textContent = "OTP sent successfully! Redirecting...";
                    messageEl.className = "text-center text-green-500 text-sm mt-4";

                    // Save roll_no for OTP page
                    localStorage.setItem('roll_no', roll_no);

                    setTimeout(() => {
                        window.location.href = "otp.php"; // your OTP page filename
                    }, 1500);
                } else {
                    messageEl.textContent = data.error || "Something went wrong.";
                    messageEl.className = "text-center text-red-500 text-sm mt-4";
                }
            } catch (err) {
                messageEl.textContent = "Error connecting to server.";
                messageEl.className = "text-center text-red-500 text-sm mt-4";
            }
        });
    </script>
</body>
</html>

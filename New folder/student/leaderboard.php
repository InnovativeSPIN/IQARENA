<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Leaderboard</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../assets/css/staff/leaderboard.css">
</head>
<body class="min-h-screen">
    <div class="container full-page-parallax">
        <div class="parallax">
            <img src="https://returnpath.com/assets/images/backgrounds/background-confetti-xl-arcade.svg">
            <img src="https://returnpath.com/assets/images/backgrounds/background-confetti-lg-arcade.svg">
            <img src="https://returnpath.com/assets/images/backgrounds/background-confetti-md-arcade.svg">
            <img src="https://returnpath.com/assets/images/backgrounds/background-confetti-sm-arcade.svg">
            <img src="https://returnpath.com/assets/images/backgrounds/background-confetti-xs-arcade.svg">
        </div>
    </div>

    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-orange-400">IT 2nd year Leaderboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-indigo-600 font-medium">IT</span>
                    </div>
                    <div>
                        <p class="font-medium text-orange-500">Alex Thompson</p>
                        <p class="text-xs text-gray-500">Student</p>
                    </div>
                </div>
                <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors">
                    <i data-lucide="log-out"></i>
                </button>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="leaderboard-item rank-1 flex flex-col items-center mb-12 border-none">
            <img src="../assets/images/leaderboard/one.png" alt="Trophy" class="trophy-img">
            <span class="text-yellow-800 text-xl font-medium mb-2">#1</span>
            <h3 class="leaderboard-name">One</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="leaderboard-item rank-2 flex flex-col items-center border-none">
                <img src="../assets/images/leaderboard/two.png" alt="Medal" class="medal-img">
                <span class="text-gray-800 text-lg font-medium mb-2">#2</span>
                <h3 class="leaderboard-name">Two</h3>
            </div>

            <div class="leaderboard-item rank-3 flex flex-col items-center border-none">
                <img src="../assets/images/leaderboard/two.png" alt="Award" class="award-img">
                <span class="text-amber-800 text-lg font-medium mb-2">#3</span>
                <h3 class="leaderboard-name">Three</h3>
            </div>
        </div>
    </main>
</body>
</html>
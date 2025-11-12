<?php 

include("../resource/conn.php");

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();


if (!isset($_SESSION['role_id'])) { 
     header("Location: ../login.php");
           
        
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://unpkg.com/lucide@latest"></script>
      <script src="https://cdn.tailwindcss.com"></script>
      
    <link rel="stylesheet" href="../assets/css/student/dash.css">
    <link rel="stylesheet" href="../assets/css/resource/style.css">
    
</head>
<body>

<div class="bg-gray-100 min-h-screen flex flex-col">
    <?php include('./header.php'); ?>
    <main class="container mx-auto p-6 flex flex-col gap-8">
        <section id="nav-section" class="mb-6">
                    <nav class="flex gap-4">
                        <a href="index.php" class="px-4 py-2 rounded-xl bg-orange-500 text-white font-semibold shadow hover:bg-orange-600 transition">Dashboard</a>
                        <a href="test-list.php" class="px-4 py-2 rounded-xl bg-orange-500 text-white font-semibold shadow hover:bg-orange-600 transition">Daily Quiz</a>
                        <a href="leaderboard.php" class="px-4 py-2 rounded-xl bg-orange-500 text-white font-semibold shadow hover:bg-orange-600 transition">Leaderboard</a>
                        <a href="Result.php" class="px-4 py-2 rounded-xl bg-orange-500 text-white font-semibold shadow hover:bg-orange-600 transition">Result</a>
                        <a href="report.php" class="px-4 py-2 rounded-xl bg-orange-500 text-white font-semibold shadow hover:bg-orange-600 transition">Reports</a>
                    </nav>
        </section>

        <section id="stats-section" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Quizzes Attended -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-orange-400 hover:shadow-xl transition">
                <div class="flex items-center space-x-4">
                    <div class="bg-orange-100 p-3 rounded-xl">
                        <i data-lucide="book-open" class="w-7 h-7 text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Quizzes Attended</p>
                        <p class="text-3xl font-bold text-gray-800">8</p>
                        <p class="text-xs text-green-600 mt-1">↑ 12% from last semester</p>
                    </div>
                </div>
            </div>

            <!-- Students Percentage -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-blue-400 hover:shadow-xl transition">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-xl">
                        <i data-lucide="users" class="w-7 h-7 text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Students Percentage</p>
                        <p class="text-3xl font-bold text-gray-800">156</p>
                        <p class="text-xs text-green-600 mt-1">↑ 8% from last month</p>
                    </div>
                </div>
            </div>

            <!-- Avg. Performance -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-green-400 hover:shadow-xl transition">
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 p-3 rounded-xl">
                        <i data-lucide="trending-up" class="w-7 h-7 text-green-500"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500">Avg. Performance</p>
                        <p class="text-3xl font-bold text-gray-800">78%</p>
                        <div class="mt-2 w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                            <div class="bg-green-400 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                        <p class="text-xs text-green-600 mt-1">↑ 3% from last term</p>
                    </div>
                </div>
            </div>

            <!-- Ongoing Quizzes -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-yellow-400 hover:shadow-xl transition">
                <div class="flex items-center space-x-4">
                    <div class="bg-yellow-100 p-3 rounded-xl">
                        <i data-lucide="clock" class="w-7 h-7 text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Ongoing Quizzes</p>
                        <p class="text-3xl font-bold text-gray-800">3</p>
                        <p class="text-xs text-gray-500 mt-1">Currently running</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="filters-section" class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <div class="flex items-center bg-gray-50 border border-gray-200 p-3 rounded-xl shadow-sm w-full md:w-1/2 focus-within:ring-2 focus-within:ring-orange-400 transition">
                <i data-lucide="search" class="w-5 h-5 text-gray-400 mr-2"></i>
                <input type="text" id="search-input" placeholder="Search quizzes..." class="w-full bg-transparent outline-none text-gray-700 placeholder-gray-400" />
            </div>
            <div class="flex">
                <a href="analytics.php" class="flex items-center px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl shadow-sm transition">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 mr-2"></i> Analytics
                </a>
            </div>
        </section>

        <section id="quiz-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Quiz Card Example -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition border-l-4 border-orange-500">
                <h3 class="text-lg font-semibold text-gray-800">Java Basics Quiz</h3>
                <p class="text-sm text-gray-500 mb-3">Created on: Jan 15, 2025</p>
                <div class="flex justify-between items-center">
                    <span class="px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-600 font-medium">Active</span>
                    <button class="text-sm text-orange-600 hover:underline">View</button>
                </div>
            </div>
            <!-- Add more quiz cards dynamically as needed -->
        </section>
    </main>
    <?php include('../resource/footer.php'); ?>
</div>
</body>
</html>


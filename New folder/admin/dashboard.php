<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-orange-100 p-2 rounded-lg">
                    <i data-lucide="brain" class="w-6 h-6 text-orange-600"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-orange-600">Admin Dashboard</h1>
                    <p class="text-gray-500 text-sm">Monitor all department activities</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="hidden md:block">
                    <div class="flex items-center space-x-2 bg-orange-50 px-3 py-1 rounded-full">
                        <i data-lucide="calendar" class="w-4 h-4 text-orange-500"></i>
                                         
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center relative">
                        <span class="text-indigo-600 font-medium">AT</span>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="hidden md:block">
                        <p class="font-medium text-black">Prof. Alex Thompson</p>
                        <p class="text-xs text-gray-500">Admin</p>
                    </div>
                </div>
                <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition-colors">
                    <i data-lucide="log-out"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex relative">
        <!-- Sidebar -->
        <div class="w-56 bg-white text-gray-800 h-screen sticky top-0 border-r border-gray-200">
            <div class="p-4">
                <h1 class="text-xl font-bold mb-6">Admin Panel</h1>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <button class="tab-button active w-full text-left px-3 py-2 rounded hover:bg-gray-100 font-medium flex items-center active-nav" data-tab="ai">
                                <i data-lucide="cpu" class="w-4 h-4 mr-3"></i>
                                <span>AI Department</span>
                            </button>
                        </li>
                        <li>
                            <button class="tab-button w-full text-left px-3 py-2 rounded hover:bg-gray-100 font-medium flex items-center" data-tab="cs">
                                <i data-lucide="code" class="w-4 h-4 mr-3"></i>
                                <span>Computer Science</span>
                            </button>
                        </li>
                        <li>
                            <button class="tab-button w-full text-left px-3 py-2 rounded hover:bg-gray-100 font-medium flex items-center" data-tab="it">
                                <i data-lucide="database" class="w-4 h-4 mr-3"></i>
                                <span>Information Technology</span>
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Content Area -->
        <main class="flex-1 container mx-auto px-4 py-8">

        <!-- All Staff Section -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-black">All Staff Members</h3>
                <p class="text-sm text-gray-500">Staff who have uploaded questions</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                <!-- Staff Member 1 -->
                <div class="flex items-center p-3 hover:bg-orange-50 rounded-lg transition-colors cursor-pointer staff-member">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                        <span class="text-indigo-600 font-medium">AT</span>
                    </div>
                    <div>
                        <p class="font-medium">Prof. Alex Thompson</p>
                        <p class="text-sm text-gray-500">AI Department • 42 questions</p>
                    </div>
                </div>
                <!-- Staff Member 2 -->
                <div class="flex items-center p-3 hover:bg-orange-50 rounded-lg transition-colors cursor-pointer staff-member">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                        <span class="text-blue-600 font-medium">MJ</span>
                    </div>
                    <div>
                        <p class="font-medium">Prof. Michael Johnson</p>
                        <p class="text-sm text-gray-500">CS Department • 38 questions</p>
                    </div>
                </div>
                <!-- Staff Member 3 -->
                <div class="flex items-center p-3 hover:bg-orange-50 rounded-lg transition-colors cursor-pointer staff-member">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                        <span class="text-purple-600 font-medium">SW</span>
                    </div>
                    <div>
                        <p class="font-medium">Prof. Sarah Williams</p>
                        <p class="text-sm text-gray-500">IT Department • 29 questions</p>
                    </div>
                </div>
                <!-- Staff Member 4 -->
                <div class="flex items-center p-3 hover:bg-orange-50 rounded-lg transition-colors cursor-pointer staff-member">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <span class="text-green-600 font-medium">RB</span>
                    </div>
                    <div>
                        <p class="font-medium">Dr. Robert Brown</p>
                        <p class="text-sm text-gray-500">AI Department • 25 questions</p>
                    </div>
                </div>
                <!-- Staff Member 5 -->
                <div class="flex items-center p-3 hover:bg-orange-50 rounded-lg transition-colors cursor-pointer staff-member">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                        <span class="text-yellow-600 font-medium">LG</span>
                    </div>
                    <div>
                        <p class="font-medium">Dr. Lisa Green</p>
                        <p class="text-sm text-gray-500">CS Department • 19 questions</p>
                    </div>
                </div>
                <!-- Staff Member 6 -->
                <div class="flex items-center p-3 hover:bg-orange-50 rounded-lg transition-colors cursor-pointer staff-member">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                        <span class="text-red-600 font-medium">DW</span>
                    </div>
                    <div>
                        <p class="font-medium">Dr. David White</p>
                        <p class="text-sm text-gray-500">IT Department • 15 questions</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- HODs Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-black mb-4">HOD of AI</h3>
                <div class="flex items-center">
                    <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                        <span class="text-indigo-600 text-xl font-medium">AT</span>
                    </div>
                    <div>
                        <p class="font-medium">Prof. Alex Thompson</p>
                        <p class="text-sm text-gray-500">12 years experience</p>
                        <p class="text-sm text-gray-500 mt-1">alex.thompson@university.edu</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-black mb-4"> HOD of CS</h3>
                <div class="flex items-center">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <span class="text-blue-600 text-xl font-medium">MJ</span>
                    </div>
                    <div>
                        <p class="font-medium">Prof. Michael Johnson</p>
                        <p class="text-sm text-gray-500">15 years experience</p>
                        <p class="text-sm text-gray-500 mt-1">michael.johnson@university.edu</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-black mb-4">HOD of IT</h3>
                <div class="flex items-center">
                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                        <span class="text-purple-600 text-xl font-medium">SW</span>
                    </div>
                    <div>
                        <p class="font-medium">Prof. Sarah Williams</p>
                        <p class="text-sm text-gray-500">10 years experience</p>
                        <p class="text-sm text-gray-500 mt-1">sarah.williams@university.edu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Leaderboards -->
        <div class="tab-content active" id="ai-tab">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h2 class="text-2xl font-bold text-black flex items-center">
                    <i data-lucide="cpu" class="text-orange-500 mr-3"></i>
                    AI Department Leaderboard
                </h2>
            </div>
            <!-- AI Department content here -->
        </div>

        <div class="tab-content hidden" id="cs-tab">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h2 class="text-2xl font-bold text-black flex items-center">
                    <i data-lucide="code" class="text-blue-500 mr-3"></i>
                    CS Department Leaderboard
                </h2>
            </div>
            <!-- CS Department content here -->
        </div>

        <div class="tab-content hidden" id="it-tab">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h2 class="text-2xl font-bold text-black flex items-center">
                    <i data-lucide="database" class="text-purple-500 mr-3"></i>
                    IT Department Leaderboard
                </h2>
            </div>
            <!-- IT Department content here -->
        </div>

        <!-- Podium -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- 2nd Place -->
            <div class="podium-card rank-2 bg-white rounded-xl shadow-md p-6 flex flex-col items-center order-1 md:order-1 h-64">
                <div class="flex items-center mb-4">
                    <i data-lucide="medal" class="text-gray-400 w-6 h-6 mr-2"></i>
                    <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">#2</span>
                </div>
                <div class="avatar-badge mb-4">BS</div>
                <h3 class="font-semibold text-orange-600 text-center mb-1">Bob Smith</h3>
                <p class="text-gray-500 text-xs text-center mb-4">16 tests completed</p>
                <div class="text-3xl font-bold text-gray-700">92%</div>
                <p class="text-gray-400 text-xs mt-1">Average Score</p>
                <div class="absolute bottom-4 left-4 text-xs text-gray-400">
                    <i data-lucide="trending-up" class="w-4 h-4 text-green-500 inline mr-1"></i> +2.5% this week
                </div>
            </div>

            <!-- 1st Place -->
            <div class="podium-card rank-1 bg-white rounded-xl shadow-lg p-6 flex flex-col items-center order-2 md:order-2 h-72 -mt-4 glow">
                <div class="flex items-center mb-4">
                    <i data-lucide="crown" class="text-yellow-500 w-6 h-6 mr-2"></i>
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">TOP PERFORMER</span>
                </div>
                <div class="avatar-badge mb-4">AJ</div>
                <h3 class="font-semibold text-orange-600 text-center mb-1">Alice Johnson</h3>
                <p class="text-gray-500 text-xs text-center mb-4">18 tests completed</p>
                <div class="text-4xl font-bold text-gray-800">95%</div>
                <p class="text-gray-400 text-xs mt-1">Average Score</p>
                <div class="absolute bottom-4 left-4 text-xs text-gray-400">
                    <i data-lucide="award" class="w-4 h-4 text-yellow-500 inline mr-1"></i> 5 perfect scores
                </div>
            </div>

            <!-- 3rd Place -->
            <div class="podium-card rank-3 bg-white rounded-xl shadow-md p-6 flex flex-col items-center order-3 md:order-3 h-60">
                <div class="flex items-center mb-4">
                    <i data-lucide="award" class="text-amber-700 w-6 h-6 mr-2"></i>
                    <span class="bg-amber-100 text-amber-800 text-sm font-medium px-3 py-1 rounded-full">#3</span>
                </div>
                <div class="avatar-badge mb-4">CD</div>
                <h3 class="font-semibold text-orange-600 text-center mb-1">Carol Davis</h3>
                <p class="text-gray-500 text-xs text-center mb-4">20 tests completed</p>
                <div class="text-2xl font-bold text-gray-700">89%</div>
                <p class="text-gray-400 text-xs mt-1">Average Score</p>
                <div class="absolute bottom-4 left-4 text-xs text-gray-400">
                    <i data-lucide="clock" class="w-4 h-4 text-blue-500 inline mr-1"></i> Fastest completion time
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stats-card bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">Department Average</h3>
                        <div class="text-3xl font-bold text-orange-600 mb-1">84.2%</div>
                        <p class="text-gray-400 text-xs">Overall performance</p>
                    </div>
                    <div class="bg-orange-100 p-2 rounded-lg">
                        <i data-lucide="bar-chart-2" class="w-5 h-5 text-orange-600"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Lowest: 62%</span>
                        <span>Highest: 95%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 84.2%"></div>
                    </div>
                </div>
            </div>
            <div class="stats-card bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">Total Students</h3>
                        <div class="text-3xl font-bold text-orange-600 mb-1">156</div>
                        <p class="text-gray-400 text-xs">Active participants</p>
                    </div>
                    <div class="bg-orange-100 p-2 rounded-lg">
                        <i data-lucide="users" class="w-5 h-5 text-orange-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex space-x-2">
                    <div class="flex items-center text-xs text-gray-500">
                        <i data-lucide="chevrons-up" class="w-4 h-4 text-green-500 mr-1"></i>
                        <span>+12 this month</span>
                    </div>
                </div>
            </div>
            <div class="stats-card bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">Tests Completed</h3>
                        <div class="text-3xl font-bold text-orange-600 mb-1">2,847</div>
                        <p class="text-gray-400 text-xs">This semester</p>
                    </div>
                    <div class="bg-orange-100 p-2 rounded-lg">
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-orange-600"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-xs text-gray-500">
                        <i data-lucide="zap" class="w-4 h-4 text-yellow-500 mr-1"></i>
                        <span>Avg. 35 tests/student</span>
                    </div>
                </div>
            </div>
                    
        </div>

        <!-- Full Leaderboard -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-black">Full Leaderboard</h3>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <input type="text" placeholder="Search students..." class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-200 focus:border-orange-300">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-2.5"></i>
                    </div>
                    <select id="yearFilter" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-200 focus:border-orange-300">
                        <option value="all">All Years</option>
                        <option value="I">1st Year</option>
                        <option value="II">2nd Year</option>
                        <option value="III">3rd Year</option>
                        <option value="IV">4th Year</option>
                    </select>
                    <button class="p-2 rounded-lg hover:bg-gray-50">
                        <i data-lucide="download" class="w-5 h-5 text-gray-500"></i>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tests Completed</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average Score</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Activity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Row 1 -->
                        <tr class="leaderboard-item hover:bg-orange-50">
                            <td class="px极6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <span class="text-yellow-800 font-medium">1</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="avatar-badge">AJ</div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-black">Alice Johnson</div>
                                        <div class="text-sm text-gray-500">I Year - CS-2048</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs">1st Year</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="w-32">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 95%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">95% complete</div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">18</td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">95%</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">2 hours ago</td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">
                                View Only
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="leaderboard-item hover:bg-orange-50">
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                        <span class="text-gray-800 font-medium">2</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="avatar-badge">BS</div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-black">Bob Smith</div>
                                        <div class="text-sm text-gray-500">CS-2049</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded-full text-xs">2nd Year</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="w-32">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 92%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">92% complete</div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">16</td>
                            <td class="px6 py-极4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">92%</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">5 hours ago</td>
                            <td class="px6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-orange-600 hover:text-orange-900 mr-3">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr class="leaderboard-item hover:bg-orange-50">
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                        <span class="text-amber-800 font-medium">3</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="avatar-badge">CD</div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-black">Carol Davis</div>
                                        <div class="text-sm text-gray-500">CS-2050</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 py-1 bg-purple-50 text-purple-700 rounded-full text-xs">3rd Year</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="w-32">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 89%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">89% complete</div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">20</td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">89%</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">Yesterday</td>
                            <td class="px6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-orange-600 hover:text-orange-900 mr-3">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr class="leaderboard-item hover:bg-orange-50">
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-800 font-medium">4</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="avatar-badge">EM</div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-black">Ethan Miller</div>
                                        <div class="text-sm text-gray-500极">CS-2051</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs">4th Year</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="w-32">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 87%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">87% complete</div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">87%</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">Yesterday</td>
                            <td class="px6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-orange-600 hover:text-orange-900 mr-3">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Row 5 -->
                        <tr class="leaderboard-item hover:bg-orange-50">
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-800 font-medium">5</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="avatar-badge">SW</div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-black">Sarah Wilson</div>
                                        <div class="text-sm text-gray-500">CS-2052</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-700 rounded-full text-xs">4th Year</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <div class="w-32">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 85%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">85% complete</div>
                                </div>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">14</td>
                            <td class="px6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">85%</span>
                            </td>
                            <td class="px6 py-4 whitespace-nowrap text-sm text-gray-500">2 days ago</td>
                            <td class="px6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-orange-600 hover:text-orange-900 mr-3">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900">
                                    <i data-lucide="message-square" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px6 py-4 border-t border-gray-100 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">156</span> students
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Previous
                    </button>
                    <button class="px-3 py-1 rounded-md bg-orange-600 text-white text-sm font-medium hover:bg-orange-700">
                        1
                    </button>
                    <button class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        2
                    </button>
                    <button class="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        3
                    </button>
                    <button class="px-3 py-1 rounded-md border border-gray-300 text极m font-medium text-gray-700 hover:bg-gray-50">
                        Next
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="px6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-black">Recent Activity</h3>
            </div>
            <div class="divide-y divide-gray-200">
                <!-- Activity 1 -->
                <div class="px6 py-4 flex items-start">
                    <div class="flex-shrink-0 bg-green-100 p-2 rounded-lg">
                        <i data-lucide="award" class="w-5 h-5 text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">
                            <span class="text-black">Alice Johnson</span> achieved a perfect score on Neural Networks Quiz
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="font-medium">Score:</span> 100% • <span class="font-medium">Time:</span> 12 minutes • 2 hours ago
                        </p>
                    </div>
                </div>
                <!-- Activity 2 -->
                <div class="px6 py-4 flex items-start">
                    <div class="flex-shrink-0 bg-blue-100 p-2 rounded-lg">
                        <i data-lucide="clock" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">
                            <span class="text-black">Bob Smith</span> completed the Machine Learning Challenge in record time
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="font-medium">Time:</span> 18 minutes • <span class="font-medium">Score:</span> 98% • 5 hours ago
                        </p>
                    </div>
                </div>
                <!-- Activity 3 -->
                <div class="px6 py-4 flex items-start">
                    <div class="flex-shrink-0 bg-purple-100 p-2 rounded-lg">
                        <i data-lucide="book-open" class="w-5 h-5 text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">
                            <span class="text-black">Carol Davis</span> completed all Deep Learning modules
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="font-medium">Progress:</span> 100% • <span class="font-medium">Average:</span> 89% • Yesterday
                        </p>
                    </div>
                </div>
            </div>
            <div class="px6 py-4 border-t border-gray-100 text-center">
                <button class="text-black text-sm font-medium hover:text-gray-700 flex items-center justify-center mx-auto">
                    View all activity
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                </button>
            </div>
        </div>
        </main>
    </div>
        
    <!-- Staff Quizzes Modal -->
    <div id="staffQuizzesModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-lg" id="modalStaffName">Staff Quizzes</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Questions</th>
                        </tr>
                    </thead>
                    <tbody id="quizzesList" class="bg-white divide-y divide-gray-200">
                        <!-- Quizzes will be inserted here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quiz Leaderboard Modal -->
    <div id="quizLeaderboardModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[80vh] overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-lg" id="modalQuizTitle">Quiz Leaderboard</h3>
                <button id="closeQuizModal" class="text-gray-500 hover:text-gray-700">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Taken</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Completed</th>
                        </tr>
                    </thead>
                    <tbody id="quizLeaderboardList" class="bg-white divide-y divide-gray-200">
                        <!-- Leaderboard data will be inserted here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Tab functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active classes from all buttons and nav indicators
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'active-nav');
                });
                
                // Add active classes to clicked button
                button.classList.add('active', 'active-nav');
                
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('active');
                });
                
                // Show selected tab content
                const tabId = button.getAttribute('data-tab');
                const activeTab = document.getElementById(`${tabId}-tab`);
                if (activeTab) {
                    activeTab.classList.remove('hidden');
                    activeTab.classList.add('active');
                }
                
                // Update page title based on selected department
                const titleMap = {
                    'ai': 'AI Department Leaderboard',
                    'cs': 'CS Department Leaderboard', 
                    'it': 'IT Department Leaderboard'
                };
                document.title = `Admin Dashboard | ${titleMap[tabId]}`;
            });
        });
                
        // Simulate live updates every 10 seconds
        setInterval(() => {
            // In a real app, you would fetch new data here
            console.log("Checking for updates...");
                        
            // Add a subtle visual cue that data is refreshing
            const liveIndicator = document.querySelector('.live-pulse');
            if (liveIndicator) {
                liveIndicator.classList.remove('live-pulse');
                void liveIndicator.offsetWidth; // Trigger reflow
                liveIndicator.classList.add('live-pulse');
            }
        }, 10000);
                
        // Staff click handler and modal functionality
        document.querySelectorAll('.staff-member').forEach(staff => {
            staff.addEventListener('click', () => {
                const staffName = staff.querySelector('p.font-medium').textContent;
                document.getElementById('modalStaffName').textContent = `${staffName}'s Quizzes`;
                
                // In a real app, you would fetch this data from an API
                // Here's sample data based on the staff member
                let quizzes = [];
                if (staffName.includes('Alex Thompson')) {
                    quizzes = [
                        { title: 'Neural Networks Basics', domain: 'Machine Learning', date: '2023-10-15', questions: 20 },
                        { title: 'Python Fundamentals', domain: 'Programming', date: '2023-09-28', questions: 15 },
                        { title: 'Data Structures', domain: 'Computer Science', date: '2023-09-10', questions: 25 }
                    ];
                } else if (staffName.includes('Michael Johnson')) {
                    quizzes = [
                        { title: 'Algorithms', domain: 'Computer Science', date: '2023-10-10', questions: 30 },
                        { title: 'Database Systems', domain: 'Information Technology', date: '2023-09-20', questions: 18 }
                    ];
                } else if (staffName.includes('Sarah Williams')) {
                    quizzes = [
                        { title: 'Web Development', domain: 'Information Technology', date: '2023-10-05', questions: 22 },
                        { title: 'Network Security', domain: 'Cybersecurity', date: '2023-09-15', questions: 15 }
                    ];
                }

                const quizzesList = document.getElementById('quizzesList');
                quizzesList.innerHTML = quizzes.map(quiz => `
                    <tr class="cursor-pointer hover:bg-gray-50 quiz-row" data-quiz="${quiz.title}">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${quiz.title}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${quiz.domain}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${quiz.date}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${quiz.questions}</td>
                    </tr>
                `).join('');

                // Add click handler for quiz rows
                document.querySelectorAll('.quiz-row').forEach(row => {
                    row.addEventListener('click', () => {
                        const quizTitle = row.getAttribute('data-quiz');
                        document.getElementById('modalQuizTitle').textContent = `${quizTitle} Leaderboard`;
                        
                        // Sample leaderboard data - in real app this would come from API
                        const leaderboardData = [
                            { rank: 1, student: 'Alice Johnson', score: '100%', time: '12:45', date: '2023-10-20' },
                            { rank: 2, student: 'Bob Smith', score: '98%', time: '15:30', date: '2023-10-19' },
                            { rank: 3, student: 'Carol Davis', score: '95%', time: '18:12', date: '2023-10-18' },
                            { rank: 4, student: 'David Wilson', score: '92%', time: '20:05', date: '2023-10-17' },
                            { rank: 5, student: 'Ethan Miller', score: '89%', time: '22:30', date: '2023-10-16' }
                        ];

                        const leaderboardList = document.getElementById('quizLeaderboardList');
                        leaderboardList.innerHTML = leaderboardData.map(student => `
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${student.rank}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">${student.student}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        ${student.score === '100%' ? 'bg-green-100 text-green-800' : 
                                          student.score >= '90%' ? 'bg-blue-100 text-blue-800' : 
                                          'bg-yellow-100 text-yellow-800'}">
                                        ${student.score}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${student.time}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">${student.date}</td>
                            </tr>
                        `).join('');

                        document.getElementById('staffQuizzesModal').classList.add('hidden');
                        document.getElementById('quizLeaderboardModal').classList.remove('hidden');
                    });
                });

                document.getElementById('staffQuizzesModal').classList.remove('hidden');
            });
        });

        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('staffQuizzesModal').classList.add('hidden');
        });

        document.getElementById('closeQuizModal').addEventListener('click', () => {
            document.getElementById('quizLeaderboardModal').classList.add('hidden');
        });

        // Close modals when clicking outside
        document.getElementById('staffQuizzesModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('staffQuizzesModal')) {
                document.getElementById('staffQuizzesModal').classList.add('hidden');
            }
        });

        document.getElementById('quizLeaderboardModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('quizLeaderboardModal')) {
                document.getElementById('quizLeaderboardModal').classList.add('hidden');
            }
        });

        // Year filter functionality
        document.getElementById('yearFilter').addEventListener('change', (e) => {
            const selectedYear = e.target.value;
            document.querySelectorAll('.leaderboard-item').forEach(row => {
                const yearCell = row.querySelector('td:nth-child(2) div:nth-child(2)');
                if (yearCell) {
                    const yearText = yearCell.textContent;
                    const studentYear = yearText.split('-')[0].trim();
                    if (selectedYear === 'all' || studentYear === selectedYear) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        // Add hover effects for better interactivity
        document.querySelectorAll('.leaderboard-item').forEach(row => {
            row.addEventListener('mouseenter', () => {
                const rankCell = row.querySelector('td:first-child div');
                if (rankCell) {
                    rankCell.classList.add('transform', 'scale-110');
                }
            });
            row.addEventListener('mouseleave', () => {
                const rankCell = row.querySelector('td:first-child div');
                if (rankCell) {
                    rankCell.classList.remove('transform', 'scale-110');
                }
            });
        });
    </script>
</body>
</html>
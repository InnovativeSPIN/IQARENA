<!DOCTYPE html>
<html lang="en">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports Dashboard</title>
    <meta name="description" content="Comprehensive reporting dashboard for college administration">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script>
        
    </script>
    <style>
  .shadow-orange {
    box-shadow: 0 4px 6px rgba(234, 88, 12, 0.4) !important;
  }
</style>

</head>
<body class="bg-gray-50 min-h-screen">
    <header class="bg-white shadow-orange">
        <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="text-orange-600 font-bold text-2xl">CodeCampus</span>
                <span class="text-sm text-gray-500">Admin Dashboard</span>
            </div>
            <div class="flex items-center space-x-4">
                <button class="px-3 py-1 bg-gray-200 rounded-md text-sm">Logout</button>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <div class="lg:w-1/4 bg-white rounded-lg shadow-orange p-4">
                <h3 class="text-lg font-semibold mb-4">Reports Navigation</h3>
                <ul class="space-y-2">
                    <li>
                        <button id="studentReportsBtn" class="w-full text-left px-3 py-2 bg-orange-600 text-white rounded-md">
                            <i class="fas fa-user-graduate mr-2"></i> Student Reports
                        </button>
                    </li>
                    <li>
                        <button id="facultyReportsBtn" class="w-full text-left px-3 py-2 hover:bg-orange-100 rounded-md">
                            <i class="fas fa-chalkboard-teacher mr-2"></i> Faculty Reports
                        </button>
                    </li>
                    <li>
                        <button id="departmentReportsBtn" class="w-full text-left px-3 py-2 hover:bg-orange-100 rounded-md">
                            <i class="fas fa-building mr-2"></i> Department Reports
                        </button>
                    </li>
                    <li>
                        <button id="testReportsBtn" class="w-full text-left px-3 py-2 hover:bg-orange-100 rounded-md">
                            <i class="fas fa-clipboard-check mr-2"></i> Test Reports
                        </button>
                    </li>
                    <li>
                        <button id="performanceReportsBtn" class="w-full text-left px-3 py-2 hover:bg-orange-100 rounded-md">
                            <i class="fas fa-chart-line mr-2"></i> Performance Reports
                        </button>
                    </li>
                </ul>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3">Quick Filters</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium mb-1">Time Period</label>
                            <select id="timePeriod" class="w-full px-3 py-2 border rounded-md">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                                <option value="custom">Custom Range</option>
                            </select>
                        </div>
                        <div id="customDateRange" class="hidden space-y-2">
                            <div>
                                <label class="block text-sm font-medium mb-1">From</label>
                                <input type="date" class="w-full px-3 py-2 border rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">To</label>
                                <input type="date" class="w-full px-3 py-2 border rounded-md">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Department</label>
                            <select id="departmentFilter" class="w-full px-3 py-2 border rounded-md">
                                <option value="all">All Departments</option>
                                <option value="cs">Computer Science</option>
                                <option value="ee">Electrical Engineering</option>
                                <option value="me">Mechanical Engineering</option>
                                <option value="ce">Civil Engineering</option>
                            </select>
                        </div>
                        <button class="w-full px-3 py-2 bg-orange-600 text-white rounded-md">
                            <i class="fas fa-filter mr-2"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:w-3/4 space-y-6" id="dynamicContent">
                <!-- Report Header -->
                <div class="bg-white rounded-lg shadow-orange p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold">Student Reports</h2>
                            <p class="text-sm text-gray-500">Last updated: <span id="lastUpdated">Today, 10:45 AM</span></p>
                        </div>
                        <div class="flex space-x-3">
                            <button class="px-3 py-1 border rounded-md hover:bg-orange-100">
                                <i class="fas fa-download mr-1"></i> Export
                            </button>
                            <button class="px-3 py-1 border rounded-md hover:bg-orange-100">
                                <i class="fas fa-print mr-1"></i> Print
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg shadow-orange p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Total Students</p>
                                <p class="text-2xl font-bold">1,245</p>
                            </div>
                            <div class="bg-orange-100 p-3 rounded-full">
                                <i class="fas fa-user-graduate text-orange-600"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                <span class="text-green-600">+5.2%</span> from last month
                            </p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-orange p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Active Tests</p>
                                <p class="text-2xl font-bold">28</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-clipboard-check text-green-600"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                <span class="text-green-600">+3 new</span> this week
                            </p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-orange p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Avg. Score</p>
                                <p class="text-2xl font-bold">72.5%</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-chart-line text-purple-600"></i>
                            </div>
                        </div>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                <span class="text-red-600">-1.2%</span> from last month
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-lg shadow-orange p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Student Performance</h3>
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 border rounded-md hover:bg-orange-100">
                                <i class="fas fa-table mr-1"></i> Table View
                            </button>
                            <button class="px-3 py-1 border rounded-md hover:bg-orange-100">
                                <i class="fas fa-chart-bar mr-1"></i> Chart View
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tests Taken</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Example rows -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">CS2023001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rahul Sharma</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Computer Science</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">78%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
                                </tr>
                                <!-- Add more rows if needed -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Charts Placeholder -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg shadow-orange p-6">
                        <h3 class="text-lg font-semibold mb-4">Department-wise Performance</h3>
                        <div class="h-64 bg-gray-100 rounded flex items-center justify-center">
                            <p class="text-gray-500">Chart visualization would appear here</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-orange p-6">
                        <h3 class="text-lg font-semibold mb-4">Year-wise Participation</h3>
                        <div class="h-64 bg-gray-100 rounded flex items-center justify-center">
                            <p class="text-gray-500">Chart visualization would appear here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t mt-8 py-6">
        <div class="container mx-auto px-4 text-center text-sm text-gray-500">
            <p>© 2023 CodeCampus - College Coding Platform</p>
        </div>
    </footer>

    <script>
        const studentReportsBtn = document.getElementById('studentReportsBtn');
        const facultyReportsBtn = document.getElementById('facultyReportsBtn');
        const departmentReportsBtn = document.getElementById('departmentReportsBtn');
        const testReportsBtn = document.getElementById('testReportsBtn');
        const performanceReportsBtn = document.getElementById('performanceReportsBtn');
        const timePeriod = document.getElementById('timePeriod');
        const customDateRange = document.getElementById('customDateRange');

        const reportData = {
            student: {
                title: "Student Reports",
                description: "Detailed reports on student activities and performance"
            },
            faculty: {
                title: "Faculty Reports",
                description: "Reports on faculty activities and course management"
            },
            department: {
                title: "Department Reports",
                description: "Department-wise analysis and statistics"
            },
            test: {
                title: "Test Reports",
                description: "Detailed reports on tests and assessments"
            },
            performance: {
                title: "Performance Reports",
                description: "Performance metrics and analytics"
            }
        };

        timePeriod.addEventListener('change', function () {
            if (this.value === 'custom') {
                customDateRange.classList.remove('hidden');
            } else {
                customDateRange.classList.add('hidden');
            }
        });

        function setActiveReport(activeBtn, reportType) {
            [studentReportsBtn, facultyReportsBtn, departmentReportsBtn, testReportsBtn, performanceReportsBtn].forEach(btn => {
                btn.classList.remove('bg-orange-600', 'text-white');
                btn.classList.add('hover:bg-orange-100');
            });

            activeBtn.classList.add('bg-orange-600', 'text-white');
            activeBtn.classList.remove('hover:bg-orange-100');

            document.querySelector('#dynamicContent h2').textContent = reportData[reportType].title;
            document.querySelector('#dynamicContent p').textContent = reportData[reportType].description;
        }

        studentReportsBtn.addEventListener('click', () => setActiveReport(studentReportsBtn, 'student'));
        facultyReportsBtn.addEventListener('click', () => setActiveReport(facultyReportsBtn, 'faculty'));
        departmentReportsBtn.addEventListener('click', () => setActiveReport(departmentReportsBtn, 'department'));
        testReportsBtn.addEventListener('click', () => setActiveReport(testReportsBtn, 'test'));
        performanceReportsBtn.addEventListener('click', () => setActiveReport(performanceReportsBtn, 'performance'));

        setActiveReport(studentReportsBtn, 'student');
    </script>
</body>
</html>

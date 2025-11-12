<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/hod_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            500: '#f97316',
                            600: '#ea580c',
                        },
                        secondary: {
                            500: '#10b981',
                            600: '#059669',
                        },
                        accent: {
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    boxShadow: {
                        'custom': '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    }
                }
            }
        }
    </script>
    
    
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-white w-64 fixed h-full shadow-lg z-20">
            <div class="p-4 flex items-center justify-center border-b border-gray-200">
                <div class="flex items-center">
                    <i class="fas fa-university text-primary-500 text-3xl mr-3"></i>
                    <h1 class="text-xl font-bold text-gray-800">HOD Dashboard</h1>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center space-x-3 p-3 bg-primary-50 rounded-lg mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p class="font-medium">Dr. John Smith</p>
                        <p class="text-xs text-gray-500">Computer Science HOD</p>
                    </div>
                </div>
                <nav class="mt-6">
                    <div>
                        <p class="text-xs uppercase text-gray-500 font-semibold px-3 mb-2">Main</p>
                        <a href="#" class="flex items-center px-3 py-3 text-gray-700 rounded-lg active-nav">
                            <i class="fas fa-tachometer-alt mr-3 text-primary-500"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div>
                        <a href="#" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-chart-line mr-3 text-primary-500"></i>
                            <span>Analysis</span>
                        </a>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs uppercase text-gray-500 font-semibold px-3 mb-2">Management</p>
                        <a href="#" onclick="showStaffSection()" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-chalkboard-teacher mr-3 text-primary-500"></i>
                            <span>Staff</span>
                        </a>
                        <a href="#" onclick="showStudentsSection()" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-user-graduate mr-3 text-primary-500"></i>
                            <span>Students</span>
                        </a>
                        <a href="#" onclick="showScheduleSection()" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-calendar-alt mr-3 text-primary-500"></i>
                            <span>Schedule</span>
                        </a>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs uppercase text-gray-500 font-semibold px-3 mb-2">Settings</p>
                        <a href="#" onclick="openProfileSettings()" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-cog mr-3 text-primary-500"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="flex items-center px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-3 text-primary-500"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-0 md:ml-64 transition-all duration-300">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="md:hidden text-gray-600 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="text-lg font-semibold ml-3">Dashboard Overview</h2>
                    </div>
                    <div class="flex items-center space-x-4">
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-4 overflow-y-auto" style="max-height: calc(100vh - 64px)">
                <!-- Dashboard content will be shown by default -->
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Total Students</p>
                                <h3 class="text-2xl font-bold mt-1">1,245</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center">
                                <i class="fas fa-user-graduate text-primary-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full flex items-center">
                                <i class="fas fa-arrow-up mr-1 text-xs"></i> 12%
                            </span>
                            <span class="text-gray-500 text-xs ml-2">from last year</span>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Teaching Staff</p>
                                <h3 class="text-2xl font-bold mt-1">42</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-secondary-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full flex items-center">
                                <i class="fas fa-plus mr-1 text-xs"></i> 2
                            </span>
                            <span class="text-gray-500 text-xs ml-2">new hires</span>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Tests Conducted</p>
                                <h3 class="text-2xl font-bold mt-1">28</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-accent-100 flex items-center justify-center">
                                <i class="fas fa-book text-accent-500 text-xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full flex items-center">
                                <i class="fas fa-arrow-up mr-1 text-xs"></i> 12
                            </span>
                            <span class="text-gray-500 text-xs ml-2">this month</span>
                        </div>
                    </div>
                </div>
                <!-- Staff and Students Section -->
                <div class="grid grid-cols-1">
                    <!-- Staff Management -->
                    <div class="staff-management bg-white rounded-lg shadow w-full">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-semibold text-lg">Teaching Staff</h3>
                            <div class="flex space-x-2">
                                <button onclick="openAddStaffModal()" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm flex items-center">
                                    <i class="fas fa-plus mr-2"></i> Add Staff
                                </button>
                                
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tests</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-primary-500"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Dr. Sarah Johnson</div>
                                                    <div class="text-sm text-gray-500">s.johnson@univ.edu</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Professor</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            8
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button onclick="editStaff(1)" class="text-primary-500 hover:text-primary-600 mr-3"><i class="fas fa-edit"></i></button>
                                            <button onclick="deleteStaff(1)" class="text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-primary-500"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Prof. Michael Brown</div>
                                                    <div class="text-sm text-gray-500">m.brown@univ.edu</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Associate Prof.</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            8
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button onclick="editStaff(2)" class="text-primary-500 hover:text-primary-600 mr-3"><i class="fas fa-edit"></i></button>
                                            <button onclick="deleteStaff(2)" class="text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-primary-500"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Dr. Emily Wilson</div>
                                                    <div class="text-sm text-gray-500">e.wilson@univ.edu</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Assistant Prof.</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">On Leave</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            8
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button onclick="editStaff(3)" class="text-primary-500 hover:text-primary-600 mr-3"><i class="fas fa-edit"></i></button>
                                            <button onclick="deleteStaff(3)" class="text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-gray-200 text-center">
                            <button class="view-all-staff text-primary-500 hover:text-primary-600 text-sm font-medium">View All Staff (42)</button>
                        </div>
                    </div>

                    <!-- Student Management -->
                    <div class="student-management bg-white rounded-lg shadow">
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-semibold text-lg">Student Records</h3>
                            <div class="flex space-x-2">
                                <button onclick="openAddStudentModal()" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm flex items-center">
                                    <i class="fas fa-plus mr-2"></i> Add Student
                                </button>
                                <select id="yearFilter" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-200 focus:border-orange-300">
                                         <option value="all">All Years</option>
                                         <option value="I">I Year</option>
                                         <option value="II">II Year</option>
                                         <option value="III">III Year</option>
                                        <option value="IV">IV Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reg. No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tests</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">CS2023001</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-primary-500"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Alex Turner</div>
                                                    <div class="text-sm text-gray-500">B.Tech CSE</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">III Year</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            12/15
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button onclick="editStudent(1)" class="text-primary-500 hover:text-primary-600 mr-3"><i class="fas fa-edit"></i></button>
                                            <button onclick="deleteStudent(1)" class="text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">CS2023002</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-primary-500"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Sophia Martinez</div>
                                                    <div class="text-sm text-gray-500">B.Tech CSE</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">III Year</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            12/15
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button onclick="editStudent(2)" class="text-primary-500 hover:text-primary-600 mr-3"><i class="fas fa-edit"></i></button>
                                            <button onclick="deleteStudent(2)" class="text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">CS2022005</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-primary-500"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">James Wilson</div>
                                                    <div class="text-sm text-gray-500">B.Tech CSE</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">IV Year</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Probation</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            12/15
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <button onclick="editStudent(3)" class="text-primary-500 hover:text-primary-600 mr-3"><i class="fas fa-edit"></i></button>
                                            <button onclick="deleteStudent(3)" class="text-red-500 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-gray-200 flex items-center justify-between">
                            <span class="text-sm text-gray-600">Showing 1 to 3 of 1,245 students</span>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Previous</button>
                                <button class="px-3 py-1 border border-gray-300 rounded text-sm bg-primary-500 text-white">1</button>
                                <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">2</button>
                                <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">3</button>
                                <button class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">Next</button>
                            </div>
                        </div>
                    </div>


                    <!-- Schedule Section -->
                    <div class="schedule-section bg-white rounded-lg shadow hidden">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="font-semibold text-lg">Class Schedule</h3>
                        </div>
                        <div class="p-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monday</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tuesday</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wednesday</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thursday</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Friday</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">9:00 - 10:30</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS101 (Prof. Smith)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS102 (Dr. Johnson)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS101 (Prof. Smith)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">Lab Session</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS102 (Dr. Johnson)</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">10:45 - 12:15</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS103 (Dr. Brown)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS101 (Prof. Smith)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS103 (Dr. Brown)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS102 (Dr. Johnson)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS101 (Prof. Smith)</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1:30 - 3:00</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS102 (Dr. Johnson)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS103 (Dr. Brown)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">Lab Session</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS101 (Prof. Smith)</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">CS103 (Dr. Brown)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <!-- Add Staff Modal -->
    <div id="addStaffModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Add New Staff Member</h3>
                <button onclick="closeModal('addStaff')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addStaffForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="newStaffName" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="newStaffEmail" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Position <span class="text-red-500">*</span></label>
                    <select id="newStaffPosition" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                        <option value="">Select Position</option>
                        <option value="Professor">Professor</option>
                        <option value="Associate Professor">Associate Professor</option>
                        <option value="Assistant Professor">Assistant Professor</option>
                        <option value="Lecturer">Lecturer</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Department <span class="text-red-500">*</span></label>
                    <select id="newStaffDepartment" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                        <option value="">Select Department</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Mathematics">Information Technology</option>
                        <option value="Physics">Artificial Intelligence</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addStaff')" class="px-4 py-2 border rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition">Add Staff</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Add New Student</h3>
                <button onclick="closeModal('addStudent')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="addStudentForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Student ID <span class="text-red-500">*</span></label>
                    <input type="text" id="newStudentId" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="newStudentName" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Program <span class="text-red-500">*</span></label>
                    <select id="newStudentProgram" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                        <option value="">Select Program</option>
                        <option value="B.Tech CSE">B.E Computer Science</option>
                        <option value="B.Tech IT">B.Tech Information Technology</option>
                        <option value="B.Sc CS">B.Tech  Artificial Intelligence</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Year <span class="text-red-500">*</span></label>
                    <select id="newStudentYear" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                        <option value="">Select Year</option>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="newStudentEmail" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addStudent')" class="px-4 py-2 border rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition">Add Student</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div id="editStaffModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Staff Details</h3>
                <button onclick="closeModal('editStaff')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editStaffForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Full Name</label>
                    <input type="text" id="editStaffName" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Email</label>
                    <input type="email" id="editStaffEmail" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Position</label>
                    <select id="editStaffPosition" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="Professor">Professor</option>
                        <option value="Associate Professor">Associate Professor</option>
                        <option value="Assistant Professor">Assistant Professor</option>
                        <option value="Lecturer">Lecturer</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Status</label>
                    <select id="editStaffStatus" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('editStaff')" class="px-4 py-2 border rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editStudentModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Student Details</h3>
                <button onclick="closeModal('editStudent')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editStudentForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Student ID</label>
                    <input type="text" id="editStudentId" class="w-full px-3 py-2 border rounded-lg bg-gray-100" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Full Name</label>
                    <input type="text" id="editStudentName" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Program</label>
                    <input type="text" id="editStudentProgram" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Year</label>
                    <select id="editStudentYear" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Status</label>
                    <select id="editStudentStatus" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        <option value="Active">Active</option>
                        <option value="Probation">Probation</option>
                        <option value="Suspended">Suspended</option>
                        <option value="Graduated">Graduated</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('editStudent')" class="px-4 py-2 border rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Profile Settings Modal -->
    <div id="profileSettingsModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Profile Settings</h3>
                <button onclick="closeModal('profileSettings')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="profileSettingsForm">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="profileName" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" id="profileEmail" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Department <span class="text-red-500">*</span></label>
                    <input type="text" id="profileDepartment" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Change Password</label>
                    <input type="password" id="profileNewPassword" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" placeholder="Leave blank to keep current">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2">Confirm Password</label>
                    <input type="password" id="profileConfirmPassword" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition" placeholder="Leave blank to keep current">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('profileSettings')" class="px-4 py-2 border rounded-lg hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold" id="confirmModalTitle">Confirm Action</h3>
                <button onclick="closeModal('confirm')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-6">
                <p id="confirmModalMessage">Are you sure you want to perform this action?</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('confirm')" class="px-4 py-2 border rounded-lg hover:bg-gray-50 transition">Cancel</button>
                <button type="button" id="confirmModalAction" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Confirm</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Function to show staff section
        function showStaffSection() {
            document.querySelector('.staff-management').style.display = 'block';
            document.querySelector('.student-management').style.display = 'none';
            document.querySelector('.schedule-section').style.display = 'none';
            document.querySelector('header h2').textContent = 'Staff Management';
            updateActiveNav('staff');
        }

        // Function to show students section
        function showStudentsSection() {
            document.querySelector('.staff-management').style.display = 'none';
            document.querySelector('.student-management').style.display = 'block';
            document.querySelector('.schedule-section').style.display = 'none';
            document.querySelector('header h2').textContent = 'Student Management';
            updateActiveNav('students');
        }

        // Function to show schedule section
        function showScheduleSection() {
            document.querySelector('.staff-management').style.display = 'none';
            document.querySelector('.student-management').style.display = 'none';
            document.querySelector('.schedule-section').style.display = 'block';
            document.querySelector('header h2').textContent = 'Class Schedule';
            updateActiveNav('schedule');
        }

        // Function to update active navigation styling
        function updateActiveNav(section) {
            // Remove active class from all nav items
            document.querySelectorAll('nav a').forEach(link => {
                link.classList.remove('active-nav');
            });

            // Add active class to clicked nav item
            if (section === 'staff') {
                document.querySelector('a[onclick="showStaffSection()"]').classList.add('active-nav');
            } else if (section === 'students') {
                document.querySelector('a[onclick="showStudentsSection()"]').classList.add('active-nav');
            } else if (section === 'schedule') {
                document.querySelector('a[onclick="showScheduleSection()"]').classList.add('active-nav');
            }
        }

        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');
            
            // Add overlay when sidebar is active on mobile
            if (sidebar.classList.contains('active')) {
                const overlay = document.createElement('div');
                overlay.id = 'sidebarOverlay';
                overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-10 md:hidden';
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    document.body.removeChild(overlay);
                });
                document.body.appendChild(overlay);
            } else {
                const overlay = document.getElementById('sidebarOverlay');
                if (overlay) document.body.removeChild(overlay);
            }
        });

        // Close sidebar when clicking main content on mobile
        document.querySelector('.flex-1').addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                const sidebar = document.querySelector('.sidebar');
                if (sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    const overlay = document.getElementById('sidebarOverlay');
                    if (overlay) document.body.removeChild(overlay);
                }
            }
        });

        // Modal functions
        function openProfileSettings() {
            // In a real app, you would fetch the current profile data from an API
            document.getElementById('profileName').value = 'HOD Nam';
            document.getElementById('profileEmail').value = 'john.smith@univ.edu';
            document.getElementById('profileDepartment').value = 'Computer Science';
            
            document.getElementById('profileSettingsModal').classList.add('active');
        }
        function openAddStaffModal() {
            document.getElementById('addStaffModal').classList.add('active');
        }

        function openAddStudentModal() {
            // Generate a new student ID
            const year = new Date().getFullYear().toString().substr(-2);
            const randomNum = Math.floor(1000 + Math.random() * 9000);
            document.getElementById('newStudentId').value = `CS${year}${randomNum}`;
            
            document.getElementById('addStudentModal').classList.add('active');
        }

        function closeModal(type) {
            if (type === 'addStaff') {
                document.getElementById('addStaffModal').classList.remove('active');
            } else if (type === 'addStudent') {
                document.getElementById('addStudentModal').classList.remove('active');
            } else if (type === 'editStaff') {
                document.getElementById('editStaffModal').classList.remove('active');
            } else if (type === 'editStudent') {
                document.getElementById('editStudentModal').classList.remove('active');
            } else if (type === 'profileSettings') {
                document.getElementById('profileSettingsModal').classList.remove('active');
            } else if (type === 'confirm') {
                document.getElementById('confirmModal').classList.remove('active');
            }
        }

        // Edit functions
        function editStaff(id) {
            // In a real app, you would fetch the staff data from an API
            const staffRow = document.querySelector(`tbody tr:nth-child(${id})`);
            const staffData = {
                name: staffRow.querySelector('.text-gray-900').textContent,
                email: staffRow.querySelector('.text-gray-500').textContent,
                position: staffRow.querySelector('.bg-blue-100, .bg-green-100, .bg-yellow-100, .bg-gray-100').textContent,
                status: staffRow.querySelectorAll('.bg-blue-100, .bg-green-100, .bg-yellow-100, .bg-gray-100')[1].textContent
            };

            document.getElementById('editStaffName').value = staffData.name;
            document.getElementById('editStaffEmail').value = staffData.email;
            document.getElementById('editStaffPosition').value = staffData.position;
            document.getElementById('editStaffStatus').value = staffData.status;

            document.getElementById('editStaffModal').classList.add('active');
        }

        function editStudent(id) {
            // In a real app, you would fetch the student data from an API
            const studentRow = document.querySelector(`tbody tr:nth-child(${id})`);
            const studentData = {
                id: studentRow.querySelector('.text-gray-900').textContent,
                name: studentRow.querySelectorAll('.text-gray-900')[1].textContent,
                program: studentRow.querySelector('.text-gray-500').textContent,
                year: studentRow.querySelector('.bg-purple-100, .bg-blue-100').textContent,
                status: studentRow.querySelector('.bg-green-100, .bg-yellow-100').textContent
            };

            document.getElementById('editStudentId').value = studentData.id;
            document.getElementById('editStudentName').value = studentData.name;
            document.getElementById('editStudentProgram').value = studentData.program;
            document.getElementById('editStudentYear').value = studentData.year;
            document.getElementById('editStudentStatus').value = studentData.status;

            document.getElementById('editStudentModal').classList.add('active');
        }

        // Delete functions with confirmation modal
        function deleteStaff(id) {
            document.getElementById('confirmModalTitle').textContent = 'Delete Staff Member';
            document.getElementById('confirmModalMessage').textContent = 'Are you sure you want to delete this staff member? This action cannot be undone.';
            document.getElementById('confirmModalAction').onclick = function() {
                // In a real app, you would send a delete request to your backend
                alert('Staff member deleted successfully!');
                closeModal('confirm');
                // Then refresh the table or remove the row
            };
            document.getElementById('confirmModal').classList.add('active');
        }

        function deleteStudent(id) {
            document.getElementById('confirmModalTitle').textContent = 'Delete Student';
            document.getElementById('confirmModalMessage').textContent = 'Are you sure you want to delete this student record? This action cannot be undone.';
            document.getElementById('confirmModalAction').onclick = function() {
                // In a real app, you would send a delete request to your backend
                alert('Student deleted successfully!');
                closeModal('confirm');
                // Then refresh the table or remove the row
            };
            document.getElementById('confirmModal').classList.add('active');
        }

        // Form submissions
        document.getElementById('profileSettingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newPassword = document.getElementById('profileNewPassword').value;
            const confirmPassword = document.getElementById('profileConfirmPassword').value;
            
            if (newPassword && newPassword !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            
            // Here you would send the updated profile data to your backend
            const name = document.getElementById('profileName').value;
            alert(`Profile updated successfully! Welcome, ${name}`);
            closeModal('profileSettings');
            
            // Update the displayed profile info
            document.querySelector('.sidebar p.font-medium').textContent = name;
            document.querySelector('.sidebar p.text-xs.text-gray-500').textContent = 
                document.getElementById('profileDepartment').value + ' HOD';
        });
        document.getElementById('addStaffForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would send the data to your backend
            const name = document.getElementById('newStaffName').value;
            alert(`New staff member ${name} added successfully!`);
            closeModal('addStaff');
            // Reset form
            this.reset();
        });

        document.getElementById('addStudentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would send the data to your backend
            const name = document.getElementById('newStudentName').value;
            alert(`New student ${name} added successfully!`);
            closeModal('addStudent');
            // Reset form and generate new ID for next student
            this.reset();
            const year = new Date().getFullYear().toString().substr(-2);
            const randomNum = Math.floor(1000 + Math.random() * 9000);
            document.getElementById('newStudentId').value = `CS${year}${randomNum}`;
        });

        document.getElementById('editStaffForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would send the data to your backend
            alert('Staff details updated successfully!');
            closeModal('editStaff');
        });

        document.getElementById('editStudentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Here you would send the data to your backend
            alert('Student details updated successfully!');
            closeModal('editStudent');
        });

    </script>
    </body>
    </html>
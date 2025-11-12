  <div class="flex flex-col h-screen overflow-hidden">
        <!-- Top Navigation Bar -->
        <header class="bg-white shadow-sm">
            <div class="flex justify-center items-center p-4">
                <div class="flex items-center space-x-8">
                    <a href="#" class="nav-item flex flex-col items-center p-2 text-gray-700 hover:text-primary-500" onclick="showSection('dashboard')">
                        <i data-feather="home" class="w-5 h-5"></i>
                        <span class="text-xs mt-1">Dashboard</span>
                    </a>
                    <a href="#" class="nav-item flex flex-col items-center p-2 text-gray-700 hover:text-primary-500" onclick="showSection('users')">
                        <i data-feather="users" class="w-5 h-5"></i>
                        <span class="text-xs mt-1">Users</span>
                    </a>
                    <a href="#" class="nav-item flex flex-col items-center p-2 text-gray-700 hover:text-primary-500" onclick="showSection('questions')">
                        <i data-feather="help-circle" class="w-5 h-5"></i>
                        <span class="text-xs mt-1">Questions</span>
                    </a>
                    <a href="#" class="nav-item flex flex-col items-center p-2 text-gray-700 hover:text-primary-500" onclick="showSection('tests')">
                        <i data-feather="clipboard" class="w-5 h-5"></i>
                        <span class="text-xs mt-1">Tests</span>
                    </a>
                    <a href="#" class="nav-item flex flex-col items-center p-2 text-gray-700 hover:text-primary-500" onclick="showSection('departments')">
                        <i data-feather="layers" class="w-5 h-5"></i>
                        <span class="text-xs mt-1">Departments</span>
                    </a>
                    <a href="#" class="nav-item flex flex-col items-center p-2 text-gray-700 hover:text-primary-500" onclick="showSection('reports')">
                        <i data-feather="bar-chart-2" class="w-5 h-5"></i>
                        <span class="text-xs mt-1">Reports</span>
                    </a>
                </div>
                <div class="absolute right-4 flex items-center space-x-4">
                    <div class="relative">
                        <i data-feather="bell" class="text-gray-500 hover:text-primary-500 cursor-pointer"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-primary-500 rounded-full text-white text-xs flex items-center justify-center">3</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                            <i data-feather="user" class="text-primary-600"></i>
                        </div>
                        <span class="ml-2 text-sm font-medium">Admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Page Title -->
            <div class="bg-white shadow-sm">
                <div class="p-4">
                    <h1 class="text-2xl font-bold text-gray-800" id="page-title">Dashboard</h1>
                </div>
            </div>

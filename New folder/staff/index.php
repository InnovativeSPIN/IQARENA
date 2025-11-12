<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Staff Dashboard </title>

  <!-- TailwindCSS -->
  <script src="https://cdn.tailwindcss.com"></script>


  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>

<div class="bg-gray-100 min-h-screen flex flex-col">

  <?php include('./header.php') ?>

  <main class="container mx-auto p-6 flex flex-col gap-8">


    <section id="nav-section" class="mb-6">
      <?php include('./nav.php') ?>
    </section>



    <section id="stats-section" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

      <!-- Quizzes Created -->
      <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-orange-400 hover:shadow-xl transition">
        <div class="flex items-center space-x-4">
          <div class="bg-orange-100 p-3 rounded-xl">
            <i data-lucide="book-open" class="w-7 h-7 text-orange-500"></i>
          </div>
          <div>
            <p class="text-sm text-gray-500">Quizzes Created</p>
            <p class="text-3xl font-bold text-gray-800">8</p>
            <p class="text-xs text-green-600 mt-1">↑ 12% vs last semester</p>
          </div>
        </div>
      </div>

      <!-- Students Evaluated -->
      <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-blue-400 hover:shadow-xl transition">
        <div class="flex items-center space-x-4">
          <div class="bg-blue-100 p-3 rounded-xl">
            <i data-lucide="users" class="w-7 h-7 text-blue-500"></i>
          </div>
          <div>
            <p class="text-sm text-gray-500">Students Evaluated</p>
            <p class="text-3xl font-bold text-gray-800">156</p>
            <p class="text-xs text-green-600 mt-1">↑ 8% vs last month</p>
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
            <p class="text-xs text-green-600 mt-1">↑ 3% vs last term</p>
          </div>
        </div>
      </div>

      <!-- Active Quizzes -->
      <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-yellow-400 hover:shadow-xl transition">
        <div class="flex items-center space-x-4">
          <div class="bg-yellow-100 p-3 rounded-xl">
            <i data-lucide="clock" class="w-7 h-7 text-yellow-500"></i>
          </div>
          <div>
            <p class="text-sm text-gray-500">Active Quizzes</p>
            <p class="text-3xl font-bold text-gray-800">3</p>
            <p class="text-xs text-gray-500 mt-1">Currently running</p>
          </div>
        </div>
      </div>

    </section>


    <section id="filters-section"
      class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">

      <!-- Search Bar -->
      <div class="flex items-center bg-gray-50 border border-gray-200 p-3 rounded-xl shadow-sm w-full md:w-1/2 focus-within:ring-2 focus-within:ring-orange-400 transition">
        <i data-lucide="search" class="w-5 h-5 text-gray-400 mr-2"></i>
        <input type="text"
          id="search-input"
          placeholder="Search quizzes..."
          class="w-full bg-transparent outline-none text-gray-700 placeholder-gray-400" />
      </div>

      <!-- Filters & Button -->
      <div class="flex space-x-3">
        <select id="filter-status"
          class="p-2.5 rounded-xl border border-gray-200 bg-white shadow-sm text-gray-700 cursor-pointer hover:border-orange-400 focus:ring-2 focus:ring-orange-400 transition">
          <option value="all">All</option>
          <option value="active">Active</option>
          <option value="completed">Completed</option>
        </select>

        <button class="flex items-center px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl shadow-sm transition">
          <i data-lucide="bar-chart-3" class="w-5 h-5 mr-2"></i> Analytics
        </button>
      </div>
    </section>




    <section id="quiz-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <!-- Quiz Card -->
      <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition border-l-4 border-orange-500">
        <h3 class="text-lg font-semibold text-gray-800">Java Basics Quiz</h3>
        <p class="text-sm text-gray-500 mb-3">Created on: Jan 15, 2025</p>
        <div class="flex justify-between items-center">
          <span class="px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-600 font-medium">Active</span>
          <button class="text-sm text-orange-600 hover:underline">View</button>
        </div>
      </div>

      <!-- Quiz Card -->
      <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition border-l-4 border-orange-500">
        <h3 class="text-lg font-semibold text-gray-800">HTML & CSS Fundamentals</h3>
        <p class="text-sm text-gray-500 mb-3">Created on: Dec 30, 2024</p>
        <div class="flex justify-between items-center">
          <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600 font-medium">Completed</span>
          <button class="text-sm text-orange-600 hover:underline">View</button>
        </div>
      </div>

      <!-- Quiz Card -->
      <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition border-l-4 border-orange-500">
        <h3 class="text-lg font-semibold text-gray-800">Python Advanced Concepts</h3>
        <p class="text-sm text-gray-500 mb-3">Created on: Feb 2, 2025</p>
        <div class="flex justify-between items-center">
          <span class="px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-600 font-medium">Active</span>
          <button class="text-sm text-orange-600 hover:underline">View</button>
        </div>
      </div>

      <!-- Quiz Card -->
      <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition border-l-4 border-orange-500">
        <h3 class="text-lg font-semibold text-gray-800">Database Management Quiz</h3>
        <p class="text-sm text-gray-500 mb-3">Created on: Nov 20, 2024</p>
        <div class="flex justify-between items-center">
          <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600 font-medium">Completed</span>
          <button class="text-sm text-orange-600 hover:underline">View</button>
        </div>
      </div>

    </section>

  </main>

</div>
  <section id="api-section">
    <?php include('../resource/api.php') ?>
  </section>


  <?php include('./sessionHandle.php') ?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Test</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen font-sans">
    <?php include('./header.php') ?>

  <main class="container mx-auto p-6 flex flex-col gap-8">
    <section id="nav-section">
      <?php include('./nav.php') ?>
    </section>

<section id="quiz-list-section" class="container mx-auto mt-8">
  <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col md:flex-row md:justify-between md:items-center gap-6">

    <div class="flex-1">
      <h2 class="text-2xl font-bold text-gray-800 mb-2">Data Structures Quiz</h2>
      <p class="text-gray-600 mb-4">Covers Linked Lists, Trees, and Graphs fundamentals.</p>

      <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700">
        <div><span class="font-semibold">Domain:</span> Programming</div>
        <div><span class="font-semibold">Department:</span> CSE</div>
        <div><span class="font-semibold">Year:</span> II</div>
        <div><span class="font-semibold">Start Time:</span> 10:00 AM</div>
        <div><span class="font-semibold">End Time:</span> 11:00 AM</div>
        <div><span class="font-semibold">Duration:</span> 60 mins</div>
        <div><span class="font-semibold">Total Questions:</span> 25</div>
        <div><span class="font-semibold">Total Marks:</span> 50</div>
        <div><span class="font-semibold">Status:</span> <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold">Active</span></div>
      </div>
    </div>

    <div class="flex md:flex-col gap-4 items-center md:items-end">
      <button class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white rounded-xl shadow-md font-semibold transition duration-200">
        View Quiz
      </button>
      <button class="px-6 py-3 border border-gray-300 hover:border-gray-400 text-gray-700 rounded-xl shadow-sm font-medium transition duration-200">
        Edit Quiz
      </button>
    </div>

  </div>
</section>

</main>

    <section id="api-section" class="container mt-6">
        <?php include('../resource/api.php') ?>
    </section>


    <script>
        window.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch('<?php echo $api; ?>faculty/test/testRoutes.php');
                const result = await response.json();

                if (result.success) {
                    const container = document.querySelector('#quiz-list-section .quiz-list');
                    container.innerHTML = ''; 

                    result.data.forEach(test => {
                        const div = document.createElement('div');
                        div.className = "quiz-card bg-white rounded-xl shadow-md p-6";

                        div.innerHTML = `
                            <h2>${test.title}</h2>
                            <p class="description">${test.description}</p>
                            <ul class="quiz-info-list">
                                <li><span>Domain:</span> <span>${test.domain}</span></li>
                                <li><span>Department:</span> <span>${test.department}</span></li>
                                <li><span>Year:</span> <span>${test.year}</span></li>
                                <li><span>Start:</span> <span>${test.start_time}</span></li>
                                <li><span>End:</span> <span>${test.end_time}</span></li>
                                <li><span>Duration:</span> <span>${test.duration_minutes} mins</span></li>
                                <li><span>Qs:</span> <span>${test.total_questions}</span></li>
                                <li><span>Marks:</span> <span>${test.total_marks}</span></li>
                                <li><span>Status:</span> <span class="status ${test.is_active == 1 ? 'active' : 'inactive'}">${test.is_active == 1 ? 'Active' : 'Inactive'}</span></li>
                            </ul>
                        `;
                        container.appendChild(div);
                    });
                } else {
                    console.error('Failed to load tests:', result.message);
                }
            } catch (err) {
                console.error('Error fetching tests:', err);
            }
        });
    </script>
    <?php include('../resource/logout.php') ?>
    <?php include('../resource/check_session.php') ?>
</body>
</html>

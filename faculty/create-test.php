<?php
include("../resource/session.php");


include("../resource/conn.php");

// Get all topics
$topicStmt = $conn->prepare("
    SELECT topic_id, title 
    FROM topics 
    WHERE by_admin = 1 OR added_by = ?
    ORDER BY created_at DESC
");
$topicStmt->bind_param("i", $_SESSION['id']);
$topicStmt->execute();
$topicResult = $topicStmt->get_result();

// fetch departments
$stmt = $conn->prepare("
    SELECT id, short_name, full_name 
    FROM departments
    ORDER BY id ASC
");
$stmt->execute();
$result = $stmt->get_result();

$departments = [];
while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}

include("../backend/faculty/createTest.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Test | IQ Arena</title>

  <!-- TailwindCSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    select option:checked,
    select option:hover {
      background-color: #f97316;
      color: white;
    }
  </style>
</head>

<body class="bg-gray-100 min-h-screen font-sans">


  <?php include('./header.php') ?>

  <main class="container mx-auto p-6 flex flex-col gap-8">

    <section id="nav-section">
      <?php include('./nav.php') ?>
    </section>

    <section id="title-section">
      <h2 class="text-3xl font-bold text-gray-800 mb-2">Create New Test</h2>
      <p class="text-gray-500">Fill out the form below to create a new test for students.</p>
    </section>

    <section id="form-section" class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-[95%] mx-auto">
      <form id="create-test-form" class="grid grid-cols-1 md:grid-cols-2 gap-6" action="./create-test.php" method="post">
        <div class="flex flex-col md:col-span-2 relative">
          <label class="font-semibold text-gray-700 mb-2">Select Topic</label>
          <div class="relative">
            <select
              name="topic"
              id="topic"
              required
              class="w-full p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 text-lg 
           focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200">
        <option value="" selected disabled>--Select Topic--</option>
         <?php while ($row = $topicResult->fetch_assoc()): ?>
          <option value="<?php echo $row['topic_id']; ?>">
            <?php echo htmlspecialchars($row['title']); ?>
          </option>
        <?php endwhile; ?>
            </select>
             


          </div>
        </div>
        <div class="flex flex-col md:col-span-2 relative">
          <label class="font-semibold text-gray-700 mb-2">Sub Topic</label>
          <div class="relative">
            <select
              name="sub_topic"
              id="subTopicSelect"
              required
              class="w-full p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 text-lg 
           focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200">
                <option value="">--Select Sub Topic--</option>
            </select>
          </div>
        </div>
        <!-- Test Title -->
        <div class="flex flex-col md:col-span-2">
          <label for="title" class="font-semibold text-gray-700 mb-2">Test Title</label>
          <input type="text" name="title" id="title" placeholder="Enter test title" required
            class="p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full" />
        </div>

        <!-- Subject -->
        <div class="flex flex-col md:col-span-2">
          <label for="subject" class="font-semibold text-gray-700 mb-2">Subject</label>
          <input type="text" name="domain" id="subject" placeholder="Enter subject" required
            class="p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full" />
        </div>


        <!-- Timing Dropdown -->

        <div class="flex flex-col md:col-span-1 relative">
          <label class="font-semibold text-gray-700 mb-2">Timing</label>
          <div class="relative">

            <select
              name="timing"
              id="timingSelect"
              required
              class="w-full p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 text-lg 
           focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200">
              <option value="">--Select Timing--</option>
              <option value="morning">Morning</option>
              <option value="afternoon">Afternoon</option>
              <option value="evening">Evening</option>
              <option value="full_day">Full Day</option>
            </select>

          </div>
        </div>

        <div class="flex flex-col md:col-span-1">
          <label for="Duration" class="font-semibold text-gray-700 mb-2">Duration ( In Minutes )</label>
          <input type="number" name="Duration" id="Duration" placeholder="Enter Duration" required
            class="p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full" />
        </div>

        <!-- Total Marks -->
        <div class="flex flex-col md:col-span-1">
          <label for="totalMarks" class="font-semibold text-gray-700 mb-2">Total Marks</label>
          <input type="number" name="total_marks" id="totalMarks" placeholder="Enter marks" required
            class="p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full" />
        </div>

        <!-- Total Questions -->
        <div class="flex flex-col md:col-span-1">
          <div class="flex items-center justify-between mb-2">
            <label for="totalQuestion" class="font-semibold text-gray-700">Total Questions</label>
            <span id="availableQuestionsBadge" class="ml-2 px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm font-semibold border border-orange-300" style="display:none;">Available: 0</span>
          </div>
          <input type="number" name="num_questions" id="totalQuestion" placeholder="Enter total questions" required
            class="p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full" />
        </div>

        <!-- Select Topic -->


        <!-- Year & Department -->
        <div class="flex flex-col md:flex-row gap-4 md:col-span-2">

          <!-- Year -->
          <div class="flex-1 flex flex-col relative">
            <label class="font-semibold text-gray-700 mb-2">Year</label>
            <div class="relative">
              <select
                name="year"
                id="yearSelect"
                required
                class="w-full p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 text-lg 
           focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200">
                <option value="">--Select Year--</option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
              </select>
            </div>
          </div>

          <!-- Department -->
          <div class="flex-1 flex flex-col relative">
            <label class="font-semibold text-gray-700 mb-2">Department</label>
            <div class="relative">
              <select
                name="department"
                id="departmentSelect"
                required
                class="w-full p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm bg-white text-gray-700 text-lg 
         focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200">
                <option value="" class="py-3">--Select Department--</option>
                <?php foreach ($departments as $dept): ?>
        <option value="<?php echo htmlspecialchars($dept['id']); ?>">
            <?php echo htmlspecialchars($dept['full_name']); ?>
        </option>
    <?php endforeach; ?>
              </select>

            </div>
          </div>

        </div>

        <!-- Description -->
        <div class="flex flex-col md:col-span-2">
          <label for="description" class="font-semibold text-gray-700 mb-2">Description</label>
          <textarea name="description" id="description" rows="4" placeholder="Enter description..."
            class="p-3 md:p-4 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200 w-full"></textarea>
        </div>
    
        <div class="md:col-span-2 flex justify-center mt-6">
          <button type="submit"
            class="px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white rounded-2xl shadow-lg font-semibold transition duration-200">
            Create Test
          </button>
        </div>

      </form>
    </section>


  </main>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const topicSelect = document.getElementById('topic');
    const subTopicSelect = document.getElementById('subTopicSelect');
    const availableQuestionsBadge = document.getElementById('availableQuestionsBadge');
    let subtopicData = [];

    topicSelect.addEventListener('change', function() {
      const topicId = this.value;
      subTopicSelect.innerHTML = '<option value="">Loading...</option>';
      fetch(`../backend/faculty/get_subtopic_question_count.php?topic_id=${topicId}`)
        .then(response => response.json())
        .then(data => {
          subtopicData = data;
          let options = '<option value="">--Select Sub Topic--</option>';
          if (data.length > 0) {
            data.forEach(sub => {
              options += `<option value="${sub.sub_topic_id}">${sub.title}</option>`;
            });
          }
          subTopicSelect.innerHTML = options;
          availableQuestionsBadge.style.display = 'none';
        })
        .catch(() => {
          subTopicSelect.innerHTML = '<option value="">No sub topics found</option>';
          availableQuestionsBadge.style.display = 'none';
        });
    });

    subTopicSelect.addEventListener('change', function() {
      const subId = this.value;
      const sub = subtopicData.find(s => s.sub_topic_id == subId);
      if (sub) {
        availableQuestionsBadge.textContent = `Available: ${sub.question_count}`;
        availableQuestionsBadge.style.display = 'inline-block';
      } else {
        availableQuestionsBadge.style.display = 'none';
      }
    });
  });
  </script>
  </body>
  </html>
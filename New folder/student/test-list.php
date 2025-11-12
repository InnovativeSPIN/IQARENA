<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Tests</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../assets/css/student/testlist.css">
  <link rel="stylesheet" href="../assets/css/main.css">
  <style>
    

    body {
      background: var(--color-surface);
      font-family: "Inter", sans-serif;
      color: var(--text);
    }

    
    .custom-card {
      background: var(--color-background);
      border: 1px solid var(--card-border);
      border-radius: 1rem;
      transition: all 0.3s ease;
    }

    .custom-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px var(--shadow);
    }

    
    .status-active {
      background: #22c55e; 
    }

    .status-inactive {
      background: #ef4444; /* red */
    }
  </style>
</head>
<body>
  <div class="max-w-7xl mx-auto mt-12 px-6">
    <!-- Page Heading -->
    <div class="text-center mb-10">
      <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">
        🎓 Available <span class="text-orange-600">Tests</span>
      </h1>
      <p class="mt-2 text-gray-600">Choose a test and start your journey</p>
    </div>

    <!-- Test Grid -->
    <div id="testContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>
  </div>

<script>
async function fetchTests() {
  try {
    const res = await fetch('../../server/controllers/student/test-list.php', {
      method: 'GET',
      credentials: 'include'
    });

    const data = await res.json();
    const container = document.getElementById('testContainer');
    container.innerHTML = "";

    if (!data || data.length === 0) {
      container.innerHTML = "<p class='text-gray-500 text-center col-span-3'>No available tests at the moment.</p>";
      return;
    }

    data.forEach(test => {
      const card = document.createElement('div');
      card.className = "relative p-6 custom-card shadow";

      const statusColor = test.is_active == 1 ? 'status-active' : 'status-inactive';

      function getSlotLabel(start, end) {
        const startH = new Date(start).getHours();
        const endH = new Date(end).getHours();
        if (startH === 9 && endH === 21) return 'Full Day';
        if (startH === 9 && endH === 12) return 'Morning';
        if (startH === 12 && endH === 14) return 'Afternoon';
        if (startH === 14 && endH === 17) return 'Evening';
        return `${new Date(start).toLocaleTimeString()} - ${new Date(end).toLocaleTimeString()}`;
      }

      const slotLabel = getSlotLabel(test.start_time, test.end_time);

      card.innerHTML = `
        <span class="absolute top-3 right-3 w-3 h-3 rounded-full ${statusColor}" 
              title="${test.is_active == 1 ? 'Active' : 'Inactive'}"></span>
        <h2 class="text-xl font-semibold mb-2 text-gray-900">${test.title}</h2>
        <p class="text-gray-600 mb-3">${test.description || "No description available."}</p>
        <p class="text-sm text-gray-500 mb-1"><strong>Domain:</strong> ${test.domain || "N/A"}</p>
        <p class="text-sm text-gray-500 mb-1"><strong>Department:</strong> ${test.department || "N/A"} | <strong>Year:</strong> ${test.year || "N/A"}</p>
        <p class="text-sm text-gray-500 mb-1"><strong>Time Slot:</strong> ${slotLabel}</p>
        <p class="text-sm text-gray-500 mb-4"><strong>Duration:</strong> ${test.duration_minutes} mins | <strong>Marks:</strong> ${test.total_marks}</p>
        <button onclick="window.location.href='quiz-attend.php?test_id=${test.test_id}'" 
                class="w-full px-4 py-2 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition">
          Start Test
        </button>
      `;

      container.appendChild(card);
    });

  } catch (error) {
    console.error("Error fetching tests:", error);
    document.getElementById('testContainer').innerHTML = "<p class='text-red-500 text-center col-span-3'>Failed to fetch tests.</p>";
  }
}

window.addEventListener('DOMContentLoaded', fetchTests);
</script>
</body>
</html>

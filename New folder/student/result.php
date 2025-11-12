<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Test Result</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="./client/assets/student/result.css">
</head>
<body class="font-sans text-gray-800">

  <div class="max-w-4xl mx-auto px-6 py-10">
    <!-- Header -->
    <div class="text-center mb-10 fade-in" style="animation-delay:.05s">
      <h1 class="text-4xl font-extrabold text-orange-500 drop-shadow-md mb-2">🎓 Student Test Result</h1>
      <p class="text-gray-700">Detailed breakdown of your performance</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
      <div class="bg-white rounded-xl shadow-md p-5 flex flex-col items-center border-l-4 border-orange-400 fade-in card-animate" style="animation-delay:.1s">
        <div class="text-sm text-gray-600">Total Questions</div>
        <div class="text-2xl font-bold text-orange-500" id="total-questions">0</div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-5 flex flex-col items-center border-l-4 border-green-500 fade-in card-animate" style="animation-delay:.2s">
        <div class="text-sm text-gray-600">Correct</div>
        <div class="text-2xl font-bold text-green-600" id="correct-answers">0</div>
      </div>
      <div class="bg-white rounded-xl shadow-md p-5 flex flex-col items-center border-l-4 border-red-500 fade-in card-animate" style="animation-delay:.3s">
        <div class="text-sm text-gray-600">Wrong</div>
        <div class="text-2xl font-bold text-red-500" id="wrong-answers">0</div>
      </div>
    </div>

    <!-- Question Cards -->
    <div id="questions-container" class="space-y-6"></div>

    <!-- Centered Send Button -->
    <div class="text-center mt-10 fade-in" style="animation-delay:.8s">
      <button
        id="sendMailBtn"
        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition-transform duration-300 hover:scale-105"
      >
        📩 Send to Mail
      </button>
    </div>
  </div>

  <script src="./client/assets/student/result.js"></script>
</body>
</html>
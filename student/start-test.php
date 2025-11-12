<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MCQ Quiz App — LocalStorage Only</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Landing Page -->
  <div id="landingPage" class="flex h-screen items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-lg">
      <h1 class="text-3xl font-bold text-gray-800 mb-3">Welcome to the NSCET Quiz</h1>
      <p class="text-gray-600 mb-6">No servers. No excuses. Your answers are saved in your browser.</p>
      <div class="space-x-2">
        <button id="startQuiz" class="bg-orange-600 text-white py-2 px-6 rounded-md">Start Test</button>
        <button id="resumeQuiz" class="bg-gray-200 text-gray-800 py-2 px-6 rounded-md hidden">Resume</button>
      </div>
      <p class="text-xs text-gray-500 mt-3">If you’ve taken this quiz before, you can resume where you left off.</p>
    </div>
  </div>

  <!-- Quiz Content -->
  <div id="quizContent" class="hidden h-screen overflow-hidden">
    <div class="flex h-full">
      <!-- Sidebar -->
      <aside class="bg-white w-72 border-r border-gray-200 p-4 flex flex-col">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quiz Navigation</h2>

        <div class="grid grid-cols-6 gap-2 mb-4" id="questionNumbers"></div>

        <div class="space-y-2 text-sm mt-2">
          <div class="flex items-center">
            <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-2"></span>
            <span>Answered: <span id="answeredCount">0</span></span>
          </div>
          <div class="flex items-center">
            <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
            <span>Skipped: <span id="skippedCount">0</span></span>
          </div>
          <div class="flex items-center">
            <span class="inline-block w-3 h-3 rounded-full bg-gray-300 mr-2"></span>
            <span>Not Answered: <span id="notAnsweredCount">0</span></span>
          </div>
        </div>

        <div class="mt-auto pt-4 border-t border-gray-200 space-y-2">
          <button id="submitQuiz" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded">Submit Quiz</button>
        </div>
      </aside>

      <!-- Main -->
      <main class="flex-1 overflow-auto">
        <div class="max-w-4xl mx-auto p-6">
          <header class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">General Knowledge Quiz</h1>
            <span class="text-sm text-gray-500">Local mode</span>
          </header>

          <div id="quiz-container"></div>

          <div class="flex justify-between mt-6">
            <button id="prevBtn" class="bg-gray-200 py-2 px-4 rounded disabled:opacity-50" disabled>
              <i class="fas fa-arrow-left mr-2"></i>Previous
            </button>
            <div class="space-x-2">
              <button id="skipBtn" class="bg-yellow-100 text-yellow-800 py-2 px-4 rounded">
                <i class="fas fa-forward mr-2"></i>Skip
              </button>
              <button id="nextBtn" class="bg-orange-500 text-white py-2 px-4 rounded">
                Next<i class="fas fa-arrow-right ml-2"></i>
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Result Page -->
  <div id="resultPage" class="hidden flex h-screen items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-xl w-full">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Result</h2>
      <p id="resultText" class="text-lg text-gray-700 mb-4"></p>

      

      <div class="flex justify-center space-x-2">
        <a href="./">
                    <button id="clearAllBtn" class="bg-gray-200 text-gray-800 py-2 px-5 rounded">Return</button>

        </a>
      </div>
    </div>
  </div>

<script>
const QUESTIONS = [
  {
    id: 1,
    question: "Who is known as the “Missile Man of India”?",
    options: { A: "Homi J. Bhabha", B: "A. P. J. Abdul Kalam", C: "Vikram Sarabhai", D: "Satish Dhawan" },
    correct: "B", mark: 1
  },
  {
    id: 2,
    question: "Which city is known as the “Pink City” of India?",
    options: { A: "Udaipur", B: "Jaipur", C: "Jodhpur", D: "Bikaner" },
    correct: "B", mark: 1
  },
  {
    id: 3,
    question: "In which state is the famous Valley of Flowers National Park located?",
    options: { A: "Uttarakhand", B: "Himachal Pradesh", C: "Jammu & Kashmir", D: "Sikkim" },
    correct: "A", mark: 1
  },
  {
    id: 4,
    question: "Who composed the Indian National Anthem “Jana Gana Mana”?",
    options: { A: "Bankim Chandra Chatterjee", B: "Rabindranath Tagore", C: "Mahatma Gandhi", D: "Subhas Chandra Bose" },
    correct: "B", mark: 1
  },
  {
    id: 5,
    question: "Which Indian was the first to win an individual Olympic gold medal?",
    options: { A: "Leander Paes", B: "Abhinav Bindra", C: "P. T. Usha", D: "Rajyavardhan Singh Rathore" },
    correct: "B", mark: 1
  }
];

let answers = {};
let currentQuestionIndex = 0;

const landingPage = document.getElementById("landingPage");
const quizContent = document.getElementById("quizContent");
const resultPage = document.getElementById("resultPage");
const questionNumbers = document.getElementById("questionNumbers");
const answeredCountEl = document.getElementById("answeredCount");
const skippedCountEl = document.getElementById("skippedCount");
const notAnsweredCountEl = document.getElementById("notAnsweredCount");

document.getElementById("startQuiz").onclick = startQuiz;
document.getElementById("prevBtn").onclick = onPrev;
document.getElementById("nextBtn").onclick = onNext;
document.getElementById("skipBtn").onclick = onSkip;
document.getElementById("submitQuiz").onclick = onSubmit;
document.getElementById("clearAllBtn").onclick = clearAll;

function startQuiz() {
  answers = {};
  currentQuestionIndex = 0;
  landingToQuiz();
}

function landingToQuiz() {
  landingPage.classList.add("hidden");
  resultPage.classList.add("hidden");
  quizContent.classList.remove("hidden");
  buildSidebar();
  renderQuestion();
  updateCounts();
}

function buildSidebar() {
  questionNumbers.innerHTML = "";
  QUESTIONS.forEach((q, idx) => {
    const btn = document.createElement("button");
    btn.textContent = idx + 1;
    btn.id = "qnum-" + q.id;
    btn.className = "w-9 h-9 text-sm flex items-center justify-center rounded border";
    btn.onclick = () => { currentQuestionIndex = idx; renderQuestion(); };
    questionNumbers.appendChild(btn);
    updateSidebarStatus(q.id);
  });
}

function updateSidebarStatus(qid) {
  const btn = document.getElementById("qnum-" + qid);
  if (!btn) return;
  if (answers[qid] === "") {
    btn.className = "w-9 h-9 text-sm flex items-center justify-center rounded bg-yellow-500 text-white";
  } else if (answers[qid]) {
    btn.className = "w-9 h-9 text-sm flex items-center justify-center rounded bg-green-500 text-white";
  } else {
    btn.className = "w-9 h-9 text-sm flex items-center justify-center rounded border";
  }
}

function renderQuestion() {
  const q = QUESTIONS[currentQuestionIndex];
  const container = document.getElementById("quiz-container");
  const selected = answers[q.id];

  let optionsHTML = "";
  Object.entries(q.options).forEach(([key, val]) => {
    const isSel = selected === key;
    optionsHTML += `
      <div class="option border rounded p-3 cursor-pointer ${isSel ? "border-orange-500 bg-orange-50" : "hover:bg-gray-50"}"
           data-label="${key}" data-qid="${q.id}">
        <span class="font-medium mr-2">${key}.</span>${val}
      </div>`;
  });

  container.innerHTML = `
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold mb-4">${q.question}</h2>
      <div class="space-y-2">${optionsHTML}</div>
    </div>
  `;

  container.querySelectorAll(".option").forEach(opt => {
    opt.onclick = () => {
      const label = opt.dataset.label;
      const qid = parseInt(opt.dataset.qid, 10);
      answers[qid] = label;
      updateSidebarStatus(qid);
      updateCounts();
      renderQuestion();
    };
  });

  document.getElementById("prevBtn").disabled = currentQuestionIndex === 0;
}

function updateCounts() {
  let answered = 0, skipped = 0;
  QUESTIONS.forEach(q => {
    if (answers[q.id] === "") skipped++;
    else if (answers[q.id]) answered++;
  });
  answeredCountEl.textContent = answered;
  skippedCountEl.textContent = skipped;
  notAnsweredCountEl.textContent = QUESTIONS.length - answered - skipped;
}

function onPrev() {
  if (currentQuestionIndex > 0) {
    currentQuestionIndex--;
    renderQuestion();
  }
}

function onNext() {
  if (currentQuestionIndex < QUESTIONS.length - 1) {
    currentQuestionIndex++;
    renderQuestion();
  }
}

function onSkip() {
  const q = QUESTIONS[currentQuestionIndex];
  if (!answers.hasOwnProperty(q.id)) {
    answers[q.id] = ""; // mark as skipped
    updateSidebarStatus(q.id);
    updateCounts();
  }
  currentQuestionIndex = (currentQuestionIndex + 1) % QUESTIONS.length;
  renderQuestion();
}

function onSubmit() {
  const result = computeScore();
  showResult(result);
}

function computeScore() {
  let score = 0;
  const detail = [];
  QUESTIONS.forEach(q => {
    const given = answers[q.id];
    const correct = q.correct;
    const isCorrect = given === correct;
    if (isCorrect) score += q.mark || 1;
    detail.push({ id: q.id, question: q.question, given, correct, options: q.options, isCorrect });
  });
  return { score, total: QUESTIONS.reduce((s, q) => s + (q.mark || 1), 0), detail };
}

function showResult(precomputed) {
  const data = precomputed || {
    score: 0,
    total: QUESTIONS.length,
    detail: computeScore().detail
  };

  quizContent.classList.add("hidden");
  landingPage.classList.add("hidden");
  resultPage.classList.remove("hidden");

  document.getElementById("resultText").textContent = `You scored ${data.score} out of ${data.total}`;

  // If you want to show review, add a div with id="reviewContainer" in your HTML
}

function clearAll() {
  answers = {};
  currentQuestionIndex = 0;
  resultPage.classList.add("hidden");
  landingPage.classList.remove("hidden");
}
</script>
</body>
</html>
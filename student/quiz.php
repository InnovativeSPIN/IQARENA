<?php
include("../resource/conn.php");
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    header("Location: test-list.php");
    die("Unauthorized");
}

$test_id = intval($_GET['id']);

// Fetch test info
$sql = "SELECT sub_topic_id, time_slot, duration_minutes ,title FROM tests WHERE test_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $test_id);
$stmt->execute();
$stmt->bind_result($subtopic_id, $time_slot, $duration_minutes,$title);
if (!$stmt->fetch()){
  header("Location: test-list.php");
  die("Test not found");
}

$stmt->close();

// Fetch questions

// Fetch only questions allocated for this test
$sql = "SELECT q.question_id, q.question_text, q.option_a, q.option_b, q.option_c, q.option_d, q.correct_option, q.mark
        FROM test_questions tq
        JOIN questions q ON tq.question_id = q.question_id
        WHERE tq.test_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $test_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
  $questions[] = [
    'id' => intval($row['question_id']),
    'question' => $row['question_text'],
    'options' => [
      'A' => $row['option_a'],
      'B' => $row['option_b'],
      'C' => $row['option_c'],
      'D' => $row['option_d']
    ],
    'correct' => $row['correct_option'],
    'mark' => intval($row['mark'])
  ];
}
$stmt->close();

$questions_json = json_encode($questions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>NSCET Quiz</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 font-sans">
<!-- Fullscreen enforcement overlay -->
<!-- <div id="fullscreenOverlay" style="display:flex;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.85);z-index:9999;align-items:center;justify-content:center;flex-direction:column;">
  <div class="text-white text-2xl font-bold mb-4">Quiz must be taken in fullscreen mode</div>
  <button id="fullscreenBtn" class="bg-orange-500 text-white px-6 py-3 rounded text-lg">Enter Fullscreen</button>
</div> -->

<div id="quizContent" class="h-screen overflow-hidden">
  <div class="flex h-full">
    <!-- Sidebar -->
    <aside class="bg-white w-72 border-r border-gray-200 p-4 flex flex-col">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Navigation</h2>
      <div class="grid grid-cols-6 gap-2 mb-4" id="questionNumbers"></div>
      <div class="space-y-2 text-sm mt-2">
        <div class="flex items-center"><span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-2"></span>Answered: <span id="answeredCount">0</span></div>
        <div class="flex items-center"><span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>Skipped: <span id="skippedCount">0</span></div>
        <div class="flex items-center"><span class="inline-block w-3 h-3 rounded-full bg-gray-300 mr-2"></span>Not Answered: <span id="notAnsweredCount">0</span></div>
      </div>
      <div class="mt-auto pt-4 border-t border-gray-200 space-y-2">
        <button id="submitQuiz" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded">Submit Quiz</button>
      </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-auto">
      <div class="max-w-4xl mx-auto p-6">
        <header class="flex justify-between items-center mb-4">
          <h1 class="text-2xl font-bold text-gray-800"> <?= htmlspecialchars($title) ?></h1>
         
        </header>

        <!-- Timer -->
        <div id="timer" class="text-right text-lg font-bold text-red-600 mb-4"></div>

        <!-- Questions -->

        <div id="quiz-container"></div>
        <script>
// Show/hide fullscreen enforcement overlay

function showFullscreenOverlay() {
  document.getElementById('fullscreenOverlay').style.display = 'flex';
  quizContent.style.filter = 'blur(8px)';
}
function hideFullscreenOverlay() {
  document.getElementById('fullscreenOverlay').style.display = 'none';
  quizContent.style.filter = '';
}

document.getElementById('fullscreenBtn').addEventListener('click', function() {
  requestFullscreen();
});
        // Enhance question rendering for code formatting
    function renderQuestionText(text) {
      if (!text) return '';
      // Detect code-like questions: multi-line, or multiple Python statements, or keywords
      const codePattern = /(\bprint\b|\bwhile\b|\bfor\b|\bif\b|\bdef\b|\bclass\b|\blist\d*\b|\bresult\b|\bextend\b|\bnot in\b|\b\[|\]|\(|\)|=|\+|\.|:|;)/;
      const lines = text.split('\n');
      // Also treat as code block if there are multiple statements separated by semicolon or many assignments/keywords
      const statementCount = text.split(/;|\bprint\b|\bwhile\b|\bfor\b|\bif\b|\bdef\b|\bclass\b|\blist\d*\b|\bresult\b|\bextend\b|\bnot in\b|=/).length;
      if (lines.length > 1 || codePattern.test(text) || statementCount > 3) {
        return `<pre class="bg-gray-100 rounded p-2 text-sm overflow-x-auto"><code>${escapeHtml(text)}</code></pre>`;
      } else {
        return escapeHtml(text).replace(/\n/g, '<br>');
      }
    }
        function escapeHtml(str) {
            return str.replace(/[&<>"']/g, function(tag) {
                const charsToReplace = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                };
                return charsToReplace[tag] || tag;
            });
        }
        // Patch quiz rendering to use renderQuestionText
        document.addEventListener('DOMContentLoaded', function() {
            const questions = <?= $questions_json ?>;
            const quizContainer = document.getElementById('quiz-container');
            if (!quizContainer || !questions.length) return;
            let current = 0;
            function showQuestion(idx) {
                const q = questions[idx];
                quizContainer.innerHTML = `
                  <div class="mb-6">
                    <div class="font-semibold mb-2">Q${idx+1}:</div>
                    <div class="mb-4">${renderQuestionText(q.question)}</div>
                    <div class="grid grid-cols-2 gap-4">
                      ${Object.entries(q.options).map(([key, val]) => `
                        <label class="block p-3 border rounded-xl cursor-pointer hover:bg-orange-50">
                          <input type="radio" name="option" value="${key}" class="mr-2"> ${escapeHtml(val)}
                        </label>
                      `).join('')}
                    </div>
                  </div>
                `;
            }
            showQuestion(current);
            // You may need to patch navigation logic to use showQuestion
        });
        </script>

        <div class="flex justify-between mt-6">
          <button id="prevBtn" class="bg-gray-200 py-2 px-4 rounded disabled:opacity-50" disabled><i class="fas fa-arrow-left mr-2"></i>Previous</button>
          <div class="space-x-2">
            <button id="skipBtn" class="bg-yellow-100 text-yellow-800 py-2 px-4 rounded"><i class="fas fa-forward mr-2"></i>Skip</button>
            <button id="nextBtn" class="bg-orange-500 text-white py-2 px-4 rounded">Next<i class="fas fa-arrow-right ml-2"></i></button>
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
      <a href="./"><button id="clearAllBtn" class="bg-gray-200 text-gray-800 py-2 px-5 rounded">Return</button></a>
    </div>
  </div>
</div>

<script>


// Proctoring features
let suspiciousCount = 0;
let flagged = false;

// Enforce fullscreen mode
function requestFullscreen() {
  const el = document.documentElement;
  if (el.requestFullscreen) el.requestFullscreen();
  else if (el.mozRequestFullScreen) el.mozRequestFullScreen();
  else if (el.webkitRequestFullscreen) el.webkitRequestFullscreen();
  else if (el.msRequestFullscreen) el.msRequestFullscreen();
}

function isFullscreen() {
  return document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;
}

function enforceFullscreen() {
  if (!isFullscreen()) {
    showFullscreenOverlay();
  } else {
    hideFullscreenOverlay();
  }
}

// Detect tab switch or window blur
window.onblur = function() {
  suspiciousCount++;
  if (suspiciousCount === 1) {
    alert('Warning 1: You switched tabs or minimized the window. Please stay on the quiz page!');
  } else if (suspiciousCount === 2) {
    alert('Warning 2: You switched tabs or minimized the window again. Next time, your test will be flagged and submitted automatically.');
  } else if (suspiciousCount >= 3 && !flagged) {
    flagged = true;
    alert('Test flagged due to repeated suspicious activity. Submitting your test now.');
    autoFlaggedSubmit();
    console.warn('Suspicious activity: Tab switch or window blur detected. Test flagged and submitted.');
  }
};

// Detect exit from fullscreen
document.addEventListener('fullscreenchange', function() {
  enforceFullscreen();
  if (isFullscreen()) {
    // Only start quiz if it hasn't started yet
    if (!window.quizStarted) {
      window.quizStarted = true;
      buildSidebar();
      renderQuestion();
      updateCounts();
      startTimer();
    }
  } else {
    showFullscreenOverlay();
    window.quizStarted = false;
  }
});

// Detect window focus (optional: log)
window.onfocus = function() {
  enforceFullscreen();
  console.log('Window refocused.');
};

// Disable right-click
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});

// Disable copy, paste, and cut silently
['copy', 'paste', 'cut'].forEach(function(evt) {
  document.addEventListener(evt, function(e) {
    e.preventDefault();
  });
});

// Disable print silently
window.onbeforeprint = function() {
  return false;
};

// Auto-submit as flagged
function autoFlaggedSubmit() {
  clearInterval(timerInterval);
  fetch('save-quiz.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      test_id:  <?= htmlspecialchars($test_id) ?>,
      answers: answers,
      score: computeScore().score,
      flagged: true
    })
  })
  .then(res => res.json())
  .then(data => {
    fetch('get-score.php?student_test_id=' + data.student_test_id)
      .then(res => res.json())
      .then(scoreData => {
        showResult({ score: scoreData.score, total: computeScore().total, flagged: true });
      })
      .catch(() => showResult({ ...computeScore(), flagged: true }));
  })
  .catch(() => showResult({ ...computeScore(), flagged: true }));
}

function shuffle(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
  return array;
}

const QUESTIONS = shuffle(<?= $questions_json ?>);

let answers = {};
let currentQuestionIndex = 0;
const quizContent = document.getElementById("quizContent");
const resultPage = document.getElementById("resultPage");
const questionNumbers = document.getElementById("questionNumbers");
const answeredCountEl = document.getElementById("answeredCount");
const skippedCountEl = document.getElementById("skippedCount");
const notAnsweredCountEl = document.getElementById("notAnsweredCount");

let duration = <?= $duration_minutes ?> * 60;
const timerEl = document.getElementById('timer');
let timerInterval;

document.getElementById("prevBtn").onclick = onPrev;
document.getElementById("nextBtn").onclick = onNext;
document.getElementById("skipBtn").onclick = onSkip;
document.getElementById("submitQuiz").onclick = onSubmit;
document.getElementById("clearAllBtn").onclick = clearAll;

window.onload = function() {
  buildSidebar();
  renderQuestion();
  updateCounts();
  startTimer();
}

function startTimer() {
  timerInterval = setInterval(() => {
    let mins = Math.floor(duration / 60);
    let secs = duration % 60;
    timerEl.textContent = `Time Left: ${mins.toString().padStart(2,'0')}:${secs.toString().padStart(2,'0')}`;
    if (duration <= 0) {
      clearInterval(timerInterval);
      alert("Time's up!");
      onSubmit();
    }
    duration--;
  }, 1000);
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
  if (answers[qid] === "") btn.className = "w-9 h-9 text-sm flex items-center justify-center rounded bg-yellow-500 text-white";
  else if (answers[qid]) btn.className = "w-9 h-9 text-sm flex items-center justify-center rounded bg-green-500 text-white";
  else btn.className = "w-9 h-9 text-sm flex items-center justify-center rounded border";
}
function renderQuestion() {
  if (!QUESTIONS[currentQuestionIndex]) return;


  const q = QUESTIONS[currentQuestionIndex];
  const container = document.getElementById("quiz-container");
  const selected = answers[q.id];

  // Enhanced code block rendering for question text
  function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, function(tag) {
      const charsToReplace = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
      };
      return charsToReplace[tag] || tag;
    });
  }
  function renderQuestionText(text) {
    if (!text) return '';
    // Detect code-like questions: multi-line, or multiple Python statements, or keywords
    const codePattern = /(\bprint\b|\bwhile\b|\bfor\b|\bif\b|\bdef\b|\bclass\b|\blist\d*\b|\bresult\b|\bextend\b|\bnot in\b|\[|\]|\(|\)|=|\+|\.|:|;)/;
    const lines = String(text).split('\n');
    const statementCount = String(text).split(/;|\bprint\b|\bwhile\b|\bfor\b|\bif\b|\bdef\b|\bclass\b|\blist\d*\b|\bresult\b|\bextend\b|\bnot in\b|=/).length;
    if (lines.length > 1 || codePattern.test(text) || statementCount > 3) {
      return `<pre class="bg-gray-100 rounded p-2 text-sm overflow-x-auto"><code>${escapeHtml(text)}</code></pre>`;
    } else {
      return escapeHtml(text).replace(/\n/g, '<br>');
    }
  }

  let optionsHTML = "";
  Object.entries(q.options).forEach(([key, val]) => {
    const isSel = selected === key;
    optionsHTML += `
      <div class="option border rounded p-3 cursor-pointer ${isSel ? "border-orange-500 bg-orange-50" : "hover:bg-gray-50"}"
           data-label="${key}" data-qid="${q.id}">
        <span class="font-medium mr-2">${key}.</span>${escapeHtml(val)}
      </div>`;
  });

  container.innerHTML = `
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold mb-4">${renderQuestionText(q.question)}</h2>
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

function onPrev() { if(currentQuestionIndex>0){currentQuestionIndex--;renderQuestion();} }
function onNext() { if(currentQuestionIndex<QUESTIONS.length-1){currentQuestionIndex++;renderQuestion();} }

function onSkip() {
  const q = QUESTIONS[currentQuestionIndex];
  if (!answers.hasOwnProperty(q.id)) answers[q.id] = "";
  updateSidebarStatus(q.id);
  updateCounts();
  currentQuestionIndex = (currentQuestionIndex + 1) % QUESTIONS.length;
  renderQuestion();
}

function onSubmit() {
  clearInterval(timerInterval);
  const result = computeScore();

  fetch('save-quiz.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      test_id:  <?= htmlspecialchars($test_id) ?>,
      answers: answers,
      score: result.score
    })
  })
  .then(res => res.json())
  .then(data => {
    // Fetch actual score from DB
    fetch('get-score.php?student_test_id=' + data.student_test_id)
      .then(res => res.json())
      .then(scoreData => {
        showResult({ score: scoreData.score, total: result.total });
      })
      .catch(() => showResult(result));
  })
  .catch(() => showResult(result));
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
  return { score, total: QUESTIONS.reduce((s,q)=>s+(q.mark||1),0), detail };
}

function showResult(precomputed) {
  const data = precomputed || computeScore();
  quizContent.classList.add("hidden");
  resultPage.classList.remove("hidden");
  if (data.flagged) {
    document.getElementById("resultText").textContent = `Your test was flagged and submitted automatically due to suspicious activity. You scored ${parseInt(data.score, 10)} out of ${data.total}`;
  } else {
    document.getElementById("resultText").textContent = `You scored ${parseInt(data.score, 10)} out of ${data.total}`;
  }
}

function clearAll() { answers = {}; currentQuestionIndex=0; resultPage.classList.add("hidden"); }
</script>

</body>
</html>
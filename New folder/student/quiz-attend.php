<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MCQ Quiz App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/student/quiz-attend.css" />
</head>
<body class="bg-gray-100 font-sans">
    <!-- Landing Page -->
    <div id="landingPage" class="flex h-screen items-center justify-center">
        <div class="bg-white p-8 rounded-xl shadow-md text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Welcome to the NSCET Quiz
            </h1>
            <p class="text-gray-600 mb-6">
                Test your knowledge with 10 exciting questions. Click below to
                start the quiz in full-screen mode.
            </p>
            <button
                id="startQuiz"
                class="bg-orange-600 hover:bg-orange-600 text-white py-3 px-8 rounded-md transition duration-300 text-lg"
            >
                Start Test
            </button>
        </div>
    </div>

    <!-- Quiz Content -->
    <div id="quizContent" class="hidden flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar bg-white w-64 border-r border-gray-200 p-4 flex flex-col md:relative">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Quiz Navigation</h2>
                <button
                    id="closeSidebar"
                    class="md:hidden text-gray-500 hover:text-gray-700"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Time Left:</span>
                    <span id="sidebarTimer" class="font-bold">10:00</span>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">
                    Questions
                </h3>
                <div class="grid grid-cols-5 gap-2 mb-6" id="questionNumbers"></div>

                <div class="space-y-2 text-sm">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                        <span>Answered: <span id="answeredCount">0</span></span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                        <span>Not Answered: <span id="notAnsweredCount">0</span></span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                        <span>Skipped: <span id="skippedCount">0</span></span>
                    </div>
                </div>
            </div>
            <div class="mt-auto pt-4 border-t border-gray-200">
                <button
                    id="submitQuiz"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md transition duration-300"
                >
                    Submit Quiz
                </button>
            </div>
        </div>

        <!-- Mobile sidebar toggle -->
        <div class="md:hidden fixed bottom-6 right-6 z-30">
            <button
                id="toggleSidebar"
                class="bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600 transition duration-300"
            >
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Overlay for mobile sidebar -->
        <div id="overlay" class="overlay"></div>

        <!-- Main content -->
        <div class="flex-1 overflow-auto">
            <div class="max-w-4xl mx-auto p-6">
                <!-- Header -->
                <header class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">General Knowledge Quiz</h1>
                        <p class="text-gray-600">Test your knowledge with these questions</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-white p-3 rounded-lg shadow-sm flex items-center">
                            <i class="fas fa-clock text-orange-500 mr-2"></i>
                            <span id="mainTimer" class="font-bold timer">10:00</span>
                        </div>
                    </div>
                </header>

                <div id="quiz-container" class="mt-10"></div>

                <div id="submitModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white p-6 rounded shadow-md text-center max-w-sm mx-auto">
                        <h2 class="text-xl font-semibold mb-4">Submit Quiz</h2>
                        <p class="mb-4">
                            You’ve answered all questions. Do you want to submit your answers?
                        </p>
                        <div class="flex justify-center space-x-4">
                            <button id="confirmSubmit" class="bg-green-500 text-white px-4 py-2 rounded">
                                Submit
                            </button>
                            <button id="cancelSubmit" class="bg-gray-300 px-4 py-2 rounded">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center mt-6 max-w-4xl mx-auto">
                    <button
                        id="prevBtn"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-6 rounded-md transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled
                    >
                        <i class="fas fa-arrow-left mr-2"></i> Previous
                    </button>
                    <div class="flex space-x-3">
                        <button
                            id="skipBtn"
                            class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 py-2 px-6 rounded-md transition duration-300"
                        >
                            <i class="fas fa-forward mr-2"></i> Skip
                        </button>
                        <button
                            id="nextBtn"
                            class="bg-orange-500 hover:bg-orange-600 text-white py-2 px-6 rounded-md transition duration-300"
                        >
                            Next <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
let quizData = [];
let questions = [];
let currentQuestionIndex = 0;
let timeLeft = 0;
let timerInterval;
let answers = {}; // { question_id: selectedOption }

const urlParams = new URLSearchParams(window.location.search);
const testId = urlParams.get('test_id');

const submitModal = document.getElementById("submitModal");
const confirmSubmit = document.getElementById("confirmSubmit");
const cancelSubmit = document.getElementById("cancelSubmit");
const startQuiz = document.getElementById("startQuiz");
const landingPage = document.getElementById("landingPage");
const quizContent = document.getElementById("quizContent");
const questionNumbers = document.getElementById("questionNumbers");
const submitQuiz = document.getElementById("submitQuiz");
const skipBtn = document.getElementById("skipBtn");
const nextBtn = document.getElementById("nextBtn");
const prevBtn = document.getElementById("prevBtn");

// ================== SECURITY LOCKS ==================

// Prevent back/forward navigation
history.pushState(null, null, location.href);
window.addEventListener("popstate", function () {
    alert("Navigation is disabled during the test!");
    history.pushState(null, null, location.href);
});

// Block keyboard shortcuts
function blockKeys(e) {
    if (
        e.key === "F12" ||
        (e.ctrlKey && e.shiftKey && ["I","J","C"].includes(e.key.toUpperCase())) ||
        (e.ctrlKey && ["U","S","P"].includes(e.key.toUpperCase()))
    ) {
        e.preventDefault();
        alert("This action is disabled during the test!");
    }
}

// Block right-click
function blockRightClick(e) {
    e.preventDefault();
    alert("Right-click is disabled during the test!");
}

// Detect DevTools open
const threshold = 160;
function detectDevTools() {
    const widthThreshold = window.outerWidth - window.innerWidth > threshold;
    const heightThreshold = window.outerHeight - window.innerHeight > threshold;
    if (widthThreshold || heightThreshold) {
        alert("DevTools is disabled during the test!");
    }
}
setInterval(detectDevTools, 1000);

// Initialize security locks
window.addEventListener("load", () => {
    window.addEventListener("keydown", blockKeys);
    window.addEventListener("contextmenu", blockRightClick);
});

let quizData = [];
let questions = [];
let currentQuestionIndex = 0;
let timeLeft = 600; // Default 10 minutes
let timerInterval;
let answers = {};

const submitModal = document.getElementById("submitModal");
const confirmSubmit = document.getElementById("confirmSubmit");
const cancelSubmit = document.getElementById("cancelSubmit");
const startQuiz = document.getElementById("startQuiz");
const landingPage = document.getElementById("landingPage");
const quizContent = document.getElementById("quizContent");
const questionNumbers = document.getElementById("questionNumbers");
const submitQuiz = document.getElementById("submitQuiz");
const skipBtn = document.getElementById("skipBtn");
const nextBtn = document.getElementById("nextBtn");
const prevBtn = document.getElementById("prevBtn");

// ================== SECURITY LOCKS ==================
// ...existing code...

// ================== QUIZ LOGIC ==================

window.onbeforeunload = () => "Are you sure you want to leave? Your quiz progress will be lost.";

function updateTimerDisplay() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    const formattedTime = `${String(minutes).padStart(2,"0")}:${String(seconds).padStart(2,"0")}`;
    document.getElementById("mainTimer").textContent = formattedTime;
    document.getElementById("sidebarTimer").textContent = formattedTime;
    if (timeLeft <= 60) {
        document.getElementById("mainTimer").classList.add("text-red-500");
        document.getElementById("sidebarTimer").classList.add("text-red-500");
    }
}

function startTimer() {
    updateTimerDisplay();
    timerInterval = setInterval(() => {
        if (timeLeft > 0) {
            timeLeft--;
            updateTimerDisplay();
        }
    }, 1000);
}

// Provide static questions for frontend-only demo
questions = [
    {
        question_id: 1,
        question_text: "What is the capital of France?",
        option_a: "Berlin",
        option_b: "Madrid",
        option_c: "Paris",
        option_d: "Rome"
    },
    {
        question_id: 2,
        question_text: "Which planet is known as the Red Planet?",
        option_a: "Earth",
        option_b: "Mars",
        option_c: "Jupiter",
        option_d: "Saturn"
    },
    {
        question_id: 3,
        question_text: "Who wrote 'Hamlet'?",
        option_a: "Charles Dickens",
        option_b: "William Shakespeare",
        option_c: "Jane Austen",
        option_d: "Mark Twain"
    }
    // Add more questions as needed
];
quizData = questions;
startTimer();
initQuiz();
renderSingleQuestion();
            </div>
            <h2 class="text-xl font-semibold text-gray-800 mb-6">${q.question_text}</h2>
            <div class="space-y-3" id="optionsContainer">
                ${renderStyledOption("A", q.option_a, q.question_id, selectedAnswer)}
                ${renderStyledOption("B", q.option_b, q.question_id, selectedAnswer)}
                ${renderStyledOption("C", q.option_c, q.question_id, selectedAnswer)}
                ${renderStyledOption("D", q.option_d, q.question_id, selectedAnswer)}
            </div>
        </div>
    `;
    quizContainer.appendChild(card);

    card.querySelectorAll(".option").forEach((option) => {
        option.addEventListener("click", () => {
            const label = option.getAttribute("data-label");
            const qid = option.getAttribute("data-question-id");
            answers[qid] = label;
            updateSidebarStatus(qid);
            renderSingleQuestion();
            updateAnsweredCounts();
        });
    });

    updateAnsweredCounts();
}

function renderStyledOption(label, text, questionId, selectedAnswer) {
    const isSelected = selectedAnswer === label;
    const selectedClass = isSelected ? "border-orange-500 ring-2 ring-orange-300 bg-orange-50" : "";
    return `
        <div class="option border border-gray-200 rounded-lg p-4 cursor-pointer transition duration-300 hover:shadow-md ${selectedClass}" 
             data-label="${label}" data-question-id="${questionId}">
            <span class="font-medium mr-3">${label}.</span><span>${text}</span>
        </div>
    `;
}

function initQuiz() {
    questionNumbers.innerHTML = "";
    quizData.forEach((_, index) => {
        const questionNumber = document.createElement("div");
        questionNumber.className = "question-number w-10 h-10 flex items-center justify-center rounded-md border border-gray-300 cursor-pointer transition duration-300 hover:bg-gray-100";
        questionNumber.textContent = index + 1;
        questionNumber.dataset.index = index;
        questionNumber.id = `qnum-${quizData[index].question_id}`;
        questionNumber.addEventListener("click", () => {
            currentQuestionIndex = index;
            renderSingleQuestion();
        });
        questionNumbers.appendChild(questionNumber);
        updateSidebarStatus(quizData[index].question_id);
    });
    updateAnsweredCounts();
}

function updateSidebarStatus(questionId) {
    const elem = document.getElementById(`qnum-${questionId}`);
    if (elem) {
        if (answers[questionId]) {
            elem.classList.add("bg-green-200", "text-green-800", "font-semibold");
            elem.classList.remove("bg-yellow-200", "text-yellow-800");
        } else elem.classList.remove("bg-green-200", "text-green-800", "font-semibold");
    }
}

function updateAnsweredCounts() {
    const total = questions.length;
    const answered = Object.keys(answers).filter((qid) => answers[qid] !== undefined && answers[qid] !== "").length;
    const skipped = Object.keys(answers).filter((qid) => answers[qid] === "").length;
    const notAnswered = total - answered - skipped;

    document.getElementById("answeredCount").textContent = answered;
    document.getElementById("notAnsweredCount").textContent = notAnswered;
    document.getElementById("skippedCount").textContent = skipped;
}

// ================== BUTTON EVENTS ==================
startQuiz.addEventListener("click", () => {
    landingPage.classList.add("hidden");
    quizContent.classList.remove("hidden");
});

skipBtn.addEventListener("click", () => {
    const q = questions[currentQuestionIndex];
    if (!answers[q.question_id]) answers[q.question_id] = "";
    updateSidebarStatus(q.question_id);
    currentQuestionIndex++;
    if (currentQuestionIndex >= questions.length) currentQuestionIndex = 0;
    renderSingleQuestion();
});

nextBtn.addEventListener("click", () => {
    currentQuestionIndex++;
    if (currentQuestionIndex >= questions.length) currentQuestionIndex = 0;
    renderSingleQuestion();
    const allAnsweredOrSkipped = questions.every((q) => answers.hasOwnProperty(q.question_id));
    if (allAnsweredOrSkipped) submitModal.classList.remove("hidden");
});

prevBtn.addEventListener("click", () => {
    if (currentQuestionIndex > 0) {
        currentQuestionIndex--;
        renderSingleQuestion();
    }
});

submitQuiz.addEventListener("click", () => {
    if (confirm("Are you sure you want to submit the quiz?")) {
        clearInterval(timerInterval);
        submitAnswers();
    }
});

confirmSubmit.addEventListener("click", () => {
    clearInterval(timerInterval);
    submitModal.classList.add("hidden");
    submitAnswers();
});
cancelSubmit.addEventListener("click", () => submitModal.classList.add("hidden"));

// ================== SUBMIT ==================
async function submitAnswers() {
    try {
        const response = await fetch("../../server/controllers/student/submit_quiz.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ answers }),
            credentials: "include",
        });
        const result = await response.json();

        if (result.status === "success") {
            removeSecurityLocks();
            window.location.href = `/CODING-QUIZ-APP/client/student/congrats.php?score=${result.score}&total=${result.total_marks}`;
        } else alert("Submission failed: " + result.message);
    } catch (error) {
        alert("Error submitting quiz: " + error.message);
    }
}

// ================== FULLSCREEN CONTROL ==================

// Enter fullscreen mode
function enterFullScreen() {
    const elem = document.documentElement;
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.webkitRequestFullscreen) { // Safari
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { // IE/Edge
        elem.msRequestFullscreen();
    }
}

// Exit fullscreen mode
function exitFullScreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.webkitExitFullscreen) { // Safari
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) { // IE/Edge
        document.msExitFullscreen();
    }
}

// Call enterFullScreen on page load
window.addEventListener("load", () => {
    enterFullScreen();
});

// Optionally exit fullscreen on quiz submission
function removeSecurityLocks() {
    exitFullScreen();
    window.removeEventListener("keydown", blockKeys);
    window.removeEventListener("contextmenu", blockRightClick);
    window.onbeforeunload = null;
}

</script>


</body>
</html>
